<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            // Streak-based
            ['name' => 'First Step',     'description' => 'Buat habit pertamamu',          'icon' => '👣', 'requirement' => 'habit_count',  'requirement_value' => 1],
            ['name' => 'Starter',        'description' => 'Check-in pertama kali',         'icon' => '✅', 'requirement' => 'checkin_count', 'requirement_value' => 1],
            ['name' => '3-Day Streak',   'description' => 'Konsisten 3 hari berturut',     'icon' => '🔥', 'requirement' => 'streak',        'requirement_value' => 3],
            ['name' => 'Week Warrior',   'description' => 'Konsisten 7 hari berturut',     'icon' => '⚔️', 'requirement' => 'streak',        'requirement_value' => 7],
            ['name' => 'Month Master',   'description' => 'Konsisten 30 hari berturut',    'icon' => '🏅', 'requirement' => 'streak',        'requirement_value' => 30],
            ['name' => 'Century Club',   'description' => 'Konsisten 100 hari berturut',   'icon' => '💎', 'requirement' => 'streak',        'requirement_value' => 100],

            // Check-in count
            ['name' => 'Dedicated',      'description' => 'Total 25 check-in',             'icon' => '📋', 'requirement' => 'checkin_count', 'requirement_value' => 25],
            ['name' => 'Committed',      'description' => 'Total 50 check-in',             'icon' => '📊', 'requirement' => 'checkin_count', 'requirement_value' => 50],
            ['name' => 'Veteran',        'description' => 'Total 100 check-in',            'icon' => '🎖️', 'requirement' => 'checkin_count', 'requirement_value' => 100],

            // Habit count
            ['name' => 'Multi-tasker',   'description' => 'Punya 3 habits aktif',          'icon' => '🎯', 'requirement' => 'habit_count',  'requirement_value' => 3],
            ['name' => 'Overachiever',   'description' => 'Punya 5 habits aktif',          'icon' => '🚀', 'requirement' => 'habit_count',  'requirement_value' => 5],
            ['name' => 'Habit Master',   'description' => 'Punya 10 habits aktif',         'icon' => '👑', 'requirement' => 'habit_count',  'requirement_value' => 10],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['name' => $achievement['name']],
                $achievement
            );
        }
    }
}