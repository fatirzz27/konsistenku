<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Streak extends Model
{
    protected $fillable = [
        'habit_id', 'user_id', 'current_streak', 'longest_streak', 'last_checked_date',
    ];

    protected function casts(): array
    {
        return [
            'last_checked_date' => 'date',
        ];
    }

    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}