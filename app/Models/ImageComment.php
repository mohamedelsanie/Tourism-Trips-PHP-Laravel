<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageComment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'comment',
        'status',
        'parent',
        'image_id',
        'user_id',
        'comment_stars',
    ];

    public function user(){
        return $this->belongsTomany(User::class,'users');
    }

    public function image(){
        return $this->belongsTomany(Image::class,'images');
    }
    public function children() {
        return $this->hasMany(ImageComment::class, 'parent', 'id');
    }
}
