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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->longtext('name');
            $table->point('location');
            $table->boolean('return');
            $table->boolean('from');
            $table->boolean('to');
            $table->unsignedBigInteger('address_type_id')->nullable();
            $table->foreign('address_type_id')->references('id')->on('address_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
