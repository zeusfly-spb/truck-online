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
      Schema::create('companies', function (Blueprint $table) {
          $table->id();
          $table->string('inn',12)->unique();
          $table->string('short_name');
          $table->string('kpp',9)->nullable();
          $table->string('ogrn')->nullable();
          $table->string('phone',10);
          $table->string('email')->nullable();
          $table->string('full_name')->nullable();
          $table->string('link')->nullable();
          $table->date('company_reg_date')->nullable();
          $table->string('edo_provider')->nullable();
          $table->string('edo_id')->nullable();
          //relation types

          //nullable types
          $table->string('contact')->nullable();
          $table->date('data_contract')->nullable();
          $table->mediumText('ceo_name')->nullable();
          $table->mediumText('cceo_name')->nullable();
          $table->mediumText('cceo_contract_name')->nullable();
          $table->date('cceo_contract_date')->nullable();

        $table->unsignedBigInteger('user_id')->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->unsignedBigInteger('tax_id')->nullable();;
        $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
        $table->unsignedBigInteger('country_id')->nullable();;
        $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        $table->unsignedBigInteger('address_id')->nullable();;
        $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
        $table->unsignedBigInteger('post_address_id')->nullable();;
        $table->foreign('post_address_id')->references('id')->on('addresses')->onDelete('cascade');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
