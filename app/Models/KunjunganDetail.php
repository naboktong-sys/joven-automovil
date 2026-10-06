<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kunjungan_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kunjungan_id',
        'produk_id',
        'qty',
        'harga',
        'subtotal',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'qty' => 'integer',
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relation: Belongs to Kunjungan
     */
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan_id');
    }

    /**
     * Relation: Belongs to Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }

    /**
     * Get harga formatted
     */
    public function getHargaFormattedAttribute()
    {
        return 'Rp. ' . format_uang($this->harga);
    }

    /**
     * Get subtotal formatted
     */
    public function getSubtotalFormattedAttribute()
    {
        return 'Rp. ' . format_uang($this->subtotal);
    }

    /**
     * Boot method - auto calculate subtotal
     */
    protected static function boot()
    {
        parent::boot();

        // Before creating, calculate subtotal
        static::creating(function($detail) {
            if (!$detail->subtotal) {
                $detail->subtotal = $detail->qty * $detail->harga;
            }
        });

        // Before updating, recalculate subtotal
        static::updating(function($detail) {
            if ($detail->isDirty(['qty', 'harga'])) {
                $detail->subtotal = $detail->qty * $detail->harga;
            }
        });

        // After create/update/delete, update kunjungan totals
        static::saved(function($detail) {
            $detail->kunjungan->recalculateTotals();
        });

        static::deleted(function($detail) {
            $detail->kunjungan->recalculateTotals();
        });
    }

    /**
     * Scope: By produk
     */
    public function scopeByProduk($query, $produk_id)
    {
        return $query->where('produk_id', $produk_id);
    }

    /**
     * Scope: By kunjungan
     */
    public function scopeByKunjungan($query, $kunjungan_id)
    {
        return $query->where('kunjungan_id', $kunjungan_id);
    }
}
