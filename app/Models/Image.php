<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model implements TranslatableContract
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    public $translatedAttributes = ['title', 'description', 'content'];
    protected $fillable = [
        'slug',
        'image',
        'gallery',
        'status',
        'comments_status',
        'admin_id',
    ];
    protected $casts = [
        'gallery' => 'array',
    ];
    public function admin(){
        return $this->belongsTomany(Admin::class,'admins');
    }
}
