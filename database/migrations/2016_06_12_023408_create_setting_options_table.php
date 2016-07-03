<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('setting_options'))
        {
            Schema::create('setting_options', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('setting_id')->unsigned(); //FK
                $table->string('name', 128);
                $table->enum('subtype', ['','text','radio','checkbox']);
                $table->timestamps();

                $table->foreign('setting_id')->references('id')->on('settings');
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
        Schema::dropIfExists('setting_options');
    }
}
