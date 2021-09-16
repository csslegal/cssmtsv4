<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Yönetim Oturum @yield('title') </title>

    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/logo.png') }}" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('css')

</head>

<body>
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
        setTimeout(function() {
            window.location.reload(1);
        }, {{ config('app.yenilenmeSuresi') * 1000 }});
    </script>
    @yield('js')
</body>

</html>
