<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'admin_id',
        'item_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'jumlah',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'datetime',
        'tanggal_pengembalian' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

        public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

        public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

}
