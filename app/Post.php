<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;


class Post extends Model
{

    use Sluggable;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;

    protected $fillable = ['title','content', 'date', 'description'];

// методы для установки связи постов с категориями, авторам и тегами
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */

// данный метод помогает создавать сео дружелюбные ссылки,
// например, если title на русском, то метод переводит в латиницу
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function add($fields)
    {
// создаем экземпляр класса post
        $post = new static;
// заполняем его данными
        $post->fill($fields);
// сохраняем его
        $post->user_id = Auth::user()->id;
        $post->save();

        return $post;
    }

    public function edit($fields)
    {
// редактируем пост, заполняя его новыми данными и сохраняем
        $this->fill($fields);
        $this->save();
    }

// удаляем пост, используя стандартный метод laravel delete
    public function remove()
    {
// при удалении поста удаляем и картинку
        $this->removeImage();
        $this->delete();
    }

    public  function uploadImage($image)
    {
        if ($image == null)
        {
            return;
        }
        $this->removeImage();
// формируем название картинки, используя рандом из 10 символов
        $filename = str_random(10) . '.' . $image->extension();
// загружаем полученную картинку в папку uploads
        $image->storeAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }
// метод вызова картинки у поста, если картинки нет,
// то выводим дефолтную
    public function getImage()
    {
        if ($this->image == null)
        {
            return '/public/img/no-image.png';
        }
        return '/public/uploads/' . $this->image;
    }

    public function removeImage()
    {
        if ($this->image !== null)
        {
// используя стандартный класс laravel Storage удаляем картинку,
// если она была раньше загружена
            Storage::delete('uploads/' . $this->image);
        }
    }

    public function setCategory($id)
    {
        if ($id == null)
        {
            return;
        }
// если у поста есть категория, то устанавливаем связь
        $this->category_id = $id;
        $this->save();
    }

// у поста может быть несколько тегов, поэтому передаем массив
    public function setTags($ids)
    {
        if ($ids == null)
        {
            return;
        }
// используем для связи стандартный метод laravel sync
        $this->tags()->sync($ids);
    }

// если пост черновик, то значение IS_DRAFT
    public function setDraft()
    {
        $this->status = Post::IS_DRAFT;
        $this->save();
    }

// если пост опубликован, то значение IS_PUBLIC
    public function setPublic()
    {
        $this->status = Post::IS_PUBLIC;
        $this->save();
    }

// метод переключения состояние поста между черновик и опубликован
    public function toggleStatus($value)
    {
        if ($value == null)
        {
           return $this->setDraft();
        }
        else
        {
           return $this->setPublic();
        }
    }

// аналогично создаем метод переключения между
// рекомендованный пост и нерекомендованный пост
    public function setFeatured()
    {
        $this->is_featured = 0;
        $this->save();
    }

    public function setStandart()
    {
        $this->is_featured = 1;
        $this->save();
    }

    public function toggleFeatured($value)
    {
        if ($value == null)
        {
            return $this->setStandart();
        }
        else
        {
            return $this->setFeatured();
        }
    }

    public function setDateAttribute($value)
    {
// используем класс laravel Carbon для преобразования вида даты в такой,
// чтобы он сохранялся в базу данных mysql без ошибок
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }

    public function getDateAttribute($value)
    {
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');

        return $date;
    }

    public function getCategoryTitle()
    {
        return ($this->category != null)
            ?   $this->category->title
            :   'Нет категории';
    }

    public function getTagsTitles()
    {
        return (!$this->tags->isEmpty())
            ?   implode(', ', $this->tags->pluck('title')->all())
            : 'Нет тегов';
    }

    public function getCategoryID()
    {
// делаем проверку на наличие категории у поста, если ее нет, то выводим  null
        return $this->category != null ? $this->category->id : null;
    }

    public function getDate()
    {
// используем класс Carbon чтобы показывать дату, взятую из базы в одном формате, в нужном формате
        return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
    }

// метод для показа предыдущего поста
    public function hasPrevious()
    {
// выводим пост с id, которое меньше чем у текущего поста,
// но самое максимальное из меньших, то есть, если у нас сейчас
// пост с id = 10, то мы вытаскиваем пост с id = 9
        return self::where('id', '<', $this->id)->max('id');
    }

    public function getPrevious()
    {
        $postID = $this->hasPrevious(); //ID
        return self::find($postID);
    }

// показываем следующий пост за текущим
    public function hasNext()
    {
        return self::where('id', '>', $this->id)->min('id');
    }

    public function getNext()
    {
        $postID = $this->hasNext();
        return self::find($postID);
    }

// выводим все посты, кроме текущего
    public function related()
    {
        return self::all()->except($this->id);
    }

// метод вывода категории у поста, если категории нет - ничего не выводим
    public function hasCategory()
    {
        return $this->category != null ? true : false;
    }

    public static function getPopularPosts()
    {
        return self::orderBy('views','desc')->take(3)->get();
    }

    public function getComments()
    {
// выводим только одобренные комментарии, то есть, со статусом 1
        return $this->comments()->where('status', 1)->get();
    }
}
