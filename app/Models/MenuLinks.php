<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class MenuLinks extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $timestamps = false;

    public $translatedAttributes = ['title', 'name', 'slug'];

    protected $fillable = [
        'type',
        'target',
        'menu_id',
    ];
}
