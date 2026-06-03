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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('identity_number', length: 25);
            $table->string('name', length: 100);
            $table->text('adress');
            $table->string('phone');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->string('occupation');
            $table->date('identity_expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
