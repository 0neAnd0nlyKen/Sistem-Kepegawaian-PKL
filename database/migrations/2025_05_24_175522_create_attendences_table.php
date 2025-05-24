<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendences', function (Blueprint $table) {
            //pegawai id dan tanggal adalah key unik gabungan
            $table->foreignId('pegawai_id')->constrained('employees')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->enum('status', ['pending', 'hadir', 'izin', 'sakit', 'cuti', 'alpha'])->default('pending');
            $table->timestamps();

            $table->primary(['pegawai_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendences');
    }
};
