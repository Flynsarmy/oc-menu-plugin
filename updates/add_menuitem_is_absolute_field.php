<?php namespace Flynsarmy\Menu\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddMenuitemIsAbsoluteField extends Migration
{

	public function up()
	{
		Schema::table('flynsarmy_menu_menuitems', function($table)
		{
			$table->string('is_absolute')->default(0);
		});
	}

	public function down()
	{
		Schema::table('flynsarmy_menu_menuitems', function($table)
		{
			$table->dropColumn('is_absolute');
		});
	}

}
