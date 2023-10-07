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
        Schema::create('calc_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('container_id')->index();
            $table->unsignedBigInteger('from_address_id')->index();
            $table->unsignedBigInteger('delivery_address_id')->index();
            $table->unsignedBigInteger('return_address_id')->index();
            $table->unsignedBigInteger('delivery2_address_id')->index()->nullable();
            $table->unsignedBigInteger('return2_address_id')->index()->nullable();
            $table->unsignedBigInteger('tax_id')->index();

            $table->double('price');
            $table->double('distance');
            $table->double('weight');
            $table->boolean('imo');
            $table->boolean('temp_reg');
            $table->boolean('is_international');
            $table->boolean('hidden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calc_histories');
    }
};
