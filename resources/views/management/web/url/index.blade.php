@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Url Analizleri</li>
        </ol>
    </nav>
    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">
            Url
            <div class="dropdown float-end text-white">
                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    İşlemler
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="/yonetim/web/url/create">URL Ekle</a></li>
                    <li><a class="dropdown-item" href="/yonetim/web/url/detay">Link Detayları</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Adı</th>
                        <th>E. Tarih</th>
                        <th>G. Tarih</th>
                        <th>Özet</th>
                        <th>Detay</th>
                        <!-- <th>Linkler</th><th>Linkler</th>-->
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1 @endphp
                    @foreach ($kayitlar as $kayit)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td class="@php echo $kayit->detay_kontrol==1? " text-success":""; @endphp">{{ $kayit->name }}
                            </td>
                            <td>{{ $kayit->created_at }}</td>
                            <td>{{ $kayit->updated_at }}</td>
                            <td>
                                <button onclick="goster({{ $kayit->id }})" data-bs-target="#exampleModal"
                                    class="text-success" data-bs-toggle="modal">
                                    <i class="bi bi-image"></i>
                                </button>
                            </td>
                            <td>
                                <button onclick="detay({{ $kayit->id }})" data-bs-target="#exampleModal"
                                    class="text-dark" data-bs-toggle="modal">
                                    <i class="bi bi-image"></i>
                                </button>
                            </td>
                            <!--<td><a href="/yonetim/web/url/{{ $kayit->id }}">Git</a></td><td><a href="/yonetim/web/url/{{ $kayit->id }}/home">Getir</a></td>-->
                            <td>
                                <form action="/yonetim/web/url/{{ $kayit->id }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" data-bs-toggle="tooltip" data-bs-placement="right" title="Sil">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
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
                    <h5 class="modal-title" id="exampleModalLabel">Url Detay Özetleri</h5>
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
            $("#icerikYükle").html(
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="m-2">Yükleniyor...</span></div>'
            );
            $.ajax({
                type: 'POST',
                url: "/yonetim/web/url/ajax-ozet",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    $("#icerikYükle").html(data);
                },
                error: function(data, status, xhr) {
                    $("#icerikYükle").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                },
            });
        }

        function detay(id) {
            $("#icerikYükle").html(
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="m-2">Yükleniyor...</span></div>'
            );
            $.ajax({
                type: 'POST',
                url: "/yonetim/web/url/ajax-detay",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    $("#icerikYükle").html(data);
                },
                error: function(data, status, xhr) {
                    $("#icerikYükle").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                },
            });
        }
    </script>
@endsection
