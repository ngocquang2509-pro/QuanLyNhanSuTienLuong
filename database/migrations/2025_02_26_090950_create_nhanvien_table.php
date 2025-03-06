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
        Schema::create('nhanvien', function (Blueprint $table) {
            $table->id();
            $table->string('HoTen');
            $table->enum('GioiTinh', ['Nam', 'Nữ']);
            $table->date('NgaySinh');
            $table->string('DienThoai')->nullable();
            $table->string('CCCD')->unique();
            $table->string('Email')->unique();
            $table->text('DiaChi');
            $table->foreignId('MaPhongBan')->constrained('phongban')->onDelete('cascade');
            $table->foreignId('MaChucVu')->constrained('chucvu')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhanvien');
    }
};
