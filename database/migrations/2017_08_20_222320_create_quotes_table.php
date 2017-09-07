<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('quotes', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('desginer_id')->unsigned();
          $table->foreign('desginer_id')->references('id')->on('employees');
          $table->integer('seller_id')->unsigned();
          $table->foreign('seller_id')->references('id')->on('employees');
          $table->integer('project_id')->unsigned();
          $table->foreign('project_id')->references('id')->on('projects');
          $table->integer('customer_id')->unsigned();
          $table->foreign('customer_id')->references('id')->on('customers');
          $table->datetime('request_date');
          $table->datetime('delivery_date');
          $table->datetime('close_date');
          $table->float('ammount', 8, 4);
          $table->integer('status');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
}