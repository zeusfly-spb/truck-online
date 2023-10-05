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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('company_from_id');
            // $table->foreign('company_from_id')->references('id')->on('companies')->onDelete('cascade');
            // $table->unsignedBigInteger('company_to_id');
            // $table->foreign('company_to_id')->references('id')->on('companies')->onDelete('cascade');
            // $table->unsignedBigInteger('order_id');
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('company_from_id')->index();
            $table->unsignedBigInteger('company_to_id')->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->double('amount');
            $table->boolean('notified');
            $table->boolean('payed');
            $table->boolean('fine');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
