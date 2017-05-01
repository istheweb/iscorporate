<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateIssuesTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_issues', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('client_id')->unsigned()->index();
            $table->integer('resource_id')->unsigned()->index();
            $table->integer('creator_id')->unsigned()->index();
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->tinyInteger('type_id')->unsigned()->index();
            $table->string('name_contact', 255)->nullable();
            $table->string('surname_contact', 255)->nullable();
            $table->string('subject', 600)->nullable();
            $table->text('content')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->softDeletes();
            $table->datetime('status_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_issues');
    }
}
