@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Müşteri Bilgileri</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">
            Müşteri Bilgileri
            <a class="float-end text-white" href="/yonetim/customers/create">Dosya Yükle</a>
        </div>
        <div class="card-body scroll">
            <table id="dtaTable" class="table table-striped table-bordered display table-light " style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Adı</th>
                        <th>Telefon</th>
                        <th>E-posta</th>
                        <th>Adres</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
