<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public  function index()
    {
// вытаскиваем из базы данных все категории и выводим их на страницу
        $categories = Category::all();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

// при создании категории отправляем данные в базу данных
// и возвращаемся на страницу категорий
    public function store(Request $request)
    {
// проверяем, чтобы поле Название категории было заполнено
        $this->validate($request,[
            'title' => 'required'
        ]);
        Category::create($request->all());
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', ['category' => $category]);
    }
// метод изменения категории принимает в качестве параметров запрос и id категории
    public function update(Request $request, $id)
    {
// проверям, чтобы обязательно заполнили поле Название категории
        $this->validate($request,[
            'title' => 'required'
        ]);
        $category = Category::find($id);
        $category->update($request->all());
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
// при удалении обращаемся к таблице, ищем нужную категорию по id,
// удаляем ее и возвращаемся на страницу категорий
        Category::find($id)->delete();
        return redirect()->route('categories.index');
    }
}
