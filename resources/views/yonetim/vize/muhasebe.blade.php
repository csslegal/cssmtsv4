@extends('sablon.yonetim')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
                    <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Muhasebe</li>
                </ol>
            </nav>

            @include('include.yonetim.vize.nav')

            <div class="card card-primary mb-3">
                <div class="card-header bg-primary text-white">Vize Dosyası İşlemi Bekleyen Müşteriler</div>
                <div class="card-body scroll">

                    <table id="dataTableVize" class=" table table-striped table-bordered display table-light"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-2">Müşteri Adı</th>
                                <th class="col-md-3">Vize Tipi</th>
                                <th class="col-md-2">Vize Süresi</th>
                                <th class="col-md-4">Dosya Durumu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a class="text-danger fw-bold" href="/musteri/1/index">12321</a></td>
                                <td>System Architect</td>
                                <td>Yerleşim Vizeleri </td>
                                <td>6 Ay</td>
                                <td>Müşteri Ödemesi bekleniyor</td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
