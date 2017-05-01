<?php namespace Istheweb\IsCorporate\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('istheweb_iscorporate_invoices', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('budget_id')->unsigned();
            $table->string('invoice_number', 255)->unique();
            $table->date('invoice_date')->nullable();
            $table->date('vto_date')->nullable();
            $table->date('send_date')->nullable();
            $table->tinyInteger('payment_type')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_pdf')->default(0);
            $table->tinyInteger('client_sent')->default(0);
            $table->float('taxable_base');
            $table->integer('tax');
            $table->float('total');
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('istheweb_iscorporate_invoices');
    }
}
