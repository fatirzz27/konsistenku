<?php

namespace App\Console\Commands;

use App\Mail\HabitReminderMail;
use App\Models\Habit;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendHabitReminders extends Command
{
    protected $signature = 'habits:send-reminders';
    protected $description = 'Kirim email reminder untuk habits yang waktunya sudah tiba';

    public function handle(): void
    {
        $currentTime = Carbon::now()->format('H:i');

        $this->info("Mengecek reminders untuk jam: {$currentTime}");

        // Ambil habits yang reminder-nya aktif dan waktunya sekarang
        $habits = Habit::where('is_active', true)
            ->where('reminder_enabled', true)
            ->whereNotNull('reminder_time')
            ->get()
            ->filter(function ($habit) use ($currentTime) {
                // Bandingkan jam:menit
                return Carbon::parse($habit->reminder_time)->format('H:i') === $currentTime;
            })
            ->filter(function ($habit) {
                // Hanya kirim jika belum check-in hari ini
                return !$habit->isLoggedToday();
            });

        $count = 0;
        foreach ($habits as $habit) {
            Mail::to($habit->user->email)->send(new HabitReminderMail($habit));
            $count++;
            $this->info("📧 Sent reminder to {$habit->user->email} for: {$habit->name}");
        }

        $this->info("✅ Selesai! {$count} reminder terkirim.");
    }
}