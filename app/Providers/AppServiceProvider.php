<?php

namespace App\Providers;

use App\Post;
use App\Comment;
use App\Category;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
// используем встроенный визуальный композер laravel,
// чтобы выводить на всех страницах одинаковые элементы,
// в данном случае когда загружается наш сайтбар,
// то мы подключаем методы вывода постов, категорий
        view()->composer('pages._sidebar', function($view){
            $view->with('popularPosts', Post::getPopularPosts());
            $view->with('featuredPosts', Post::where('is_featured', 1)->take(2)->get());
            $view->with('recentPosts', Post::orderBy('date', 'desc')->take(2)->get());
            $view->with('categories', Category::all());
        });

        view()->composer('admin._sidebar', function($view){
            $view->with('newCommentsCount', Comment::where('status',0)->count());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
