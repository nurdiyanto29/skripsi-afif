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
//         id, 
// tanggal
// jam,,
// user_id,
// jumlah_wisatawan
// mobil_id
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jam');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('travel_id');
            $table->integer('jumlah_wisatawan');
            $table->enum('status', ['belum_bayar', 'bayar', 'disetujui', 'ditolak', 'selesai']);

            $table->timestamps();
        });
        // DB::statement('ALTER TABLE pesanan ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
