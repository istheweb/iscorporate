<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOptionValuesTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_option_values', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('project_option_id')->unsigned();
            $table->string('code')->unique();
            $table->string('value', 255);
            $table->float('price', 18,2);
            //$table->longText('data')->nullable();
            //$table->longText('urls')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_option_values');
    }
}
