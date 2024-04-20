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
        Schema::create('system_file', function (Blueprint $table) {
            $table->id();
            $table->string('disk_name');
            $table->string('file_name');
            $table->integer('file_size');
            $table->string('content_type');
            $table->string('flag')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('attachable_id');
            $table->string('attachable_type');
                        
            $table->timestamps();
        });
        // DB::statement('ALTER TABLE paket_wisata ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_file');
    }
};
