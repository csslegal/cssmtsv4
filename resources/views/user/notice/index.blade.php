@extends('sablon.genel')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/kullanici">Kullanıcı İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Duyurular</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Duyurular</div>
        <div class="card-body">

            <table id="dataTableDilOkulu" class=" table table-striped table-bordered display table-light"
                style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Duyuru Yapan</th>
                        <th>E. Tarih</th>
                        <th>G. Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notices as $duyuru)
                        <tr>
                            <td>{{ $duyuru->d_id }}</td>
                            <td>{{ $duyuru->u_name }}</td>
                            <td>{{ $duyuru->d_tarih }}</td>
                            <td>{{ $duyuru->d_u_tarih }}</td>
                            <td>
                                <button class="border btn" onclick="duyuruGoster({{ $duyuru->d_id }})"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal" title="Göster"><i
                                        class="bi bi-image"></i>
                                </button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Duyuru İçeriği</h5>
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
        function duyuruGoster(id) {
            $("#icerikYükle").html('Veri alınıyor...');
            $.ajax({
                type: 'POST',
                url: "/kullanici/ajax/duyuru",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    $("#icerikYükle").html(data['icerik']);
                },
                error: function(data, status, xhr) {
                    $("#icerikYükle").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }
    </script>
@endsection
