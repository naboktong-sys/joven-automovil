<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kunjungans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'toko_id',
        'tanggal_kunjungan',
        'total_qty',
        'total_nilai',
        'catatan',
        'foto_kunjungan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'total_qty' => 'integer',
        'total_nilai' => 'decimal:2',
    ];

    /**
     * Relation: Belongs to Toko
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    /**
     * Relation: Has many kunjungan details
     */
    public function detail()
    {
        return $this->hasMany(KunjunganDetail::class, 'kunjungan_id');
    }

    /**
     * Get tanggal kunjungan formatted
     */
    public function getTanggalFormattedAttribute()
    {
        return tanggal_indonesia($this->tanggal_kunjungan, true);
    }

    /**
     * Get total nilai formatted
     */
    public function getTotalNilaiFormattedAttribute()
    {
        return 'Rp. ' . format_uang($this->total_nilai);
    }

    /**
     * Check if kunjungan is today
     */
    public function getIsTodayAttribute()
    {
        return $this->tanggal_kunjungan->isToday();
    }

    /**
     * Check if kunjungan is this month
     */
    public function getIsThisMonthAttribute()
    {
        return $this->tanggal_kunjungan->isCurrentMonth();
    }

    /**
     * Scope: Kunjungan hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_kunjungan', date('Y-m-d'));
    }

    /**
     * Scope: Kunjungan bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_kunjungan', date('m'))
                     ->whereYear('tanggal_kunjungan', date('Y'));
    }

    /**
     * Scope: Kunjungan tahun ini
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('tanggal_kunjungan', date('Y'));
    }

    /**
     * Scope: Kunjungan by date range
     */
    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('tanggal_kunjungan', [$start, $end]);
    }

    /**
     * Scope: Kunjungan by toko
     */
    public function scopeByToko($query, $toko_id)
    {
        return $query->where('toko_id', $toko_id);
    }

    /**
     * Boot method - auto calculate totals
     */
    protected static function boot()
    {
        parent::boot();

        // When deleting, cascade delete details
        static::deleting(function($kunjungan) {
            $kunjungan->detail()->delete();
        });
    }

    /**
     * Recalculate totals from details
     */
    public function recalculateTotals()
    {
        $this->total_qty = $this->detail()->sum('qty');
        $this->total_nilai = $this->detail()->sum('subtotal');
        $this->save();
    }

    /**
     * Get foto URL with fallback
     */
    public function getFotoUrlAttribute()
    {
        return get_foto_url('kunjungan', $this->foto_kunjungan, 'default-visit.png');
    }
}
