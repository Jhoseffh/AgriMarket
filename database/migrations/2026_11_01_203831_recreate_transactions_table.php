<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');

            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('product_id');

            $table->string('product_name');
            $table->integer('quantity');
            $table->string('oum');
            $table->string('customer_name');
            $table->string('mobile_number');
            $table->text('address');
            $table->decimal('total_amount', 10, 2);

            $table->enum('status', ['Shipping', 'Completed']);

            $table->timestamp('completion_time', 3)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};