<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar',
        'nama',
        'description',
        'total',
        'stock',
        'kategori_id',
        'admin_id'
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
}