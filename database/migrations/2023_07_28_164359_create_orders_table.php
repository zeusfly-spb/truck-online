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

            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('container_id')->index();
            $table->unsignedBigInteger('tax_id')->index();

            $table->unsignedBigInteger('from_address_id')->index();
            $table->date('from_date')->nullable();
            $table->time('from_slot')->nullable();
            $table->string('from_contact_name')->nullable();
            $table->string('from_contact_phone')->nullable();
            $table->string('from_contact_email')->nullable();

            $table->unsignedBigInteger('delivery_address_id')->index();
            $table->date('delivery_date')->nullable();
            $table->time('delivery_slot')->nullable();
            $table->string('delivery_contact_name')->nullable();
            $table->string('delivery_contact_phone')->nullable();
            $table->string('delivery_contact_email')->nullable();

            $table->unsignedBigInteger('return_address_id')->index();
            $table->date('return_date')->nullable();
            $table->time('return_slot')->nullable();
            $table->string('return_contact_name')->nullable();
            $table->string('return_contact_phone')->nullable();
            $table->string('return_contact_email')->nullable();
            $table->unsignedBigInteger('car_id')->index()->nullable();
            // car trailer
            $table->unsignedBigInteger('delivery2_address_id')->index()->nullable();
            $table->date('delivery2_date')->nullable();
            $table->time('delivery2_slot')->nullable();
            $table->string('delivery2_contact_name')->nullable();
            $table->string('delivery2_contact_phone')->nullable();
            $table->string('delivery2_contact_email')->nullable();

            $table->unsignedBigInteger('return2_address_id')->index()->nullable();
            $table->date('return2_date')->nullable();
            $table->time('return2_slot')->nullable();
            $table->string('return2_contact_name')->nullable();
            $table->string('return2_contact_phone')->nullable();
            $table->string('return2_contact_email')->nullable();
            $table->unsignedBigInteger('car2_id')->index()->nullable();

            $table->double('price');
            $table->double('weight');
            $table->integer('length_algo');
            $table->integer('length_real')->nullable();
            $table->boolean('imo');
            $table->boolean('temp_reg');
            $table->boolean('is_international');

            $table->longText('description')->nullable();
            $table->unsignedBigInteger('driver_id')->index()->nullable();
            $table->unsignedBigInteger('executer_id')->index()->nullable();
            $table->unsignedBigInteger('executer_company_id')->index()->nullable();
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
