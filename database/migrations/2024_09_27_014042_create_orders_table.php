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
            $table->bigInteger('order_increament_id');
            $table->integer('user_id');
            $table->string('name','255');
            $table->string('email','255');
            $table->string('phone','255');
            $table->text('address');
            $table->text('address_2');
            $table->string('city','255');
            $table->string('state','255');
            $table->string('country','255');
            $table->string('pincode','255');
            $table->string('coupon','255');
            $table->double('coupon_discount','8,2');
            $table->double('total','8,2');
            $table->string('payment_method','250');
            $table->string('shipping_method','250');
            $table->string('shipping_cost','250');
            $table->string('sub_total','250');
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
