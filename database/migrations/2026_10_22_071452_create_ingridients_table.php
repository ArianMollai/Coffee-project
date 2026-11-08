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
        Schema::create('ingridients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('base_unit_id')->constrained('units');
            $table->decimal('quantity', 12, 3)->default(0);
            $table->decimal('low_stock_treshhold', 12, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingridients');
    }
};
