<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kullanıcı Oturum @yield('title')</title>
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

<body onload="is_loaded();">

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
        });
        //duyuruSayisiAl();
        setTimeout(function() {
            window.location.reload(1);
            //duyuruSayisiAl();
        }, {{ config('app.yenilenmeSuresi') * 1000 }});

        function duyuruSayisiAl() {
            $.ajax({
                url: "/kullanici/ajax/duyuru-sayisi",
                type: 'get',
                success: function(sonuc) {
                    if (sonuc != 0) {
                        text = '<i class="bi bi-stack"></i>' + $("#duyuruSayisi").text() + " (" + sonuc + ") ";
                        $("#duyuruSayisi").text('');
                        $("#duyuruSayisi")
                            .addClass(["fw-bold"])
                            .html(text);
                    }
                }
            });
        }

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
