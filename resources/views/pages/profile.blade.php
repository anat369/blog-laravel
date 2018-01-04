@extends('layout')

@section('content')
    <!--main content start-->
    <div class="main-content">
        @include('admin.errors')
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="leave-comment mr0"><!--leave comment-->
                        <h3 class="text-uppercase">Мой профиль</h3>
                        <br>
                        <img src="{{$user->getImage()}}" alt="" class="profile-image">
                        <form class="form-horizontal contact-form" role="form" method="post" action="/profile" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Name" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="Email" value="{{$user->email}}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="file" class="btn btn-primary" id="image" name="avatar">
                                    <div class="col-md-12">
                                        <h4 style="text-shadow: 0 1px 0 #ccc,
                                                               0 1px 0 #c9c9c9,
                                                               0 1px 0 #bbb,
                                                               0 1px 0 #b9b9b9,
                                                               0 1px 0 #aaa,
                                                               0 1px 1px rgba(0,0,0,.1),
                                                               0 0 5px rgba(0,0,0,.1),
                                                               0 1px 3px rgba(0,0,0,.3),
                                                               0 3px 5px rgba(0,0,0,.2),
                                                               0 1px 10px rgba(0,0,0,.25),
                                                               0 1px 10px rgba(0,0,0,.2),
                                                               0 1px 20px rgba(0,0,0,.15);">Загружайте только картинки!</h4>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn send-btn">Обновить</button>
                        </form>
                    </div><!--end leave comment-->
                </div>
                @include('pages._sidebar')
            </div>
        </div>
    </div>
    <!-- end main content-->
@endsection