@extends('sablon.genel')

@section('title')
    Duyurular - Kullanıcı Oturum
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/kullanici">Kullanıcı İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Duyurular</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white fw-bold">Duyurular</div>
        <div class="card-body scroll">

            <table id="dataTableDilOkulu" class=" table table-striped table-bordered display table-light"
                style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Duyuru Yapan</th>
                        <th>G. Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notices as $notice)
                        <tr>
                            <td>{{ $notice->id }}</td>
                            <td>{{ $notice->name }}</td>
                            <td>{{ $notice->updated_at }}</td>
                            <td>
                                <button class="border btn" onclick="noticeShow({{ $notice->id }})"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal" title="Göster"> Göster </button>
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
        function noticeShow(id) {
            $("#contentLoad").html('İçerik alınıyor...');
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
