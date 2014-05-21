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
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('short_desc');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('flynsarmy_menu_menus');
    }

}
