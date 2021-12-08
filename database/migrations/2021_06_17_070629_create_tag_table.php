<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();

            $table->string('title', 50)->unique();
            $table->string('slug', 52)->unique();

            $table->boolean('active')->default(false);

             $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->index(['active'], 'tags_active_index');
        });
        \Artisan::call('db:seed', array('--class' => 'tagWithInitData'));
    }


    /**
     * 1.4) Tags crud under admin area(with fields: id, name, active. ) with dummy data
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag');
    }
}
