
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_requests', function (Blueprint $table) {
            $table->bigIncrements('request_id');

            $table->string('order_id', 20)->nullable();

            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('product_id');

            $table->string('product_name', 255);
            $table->integer('quantity');
            $table->string('oum', 50);

            $table->string('customer_name', 255);
            $table->string('mobile_number', 20);
            $table->text('address');

            $table->decimal('total_amount', 10, 2);

            $table->string('status', 50)->default('Pending');

            $table->timestamps();

            // Foreign keys
            $table->foreign('buyer_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->foreign('seller_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->foreign('product_id')
                  ->references('product_id')
                  ->on('products')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_requests');
    }
};
