<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $guarded = [];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Accessor untuk URL gambar
    public function getGambarUrlAttribute()
    {
        if ($this->gambar && Storage::disk('public')->exists($this->gambar)) {
            return Storage::url($this->gambar);
        }
        return asset('img/product-placeholder.svg'); // Default placeholder
    }

    // Event untuk hapus gambar saat produk dihapus
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($produk) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
        });
    }

        /**
     * Relation: Has many kunjungan details
     */
    public function kunjunganDetail()
    {
        return $this->hasMany(KunjunganDetail::class, 'produk_id', 'id_produk');
    }

    /**
     * Check if stok menipis
     */
    public function getStokMenipisAttribute()
    {
        return $this->stok <= 10; // threshold 10
    }

    /**
     * Scope: Produk dengan stok menipis
     */
    public function scopeStokMenipis($query, $threshold = 10)
    {
        return $query->where('stok', '<=', $threshold);
    }
}
