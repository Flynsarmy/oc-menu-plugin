<?php

namespace Flynsarmy\Menu\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class add_menuitem_data_field extends Migration
{
    public function up()
    {
        Schema::table('flynsarmy_menu_menuitems', function ($table) {
            $table->text('data')->nullable();
        });
    }

    public function down()
    {
        Schema::table('flynsarmy_menu_menuitems', function ($table) {
            $table->dropColumn('data');
        });
    }
}
