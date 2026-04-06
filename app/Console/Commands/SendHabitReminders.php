<?php

namespace App\Console\Commands;

use App\Mail\HabitReminderMail;
use App\Models\Habit;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendHabitReminders extends Command
{
    protected $signature = 'habits:send-reminders
                            {--force : Kirim reminder tanpa filter jam (untuk testing)}
                            {--window= : Toleransi menit setelah reminder_time (opsional)}';
    protected $description = 'Kirim email reminder untuk habits yang waktunya sudah tiba';

    public function handle(): void
    {
        $now = Carbon::now();
        $currentTime = $now->format('H:i');
        $force = (bool) $this->option('force');
        $windowOption = $this->option('window');
        $window = is_numeric($windowOption) ? max((int) $windowOption, 0) : null;

        $this->info("Mengecek reminders untuk jam: {$currentTime}");

        $baseHabits = Habit::with('user')
            ->where('is_active', true)
            ->where('reminder_enabled', true)
            ->whereNotNull('reminder_time')
            ->get();

        $this->line("Total habit aktif + reminder aktif: {$baseHabits->count()}");

        $timeFilteredHabits = $force
            ? $baseHabits
            : $baseHabits->filter(function ($habit) use ($now, $window) {
                $reminderTime = Carbon::parse($habit->reminder_time)->format('H:i');
                $todayReminder = Carbon::today()->setTimeFromTimeString($reminderTime);

                // Diff bernilai positif jika reminder_time sudah lewat.
                $diffMinutes = $todayReminder->diffInMinutes($now, false);

                if (is_null($window)) {
                    // Default catch-up: kirim kapanpun setelah jam reminder lewat (sekali per hari).
                    return $diffMinutes >= 0;
                }

                return $diffMinutes >= 0 && $diffMinutes <= $window;
            });

        if ($force) {
            $this->line('Mode force aktif: melewati filter jam reminder.');
        } elseif (is_null($window)) {
            $this->line('Mode catch-up aktif: reminder tetap dikirim jika jamnya sudah lewat hari ini.');
            $this->line("Habit yang sudah melewati jam reminder: {$timeFilteredHabits->count()}");
        } else {
            $this->line("Habit yang masuk window waktu ({$window} menit): {$timeFilteredHabits->count()}");
        }

        $habits = $timeFilteredHabits
            ->filter(function ($habit) {
                // Hanya kirim jika belum check-in hari ini
                return !$habit->isLoggedToday();
            });

        $this->line("Habit yang belum check-in hari ini: {$habits->count()}");

        $count = 0;
        foreach ($habits as $habit) {
            $reminderTime = Carbon::parse($habit->reminder_time)->format('H:i');
            $cacheKey = "habit-reminder-sent:{$habit->id}:{$now->toDateString()}:{$reminderTime}";

            if (!$force && Cache::has($cacheKey)) {
                $this->line("Lewati {$habit->name}: reminder {$reminderTime} sudah pernah terkirim hari ini.");
                continue;
            }

            try {
                Mail::to($habit->user->email)->send(new HabitReminderMail($habit));

                if (!$force) {
                    Cache::put($cacheKey, true, $now->copy()->endOfDay());
                }

                $count++;
                $this->info("Sent reminder to {$habit->user->email} for: {$habit->name}");
            } catch (\Throwable $exception) {
                report($exception);
                $this->error("Gagal kirim ke {$habit->user->email} untuk {$habit->name}: {$exception->getMessage()}");
            }
        }

        $this->info("Selesai! {$count} reminder terkirim.");
    }
}