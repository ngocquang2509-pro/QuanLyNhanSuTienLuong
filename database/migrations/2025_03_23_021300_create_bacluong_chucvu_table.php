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
        Schema::create('bacluong_chucvu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chucvu_id')->constrained('chucvu')->onDelete('cascade');
            $table->foreignId('bacluong_id')->constrained('bacluong')->onDelete('cascade');
            $table->decimal('HeSo', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bacluong_chucvu');
    }
};
