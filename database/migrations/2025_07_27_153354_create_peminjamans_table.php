<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->dateTime('tanggal_peminjaman');
            $table->dateTime('tanggal_pengembalian')->nullable();
            $table->enum('status', ['pending', 'Approve', 'Reject', 'Returned'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
