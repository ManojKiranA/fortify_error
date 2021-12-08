<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'id';
    public $timestamps = false;

    use Sluggable;

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    private static $tagStatusLabelValueArray = [1 => 'Активен', 0 => 'Неактивен'];
    public static function getTagStatusValueArray($key_return = true): array
    {
        $resArray = [];
        foreach (self::$tagStatusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            } else {
                $resArray[$key] = $value;
            }
        }

        return $resArray;
    }

    public static function getTagStatusLabel(string $status): string
    {
        if ( isset(self::$tagStatusLabelValueArray[$status])) {
            return self::$tagStatusLabelValueArray[$status];
        }

        return '';
    }


    public function scopeGetByActive($query, $active = null)
    {
        if (!isset($active) or strlen($active) == 0) {
            return $query;
        }
        return $query->where(with(new Tag)->getTable().'.active', $active);
    }



    public function scopeGetByTitle($query, $title = null)
    {
        if (empty($title)) {
            return $query;
        }

        return $query->where(with(new Tag)->getTable() . '.title', 'like', '%' . $title . '%');
    }


    protected static function boot()
    {

        parent::boot();

        static::deleting(function ($tag) {
        });

        static::updating(function ($tagItem) {
//            if ( !empty($tagItem->slug) ) {
//                $slug = $tagItem->slug;
//            } else {
            $slug = SlugService::createSlug(Tag::class, 'slug',  $tagItem->title);
//            }
            $tagItem->slug = $slug;
        });

    }


//    public function ProjectTagTagged()
//    {
//        return $this->hasMany(ProjectTagTagged::class);
//    }
//

    public static function getTagValidationRulesArray(  $tag_id = null, array $skipFieldsArray = []
    ): array {
        $validationRulesArray = [
            'title'       => [
                'required',
                'string',
                'max:50',
                Rule::unique(with(new Tag)->getTable())->ignore($tag_id),
            ],
            'active'  => 'nullable',
        ];

        foreach ($skipFieldsArray as $next_field) {
            if ( ! empty($validationRulesArray[$next_field])) {
                unset($validationRulesArray[$next_field]);
            }
        }

        return $validationRulesArray;
    }

}
