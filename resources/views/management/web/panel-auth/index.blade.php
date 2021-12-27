@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Panel Yetkileri</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Panel Yetkileri
            <a class="float-end text-white" href="/yonetim/web/panel-auth/create">Ekle</a>
        </div>
        <div class="card-body scroll">
            <table id="dataTable" class=" table table-striped table-bordered display table-light" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kullanıcı Adı</th>
                        <th>Yetkili Paneller</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Bitiş Tarihi</th>
                        <th>Yetki Seviyesi</th>
                        <th>Eklenme Tarihi</th>
                        <th>Güncelleme Tarihi</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td>{{ $result->id }}</td>
                            <td>{{ $result->u_name }}</td>
                            <td class="text-center">
                                <button onclick="goster({{ $result->id }})" class="text-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" title="Göster">
                                    <i class="bi bi-image"></i>
                                </button>
                            </td>
                            <td>{{ $result->start_time }}</td>
                            <td>{{ $result->and_time }}</td>
                            @if ($result->access)
                                <td>Full Erişim</td>
                            @else
                                <td>Temel Erişim </td>
                            @endif
                            <td>{{ $result->created_at }}</td>
                            <td>{{ $result->updated_at }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="/yonetim/web/panel-auth/{{ $result->id }}/edit">
                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle">
                                            <i class="bi bi-pencil-square "></i>
                                        </button>
                                    </a>
                                    <form action="/yonetim/web/panel-auth/{{ $result->id }}" method="post">
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
                    <h5 class="modal-title" id="exampleModalLabel">Yetki Verilen Paneller</h5>
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
                url: "/yonetim/ajax/panel-list",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    $("#icerikYükle").html(data);
                },
                error: function(data, status, xhr) {
                    $("#icerikYükle").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }
    </script>
@endsection
