@extends('sablon.genel')

@section('title')
    Müşteri Anasayfa
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item active">Müşteri Sayfası</li>
        </ol>
    </nav>

    @include('customer.cards.base-information')

    @include('customer.cards.notes')

    @include('customer.cards.access')

    @include('customer.modals.content-load')
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
                $("#contentLoad").html('İçerik alınıyor...');
                $("#contentHead").html('Müşteri Not Detayı');
                url = "/musteri/ajax/not-goster";
            } else if (ne == 'email') {
                $("#contentLoad").html('İçerik alınıyor...');
                url = "/musteri/ajax/email-goster";
            }
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
    </script>
@endsection
