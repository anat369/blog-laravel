@extends('layout')

@section('content')
    <!--main content start-->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @foreach($posts as $post)
                        <article class="post">
                            <div class="post-thumb">
                                <a href="{{route('post.show', $post->slug)}}"><img src="{{$post->getImage()}}" alt=""></a>
                                <a href="{{route('post.show', $post->slug)}}" class="post-thumb-overlay text-center">
                                    <div class="text-uppercase text-center">Посмотреть</div>
                                </a>
                            </div>
                            <div class="post-content">
                                <header class="entry-header text-center text-uppercase">
                                    @if($post->hasCategory())
                                        <h6> Категория: <a href="{{route('category.show', $post->category->slug)}}"> {{$post->getCategoryTitle()}}</a></h6>
                                    @endif
                                    <h1 class="entry-title"><a href="{{route('post.show', $post->slug)}}">{{$post->title}}</a></h1>
                                </header>

                                <div class="entry-content">
                                    {!!$post->description!!}
                                    <div class="btn-continue-reading text-center text-uppercase">
                                        <a href="{{route('post.show', $post->slug)}}" class="more-link">Читать дальше...</a>
                                    </div>
                                </div>
                                <div class="social-share">
                                    <span class="social-share-title pull-left text-capitalize">Опубликовано: {{$post->getDate()}}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach

                    {{$posts->links()}}
                </div>
                @include('pages._sidebar')
            </div>
        </div>
    </div>
    <!-- end main content-->
@endsection