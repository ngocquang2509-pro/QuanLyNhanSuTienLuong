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
            $table->string('HoTen');
            $table->string('ChucVu')->nullable();
            $table->string('PhongBan')->nullable();
            $table->decimal('LuongCB', 15, 2);
            $table->decimal('pc_chuc_vu', 15, 2)->nullable();
            $table->decimal('pc_trach_nhiem', 15, 2)->nullable();
            $table->integer('SoNgayCong')->default(0);
            $table->decimal('TongThuNhap', 15, 2);
            $table->decimal('bhxh', 15, 2)->default(0); // 8%
            $table->decimal('bhyt', 15, 2)->default(0); // 1.5%
            $table->decimal('bhtn', 15, 2)->default(0); // 1%
            $table->decimal('thue_tncn', 15, 2)->default(0);
            $table->decimal('luong_thuc_lanh', 15, 2);
            $table->decimal('tam_ung', 15, 2)->default(0);
            $table->decimal('con_lanh', 15, 2);
            $table->date('NgayTao');
            // Thêm cột NgayThanhToan kiểu timestamp, cho phép NULL
            $table->timestamp('NgayThanhToan')->nullable();
            $table->timestamps();
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