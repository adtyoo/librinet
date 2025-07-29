<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode');
            $table->text('description');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('genre_id');
            $table->string('gambar')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
