<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuLinksTranslation extends Model
{
    use HasFactory;
    protected $table = 'menu_link_translations';

    public $timestamps = false;
    protected $fillable = ['title', 'name', 'slug'];
}
