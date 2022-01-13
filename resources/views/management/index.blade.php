@extends('sablon.yonetim')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol id="breadcrumb" class="breadcrumb p-2 ">
                    <li class="breadcrumb-item active" aria-current="page">Yönetim İşlemleri</li>
                </ol>
            </nav>
        </div>
        @if (in_array(1, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card mb-2">
                    <div class="card-header text-white bg-primary mb-3">Vize İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Vize ile ilgili bütün işlemler.</p>
                        <a href="/yonetim/vize" class="btn text-white btn-primary btn-block">Git</a>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(2, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card   mb-2">
                    <div class="card-header text-white bg-primary mb-3">Harici Tercüme İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Harici Tercümeler ile ilgili bütün işlemler.</p>
                        <a href="/yonetim/harici" class="btn text-white btn-primary btn-block">Git</a>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(3, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card  mb-2">
                    <div class="card-header text-white bg-primary mb-3">Dil Okulu İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Dil Okulu ile ilgili bütün işlemler.</p>
                        <a href="/yonetim/dilokulu" class="btn text-white btn-primary btn-block">Git</a>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(4, $userAccesses))
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card  mb-2">
                    <div class="card-header text-white bg-primary mb-3">Web İşlemleri</div>
                    <div class="card-body">
                        <p class="card-text">Web siteleri ile ilgili bütün işlemler.</p>
                        <a href="/yonetim/web" class="btn text-white btn-primary btn-block">Git</a>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-header text-white bg-primary mb-3">Genel İşlemler</div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Diller</h5>
                                    <p class="card-text">Sistemde {{ $countLanguage }} kayıt var.</p>
                                    <a href="yonetim/language" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Duyurular</h5>
                                    <p class="card-text">Sistemde {{ $countNotice }} kayıt var.</p>
                                    <a href="yonetim/duyuru" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Kullanıcı Tipleri</h5>
                                    <p class="card-text">Sistemde {{ $countUserType }} kayıt var.</p>
                                    <a href="yonetim/users-type" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Kullanıcılar</h5>
                                    <p class="card-text"> Sistemde {{ $countUsers }} kayıt var.</p>
                                    <a href="yonetim/users" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Kullanıcı Erişimleri</h5>
                                    <p class="card-text"> Sistemde {{ $countUserAccess }} kayıt var.</p>
                                    <a href="yonetim/users-access" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Randevu Ofisleri</h5>
                                    <p class="card-text"> Sistemde {{ $countAppointmentOffice }} kayıt var.
                                    </p>
                                    <a href="yonetim/appointment-office" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Başvuru Ofisleri</h5>
                                    <p class="card-text">Sistemde {{ $countApplicationOffice }} kayıt var.
                                    </p>
                                    <a href="yonetim/application-office" class="btn btn-primary float-end">Git</a>
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
