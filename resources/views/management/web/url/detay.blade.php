@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/url">Url Analizleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">URL Detayları</li>
        </ol>
    </nav>
    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">URL Detayları</div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Site URL</th>
                        <th>Kaynak URL</th>
                        <th>Hedef URL</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1 @endphp
                    @foreach ($urlDetaylar as $urlDetay)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $urlDetay->u_name }}</td>
                            <td>{{ $urlDetay->kaynak }}</td>
                            <td>{{ $urlDetay->hedef }}</td>
                            <td>
                                <button onclick="goster({{ $urlDetay->id }})" data-bs-target="#exampleModal"
                                    class="text-success" data-bs-toggle="modal">
                                    <i class="bi bi-image"></i>
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
                url: "/yonetim/web/url/ajax",
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
