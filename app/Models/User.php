<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'age',
        'gender',
        'height_cm',
        'weight_kg',
        'activity_level',
        'is_premium',
        'premium_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'   => 'datetime',
        'password'            => 'hashed',
        'height_cm'           => 'decimal:1',
        'weight_kg'           => 'decimal:1',
        'is_premium'          => 'boolean',
        'premium_expires_at'  => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    public function waterIntakes()
    {
        return $this->hasMany(WaterIntake::class);
    }

    public function dailyProgress()
    {
        return $this->hasMany(DailyProgress::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasPremium(): bool
    {
        if (!$this->is_premium) {
            return false;
        }

        if ($this->premium_expires_at === null) {
            return true;
        }

        return $this->premium_expires_at->isFuture();
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * BMI = weight(kg) / (height(m))²
     */
    public function getBmiAttribute(): ?float
    {
        if (!$this->height_cm || !$this->weight_kg) {
            return null;
        }

        $heightM = $this->height_cm / 100;

        return round($this->weight_kg / ($heightM ** 2), 1);
    }

    public function getBmiCategoryAttribute(): ?string
    {
        $bmi = $this->bmi;

        if ($bmi === null) {
            return null;
        }

        return match (true) {
            $bmi < 18.5 => 'Underweight',
            $bmi < 25   => 'Normal',
            $bmi < 30   => 'Overweight',
            default     => 'Obese',
        };
    }
}