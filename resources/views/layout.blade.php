<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon icon -->

    <title>Блог обо всем</title>

    <!-- common css -->
    <link rel="stylesheet" href="/public/css/frontend.css">
    <link rel="stylesheet" media="screen,projection" href="/public/css/ui.totop.css" />

    <!-- HTML5 shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/public/js/html5shiv.js"></script>
    <script src="/public/js/respond.js"></script>
    <![endif]-->

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/public/images/favicon.png">

</head>

<body style="background: url('/public/images/texture.png') no-repeat center center fixed;">

<nav class="navbar main-menu navbar-default">
    <div class="container">
        <div class="menu-content">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="/public/images/logo.png" alt=""></a>
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav text-uppercase">
                    <li><a href="/">Главная</a></li>
                    @if(Auth::check())
                        <li><a href="/profile">Мой профиль</a></li>
                        <li><a href="/logout">Выход</a></li>
                    @else
                        <li><a href="/register">Регистрация</a></li>
                        <li><a href="/login">Вход</a></li>
                    @endif
                    {{--<li><a href="about-me.html">ABOUT ME </a></li>--}}
                    {{--<li><a href="contact.html">CONTACT</a></li>--}}
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </div>
    <!-- /.container-fluid -->
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session('status'))
                <div class="alert alert-info">
                    {{session('status')}}
                </div>
            @endif
        </div>
    </div>
</div>

@yield('content')

<footer class="footer-widget-section">
    <div class="footer-copy">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">&copy; <?= date('Y')?>  г. Все права защищены. <i class="fa fa-hand-peace-o"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- js files -->
<script src="/public/js/frontend.js"></script>
<!-- easing plugin ( optional ) -->
<script src="/public/js/easing.js" type="text/javascript"></script>
<!-- UItoTop plugin -->
<script src="/public/js/jquery.ui.totop.js" type="text/javascript"></script>
<!-- Starting the plugin -->
<script type="text/javascript">
    $(document).ready(function() {
        /*
        var defaults = {
        containerID: 'toTop', // fading element id
        containerHoverID: 'toTopHover', // fading element hover id
        scrollSpeed: 1200,
        easingType: 'linear'
        };
        */

        $().UItoTop({ easingType: 'easeOutQuart' });

    });
</script>
</body>
</html>