@extends('sablon.yonetim')

@section('content')

    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Web İşlemleri</li>
        </ol>
    </nav>

    @include('include.management.web.nav')

    <div class="card">
        <div class="card-header text-white bg-primary mb-3">Web İşlemleri</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="card border-primary mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Gruplar</h5>
                            <p class="card-text fw-bold"> Toplam {{ $countWebGroups }} grup sistemde kayıtlı. </p>
                            <a href="/yonetim/web/groups" class="btn btn-primary float-end">Git</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="card border-secondary mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Paneller</h5>
                            <p class="card-text fw-bold"> Toplam {{ $countWebPanels }} panel sistemde kayıtlı.
                            </p>
                            <a href="/yonetim/web/panels" class="btn btn-secondary float-end">Git</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="card border-danger mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Panel Yetkileri</h5>
                            <p class="card-text fw-bold"> Toplam {{ $countWebPanelAuth }} yetki sistemde kayıtlı. </p>
                            <a href="/yonetim/web/panel-auth" class="btn btn-danger text-white float-end">Git</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
