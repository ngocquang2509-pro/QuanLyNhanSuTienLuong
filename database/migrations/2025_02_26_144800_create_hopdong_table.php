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
        Schema::create('hopdong', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nhanvien_id')->unique(); // Đảm bảo 1-1
            $table->string('LoaiHopDong');
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->date('ngay_ky');
            $table->text('noi_dung')->nullable();
            $table->foreign('nhanvien_id')->references('id')->on('nhanvien')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hopdong');
    }
};
