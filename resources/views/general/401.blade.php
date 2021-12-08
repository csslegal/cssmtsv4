<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="noimageindex, nofollow, nosnippet">

    <title>401 | Yetkisiz İstek</title>

    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/logo.png') }}" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="page-content">
        <div class="row">
            <div class="col-md-offset-4 text-center mt-5  ">
                <img src="{{ asset('storage/logo.png') }}" alt="logo" class="p-4 mb-4">
                <br>
                <span class=" text-danger ">401 | Yetkisiz İstek</span>
                <br>
                <a class="mt-4 btn btn-primary" href="/">Ana Sayfa</a>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
