@extends('sablon.genel')

@section('title')
    Vize Anasayfa
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb">
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
            $("#contentLoad").html('İçerik alınıyor...');
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
                        $("#contentLoad").html('İçerik girişi yapılmadı');
                    } else {
                        $("#contentLoad").html(data['content']);
                    }
                },
                error: function(data, status, xhr) {
                    $("#contentLoad").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }
        @if (isset($visaFileDetail) && session('userTypeId') == 1)
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
                    $asamalar .= '<button type="submit" class="btn btn-dark text-white mt-2">Güncelle</button></form>';
                @endphp

                $("#contentLoad").html('{!! html_entity_decode($asamalar) !!}');
            }
            function status() {
                $("#contentHead").html('Dosya Durumu Güncelleme');
                @php
                    $durum = '<form action="vize/' . $visaFileDetail->id . '/durum-guncelle" method="post"><div class="form-group"><select name="status" class="form-control">';
                        if ($visaFileDetail->status) {
                            $durum .= '<option selected value="1">Acil Dosya</option><option value="0">Normal Dosya</option>';
                        } else {
                            $durum .= '<option value="1">Acil Dosya</option><option selected value="0">Normal Dosya</option>';
                        }
                    $durum .= '</select>';
                    $durum .= '<input type="hidden" name="_token" value="' . csrf_token() . '" /></div>';
                    $durum .= '<button type="submit" class="btn btn-dark text-white mt-2">Güncelle</button></form>';
                @endphp

                $("#contentLoad").html('{!! html_entity_decode($durum) !!}');
            }
        @endif
    </script>
@endsection
