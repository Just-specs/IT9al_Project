<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('product_id');
            $table->string('action_type', 50);
            $table->unsignedBigInteger('reference_id')->nullable(); 
            $table->integer('quantity_changed'); 
            $table->integer('balance_after'); 
            $table->unsignedBigInteger('performed_by'); 
            $table->text('remarks')->nullable();
            $table->timestamp('log_date')->useCurrent();

           
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('inventory_logs');
    }
}