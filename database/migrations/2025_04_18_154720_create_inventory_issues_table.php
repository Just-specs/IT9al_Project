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
        Schema::create('inventory_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id');
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->integer('quantity_issued');
            $table->date('issue_date');
            $table->timestamps();
            
            $table->foreign('part_id')->references('id')->on('products');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_issues');
    }
};
