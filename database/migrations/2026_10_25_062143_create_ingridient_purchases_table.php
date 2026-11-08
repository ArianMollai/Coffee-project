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
        Schema::create('ingridient_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingridient_id')->constrained('ingridients');
            $table->foreignId('unit_id')->constrained('units');
            $table->decimal('quantity', 12, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingridient_purchases');
    }
};
