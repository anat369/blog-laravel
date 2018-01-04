<?php

namespace App\Http\Controllers;

use Auth;
use App\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
// если поле было заполнено
        $this->validate($request, [
            'message'	=>	'required'
        ]);

// создаем новый обьект, заполняем его данными и сохраняем в базу
// потом перенаправляем обратно и выводим сообщение
        $comment = new Comment;
        $comment->text = $request->get('message');
        $comment->post_id = $request->get('post_id');
        $comment->user_id = Auth::user()->id;
        $comment->save();

        return redirect()->back()->with('status', 'Ваш комментарий будет скоро добавлен!');
    }
}
