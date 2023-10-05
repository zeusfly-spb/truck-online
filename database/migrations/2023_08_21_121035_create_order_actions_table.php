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
        Schema::create('order_actions', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('order_id');
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('order_id')->index();
            $table->string('column_name', 60);
            $table->text('old_value')->nullable();
            $table->text('update_value');
            $table->integer('status');
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->unsignedBigInteger('order_action_id')->nullable();
            // $table->foreign('order_action_id')->references('id')->on('order_actions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('order_action_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_actions');
    }
};
