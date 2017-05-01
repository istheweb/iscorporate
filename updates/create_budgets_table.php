<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBudgetsTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_budgets', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('client_id')->unsigned()->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->tinyInteger('estado')->nullable();
            $table->string('motivo', 255)->nullable();
            $table->text('observaciones_entrega')->nullable();
            $table->text('motivo_no_aceptacion')->nullable();
            $table->tinyInteger('is_project_created')->default(0);
            $table->string('invoice')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_budgets');
    }
}
