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
            $table->integer('user_id')->unsigned()->index();
            $table->string('name')->nullable()->default('');
            $table->string('short_desc')->nullable()->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('flynsarmy_menu_menus');
    }

}
