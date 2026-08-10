<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterIntake extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount_ml', 'logged_on', 'logged_at'];

    protected $casts = [
        'logged_on' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
