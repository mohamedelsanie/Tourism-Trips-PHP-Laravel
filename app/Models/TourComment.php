<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourComment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tours_comments';
    protected $fillable = [
        'name',
        'comment',
        'status',
        'parent',
        'tour_id',
        'user_id',
        'comment_stars',
    ];

    public function user(){
        return $this->belongsTomany(User::class,'users');
    }

    public function tour(){
        return $this->belongsTo(Tour::class,'tour_id');
    }
    public function children() {
        return $this->hasMany(ImageComment::class, 'parent', 'id');
    }
}
