<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (! Schema::hasTable('kartwise_compare_items')) {
            Schema::create('kartwise_compare_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('customer_id')->nullable();
                $table->unsignedInteger('product_id');
                $table->timestamps();

                $table->unique(['customer_id', 'product_id']);

                $table->foreign('customer_id')
                      ->references('id')->on('customers')
                      ->onDelete('cascade');

                $table->foreign('product_id')
                      ->references('id')->on('products')
                      ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('kartwise_compare_items');
    }
};
