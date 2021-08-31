@extends('sablon.yonetim')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vize İşlemleri</li>
                </ol>
            </nav>

            @include('include.yonetim.vize.nav')

            <div class="card">
                <div class="card-header text-white bg-primary mb-3">Genel Vize İşlemleri</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card border-primary mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Vize Tipleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaTypes }} vize tipi sistemde kayıtlı. </p>
                                    <a href="/yonetim/vize/vize-tipi" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card border-primary mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Alt Vize Tipleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaSubTypes }} alt vize tipi sistemde kayıtlı.
                                    </p>
                                    <a href="/yonetim/vize/alt-vize-tipi" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card border-primary mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Bilgilendirme Emailleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaEmailInformationList }} bilgilendirme sistemde
                                        kayıtlı. </p>
                                    <a href="/yonetim/vize/bilgilendirme-emaili" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card border-primary mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Evrak Listesi Emailleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaEmailDocumentList }} evrak listesi sistemde
                                        kayıtlı. </p>
                                    <a href="/yonetim/vize/evrak-lisesi-emaili" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
