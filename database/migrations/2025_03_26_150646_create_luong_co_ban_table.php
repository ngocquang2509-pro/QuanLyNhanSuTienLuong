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
        Schema::create('luong_co_ban', function (Blueprint $table) {
            $table->id();
            $table->string('Ten');
            $table->decimal('LuongTheoThang', 15, 2);
            $table->decimal('LuongTheoGio', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luong_co_ban');
    }
};
