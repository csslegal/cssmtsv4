@extends('sablon.genel')
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item active" aria-current="page">Kullanıcı İşlemleri</li>
        </ol>
    </nav>

    @include('user.hosgeldin')

    <div class="row mb-2">
        @if (in_array(1, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card mb-2">
                    <div class="card-header text-white bg-primary mb-3 fw-bold">Vize İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">
                            Vize ile ilgili toplam
                            <span class="fw-bold text-danger">{{ $visaCustomersCount }}</span>
                            işlem bulunmakta.
                        </p>
                        <a href="/kullanici/vize" class="btn text-white btn-danger btn-block">Git</a>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(2, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card mb-2">
                    <div class="card-header text-white bg-primary mb-3 fw-bold">Harici Tercüme İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Harici Tercümeler ile ilgili bütün işlemler.</p>
                        <a href="/kullanici/harici" class="btn text-white btn-danger btn-block">Git</a>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(3, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card  mb-2">
                    <div class="card-header text-white bg-primary mb-3 fw-bold">Dil Okulu İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Dil Okulu ile ilgili bütün işlemler.</p>
                        <a href="/kullanici/dilokulu" class="btn text-white btn-danger btn-block">Git</a>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(4, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card  mb-2">
                    <div class="card-header text-white bg-primary mb-3 fw-bold">İçerik Yönetim İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Web siteleri yönetimi ile ilgili bütün işlemler.</p>
                        <a href="/kullanici/web" class="btn text-white btn-danger btn-block">Git</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
