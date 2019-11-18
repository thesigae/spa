<?php namespace Branmuffin\Spa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBranmuffinSpaPages extends Migration
{
    public function up()
    {
        Schema::table('branmuffin_spa_pages', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('branmuffin_spa_pages', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
    }
}
