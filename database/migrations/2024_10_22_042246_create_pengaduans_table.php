<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('status_pengaduan', 255);
            $table->string('kategori_pengaduan', 255);
            $table->string('image')->nullable();
            $table->text('description_petugas')->nullable();
            $table->string('image_petugas')->nullable();
            $table->dateTime('tanggal_lapor')->useCurrent();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
