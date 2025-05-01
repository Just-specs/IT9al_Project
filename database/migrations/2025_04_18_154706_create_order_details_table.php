<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('purchase_order_id')->constrained();
            $table->string('product_name')->after('purchase_order_id');
            $table->integer('quantity_ordered');
            $table->date('order_date');
            $table->timestamps();

            $table->foreign('part_id')->references('id')->on('products');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
