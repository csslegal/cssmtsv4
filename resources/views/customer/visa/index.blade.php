@extends('sablon.genel')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a>
            </li>
            <li class="breadcrumb-item active">Vize İşlemleri</li>
        </ol>
    </nav>

    @include('customer.visa.cards.visa-proccess')

    @if (isset($visaFileDetail))
        @include('customer.visa.cards.file-detail')
        @include('customer.visa.cards.file-grades-detail')
    @endif

    @include('customer.visa.cards.information-email')

    @include('customer.modals.content-load')

@endsection

@section('js')
    <script>
        function newGrades() {
            $.get('/musteri/{{ $baseCustomerDetails->id }}/vize/asama', {}, function(resp) {
                if (resp == 1) {
                    location.reload(true);
                } else if (resp == 'NOT_FOUND_VISA_FILE') {} else {
                    setTimeout('newGrades()', 5000);
                }
            });
        }
        newGrades();

        function goster(id) {
            $("#contentLoad").html('Veri alınıyor...');
            $("#contentHead").html('Dosya İşlem Detayları');
            $.ajax({
                type: 'POST',
                url: "/musteri/ajax/vize-dosya-log",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    if (data['content'] == '') {
                        $("#contentLoad").html('Veri girişi yapılmadı');
                    } else {
                        $("#contentLoad").html(data['content']);
                    }
                },
                error: function(data, status, xhr) {
                    $("#contentLoad").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }

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
