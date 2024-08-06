<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Tour extends Model implements TranslatableContract
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    public $translatedAttributes = ['title', 'content', 'description', 'from_place', 'to_place'];

    protected $fillable = [
        'slug',
        'image',
        'from_date',
        'to_date',
        'price',
        'price_eg',
        'status',
        'category_id',
        'comments_status',
        'admin_id',
    ];

    public function admin(){
        return $this->belongsTomany(Admin::class,'admins');
    }

    public function category(){
        return $this->belongsTo(TourCategory::class,'category_id');
    }

}
