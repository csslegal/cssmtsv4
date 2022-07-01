@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Duyurular</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">
            Duyurular
            <a class="float-end text-white" href="/yonetim/duyuru/create">Ekle</a>
        </div>
        <div class="card-body scroll">
            <table id="dataTable" class=" table table-striped table-bordered display table-light " style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>İşlem Yapan</th>
                        <th>Durumu</th>
                        <th>E. Tarih</th>
                        <th>G. Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($kayitlar as $kayit)
                        <tr>
                            <td>{{ $kayit->d_id }}</td>
                            <td>{{ $kayit->u_name }}</td>
                            <td>
                                @if ($kayit->d_active != 1)
                                    Pasif
                                @else
                                    Normal
                                @endif
                            </td>
                            <td>{{ $kayit->d_tarih }}</td>
                            <td>{{ $kayit->d_u_tarih }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button onclick="goster({{ $kayit->d_id }})" class="text-success"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal" title="Göster">
                                        <i class="bi bi-image"></i> Göster
                                    </button>
                                    <a href="/yonetim/duyuru/{{ $kayit->d_id }}/edit">
                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle">
                                            <i class="bi bi-pencil-square "></i>
                                        </button>
                                    </a>
                                    <form action="/yonetim/duyuru/{{ $kayit->d_id }}" method="post">
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
    @include('customer.modals.content-load')

@endsection
@section('js')
    <script>
        function goster(id) {
            $("#contentLoad").html('İçerik alınıyor...');
            $.ajax({
                type: 'POST',
                url: "/yonetim/ajax/duyuru",
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
