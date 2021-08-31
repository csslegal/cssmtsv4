<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kullanıcı Oturum @yield('title')</title>

    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/logo.png') }}" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
    <div class="page-content">
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4">
                @include('include.nav')
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 col-sm-8" id="content">
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
        duyuruSayisiAl();
        setTimeout(function() {
            window.location.reload(1);
            duyuruSayisiAl();
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
    </script>
    @yield('js')
</body>

</html>
