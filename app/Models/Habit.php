<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'description', 'category',
        'icon', 'reminder_time', 'reminder_enabled', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'reminder_enabled' => 'boolean',
            'is_active' => 'boolean',
            'reminder_time' => 'datetime:H:i',
        ];
    }

    // === RELATIONSHIPS ===

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }

    public function streak()
    {
        return $this->hasOne(Streak::class);
    }

    // === HELPERS ===

    /**
     * Cek apakah habit ini sudah di-log hari ini
     */
    public function isLoggedToday(): bool
    {
        return $this->logs()->where('logged_at', today())->exists();
    }

    /**
     * Hitung consistency score (persentase) dalam N hari terakhir
     */
    public function consistencyScore(int $days = 30): float
    {
        $startDate = now()->subDays($days - 1)->startOfDay();

        $logCount = $this->logs()
            ->where('logged_at', '>=', $startDate->toDateString())
            ->count();

        return round(($logCount / $days) * 100, 1);
    }
}