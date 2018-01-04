<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public static  function add($email)
    {
        $sub = new static;
        $sub->email = $email;
        $sub->save();
        return $sub;
    }

// генерируем токен для подтверждения подписки
    public function generateToken()
    {
        $this->token = str_random(50);
        $this->save();
    }

// удаляем подписчика
    public function remove()
    {
        $this->delete();
    }
}
