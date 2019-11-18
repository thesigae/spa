<?php namespace Branmuffin\Spa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBranmuffinSpaPages2 extends Migration
{
    public function up()
    {
        Schema::table('branmuffin_spa_pages', function($table)
        {
            $table->integer('category_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('branmuffin_spa_pages', function($table)
        {
            $table->dropColumn('category_id');
        });
    }
}
