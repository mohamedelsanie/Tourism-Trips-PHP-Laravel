<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_link_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_links_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');
            $table->string('name')->nullable();
            $table->string('slug');

            $table->unique(['menu_links_id', 'locale']);
            $table->foreign('menu_links_id')->references('id')->on('menu_links')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_link_translations');
    }
};
