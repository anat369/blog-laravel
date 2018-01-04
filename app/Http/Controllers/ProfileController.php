<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
// авторизовались и попали на страницу профиля
        $user = Auth::user();
        return view('pages.profile', ['user'	=>	$user]);
    }

// после валидации можно изменить профиль
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'	=>	'required',
            'email' =>  [
                'required',
                'email',
                Rule::unique('users')->ignore(Auth::user()->id),
            ],
            'avatar'	=>	'nullable|image'
        ]);

        $user = Auth::user();
        $user->edit($request->all());
        $user->generatePassword($request->get('password'));
        $user->uploadAvatar($request->file('avatar'));

// после изменения профиля перенаправляем на страницу профиля и выводим сообщение
        return redirect()->back()->with('status', 'Профиль успешно обновлен');
    }
}
