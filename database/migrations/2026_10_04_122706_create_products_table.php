<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');

            $table->foreignId('seller_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('product_name');
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->string('oum');
            $table->string('image')->nullable();
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};