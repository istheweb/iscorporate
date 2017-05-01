<?php namespace Istheweb\Corporate\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreatePivotsTable extends Migration
{

    public $models = [
        'employee',
        'role',
        'project',
        'project_option',
        'project_type',
        'option_value',
        'variant',
        'budget',
        'invoice'
    ];

    public function up()
    {
        Schema::create('istheweb_iscorporate_pivots', function ($table) {
            $table->engine = 'InnoDB';
            foreach ($this->models as $model) {
                $table->integer($model . '_id')->unsigned()->nullable()->index();
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_pivots');
    }

}