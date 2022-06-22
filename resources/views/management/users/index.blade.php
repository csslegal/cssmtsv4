@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kullanıcı</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">
            Kullanıcı
            <a class="float-end text-white" href="/yonetim/users/create">Ekle</a>
        </div>
        <div class="card-body scroll">

            <table id="dataTable" class=" table table-striped table-bordered display table-light " style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kullanıcı Adı</th>
                        <th>Hesap Durumu</th>
                        <th>Giriş Durumu</th>
                        <th>Kullanıcı Tipi</th>
                        <th>Mesai Ofisi</th>
                        <th>Mesai Saati</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kayitlar as $kayit)
                        <tr>
                            <td>{{ $kayit->u_id }}</td>
                            <td>{{ $kayit->u_name }}</td>

                            <td>@if ($kayit->u_active) Normal @else <span class="text-danger fw-bold">Pasif</span> @endif</td>
                            <td>@if ($kayit->u_unlimited) Kısıtlamasız @else <span class="text-danger fw-bold">Kısıtlamalı</span> @endif</td>

                            <td>{{ $kayit->ut_name }}</td>
                            <td>{{ $kayit->bo_name }}</td>
                            <td>{{ $kayit->um_giris }} - {{ $kayit->um_cikis }}</td>

                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <!--<button onclick="goster({{ $kayit->u_id }})" class="text-success"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal" title="Göster">
                                                    <i class="bi bi-image"></i>
                                                </button>-->
                                    <a href="/yonetim/users/{{ $kayit->u_id }}/edit">
                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle">
                                            <i class="bi bi-pencil-square "></i>
                                        </button>
                                    </a>
                                    <form action="/yonetim/users/{{ $kayit->u_id }}" method="post">
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">İçerik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="icerikYükle">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function goster(id) {
            $("#icerikYükle").html('Veri alınıyor...');
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
