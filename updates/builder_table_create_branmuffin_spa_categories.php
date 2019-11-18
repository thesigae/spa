<?php namespace Branmuffin\Spa\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBranmuffinSpaCategories extends Migration
{
    public function up()
    {
        Schema::create('branmuffin_spa_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->string('title');
            $table->string('slug');
            $table->text('text');
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('branmuffin_spa_categories');
    }
}
