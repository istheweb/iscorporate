<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_projects', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->string('code')->unique();
            $table->string('name', 255)->index();
            $table->string('slug', 255)->index()->unique();
            $table->integer('status')->default(1);
            $table->integer('now')->default(1);
            $table->longText('comment')->nullable();
            $table->longText('project_description')->nullable();
            $table->string('caption')->nullable();
            $table->longText('description')->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->longText('short_description')->nullable();
            $table->dateTime('available_on');
            $table->dateTime('available_until');
            $table->boolean('enabled')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_projects');
    }
}
