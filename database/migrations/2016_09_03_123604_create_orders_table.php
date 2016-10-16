<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 128);
            $table->string('email', 128);
            $table->string('clabe', 128);
            $table->string('account', 128);
            $table->string('bank_name', 128);
            $table->string('bank_address', 128);
            $table->string('comments', 256);
            $table->string('path', 256);
            $table->string('areacode', 128);
            $table->string('cellphone', 128);
            $table->integer('accountType');
            $table->integer('moneybox_id')->unsigned();
            $table->timestamps();

            $table->foreign('moneybox_id')->references('id')->on('moneyboxes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
