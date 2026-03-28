<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Habit;
use App\Models\Streak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{
    /**
     * Daftar semua habits user
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $habits = $user->habits()
            ->with('streak')
            ->orderBy('is_active', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($habit) => [
                'habit'  => $habit,
                'score'  => $habit->consistencyScore(),
                'streak' => $habit->streak?->current_streak ?? 0,
            ]);

        return view('habits.index', compact('habits'));
    }

    /**
     * Form buat habit baru
     */
    public function create()
    {
        return view('habits.create');
    }

    /**
     * Simpan habit baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string|max:500',
            'category'         => 'required|in:personal,health,study,work,other',
            'reminder_time'    => 'nullable|date_format:H:i',
        ]);

        $validated['reminder_enabled'] = $request->has('reminder_enabled');

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->habits()->create($validated);

        // Cek achievement
        $this->checkAchievements($user);

        return redirect()->route('habits.index')
            ->with('success', 'Habit berhasil dibuat! 🎉');
    }

    /**
     * Detail habit
     */
    public function show(Habit $habit)
    {
        $this->authorizeHabit($habit);

        $habit->load('streak');
        $score  = $habit->consistencyScore();
        $streak = $habit->streak;

        $currentMonth = now()->format('Y-m');
        $monthLogs = $habit->logs()
            ->where('logged_at', 'like', "$currentMonth%")
            ->pluck('logged_at')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->toArray();

        $recentLogs = $habit->logs()
            ->orderBy('logged_at', 'desc')
            ->take(10)
            ->get();

        return view('habits.show', compact(
            'habit', 'score', 'streak', 'monthLogs', 'recentLogs'
        ));
    }

    /**
     * Open reminder link from email with safe ownership check.
     */
    public function openReminder(Habit $habit)
    {
        if ($habit->user_id !== Auth::id()) {
            return redirect()->route('habits.index')
                ->with('error', 'This reminder does not belong to your account.');
        }

        return redirect()->route('habits.show', $habit);
    }

    /**
     * Form edit habit
     */
    public function edit(Habit $habit)
    {
        $this->authorizeHabit($habit);
        return view('habits.edit', compact('habit'));
    }

    /**
     * Update habit
     */
    public function update(Request $request, Habit $habit)
    {
        $this->authorizeHabit($habit);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string|max:500',
            'category'         => 'required|in:personal,health,study,work,other',
            'reminder_time'    => 'nullable|date_format:H:i',
        ]);

        $validated['reminder_enabled'] = $request->has('reminder_enabled');
        $validated['is_active']        = $request->has('is_active');

        $habit->update($validated);

        return redirect()->route('habits.show', $habit)
            ->with('success', 'Habit berhasil diupdate! ✅');
    }

    /**
     * Hapus habit
     */
    public function destroy(Habit $habit)
    {
        $this->authorizeHabit($habit);
        $habit->delete();

        return redirect()->route('habits.index')
            ->with('success', 'Habit berhasil dihapus.');
    }

    // ========================================
    //  CHECK-IN
    // ========================================

    public function checkin(Request $request, Habit $habit)
    {
        $this->authorizeHabit($habit);

        if ($habit->isLoggedToday()) {
            return back()->with('error', 'You have already checked in this habit today.');
        }

        $validated = $request->validate([
            'mood'  => 'nullable|in:great,good,okay,bad',
            'notes' => 'nullable|string|max:500',
        ]);

        // 1. Simpan log
        $habit->logs()->create([
            'user_id'   => Auth::id(),
            'logged_at' => today(),
            'mood'      => $validated['mood'] ?? null,
            'notes'     => $validated['notes'] ?? null,
        ]);

        // 2. Update streak (langsung di controller)
        $this->updateStreak($habit);

        // 3. Cek achievement (langsung di controller)
        $newAchievements = $this->checkAchievements(Auth::user());

        $message = 'Check-in berhasil! 🎉';
        if (!empty($newAchievements)) {
            $names = collect($newAchievements)->pluck('name')->join(', ');
            $message .= " Achievement unlocked: $names 🏆";
        }

        return back()->with('success', $message);
    }

    // ========================================
    //  PRIVATE METHODS (pengganti Service)
    // ========================================

    /**
     * Hitung dan update streak habit
     */
    private function updateStreak(Habit $habit): Streak
    {
        $streak = Streak::firstOrCreate(
            ['habit_id' => $habit->id, 'user_id' => $habit->user_id],
            ['current_streak' => 0, 'longest_streak' => 0]
        );

        // Ambil semua tanggal log, urutkan dari terbaru
        $dates = $habit->logs()
            ->orderBy('logged_at', 'desc')
            ->pluck('logged_at')
            ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
            ->unique()
            ->values();

        if ($dates->isEmpty()) {
            $streak->update(['current_streak' => 0, 'last_checked_date' => null]);
            return $streak;
        }

        $today     = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        // Jika log terakhir bukan hari ini/kemarin, streak reset
        if ($dates[0] !== $today && $dates[0] !== $yesterday) {
            $streak->update(['current_streak' => 0, 'last_checked_date' => $dates[0]]);
            return $streak;
        }

        // Hitung hari berturut-turut
        $currentStreak = 1;
        for ($i = 1; $i < $dates->count(); $i++) {
            $diff = Carbon::parse($dates[$i - 1])->diffInDays(Carbon::parse($dates[$i]));
            if ($diff === 1) {
                $currentStreak++;
            } else {
                break;
            }
        }

        $longestStreak = max($streak->longest_streak, $currentStreak);

        $streak->update([
            'current_streak'    => $currentStreak,
            'longest_streak'    => $longestStreak,
            'last_checked_date' => $dates[0],
        ]);

        return $streak;
    }

    /**
     * Cek dan unlock achievements yang memenuhi syarat
     */
    private function checkAchievements($user): array
    {
        $unlockedIds     = $user->achievements()->pluck('achievements.id')->toArray();
        $allAchievements = Achievement::all();
        $newlyUnlocked   = [];

        foreach ($allAchievements as $achievement) {
            if (in_array($achievement->id, $unlockedIds)) {
                continue;
            }

            $isEarned = match ($achievement->requirement) {
                'streak'        => $user->habits()
                                        ->whereHas('streak', fn($q) => $q->where('current_streak', '>=', $achievement->requirement_value))
                                        ->exists(),

                'checkin_count' => $user->habitLogs()->count() >= $achievement->requirement_value,

                'habit_count'   => $user->habits()->where('is_active', true)->count() >= $achievement->requirement_value,

                default         => false,
            };

            if ($isEarned) {
                $user->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                ]);
                $newlyUnlocked[] = $achievement;
            }
        }

        return $newlyUnlocked;
    }

    /**
     * Pastikan habit milik user yang sedang login
     */
    private function authorizeHabit(Habit $habit): void
    {
        abort_if($habit->user_id !== Auth::id(), 403);
    }
}