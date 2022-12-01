@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kullanıcı</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Kullanıcılar
            <a class="float-end text-white" href="/yonetim/users/create">Ekle</a>
        </div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-light table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Adı</th>
                        <th>Kullanıcı Tipi</th>
                        <th>Mesai Saati</th>
                        <th>Hesap Durumu</th>
                        <th>Giriş Durumu</th>

                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kayitlar as $kayit)
                        <tr>
                            <td>{{ $kayit->id }}</td>
                            <td>{{ $kayit->name }}</td>
                            <td>{{ $kayit->ut_name }}</td>
                            <td>{{ $kayit->giris }} - {{ $kayit->cikis }}</td>
                            <td>
                                @if ($kayit->active)
                                    Normal
                                @else
                                    <span class="text-danger fw-bold">Pasif</span>
                                @endif
                            </td>
                            <td>
                                @if ($kayit->unlimited)
                                    Kısıtlamasız
                                @else
                                    <span class="text-danger fw-bold">Kısıtlamalı</span>
                                @endif
                            </td>

                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="/yonetim/users/{{ $kayit->id }}/edit">
                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </a>
                                    <form action="/yonetim/users/{{ $kayit->id }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Sil">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function goster(id) {
            $("#icerikYükle").html('İçerik alınıyor...');
            $.ajax({
                type: 'POST',
                url: "/yonetim/ajax/users",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    $("#icerikYükle").html(data['name']);
                },
                error: function(data, status, xhr) {
                    $("#icerikYükle").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });

        }
    </script>
@endsection
