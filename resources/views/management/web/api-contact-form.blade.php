@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">İletişim Formları</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">İletişim Formları</div>
        <div class="card-body scroll">
            <table id="dataTable" class="table  table-light table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Panel</th>
                        <th>Adı Soyadı</th>
                        <th>E-Posta</th>
                        <th>Telefon</th>
                        <th>Konu</th>
                        <th>Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contactForms as $result)
                        <tr>
                            <td>{{ $result->id }}</td>
                            <td>{{ $result->p_name }}</td>
                            <td>{{ $result->name }}</td>
                            <td>{{ $result->email }}</td>
                            <td>{{ $result->phone }}</td>
                            <td>{{ $result->subject }}</td>
                            <td>{{ date('Y-m-d', strtotime($result->created_at)) }}</td>
                            <td>
                                <button class="text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    onclick="goster({{ $result->id }})">
                                    <i class="bi bi-eye"></i>
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
                    <h5 class="modal-title" id="exampleModalLabel">İletişim Formu Detayları</h5>
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
                url: "/yonetim/ajax/contact-form",
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
