<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'type', 'target_value', 'current_value',
        'unit', 'target_date', 'status',
    ];

    protected $casts = [
        'target_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressPercentAttribute(): int
    {
        if ($this->target_value <= 0) return 0;
        return (int) min(100, round(($this->current_value / $this->target_value) * 100));
    }
}
