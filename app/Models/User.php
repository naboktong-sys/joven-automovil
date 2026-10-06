<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    public function scopeIsNotAdmin($query)
    {
        return $query->where('level', '!=', 1);
    }

    // Relasi ke outlets
    public function outlets()
    {
        return $this->belongsToMany(Outlet::class, 'outlet_user', 'user_id', 'id_outlet')
                    ->withTimestamps();
    }

    // Cek apakah user punya akses ke outlet tertentu
    public function hasAccessToOutlet($outletId)
    {
        // Admin punya akses ke semua outlet
        if ($this->level == 1) {
            return true;
        }

        // Kasir cek berdasarkan relasi - PERBAIKAN: tambah table prefix
        return $this->outlets()->where('outlets.id_outlet', $outletId)->exists();
    }

    // Get outlet yang bisa diakses user
    public function getAccessibleOutlets()
    {
        if ($this->level == 1) {
            return Outlet::where('status', 1)->get();
        }

        return $this->outlets()->where('outlets.status', 1)->get();
    }
}
