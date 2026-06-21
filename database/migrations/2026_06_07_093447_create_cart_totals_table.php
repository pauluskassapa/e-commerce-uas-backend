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
        Schema::create('cart_totals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('cart_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->integer('total_item')->default(0);
    $table->decimal('total_price', 15, 2)->default(0);
});
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_totals');
    }
};
