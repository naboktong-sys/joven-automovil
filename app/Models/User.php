<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /** Level user */
    public const LEVEL_ADMIN = 1;
    public const LEVEL_SALES = 2;

    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
        'level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
        'level_label',
    ];

    public function isAdmin(): bool
    {
        return (int) $this->level === self::LEVEL_ADMIN;
    }

    public function getLevelLabelAttribute(): string
    {
        return $this->isAdmin() ? 'Admin' : 'Sales';
    }
}
