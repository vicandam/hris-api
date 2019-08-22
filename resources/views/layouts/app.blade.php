<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <link rel="apple-touch-icon" sizes="57x57" href="img/logo/fav/fav-1/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/logo/fav/fav-1/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/logo/fav/fav-1/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/logo/fav/fav-1/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/logo/fav/fav-1/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/logo/fav/fav-1/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/logo/fav/fav-1/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/logo/fav/fav-1/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/logo/fav/fav-1/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/logo/fav/fav-1/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo/fav/fav-1/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/logo/fav/fav-1/favicon-96x96.png">

    <link rel="manifest" href="img/logo/fav/fav-1/manifest.json">

    <link rel="icon" type="image/png" sizes="16x16" href="img/logo/fav/fav-1/favicon-16x16.png">

    <meta name="msapplication-TileImage" content="img/logo/fav/fav-1/ms-icon-144x144.jpg">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <title>{{ config('app.name', 'Vic') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="canonical" href="{{ url('/') }}" />

    <meta name="url" content="{{ url('/') }}">

    @if(!empty($meta))
        <meta name="keywords" content="{{ $meta['keyword'] }}" />
        <meta name="title" content="{{ $meta['title'] }}">
        <meta name="description" content="{{ $meta['description'] }}">
        <meta name="author" content="{{ $meta['author'] }}">
        <meta name="page" content="{{ $meta['page'] }}">
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @if(env('APP_ENV') == 'production' || env('APP_ENV') == 'prod')
        <link href="{{ asset('css/bundle.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
    @endif


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129571250-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-129571250-2');
    </script>

</head>
<body>

    <div id="app">
        <!-- header nav -->
        <div class="header-container" >
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <div class="pull-left logo-container">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="img/logo/vic-2.jpg" class="header-logo" /> &nbsp;
                                </div>

                                <p style="font-family: Roboto; font-style: italic; font-weight: normal"> VicMedia</p>

                            </div>
                        </div>

                        @if(auth()->check())
                        <small>
                            Welcome back <b> {{ auth()->user()->name }} </b>! &nbsp;&nbsp;
                        </small>
                            <a  href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <div class="header-contact-container">
                                <span>
                                    <i class="fa fa-mobile" aria-hidden="true"></i>
                                    <a href="#" >
                                        +639161010994
                                    </a>
                                </span>

                                <span>
                                    <i class="fa fa-skype" aria-hidden="true"></i>
                                    <a href="#">live:vicandam01</a>
                                </span>

                                <span>
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <a href="#">vicajobs@gmail.com</a>
                                </span>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- content-->
        <main >
            @yield('content')
        </main>
    </div>

    <!-- footer -->
    <footer id="footer"  class="footer-container">
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 ">
                        <p  class="pull-center-text"   >{{ trans('paragraph.footer_copy_right_message') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @if(env('APP_ENV') == 'production' || env('APP_ENV') == 'prod')
        <script src="{{ asset( $environmentParentFolderAssetJsCompiledPages . '/global.js') }}"></script>
        <script src="{{ asset('js/bundle.js') }}" crossorigin="anonymous"></script>
    @else
        <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/popper.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/vue.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/axios.js') }}"></script>
        <script src="{{ asset('js/vue-infinite-scroll-2.0.2.js') }}"></script>
        <script src="{{ asset( $environmentParentFolderAssetJsCompiledPages . '/global.js') }}"></script>
    @endif
@stack('scripts')

</body>
</html>
