<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tokos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_toko',
        'alamat',
        'kontak',
        'foto_toko',
        'latitude',
        'longitude',
        'catatan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get all kunjungan for this toko
     */
    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'toko_id');
    }

    /**
     * Get kunjungan terakhir
     */
    public function kunjunganTerakhir()
    {
        return $this->hasOne(Kunjungan::class, 'toko_id')->latest('tanggal_kunjungan');
    }

    /**
     * Get total belanja toko
     */
    public function getTotalBelanjaAttribute()
    {
        return $this->kunjungan()->sum('total_nilai');
    }

    /**
     * Get total kunjungan
     */
    public function getTotalKunjunganAttribute()
    {
        return $this->kunjungan()->count();
    }

    /**
     * Get rata-rata belanja per kunjungan
     */
    public function getRataRataBelanjaAttribute()
    {
        $total = $this->total_kunjungan;
        if ($total == 0) return 0;

        return $this->total_belanja / $total;
    }

    /**
     * Scope: Toko dengan kunjungan bulan ini
     */
    public function scopeKunjunganBulanIni($query)
    {
        return $query->whereHas('kunjungan', function($q) {
            $q->whereMonth('tanggal_kunjungan', date('m'))
              ->whereYear('tanggal_kunjungan', date('Y'));
        });
    }

    /**
     * Scope: Toko yang belum dikunjungi bulan ini
     */
    public function scopeBelumKunjunganBulanIni($query)
    {
        return $query->whereDoesntHave('kunjungan', function($q) {
            $q->whereMonth('tanggal_kunjungan', date('m'))
              ->whereYear('tanggal_kunjungan', date('Y'));
        });
    }

    /**
     * Get foto URL with fallback
     */
    public function getFotoUrlAttribute()
    {
        return get_foto_url('toko', $this->foto_toko, 'default-store.svg');
    }
}
