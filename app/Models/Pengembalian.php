<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'user_id',
        'item_id',
        'admin_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'waktu_kembali',
        'kondisi_barang',
        'jumlah',
        'denda',
    ];

    // Relasi opsional
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // App\Models\Pengembalian.php

public function admin()
{
    return $this->belongsTo(Admin::class, 'admin_id');
}


    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

