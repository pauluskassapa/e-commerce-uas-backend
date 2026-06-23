<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label')->default('Alamat Utama');
            $table->text('address');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->text('shipping_address')->nullable()->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('shipping_address');
        });

        Schema::dropIfExists('user_addresses');
    }
};
