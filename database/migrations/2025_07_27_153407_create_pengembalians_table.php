<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembaliansTable extends Migration
{
    public function up()
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('item_id');
            $table->integer('jumlah');

            // Ubah dari date ke dateTime supaya bisa simpan tanggal + waktu lengkap
            $table->dateTime('tanggal_peminjaman');
            $table->dateTime('tanggal_pengembalian');
            $table->dateTime('waktu_kembali')->nullable(); // gabungkan waktu_kembali ke datetime
            $table->enum('kondisi_barang', ['Baik','Rusak', 'Hilang'])->default('Baik');
            $table->decimal('denda', 10, 2)->default(0);
            $table->timestamps();

            // Foreign keys
            $table->foreign('peminjaman_id')->references('id')->on('peminjamans')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengembalians');
    }
}
