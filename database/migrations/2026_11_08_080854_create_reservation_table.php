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
        Schema::create('reservation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('table_id')->constrained('tables')->cascadeOnDelete();
            $table->datetime('starts_at');
            $table->datetime('ends_at');
            $table->datetime('payment_expires_at');
            $table->enum('status', ['pending', 'confirmed', 'expired'])->default('pending');
            $table->decimal('price', 12, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};
