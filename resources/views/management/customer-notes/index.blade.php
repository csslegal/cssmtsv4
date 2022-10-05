@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Müşteri Notları</li>
        </ol>
    </nav>
    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Müşteri Notları</div>
        <div class="card-body scroll">
            <table id="dataTable" class=" table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Müşteri Adı</th>
                        <th>Kayıt Yapan </th>
                        <th>E. Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerNotes as $customerNote)
                        <tr>
                            <td><a href="/musteri/{{ $customerNote->customer_id }}">{{ $customerNote->id }}</a></td>
                            <td><a href="/musteri/{{ $customerNote->customer_id }}">{{ $customerNote->name }}</a></td>
                            <td>{{ $customerNote->user_name }}</td>

                            <td>{{ $customerNote->created_at }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="border btn btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalNot"
                                        onclick="$('#customer_id').val({{ $customerNote->customer_id }});" title="Yanıtla">
                                        <i class="bi bi-reply"></i>
                                    </button>
                                    <button class="border btn btn-sm" onclick="contentLoad('not','{{ $customerNote->id }}')"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal" title="Göster">
                                        <i class="bi bi-image"></i>
                                    </button>
                                    <button class="border btn btn-sm" onclick="notSil('{{ $customerNote->id }}')"
                                        title="Sil">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('include.management.content-load')

    @include('include.management.note-add-modal')
@endsection
@section('js')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#editor200',
            height: 200,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor visualblocks fullscreen insertdatetime media table paste wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        });

        function contentLoad(ne, id) {
            var url = "";
            if (ne == 'not') {
                url = "/musteri/ajax/not-goster";
            } else if (ne == 'email') {
                url = "/musteri/ajax/email-goster";
            }
            $("#contentLoad").html('İçerik alınıyor...');
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    $("#contentLoad").html(data['content']);
                },
                error: function(data, status, xhr) {
                    $("#contentLoad")
                        .html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }

        function notSil(id) {
            $.ajax({
                type: 'POST',
                url: "/musteri/ajax/not-sil",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    location.reload();
                },
                error: function(data, status, xhr) {
                    alert(xhr);
                }
            });
        }
    </script>
@endsection
