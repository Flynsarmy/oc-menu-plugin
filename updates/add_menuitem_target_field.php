<?php

namespace Flynsarmy\Menu\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class add_menuitem_target_field extends Migration
{
    public function up()
    {
        Schema::table('flynsarmy_menu_menuitems', function ($table) {
            $table->string('target_attrib')->default('');
        });
    }

    public function down()
    {
        Schema::table('flynsarmy_menu_menuitems', function ($table) {
            $table->dropColumn('target_attrib');
        });
    }
}
