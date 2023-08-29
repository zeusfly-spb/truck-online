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
        Schema::table('orders', function (Blueprint $table) {
          $table->unsignedBigInteger('executer_id')->nullable();
          $table->foreign('executer_id')->references('id')->on('users')->onDelete('cascade');
          $table->unsignedBigInteger('executer_company_id')->nullable();
          $table->foreign('executer_company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
          $table->dropColumn('executer_id');
          $table->dropColumn('executer_company_id');
        });
    }
};
