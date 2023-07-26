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
          $table->string('iin',11)->unique();
          $table->string('kpp',9);
          $table->string('ogrn');
          $table->string('phone',11);
          $table->string('email');
          $table->string('short_name');
          $table->string('full_name');
          $table->string('link');
          $table->date('company_reg_date');
          $table->string('edo_provider');
          $table->string('edo_id');
          //relation types
          $table->unsignedBigInteger('user_id');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->unsignedBigInteger('tax_id');
          $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
          $table->unsignedBigInteger('country_id');
          $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
          $table->unsignedBigInteger('address_id');
          $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
          $table->unsignedBigInteger('post_address_id');
          $table->foreign('post_address_id')->references('id')->on('addresses')->onDelete('cascade');
          //nullable types
          $table->string('contact')->nullable();
          $table->date('data_contract')->nullable();
          $table->mediumText('ceo_name')->nullable();
          $table->mediumText('cceo_name')->nullable();
          $table->mediumText('cceo_contract_name')->nullable();
          $table->date('cceo_contract_date')->nullable();

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
