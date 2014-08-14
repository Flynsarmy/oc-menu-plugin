<?php namespace Flynsarmy\Menu\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddMenuitemTargetField extends Migration
{

	public function up()
	{
		Schema::table('flynsarmy_menu_menuitems', function($table)
		{
			$table->string('target_attrib')->default('');
		});
	}

	public function down()
	{
		Schema::table('flynsarmy_menu_menuitems', function($table)
		{
			$table->dropColumn('target_attrib');
		});
	}

}
