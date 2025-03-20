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
        Schema::table('_luong', function (Blueprint $table) {
            // Kiểm tra và thêm các cột còn thiếu
            if (!Schema::hasColumn('_luong', 'LuongCoBan')) {
                $table->decimal('LuongCoBan', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'pc_chuc_vu')) {
                $table->decimal('pc_chuc_vu', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'pc_trach_nhiem')) {
                $table->decimal('pc_trach_nhiem', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'SoNgayCong')) {
                $table->integer('SoNgayCong')->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'TongThuNhap')) {
                $table->decimal('TongThuNhap', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'bhxh')) {
                $table->decimal('bhxh', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'bhyt')) {
                $table->decimal('bhyt', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'thue_tncn')) {
                $table->decimal('thue_tncn', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'luong_thuc_lanh')) {
                $table->decimal('luong_thuc_lanh', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'tam_ung')) {
                $table->decimal('tam_ung', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'con_lanh')) {
                $table->decimal('con_lanh', 15, 2)->default(0);
            }
            
            if (!Schema::hasColumn('_luong', 'NgayTao')) {
                $table->timestamp('NgayTao')->nullable();
            }
            
            if (!Schema::hasColumn('_luong', 'NgayThanhToan')) {
                $table->timestamp('NgayThanhToan')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('_luong', function (Blueprint $table) {
            // Nếu muốn rollback, bạn có thể xóa các cột đã thêm
            $columnsToRemove = [
                'LuongCoBan', 'pc_chuc_vu', 'pc_trach_nhiem', 'SoNgayCong', 
                'TongThuNhap', 'bhxh', 'bhyt', 'thue_tncn', 'luong_thuc_lanh',
                'tam_ung', 'con_lanh', 'NgayTao', 'NgayThanhToan'
            ];
            
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('_luong', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};