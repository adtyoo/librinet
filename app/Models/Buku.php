<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar',
        'kode',
        'nama',
        'description',
        'total',
        'stock',
        'kategori_id',
        'admin_id',
        'genre_id' // ✅ tetap disertakan
    ];

    protected $appends = ['image_url'];

    protected function getImageUrlAttribute()
    {
        if (Storage::disk('public')->exists($this->attributes['gambar'])) {
            return asset('storage/' . $this->attributes['gambar']);
        }

        return asset('path/to/default-image.jpg');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
