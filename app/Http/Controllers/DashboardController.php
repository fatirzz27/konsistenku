<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil habits aktif beserta streak & log hari ini
        $habits = $user->habits()
            ->where('is_active', true)
            ->with('streak')
            ->get()
            ->map(function ($habit) {
                return [
                    'habit'       => $habit,
                    'score'       => $habit->consistencyScore(),
                    'streak'      => $habit->streak?->current_streak ?? 0,
                    'logged_today' => $habit->isLoggedToday(),
                ];
            });

        // Hitung stats
        $totalHabits   = $habits->count();
        $bestStreak    = $user->habits()->with('streak')->get()
                            ->max(fn($h) => $h->streak?->longest_streak ?? 0);
        $totalCheckins = $user->habitLogs()->count();
        $totalBadges   = $user->achievements()->count();

        // Overall consistency score
        $overallScore = $totalHabits > 0
            ? round($habits->avg('score'), 1)
            : 0;

        // Consistency level
        $level = match (true) {
            $overallScore >= 91 => '💜 Master Konsistensi!',
            $overallScore >= 76 => '🟢 Sangat Konsisten!',
            $overallScore >= 51 => '🟡 Cukup Konsisten',
            $overallScore >= 26 => '🟠 Mulai Berkembang',
            default              => '🔴 Perlu Perbaikan',
        };

        // Heatmap data (365 hari terakhir)
        $heatmapData = $this->getHeatmapData($user);

        // Recent achievements
        $recentAchievements = $user->achievements()
            ->orderByPivot('unlocked_at', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'habits', 'totalHabits', 'bestStreak',
            'totalCheckins', 'totalBadges', 'overallScore',
            'level', 'heatmapData', 'recentAchievements'
        ));
    }

    /**
     * Heatmap: hitung jumlah check-in per hari selama 365 hari
     */
    private function getHeatmapData($user): array
    {
        $startDate = Carbon::today()->subDays(364);

        $logs = $user->habitLogs()
            ->where('logged_at', '>=', $startDate->toDateString())
            ->selectRaw('logged_at, COUNT(*) as count')
            ->groupBy('logged_at')
            ->pluck('count', 'logged_at')
            ->toArray();

        $data = [];
        for ($i = 0; $i < 365; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $data[$date] = $logs[$date] ?? 0;
        }

        return $data;
    }
}