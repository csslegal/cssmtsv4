@extends('sablon.genel')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item">
                <a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a>
            </li>
            <li class="breadcrumb-item active">Vize İşlemleri</li>
        </ol>
    </nav>

    @include('musteri.vize.cards.visa-proccess')

    @if (isset($appointmentDetail))
        @include('musteri.vize.cards.appointment-detail')
    @endif

    @if (isset($fileDetail))
        @include('musteri.vize.cards.file-detail')
    @endif

    @include('musteri.vize.cards.information-email')

@endsection

@section('js')
    <script>
        function subVisaTypes(id) {
            $.ajax({
                type: 'POST',
                url: "/musteri/ajax/alt-vize-tipi",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.length != 0) {

                        $('#visaSubType').find('option').remove();
                        $('#visaSubType').append('<option value="">Seçim yapınız</option>');

                        for (var i = 0; i < data.length; i++) {
                            $('#visaSubType').append('<option value="' + data[i]['id'] + '">' +
                                data[i]['name'] + '</option>');
                        }
                    } else {
                        $('#visaSubType').find('option').remove();
                        $('#visaSubType').append('<option value="">Farklı vize tipi seçiniz</option>');
                    }
                },
                error: function(response, status, xhr) {
                    alert('Veri alınırken hata oluştu. Hata: ' + xhr);
                }
            });
        }
    </script>
@endsection
