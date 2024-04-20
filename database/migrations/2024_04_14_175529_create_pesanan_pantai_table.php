<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan_pantai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('objek_wisata_id');
            // Tambahkan kolom-kolom lain yang mungkin diperlukan
            $table->timestamps();

            // Definisikan constraint foreign key
            $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
            $table->foreign('objek_wisata_id')->references('id')->on('objek_wisata')->onDelete('cascade');
        });
        // DB::statement('ALTER TABLE paket_wisata ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_wisata');
    }
};
