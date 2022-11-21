@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dosya Logları</li>
        </ol>
    </nav>
    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Dosya Logları</div>
        <div class="card-body scroll">
            <table id="dtVisaLogsTable" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>URL</th>
                        <th>Müşteri Adı</th>
                        <th>Aşama</th>
                        <th>İşlem Yapan</th>
                        <th>İşlem Tarihi</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
@endsection
