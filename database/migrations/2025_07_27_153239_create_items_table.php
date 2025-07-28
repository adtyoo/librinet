<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();  // Kolom ID
            $table->string('nama');  // Nama item
            $table->text('description');  // Deskripsi item
            $table->unsignedBigInteger('kategori_id');  // ID kategori
            $table->integer('total');  // Jumlah total item
            $table->integer('stock');  // Jumlah stok item
            $table->string('gambar')->nullable();  // Nama file gambar (opsional)
            $table->unsignedBigInteger('admin_id');  // ID admin yang mengelola item
            $table->timestamps();  // Kolom created_at dan updated_at

            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
