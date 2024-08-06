<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'post_id','type','tag_id',
    ];

    public function tag()
    {
        return $this->belongsTo(NewsTag::class, 'tag_id');
    }
}
