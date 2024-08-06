<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class News extends Model implements TranslatableContract
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;
    public $translatedAttributes = ['title', 'content', 'description'];

    protected $fillable = [
        'slug',
        'image',
        'status',
        'category_id',
        'comments_status',
        'admin_id',
    ];

    public function admin(){
        return $this->belongsTomany(Admin::class,'admins');
    }
    public function category(){
        return $this->belongsTo(NewsCategory::class,'category_id');
    }

}
