@extends('sablon.genel')

@section('title') Anasayfa - Kullanıcı Oturum @endsection

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
                <div class="card   mb-2">
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

    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white fw-bold">Müşteri Temel Bilgileri Güncelleme İstekleri</div>
        <div class="card-body scroll">
            <table id="dataTable" class=" table table-striped table-bordered display table-light" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Müşteri Adı</th>
                        <th>İstek Yapan</th>
                        <th>Durumu</th>
                        <th>İstek Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mTBGIS as $mTBGI)
                        <tr>
                            <td><a class="fw-bolder "
                                    href="/musteri/{{ $mTBGI->customer_id }}">{{ $mTBGI->customer_id }}</a></td>
                            <td><a class="fw-bold"
                                    href="/musteri/{{ $mTBGI->customer_id }}">{{ $mTBGI->name }}</a></td>
                            <td>{{ $mTBGI->user_name }} </td>
                            <td>
                                @if ($mTBGI->onay == 0)
                                    <span class="fw-bold text-danger">Onaysız</span>
                                @else
                                    <span class="fw-bold text-success">Onaylı</span>
                                @endif
                            </td>
                            <td>{{ $mTBGI->created_at }}</td>
                            <td>
                                @if ($mTBGI->onay == 0)
                                    <a class="btn btn-primary btn-sm text-white fw-bold"
                                        href="/kullanici/mTBGI/{{ $mTBGI->id }}/onay">Onay Ver</a>
                                @else
                                    <a class="btn btn-danger btn-sm text-white fw-bold"
                                        href="/kullanici/mTBGI/{{ $mTBGI->id }}/geri-al">Geri Al</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
