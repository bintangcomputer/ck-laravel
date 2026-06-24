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
        Schema::create('jual_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jual_id')->constrained('juals')->onDelete('cascade');
            $table->foreignId('exchange_rate_id')->constrained('exchange_rates')->onDelete('cascade');
            $table->string('currency_code');
            $table->integer('nominal');
            $table->double('selling_rate');
            $table->double('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jual_items');
    }
};
