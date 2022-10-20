@extends('sablon.yonetim')

@section('content')

    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Web İşlemleri</li>
        </ol>
    </nav>

    @include('include.management.web.nav')

    <div class="card">
        <div class="card-header text-white bg-danger mb-3">Web İşlemleri</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Gruplar</h5>
                            <p class="card-text">Grup detayları.</p>
                            <a href="/yonetim/web/groups" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Paneller</h5>
                            <p class="card-text">Panel detayları.</p>
                            <a href="/yonetim/web/panels" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Panel Yetkileri</h5>
                            <p class="card-text">Panel yetki detayları.</p>
                            <a href="/yonetim/web/panel-auth" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Panellere Geçiş</h5>
                            <p class="card-text">Sitelere geçiş detayları.</p>
                            <a href="/yonetim/web/paneller" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">URL Analizleri</h5>
                            <p class="card-text">URL analiz detayları. </p>
                            <a href="/yonetim/web/url" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
