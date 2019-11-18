<?php namespace Branmuffin\Spa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBranmuffinSpaCategories extends Migration
{
    public function up()
    {
        Schema::table('branmuffin_spa_categories', function($table)
        {
            $table->increments('id')->change();
        });
    }
    
    public function down()
    {
        Schema::table('branmuffin_spa_categories', function($table)
        {
            $table->integer('id')->change();
        });
    }
}
