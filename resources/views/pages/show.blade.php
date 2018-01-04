@extends('layout')

@section('content')
    <!--main content start-->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <article class="post">
                        <div class="post-thumb">
                            <a href="{{route('post.show', $post->slug)}}"><img src="{{$post->getImage()}}" alt=""></a>
                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">
                                @if($post->hasCategory())
                                    <h6><a href="{{route('category.show', $post->category->slug)}}"> {{$post->getCategoryTitle()}}</a></h6>
                                @endif
                                <h1 class="entry-title"><a href="{{route('post.show', $post->slug)}}">{{$post->title}}</a></h1>


                            </header>
                            <div class="entry-content">
                                {!! $post->content !!}
                            </div>
                            <div class="decoration">
                                @foreach($post->tags as $tag)
                                    <a href="{{route('tag.show', $tag->slug)}}" class="btn btn-default">{{$tag->title}}</a>
                                @endforeach
                            </div>

                            <div class="social-share">
							<span
                                    class="social-share-title pull-left text-capitalize">Опубликовано: {{$post->getDate()}}</span>
                            </div>
                        </div>
                    </article>

                    @if(!$post->comments->isEmpty())
                        @foreach($post->getComments() as $comment)
                            <div class="bottom-comment"><!--bottom comment-->
                                <div class="comment-img">
                                    <img class="img-circle" src="{{$comment->author->getImage()}}" alt="" width="75" height="75">
                                </div>

                                <div class="comment-text">
                                    <h5>{{$comment->author->name}}</h5>
                                    <p class="comment-date">
                                        {{-- для показа даты используем метод класса Carbon--}}
                                        {{$comment->created_at->diffForHumans()}}
                                    </p>
                                    <p class="para">{{$comment->text}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                <!-- end bottom comment-->

                    {{-- показываем форму комментариев только для авторизованного пользователя --}}
                    @if(Auth::check())
                        <div class="leave-comment"><!--leave comment-->
                            <h4>Добавить комментарий:</h4>
                            <p>(комментарии проходят премодерацию!)</p>
                            <form class="form-horizontal contact-form" role="form" method="post" action="/comment">
                                {{csrf_field()}}
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="6" name="message" placeholder="Текст комментария" required></textarea>
                                    </div>
                                </div>
                                <button class="btn send-btn">Отправить</button>
                            </form>
                        </div><!--end leave comment-->
                    @endif

                    <div class="row" style="background-color: #fff;"><!--blog next previous-->
                        <div class="col-md-6">
                            @if($post->hasPrevious())
                                <div class="related-heading" style="text-align: center">
                                    <h4>Предыдущая статья</h4>
                                </div>
                                <div class="single-blog-box">
                                    <a href="{{route('post.show', $post->getPrevious()->slug)}}">
                                        <img src="{{$post->getPrevious()->getImage()}}" alt="">
                                        <div class="overlay">
                                            <div class="promo-text">
                                                <p><i class=" pull-left fa fa-angle-left"></i></p>
                                                <h5>{{$post->getPrevious()->title}}</h5>
                                            </div>
                                        </div>


                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($post->hasNext())
                                <div class="related-heading" style="text-align: center">
                                    <h4>Следущая статья</h4>
                                </div>
                                <div class="single-blog-box">
                                    <a href="{{route('post.show', $post->getNext()->slug)}}">
                                        <img src="{{$post->getNext()->getImage()}}" alt="">
                                        <div class="overlay">
                                            <div class="promo-text">
                                                <p><i class=" pull-right fa fa-angle-right"></i></p>
                                                <h5>{{$post->getNext()->title}}</h5>

                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div><!--blog next previous end-->
                    <div class="related-post-carousel"><!--related post carousel-->
                        <div class="related-heading">
                            <h4>Вам может быть интересно:</h4>
                        </div>
                        <div class="items">
                            @foreach($post->related() as $item)
                                <div class="single-item">
                                    <a href="{{route('post.show', $item->slug)}}">
                                        <img src="{{$item->getImage()}}" alt="">

                                        <p>{{$item->title}}</p>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div><!--related post carousel-->

                </div>
                @include('pages._sidebar')
            </div>
        </div>
    </div>
    <!-- end main content-->
@endsection