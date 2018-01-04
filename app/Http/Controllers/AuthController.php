<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('pages.register');
    }

// проходим валидацию и сохраняем нового пользователя в базу
    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = User::add($request->all());
        $user->generatePassword($request->get('password'));
        return redirect('/login');
    }

// после регистрации перенаправляем пользователя на страницу входа
    public function loginForm()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'	=>	'required|email',
            'password'	=>	'required'
        ]);

// используем метод класса Auth attempt,
// который делает запрос в базу и проверяет - есть ли там
// такой пользователь
// если все в порядке, то заходим под данными пользователя
// и перенаправляем на главную, иначе отправляем пользователя
// назад и показываем сообщение об ошибке
        if(Auth::attempt([
            'email'	=>	$request->get('email'),
            'password'	=>	$request->get('password')
        ]))
        {
            return redirect('/');
        }

        return redirect()->back()->with('status', 'Неправильный логин или пароль');
    }

// при выходе из профиля перенаправляем пользователя на главную страницу
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
