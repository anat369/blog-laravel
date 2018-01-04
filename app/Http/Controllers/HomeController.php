<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(6);

        return view('pages.index')->with('posts', $posts);
    }

// метод firstOrFail - показываем нам нужный результат или выводит ошибку
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('post'));
    }

// показываем посты по определенному тегу
    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()->paginate(4);

        return view('pages.list', ['posts'  =>  $posts]);
    }

// показываем посты определенной категории
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()->paginate(4);

        return view('pages.list', ['posts'  =>  $posts]);
    }
}
