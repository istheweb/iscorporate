<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use Carbon\Carbon;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProjectTypesTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_project_types', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug')->index()->unique();
            $table->text('description')->nullable();
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('nest_left')->default(0);
            $table->integer('nest_right')->default(0);
            $table->integer('nest_depth')->default(0);
            $table->date('published_at')->default(Carbon::now());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_project_types');
    }
}
