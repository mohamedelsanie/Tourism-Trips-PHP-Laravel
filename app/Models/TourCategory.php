<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourCategory extends Model implements TranslatableContract
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;
    protected $table = 'tours_categories';
    public $translatedAttributes = ['title', 'descraption'];

    protected $fillable = [
        'slug',
        'parent',
    ];
    protected $translationForeignKey = 'category_id';

    public function parents(){
        return $this->belongsTo(TourCategory::class,'parent');
    }

    public function childs(){
        return $this->hasMany(TourCategory::class,'parent');
    }

    public static function tree(){
        $allCategories = TourCategory::get();
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
