<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id('cart_id');

            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('product_id');

            $table->string('product_name');
            $table->string('oum');
            $table->string('seller_name');

            $table->decimal('product_amount', 10, 2)->default(0.00);
            $table->timestamps();

            // Prevent duplicate products from the same seller
            // in the same buyer's cart.
            $table->unique(
                ['buyer_id', 'seller_id', 'product_id'],
                'carts_buyer_seller_product_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};