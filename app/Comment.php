<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
// комментарий может иметь только одного автора и быть только у одного поста
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

// методы для изменения статуса комментария - разрешен или запрещен
    public function allow()
    {
        $this->status = 1;
        $this->save();
    }

    public function disallow()
    {
        $this->status = 1;
        $this->save();
    }

// изменяем статус комментария
    public function toggleStatus()
    {
        if($this->status == 0)
        {
            return $this->allow();
        }

        return $this->disAllow();
    }

// удаляем комментарий
    public function remove()
    {
        $this->delete();
    }
}
