<?php namespace Flynsarmy\Menu\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMenusTable extends Migration
{

	public function up()
	{
		Schema::create('flynsarmy_menu_menus', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name')->default('');
			$table->string('id_attrib')->default('');
			$table->string('class_attrib')->default('');
			$table->string('short_desc')->default('');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('flynsarmy_menu_menus');
	}

}
