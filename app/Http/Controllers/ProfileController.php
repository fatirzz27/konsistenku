<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        $totalHabits = $user->habits()->count();
        $activeHabits = $user->habits()->where('is_active', true)->count();
        $habits = $user->habits()->orderBy('created_at', 'desc')->get();
        
        // Get best streak
        $bestStreak = $user->streaks()->max('longest_streak') ?? 0;
        
        // Get achievements
        $achievementCount = $user->achievements()->count();
        $recentAchievements = $user->achievements()
            ->orderBy('user_achievements.unlocked_at', 'desc')
            ->take(3)
            ->get();
        
        return view('profile.show', [
            'user' => $user,
            'totalHabits' => $totalHabits,
            'activeHabits' => $activeHabits,
            'habits' => $habits,
            'bestStreak' => $bestStreak,
            'achievementCount' => $achievementCount,
            'recentAchievements' => $recentAchievements,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
