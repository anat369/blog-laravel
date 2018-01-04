<?php

namespace App;

use \Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const IS_BANNED = 1;
    const IS_ACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

// один пользователь может иметь несколько постов и несколько комментариев
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

// создаем нового пользователя
    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->save();
        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields); //редактируем имя и почту

        $this->save();
    }

// при изменении поля пароля заново его шифруем
    public function generatePassword($password)
    {
        if($password != null)
        {
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function remove()
    {
        $this->removeAvatar();
        $this->delete();
    }

    public function uploadAvatar($image)
    {
        if($image == null)
        {
            return;
        }

        $this->removeAvatar();
        $filename = str_random(10) . '.' . $image->extension();
// сохраняем аватарку
        $image->storeAs('uploads', $filename);
        $this->avatar = $filename;
        $this->save();
    }

    public function removeAvatar()
    {
// при удалении пользователя удаляем его аватарку, если она была
        if($this->avatar != null)
        {
            Storage::delete('uploads/' . $this->avatar);
        }
    }

    public function getImage()
    {
        if($this->avatar == null)
        {
            return '/img/no-image.png';
        }
        return '/uploads/' . $this->avatar;
    }

// методы присвоения статуса админа или просто пользователя
    public function makeAdmin()
    {
        $this->is_admin = 1;
        $this->save();
    }

    public function makeNormal()
    {
        $this->is_admin = 1;
        $this->save();
    }

    public function toggleAdmin($value)
    {
        if ($value == null)
        {
            return $this->makeNormal();
        }
        else
        {
            return $this->makeAdmin();
        }
    }

// методы для определения статуса забанен или нет
    public function ban()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }

    public function unban()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    public function toggleBan($value)
    {
        if ($value == null)
        {
            return $this->ban();
        }
        else
        {
            return $this->unban();
        }
    }

}
