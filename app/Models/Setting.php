<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Setting extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    public $translatedAttributes = [
        'site_name',
        'site_slogan',
        'site_meta_description',
        'site_meta_keywords',
        'close_msg',
        'slider',
        'about_title',
        'about_desc',
        'about_content',
        'about_blocks',
        'about_sec1_title',
        'about_sec1_desc',
        'about_sec1_data',
        'about_sec2_title',
        'about_sec2_desc',
        'about_sec3_title',
        'about_sec3_desc',
        'about_sec3',
        'about_admin',
        'contact_title',
        'contact_desc',
        'tours_title',
        'tours_desc',
        'testimonials_title',
        'testimonials_desc',
        'news_title',
        'news_desc',
        'footer_adress',
        'contact_opening',
        'footer_menu_title',
        'footer_blog_title',
        'footer_subscribe_title',
        'footer_subscribe_desc',
    ];

    protected $fillable = [
        'site_url',
        'site_logo',
        'site_favicon',
        'site_status',
        'admin_paginate',
        'posts_per_page',
        'comments_mode',
        'user_comment_status',
        'lang',
        'fatoora_base_url',
        'fatoora_token',
        'currency',
        'currency_iso',
        'realadventures_page',
        'tripadvisor_page',
        'tawk_code',
        'testimonials_page',
        'about_page',
        'about_sec1_img',
        'about_sec2_link',
        'map_link',
        'facebook',
        'twitter',
        'youtube',
        'instagram',
        'email',
        'phone',
        'header_menu',
        'book_page',
        'payment_getway_st',

        'book_menu_st',
        'langs_menu_st',
        'login_menu_st',

        'slider_st',
        'search_st',
        'about_img1',
        'about_img2',
        'about_img3',
        'about_img4',
        'contact_page',
        'tours_page',
        'tours_count',
        'testimonials_count',
        'images_count',
        'news_count',
        'footer_logo',
        'footer_menu',
        'footer_blog_count',
    ];
    public static function checkSetting(){
        $settings = Self::all();
        if (count($settings) < 1) {
            $data = [
                'id' => 1,
                'site_status' => 'publish',
                'lang' => 'en',
            ];
            foreach (config('translatable.languages') as $key => $value) {
                $data[$key]['site_name'] = $value;
            }
            Self::create($data);
        }
        return Self::first();
    }
}
