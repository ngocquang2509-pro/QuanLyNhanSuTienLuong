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
        Schema::create('chamcong', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->time('GioVao');
            $table->time('GioRa');
            $table->string('NguonMay');
            $table->decimal('SoCong', 5, 2);
            $table->string('TrangThai');
            $table->foreignId('nhanvien_id')->constrained('nhanvien')->onDelete('cascade');
            $table->foreignId('lichlamviec_id')->nullable()->constrained('lichlamviec')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamcong');
    }
};