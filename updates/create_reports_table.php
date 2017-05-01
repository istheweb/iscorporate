<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateReportsTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_reports', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('variant_id')->unsigned();
            //$table->integer('employee_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->integer('hours');
            $table->integer('minutes');
            $table->longText('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_reports');
    }
}
