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
        Schema::create('prices_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_id')->constrained('prices')->cascadeOnDelete();
            $table->foreignId('attribute_value_id')->constrained('attribute_value')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices_attribute_values');
    }
};
