@extends('sablon.genel')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item active">Müşteri Sayfası</li>
        </ol>
    </nav>

    @include('musteri.cards.customer-process')

    @include('musteri.cards.base-information')

    @include('musteri.cards.access')

    @include('musteri.cards.notes')

    @include('musteri.cards.send-email-logs')

    <!-- Modal -->
    @include('musteri.modals.content-load')

    @include('musteri.modals.note-add-modal')

@endsection

@section('js')
    <script>
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
                        .html('<div class="alert alert-error" > ' +
                            xhr + ' </div> ');
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
