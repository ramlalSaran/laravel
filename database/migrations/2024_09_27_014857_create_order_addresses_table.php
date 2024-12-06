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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('user_id');
            $table->string('name','255');
            $table->string('email','255');
            $table->string('phone','255');
            $table->text('address');
            $table->text('address_2');
            $table->string('city','255');
            $table->string('state','255');
            $table->string('country','255');
            $table->string('pincode','250');
            $table->string('address_type','250');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
