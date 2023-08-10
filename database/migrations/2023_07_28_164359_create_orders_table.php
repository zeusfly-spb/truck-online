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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->nullable();

            $table->unsignedBigInteger('order_status_id')->nullable();;
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('container_id');
            $table->foreign('container_id')->references('id')->on('containers')->onDelete('cascade');

            $table->unsignedBigInteger('from_address_id');
            $table->foreign('from_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('from_date');
            $table->time('from_slot');
            $table->string('from_contact_name');
            $table->string('from_contact_phone');
            $table->string('from_contact_email');

            $table->unsignedBigInteger('delivery_address_id');
            $table->foreign('delivery_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('delivery_date');
            $table->time('delivery_slot');
            $table->string('delivery_contact_name');
            $table->string('delivery_contact_phone');
            $table->string('delivery_contact_email');

            $table->unsignedBigInteger('return_address_id');
            $table->foreign('return_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('return_date');
            $table->time('return_slot');
            $table->string('return_contact_name');
            $table->string('return_contact_phone');
            $table->string('return_contact_email');
            $table->unsignedBigInteger('car_id')->nullable();
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            // car trailer
            $table->unsignedBigInteger('delivery2_adress_id')->nullable();
            $table->foreign('delivery2_adress_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('delivery2_date')->nullable();
            $table->time('delivery2_slot')->nullable();
            $table->string('delivery2_contact_name')->nullable();
            $table->string('delivery2_contact_phone')->nullable();
            $table->string('delivery2_contact_email')->nullable();

            $table->unsignedBigInteger('return2_adress_id')->nullable();
            $table->foreign('return2_adress_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('return2_date')->nullable();
            $table->time('return2_slot')->nullable();
            $table->string('return2_contact_name')->nullable();
            $table->string('return2_contact_phone')->nullable();
            $table->string('return2_contact_email')->nullable();
            $table->unsignedBigInteger('car2_id')->nullable();
            $table->foreign('car2_id')->references('id')->on('cars')->onDelete('cascade');

            $table->double('price');
            $table->double('weight');
            $table->integer('length_algo');
            $table->integer('length_real');
            $table->boolean('imo');
            $table->boolean('temp_reg');
            $table->boolean('is_international');
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
            $table->longText('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
