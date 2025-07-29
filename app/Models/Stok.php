<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'kategori_id',
        'stok_total',
        'stok_tersedia',
        'admin_id',
    ];

    public function item()
    {
        return $this->belongsTo(Buku::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
