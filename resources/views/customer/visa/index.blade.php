@extends('sablon.genel')

@section('title')
    Vize Anasayfa
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
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

    @include('customer.modals.content-load')
@endsection

@section('js')
    <script>
        function newGrades() {
            $.get('/musteri/{{ $baseCustomerDetails->id }}/vize/asama', {}, function(resp) {
                //console.log(resp)
                if (resp == 'NOT_FOUND_VISA_FILE') {
                    //console.log('NOT_FOUND_VISA_FILE');
                } else if (resp == 'REFRESH') {
                    //console.log('REFRESH');
                    location.reload(true);
                } else if (resp == 'WAIT') {
                    //console.log('WAIT');
                    setTimeout('newGrades()', 10000);
                } else if (resp == 'SET') {
                    //console.log('SET');
                    setTimeout('newGrades()', 10000);
                }
            });
        }
        setTimeout('newGrades()', 10000);

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
        @if (isset($visaFileDetail))
            @if (session('userTypeId') == 1)
                function asama() {
                    $("#contentHead").html('Dosya Aşama Güncelleme');
                    @php
                        $asamalar = '<form action="vize/' . $visaFileDetail->id . '/asama-guncelle" method="post"><div class="form-group"><select name="visa_file_grades_id" class="form-control">';
                        foreach ($visaFileGrades as $visaFileGrade) {
                            if ($visaFileGrade->id == $visaFileDetail->visa_file_grades_id) {
                                $asamalar .= '<option selected value="' . $visaFileGrade->id . '">' . $visaFileGrade->name . '</option>';
                            } else {
                                $asamalar .= '<option value="' . $visaFileGrade->id . '">' . $visaFileGrade->name . '</option>';
                            }
                        }
                        $asamalar .= '</select>';
                        $asamalar .= '<input type="hidden" name="_token" value="' . csrf_token() . '" /></div>';
                        $asamalar .= '<button type="submit" class="btn btn-danger text-white mt-2">Güncelle</button></form>';
                    @endphp

                    $("#contentLoad").html('{!! html_entity_decode($asamalar) !!}');
                }
            @endif
        @endif
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
