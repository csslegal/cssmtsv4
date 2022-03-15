@extends('sablon.genel')

@section('title') Anasayfa - Kullanıcı Oturum @endsection
@section('content')

    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item active" aria-current="page">Kullanıcı İşlemleri</li>
        </ol>
    </nav>

    @include('user.hosgeldin')

    @include('include.user.visa.customer-files-table')
    @include('include.user.web.web-panels-table')

@endsection
