<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateIssueMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_issue_messages', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('messageable_id');
            $table->string('messageable_type');
            $table->text('reply');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_issue_messages');
    }
}
