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
        Schema::create('_ho_so_luong', function (Blueprint $table) {
            $table->id();
            $table->string('TenHS');
            $table->string('TG_Tao');
            $table->string('MoTa');
            $table->foreignId('PhieuLuong_id')->constrained('_phieu_luong')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_ho_so_luong');
    }
};
