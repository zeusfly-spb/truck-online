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
            $table->enum('order_status',["Черновик","Создан","Выбран","Исполнен","Закрыт","На согласовании","Отмена"]);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('container_id');
            $table->foreign('container_id')->references('id')->on('containers')->onDelete('cascade');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');

            $table->unsignedBigInteger('from_address_id');
            $table->foreign('from_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('from_date')->nullable();
            $table->time('from_slot')->nullable();
            $table->string('from_contact_name')->nullable();
            $table->string('from_contact_phone')->nullable();
            $table->string('from_contact_email')->nullable();

            $table->unsignedBigInteger('delivery_address_id');
            $table->foreign('delivery_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('delivery_date')->nullable();
            $table->time('delivery_slot')->nullable();
            $table->string('delivery_contact_name')->nullable();
            $table->string('delivery_contact_phone')->nullable();
            $table->string('delivery_contact_email')->nullable();

            $table->unsignedBigInteger('return_address_id');
            $table->foreign('return_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('return_date')->nullable();
            $table->time('return_slot')->nullable();
            $table->string('return_contact_name')->nullable();
            $table->string('return_contact_phone')->nullable();
            $table->string('return_contact_email')->nullable();
            $table->unsignedBigInteger('car_id')->nullable();
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            // car trailer
            $table->unsignedBigInteger('delivery2_address_id')->nullable();
            $table->foreign('delivery2_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('delivery2_date')->nullable();
            $table->time('delivery2_slot')->nullable();
            $table->string('delivery2_contact_name')->nullable();
            $table->string('delivery2_contact_phone')->nullable();
            $table->string('delivery2_contact_email')->nullable();

            $table->unsignedBigInteger('return2_address_id')->nullable();
            $table->foreign('return2_address_id')->references('id')->on('addresses')->onDelete('cascade');
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
            $table->integer('length_real')->nullable();
            $table->boolean('imo');
            $table->boolean('temp_reg');
            $table->boolean('is_international');

            $table->longText('description')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('taxes')->onDelete('cascade');
            $table->unsignedBigInteger('executer_id')->nullable();
            $table->foreign('executer_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('executer_company_id')->nullable();
            $table->foreign('executer_company_id')->references('id')->on('companies')->onDelete('cascade');
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
