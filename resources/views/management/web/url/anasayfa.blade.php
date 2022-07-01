@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/url">Url Analizleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $webSite->name }}</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">
            {{ $webSite->name }} anasayfa urlleri

        </div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-striped table-bordered display table-light " style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>URL</th>
                        <th>Linkler</th>
                        <th>Linkler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kayitlar as $kayit)
                        <tr>
                            <td>{{ $kayit->id }}</td>
                            <td>{{ $kayit->name }}</td>
                            <td><a href="/yonetim/web/url/{{ $webSite->id }}/subpage/{{ $kayit->id }}">Git</a></td>
                            <td><a href="/yonetim/web/url/{{ $webSite->id }}/subpage/{{ $kayit->id }}/home">Getir</a>
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
            $("#icerikYükle").html('İçerik alınıyor...');
            $.ajax({
                type: 'POST',
                url: "/yonetim/ajax/url",
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
