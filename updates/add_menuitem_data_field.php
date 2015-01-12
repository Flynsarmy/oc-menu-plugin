<?php namespace Flynsarmy\Menu\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddMenuitemDataField extends Migration
{

	public function up()
	{
		Schema::table('flynsarmy_menu_menuitems', function($table)
		{
			$table->text('data')->nullable();
		});
	}

	public function down()
	{
		Schema::table('flynsarmy_menu_menuitems', function($table)
		{
			$table->dropColumn('data');
		});
	}

}
