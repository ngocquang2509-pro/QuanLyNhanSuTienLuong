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
        Schema::create('chucvu', function (Blueprint $table) {
            $table->id();
            $table->string('TenChucVu');
            $table->bigInteger('LuongCoBan');
            $table->timestamps();
            $table->bigInteger('PC_Chuc_vu');
            $table->bigInteger('PC_Trach_nhiem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chucvu');
    }
};
