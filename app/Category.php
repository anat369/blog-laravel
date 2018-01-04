<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;



class Category extends Model
{

    use Sluggable;

    protected $fillable = ['title'];

    public function posts()
    {
// одна категория может быть у нескольких постов
        return $this->hasMany(Post::class);
    }

    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
