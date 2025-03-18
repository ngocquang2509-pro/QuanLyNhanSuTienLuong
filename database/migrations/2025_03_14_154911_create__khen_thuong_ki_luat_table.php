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
        Schema::create('_khen_thuong_ki_luat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nhanVien_id')->constrained('nhanvien')->onDelete('cascade');
            $table->enum('Loai', ['Khen thưởng', 'Kỷ luật']);
            $table->text('NoiDung');
            $table->date('NgayTao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_khen_thuong_ki_luat');
    }
};
