@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vize İşlemleri</li>
        </ol>
    </nav>

    @include('include.management.visa.nav')

    <div class="card mb-3">
        <div class="card-header text-white bg-danger">Grafikler</div>
        <div class="card-body  text-dark bg-light">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Analizler</h5>
                            <p class="card-text">Analiz grafik detayları.</p>
                            <a href="/yonetim/vize/grafik/index" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Randevu Takvimi</h5>
                            <p class="card-text">Randevu grafik detayları.</p>
                            <a href="/yonetim/vize/grafik/takvim" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header text-white bg-danger">Genel Vize İşlemleri</div>
        <div class="card-body  text-dark bg-light">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Dosya Aşamaları</h5>
                            <p class="card-text">Cari vize dosya aşama detayları.</p>
                            <a href="/yonetim/vize/dosya-asama" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Dosya Aşama Erişimleri</h5>
                            <p class="card-text">Dosya aşama erişim detayları.</p>
                            <a href="/yonetim/vize/dosya-asama-erisim" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Vize Tipleri</h5>
                            <p class="card-text">Vize tipleri detayları.</p>
                            <a href="/yonetim/vize/vize-tipi" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Vize Süreleri</h5>
                            <p class="card-text">Vize süreleri detayları.</p>
                            <a href="/yonetim/vize/vize-suresi" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Dosyası Logları</h5>
                            <p class="card-text">Vize dosya log detayları.</p>
                            <a href="/yonetim/vize/logs" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
