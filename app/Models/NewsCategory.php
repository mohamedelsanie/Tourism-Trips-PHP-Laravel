<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class NewsCategory extends Model implements TranslatableContract
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = [
        'slug',
        'parent',
    ];
    protected $translationForeignKey = 'category_id';


    public function parents(){
        return $this->belongsTo(NewsCategory::class,'parent');
    }

    public function childs(){
        return $this->hasMany(NewsCategory::class,'parent');
    }

    public static function tree(){
        $allCategories = NewsCategory::get();
        $rootCategories = $allCategories->where('parent','0');
        self::formatTree($rootCategories, $allCategories);
        return $rootCategories;
    }

    private static function formatTree($categories, $allCategories){
        foreach ($categories as $category) {
            $category->children = $allCategories->where('parent', $category->id)->values();
            if ($category->children->isNotEmpty()) {
                self::formatTree($category->children, $allCategories);
            }
        }
    }

    public function isChild(): bool
    {
        return $this->parent_id !== null;
    }

}
