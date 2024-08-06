<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
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
}
