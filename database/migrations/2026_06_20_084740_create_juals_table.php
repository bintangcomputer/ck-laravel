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
        Schema::create('juals', function (Blueprint $table) {
            $table->id();
            $table->string('bill_no', length: 15);
            $table->date('date');
            $table->time('time');

            $table->string('customer_name', length: 100);
            $table->string('customer_phone', length: 50);

            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->string('country_code');
            $table->string('country_name');
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juals');
    }
};
