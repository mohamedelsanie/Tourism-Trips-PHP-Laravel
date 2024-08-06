<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsComment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'comment',
        'status',
        'parent',
        'post_id',
        'user_id',
        'comment_stars',
    ];

    public function user(){
        return $this->belongsTomany(User::class,'users');
    }

    public function post(){
        return $this->belongsTomany(News::class,'posts');
    }
    public function children() {
        return $this->hasMany(NewsComment::class, 'parent', 'id');
    }
}
