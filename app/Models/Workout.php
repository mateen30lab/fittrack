<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'category', 'duration_minutes',
        'calories_burned', 'notes', 'performed_on',
    ];

    protected $casts = [
        'performed_on' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
