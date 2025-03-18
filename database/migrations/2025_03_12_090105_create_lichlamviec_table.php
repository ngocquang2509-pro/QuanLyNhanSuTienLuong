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
        Schema::create('lichlamviec', function (Blueprint $table) {
            $table->id();
            $table->date('NgayLamViec');
            $table->foreignId('nhanvien_id')->constrained('nhanvien')->onDelete('cascade');
            $table->foreignId('ca_id')->constrained('calamviec')->onDelete('cascade');
            $table->timestamps();
            $table->string('MoTa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lichlamviec');
    }
};
