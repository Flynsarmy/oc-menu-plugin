<?php namespace Flynsarmy\Menu\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMenuitemsTable extends Migration
{

	public function up()
	{
		Schema::create('flynsarmy_menu_menuitems', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('menu_id')->default(0)->unsigned()->index();
			$table->boolean('enabled')->default(false)->index();
			$table->string('label')->default('');
			$table->string('title_attrib')->default('');
			$table->string('id_attrib')->default('');
			$table->string('class_attrib')->default('');
			$table->string('selected_item_id')->default('');
			$table->string('url')->default('');

			// Master objects
			$table->string('master_object_class')->default('');
			$table->string('master_object_id')->default('');

			// Nesting
			$table->integer('parent_id')->default(0)->unsigned()->index();
			$table->integer('nest_left')->default(0);
			$table->integer('nest_right')->default(0);
			$table->integer('nest_depth')->default(0);

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('flynsarmy_menu_menuitems');
	}

}
