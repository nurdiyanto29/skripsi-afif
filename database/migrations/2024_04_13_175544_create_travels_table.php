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
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_mobil');
            $table->string('tranmisi');
            $table->string('nama');
            $table->integer('jml_kursi');
            $table->integer('tahun_mobil');
            $table->bigInteger('sopir_id');
            $table->bigInteger('harga');
            $table->integer('durasi_sewa');
            $table->timestamps();
        });
        // DB::statement('ALTER TABLE sopir ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel');
    }
};
