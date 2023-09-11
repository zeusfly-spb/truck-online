<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('phone_confirmations', function (Blueprint $table) {
      $table->id();
      $table->string('phone', 10);
      $table->string('code', 4);
      $table->boolean('confirmed')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('phone_confirmations');
  }
};
