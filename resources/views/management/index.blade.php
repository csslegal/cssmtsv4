@extends('sablon.yonetim')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol id="breadcrumb" class="breadcrumb p-2">
                    <li class="breadcrumb-item active" aria-current="page">Yönetim İşlemleri</li>
                </ol>
            </nav>
        </div>
        @if (in_array(1, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card mb-3">
                    <div class="card-header text-white bg-dark mb-3">Vize İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Vize ile ilgili bütün işlemler.</p>
                        <a href="/yonetim/vize" class="w-100 mt-2 btn text-white btn-dark btn-block">İşlem yap</a>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(2, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card   mb-3">
                    <div class="card-header text-white bg-dark mb-3">Harici Tercüme İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Harici Tercümeler işlemleri.</p>
                        <a href="/yonetim/harici" class="w-100 mt-2 btn text-white btn-dark btn-block">İşlem yap</a>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(3, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card  mb-3">
                    <div class="card-header text-white bg-dark mb-3">Dil Okulu İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Dil Okulu işlemleri.</p>
                        <a href="/yonetim/dilokulu" class="w-100 mt-2 btn text-white btn-dark btn-block">İşlem yap</a>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(4, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card  mb-3">
                    <div class="card-header text-white bg-dark mb-3">Web İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Web siteleri işlemleri.</p>
                        <a href="/yonetim/web" class="w-100 mt-2 btn text-white btn-dark">İşlem yap</a>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header text-white bg-dark mb-3">Genel İşlemler</div>
                <div class="card-body ">
                    <div class="row">

                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Sistem Logları</h5>
                                    <p class="card-text">Sistem kaydı logları</p>
                                    <a href="yonetim/logging" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Kullanıcı Tipleri</h5>
                                    <p class="card-text">Kullanıcı tipi kayıt detayları.</p>
                                    <a href="yonetim/users-type" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Kullanıcılar</h5>
                                    <p class="card-text">Kullanıcı kaydı detayları.</p>
                                    <a href="yonetim/users" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Kullanıcı Erişimleri</h5>
                                    <p class="card-text">Kullanıcı erişimi kayıt detayları.</p>
                                    <a href="yonetim/users-access" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Randevu Ofisleri</h5>
                                    <p class="card-text">Başvuru ofisi kayıt detayları.</p>
                                    <a href="yonetim/appointment-office" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Başvuru Ofisleri</h5>
                                    <p class="card-text">Başvuru ofisi kayıt detayları.
                                    </p>
                                    <a href="yonetim/application-office" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Müşteri Bilgileri</h5>
                                    <p class="card-text">Müşteri kayıt detayları.
                                    </p>
                                    <a href="yonetim/customers" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Müşteri Notları</h5>
                                    <p class="card-text">Müşteri not bilgisi detayları.
                                    </p>
                                    <a href="yonetim/customer-notes" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')
@endsection
