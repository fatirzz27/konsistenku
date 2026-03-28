<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'name', 'description', 'icon', 'requirement', 'requirement_value',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
                    ->withPivot('unlocked_at')
                    ->withTimestamps()
                    ->withCasts(['unlocked_at' => 'datetime']);
    }
}