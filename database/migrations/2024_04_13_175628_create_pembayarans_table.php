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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->comment('dari wisatawan');
            $table->string('metode_pembayaran');
            $table->bigInteger('jumlah_pembayaran');
            $table->bigInteger('admin_id');
            $table->date('tgl_pembayaran')->nullable();
            $table->date('tgl_konfirmasi')->nullable();
            $table->enum('status',['pending','dibayar','dikonfirmasi','ditolak'])->nullable();
           
            $table->timestamps();
        });
        // DB::statement('ALTER TABLE pembayaran ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
