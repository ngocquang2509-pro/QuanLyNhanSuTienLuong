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
        Schema::create('_khen_thuong_ki_luat_nhan_vien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('KTKL_id')->constrained('_khen_thuong_ki_luat')->onDelete('cascade');
            $table->foreignId('nhanvien_id')->constrained('nhanvien')->onDelete('cascade');
            $table->bigInteger('NoiDung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_khen_thuong_ki_luat_nhan_vien');
    }
};
