<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payments'))
        {
            Schema::create('payments', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('person_id')->unsigned(); //FK
                $table->integer('moneybox_id')->unsigned(); //FK
                $table->decimal('amount',10,2);
                $table->string('uid')->unique();
                $table->enum('method', ['P','O','S']);
                $table->enum('status', ['PENDING', 'CANCELED', 'PAYED']);
                $table->timestamps();

                $table->foreign('person_id')->references('id')->on('persons');
                $table->foreign('moneybox_id')->references('id')->on('moneyboxes');

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
