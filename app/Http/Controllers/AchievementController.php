<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $unlockedIds = $user->achievements()->pluck('achievements.id')->toArray();

        $achievements = Achievement::all()->map(fn($a) => [
            'achievement' => $a,
            'unlocked'    => in_array($a->id, $unlockedIds),
            'unlocked_at' => in_array($a->id, $unlockedIds)
                ? $user->achievements()->where('achievements.id', $a->id)->first()?->pivot?->unlocked_at
                : null,
        ]);

        $totalUnlocked = count($unlockedIds);
        $totalAll = Achievement::count();

        return view('achievements.index', compact('achievements', 'totalUnlocked', 'totalAll'));
    }
}