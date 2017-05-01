<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateIssueTypesTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_issue_types', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 100);
            $table->string('description', 255);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_issue_types');
    }
}
