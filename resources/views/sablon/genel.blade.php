<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, noimageindex, nofollow, nosnippet">
    <title>@yield('title')</title>
    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/logo.png') }}" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #preloader {
            filter: alpha(opacity=9);
            -moz-opacity: .9;
            opacity: .9;
            position: absolute;
            background: #fff;
            z-index: 9999;
            width: 100%;
            height: 100%;
        }

        #yukleniyor {
            width: 20em;
            margin: 0 auto !important;
        }
    </style>
    @yield('css')
</head>

<body class="light bg-light" onload="is_loaded();">

    @include('include.preload')

    <div class="container">
        <div class="row">
            <div class="col">

                @include('include.nav-top')
                @include('include.toast')

                @yield('content')

            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.toast').toast('show');

            setTimeout(function() {
                window.location.reload(1);
            }, {{ config('app.yenilenmeSuresi') * 1000 }});

            @if (session('theme') == 'dark')

                $([".light [class*='-light']", ".dark [class*='-dark']"]).each((i, ele) => {
                    $(ele).removeClass('bg-light').addClass('bg-dark');
                    $(ele).removeClass('text-dark').addClass('text-light');
                    // $(ele).removeClass('navbar-dark').addClass('navbar-light');
                });
                $('body').removeClass('bg-light').addClass('bg-dark');
                $('table').removeClass('table-light').addClass('table-dark');

                $('.card-body').addClass('bg-dark text-light');
                $('.modal-content').addClass('bg-dark text-light');

                $('#breadcrumb').addClass('bg-dark');
                $('#nav-top').removeClass('navbar-light').addClass('navbar-dark');
                $('#nav-top').removeClass('bg-light').addClass('bg-dark');
                $('#managament-nav').addClass('border border-light');
                $('#slogan').addClass('bg-dark');
                $('#preloader').addClass('bg-body');
            @endif
        });

        function is_loaded() { //DOM
            if (document.getElementById) {
                setTimeout("document.getElementById('preloader').style.display='none'", 1000);
            } else {
                if (document.layers) { //NS4
                    setTimeout("document.preloader.visibility = 'hidden'", 1000);
                } else { //IE4
                    setTimeout("document.all.preloader.style.display = 'none'", 1000);
                }
            }
        }
    </script>
    @yield('js')
</body>

</html>
