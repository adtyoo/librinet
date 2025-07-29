<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('buku_id');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('admin_id')->nullable();

            $table->unsignedInteger('stok_total');
            $table->unsignedInteger('stok_tersedia');

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('buku_id')->references('id')->on('bukus')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};
