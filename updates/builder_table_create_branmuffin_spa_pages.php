<?php namespace Branmuffin\Spa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBranmuffinSpaPages extends Migration
{
    public function up()
    {
        Schema::create('branmuffin_spa_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('text');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('branmuffin_spa_pages');
    }
}
