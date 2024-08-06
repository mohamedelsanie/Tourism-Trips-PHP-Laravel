<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageComment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'comment',
        'status',
        'parent',
        'page_id',
        'user_id',
        'comment_stars',
    ];

    public function user(){
        return $this->belongsTomany(User::class,'users');
    }

    public function page(){
        return $this->belongsTomany(Page::class,'pages');
    }
    public function children() {
        return $this->hasMany(PageComment::class, 'parent', 'id');
    }
}
