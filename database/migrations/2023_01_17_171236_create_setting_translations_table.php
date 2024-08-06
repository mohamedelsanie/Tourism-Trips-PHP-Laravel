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
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('setting_id')->unsigned();
            $table->string('locale')->index();
            $table->string('site_name');
            $table->string('site_slogan')->nullable();
            $table->string('site_meta_description')->nullable();
            $table->string('site_meta_keywords')->nullable();
            $table->string('close_msg')->nullable();

            $table->text('slider')->nullable()->default('[]');
            $table->string('about_title')->nullable();
            $table->string('about_desc')->nullable();
            $table->string('about_content')->nullable();
            $table->text('about_blocks')->nullable()->default('[]');

            $table->string('about_sec1_title')->nullable();
            $table->text('about_sec1_desc')->nullable();
            $table->text('about_sec1_data')->nullable();
            $table->string('about_sec2_title')->nullable();
            $table->text('about_sec2_desc')->nullable();
            $table->string('about_sec3_title')->nullable();
            $table->text('about_sec3_desc')->nullable();
            $table->text('about_sec3')->nullable()->default('[]');
            $table->text('about_admin')->nullable();

            $table->string('contact_title')->nullable();
            $table->string('contact_desc')->nullable();
            $table->string('tours_title')->nullable();
            $table->string('tours_desc')->nullable();
            $table->string('testimonials_title')->nullable();
            $table->string('testimonials_desc')->nullable();
            $table->string('news_title')->nullable();
            $table->string('news_desc')->nullable();
            $table->string('footer_adress')->nullable();
            $table->string('contact_opening')->nullable();
            $table->string('footer_menu_title')->nullable();
            $table->string('footer_blog_title')->nullable();
            $table->string('footer_subscribe_title')->nullable();
            $table->string('footer_subscribe_desc')->nullable();


            $table->unique(['setting_id', 'locale']);
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_translations');
    }
};
