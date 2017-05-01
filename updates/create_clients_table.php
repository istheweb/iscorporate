<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_clients', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->tinyInteger('estado')->default(0);
            $table->integer('company_id')->unsigned();
            $table->string('actividad', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('forma_pago', 255)->nullable();
            $table->string('banco', 255)->nullable();
            $table->string('sucursal', 255)->nullable();
            $table->string('dc', 3)->nullable();
            $table->string('cuenta', 255)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_clients');
    }
}
