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
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_url')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->enum('site_status', ['publish', 'closed'])->default('publish');
            $table->enum('user_comment_status', ['publish', 'pending', 'draft'])->default('publish');
            $table->enum('comments_mode', ['open', 'closed'])->default('open');
            $table->string('admin_paginate')->default(10);
            $table->string('posts_per_page')->default(20);
            $table->enum('lang', ['ar', 'en'])->default('en');
            $table->string('fatoora_base_url')->nullable();
            $table->text('fatoora_token')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('currency')->nullable()->default('$');
            $table->string('currency_iso')->nullable()->default('USD');
            $table->integer('testimonials_page')->nullable()->default(1);
            $table->text('map_link')->nullable();
            $table->integer('about_page')->nullable();
            $table->string('realadventures_page')->nullable();
            $table->string('tripadvisor_page')->nullable();
            $table->string('tawk_code')->nullable();


            $table->enum('payment_getway_st', ['enabled', 'disabled'])->default('enabled');
            $table->string('about_sec1_img')->nullable();
            $table->string('about_sec2_link')->nullable();

            $table->integer('header_menu')->nullable();
            $table->string('book_page')->nullable();

            $table->enum('book_menu_st', ['enabled', 'disabled'])->default('enabled');
            $table->enum('langs_menu_st', ['enabled', 'disabled'])->default('enabled');
            $table->enum('login_menu_st', ['enabled', 'disabled'])->default('enabled');

            $table->enum('slider_st', ['enabled', 'disabled'])->default('enabled');
            $table->enum('search_st', ['enabled', 'disabled'])->default('enabled');
            $table->string('about_img1')->nullable();
            $table->string('about_img2')->nullable();
            $table->string('about_img3')->nullable();
            $table->string('about_img4')->nullable();
            $table->string('contact_page')->nullable();
            $table->string('tours_page')->nullable();
            $table->integer('tours_count')->nullable();
            $table->integer('testimonials_count')->nullable();
            $table->integer('images_count')->nullable();
            $table->integer('news_count')->nullable();
            $table->string('footer_logo')->nullable();
            $table->integer('footer_menu')->nullable();
            $table->integer('footer_blog_count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
