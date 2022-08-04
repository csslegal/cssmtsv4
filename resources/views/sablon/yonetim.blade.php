<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, noimageindex, nofollow, nosnippet">
    <title>@yield('title') Yönetim</title>
    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/logo.png') }}" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #preloader {
            filter: alpha(opacity=95);
            -moz-opacity: .95;
            opacity: .95;
            position: absolute;
            background: #fff;
            z-index: 99;
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
                $(ele).removeClass('text-light').addClass('text-dark');
                $(ele).removeClass('navbar-dark').addClass('navbar-light');
                });
                $('body').removeClass('bg-light').addClass('bg-dark');
                $('#breadcrumb').addClass('bg-light');
                $('#nav-top').removeClass('navbar-dark').addClass('navbar-light');
                $('#nav-top').removeClass('bg-dark').addClass('bg-light');
            @endif
        });

        function is_loaded() { //DOM
            if (document.getElementById) {
                setTimeout("document.getElementById('preloader').style.display='none'", 1000);
            } else {
                if (document.layers) { //NS4
                    setTimeout("document.preloader.visibility = 'hidden'", 1000);
                } else { //IE4
                    setTimeout("document.all.preloader.style.display='none'", 1000);
                }
            }
        }
    </script>
    @yield('js')
</body>

</html>
