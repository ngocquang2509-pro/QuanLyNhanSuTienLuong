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
        Schema::create('_luong', function (Blueprint $table) {
            $table->id();
            $table->decimal('HSL', 8, 2)->default(1.00);
            $table->bigInteger('KTKL')->default(0);
            $table->string('HoTen');
            $table->string('ChucVu')->nullable();
            $table->string('PhongBan')->nullable();
            $table->decimal('LuongCB', 15, 2)->default(0);
            $table->decimal('pc_chuc_vu', 15, 2)->nullable();
            $table->decimal('pc_trach_nhiem', 15, 2)->nullable();
            $table->integer('SoNgayCong')->default(2);
            $table->decimal('TongThuNhap', 15, 2);
            $table->decimal('bhxh', 15, 2)->default(0);
            $table->decimal('bhyt', 15, 2)->default(0);
            $table->decimal('bhtn', 15, 2)->default(0);
            $table->decimal('thue_tncn', 15, 2)->default(0);
            $table->decimal('luong_thuc_lanh', 15, 2)->nullable();
            $table->decimal('tam_ung', 15, 2)->default(0);
            $table->decimal('con_lanh', 15, 2)->nullable();
            $table->date('NgayTao')->nullable();
            $table->timestamps();
            $table->timestamp('NgayThanhToan')->nullable();
            $table->foreignId('nhanvien_id')->constrained('nhanvien')->onDelete('cascade');
            $table->integer('NPT')->nullable();
            $table->integer('LuongTheoGio')->nullable();
            $table->integer('TrangThai')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_luong');
    }
};
