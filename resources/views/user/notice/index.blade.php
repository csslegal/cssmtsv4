@extends('sablon.genel')

@section('title') Duyurular - Kullanıcı Oturum @endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol  id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/kullanici">Kullanıcı İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Duyurular</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white fw-bold">Duyurular</div>
        <div class="card-body">

            <table id="dataTableDilOkulu" class=" table table-striped table-bordered display table-light" style="width:100%">
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
                                    data-bs-toggle="modal" data-bs-target="#exampleModal" title="Göster">
                                    <i class="bi bi-image"></i> Göster
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    <!-- Modal -->
    @include('customer.modals.content-load')
@endsection
@section('js')
    <script>
        function duyuruGoster(id) {
            $("#contentLoad").html('Veri alınıyor...');
            $.ajax({
                type: 'POST',
                url: "/kullanici/ajax/duyuru",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    $("#contentLoad").html(data['icerik']);
                },
                error: function(data, status, xhr) {
                    $("#contentLoad").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }
    </script>
@endsection
