@extends('sablon.genel')

@section('title')
    Vize Arşivler
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">Arşiv Dosyalar</li>
        </ol>
    </nav>

    @if (count($visaArchives) > 0)
        @foreach ($visaArchives as $visaArchive)
            <div class="card card-danger mb-3">
                <div class="card-header bg-danger text-white">
                    {{ $visaArchive->id }} Referans Numaralı Arşiv Dosyası
                    @if (session('userTypeId') == 1 || session('userTypeId') == 2)
                        <div class="dropdown drop float-end">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Arşiv Dosya İşlemleri</button>
                            <ul class="dropdown-menu">
                                <li>
                                    <button class="dropdown-item btn btn-secondary btn-sm "
                                        onclick="contentLoad('arsiv-log','{{ $visaArchive->id }}')" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">Logları Göster
                                    </button>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="card-body scroll">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <span class=" fw-bold">Detaylar</span>
                            <ul>
                                <li>
                                    <span class="fw-bold">Vize Tipi:</span>
                                    <span>{{ $visaArchive->visa_type_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Vize Süresi:</span>
                                    <span>{{ $visaArchive->visa_validity_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Dosya Durumu:</span>
                                    <span>{{ $visaArchive->status == 0 ? 'Normal' : 'Acil' }} Dosya</span>
                                </li>

                                @if ($visaArchive->visa_result == null)
                                    <li>
                                        <span class="fw-bold">Sonuç:</span>
                                        <span>Sonuç bulunamadı</span>
                                    </li>
                                @elseif ($visaArchive->visa_result == 1)
                                    <li>
                                        <span class="fw-bold">Sonuç:</span>
                                        <span>Olumlu</span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Vize Başlangıç Tarihi:</span>
                                        <span>{{ $visaArchive->visa_start_date }}</span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Vize Bitiş Tarihi:</span>
                                        <span>{{ $visaArchive->visa_end_date }}</span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Vize Teslim Alınma Tarihi:</span>
                                        <span>{{ $visaArchive->visa_delivery_accepted_date }}</span>
                                    </li>
                                @elseif ($visaArchive->visa_result == 2)
                                    <li>
                                        <span class="fw-bold">Sonuç:</span>
                                        <span>İade</span>
                                    </li>
                                @elseif ($visaArchive->visa_result == 0)
                                    <li>
                                        <span class="fw-bold">Sonuç:</span>
                                        <span>Olumsuz</span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Ret Nedeni:</span>
                                        <span>{{ $visaArchive->visa_refusal_reason }}</span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Ret Tarihi:</span>
                                        <span>{{ $visaArchive->visa_refusal_date }}</span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Ret Teslim Alınma Tarihi:</span>
                                        <span>{{ $visaArchive->visa_refusal_delivery_accepted_date }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <span class=" fw-bold">Randevu Bilgisi</span>
                            <ul>
                                <li>
                                    <span class="fw-bold">Dosya Uzmanı:</span>
                                    <span>{{ $visaArchive->expert_name == '' ? 'Sonuç bulunamadı' : $visaArchive->expert_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">GWF Numarası:</span>
                                    <span>{{ $visaArchive->visa_appointments_gwf == '' ? 'Sonuç bulunamadı' : $visaArchive->visa_appointments_gwf }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Randevu Ofisi:</span>
                                    <span>{{ $visaArchive->appointment_offices_name == '' ? 'Sonuç bulunamadı' : $visaArchive->appointment_offices_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Randevu Tarihi:</span>
                                    <span>{{ $visaArchive->visa_appointments_date == '' ? 'Sonuç bulunamadı' : $visaArchive->visa_appointments_date }}</span>
                                </li>

                                <li>
                                    <span class="fw-bold">Randevu Saati:</span>
                                    <span>{{ $visaArchive->visa_appointments_time == '' ? 'Sonuç bulunamadı' : $visaArchive->visa_appointments_time }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Randevu İşlem Tarihi:</span>
                                    <span>{{ $visaArchive->visa_appointments_created_at == '' ? 'Sonuç bulunamadı' : $visaArchive->visa_appointments_created_at }}</span>
                                </li>

                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <span class=" fw-bold">Diğer Bilgiler</span>
                            <ul>
                                <li>
                                    <span class="fw-bold">Başvuru Ofisi:</span>
                                    <span>{{ $visaArchive->application_offices_name == '' ? 'Sonuç bulunamadı' : $visaArchive->application_offices_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Dosya Danışmanı:</span>
                                    <span>{{ $visaArchive->advisor_name == '' ? 'Sonuç bulunamadı' : $visaArchive->advisor_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Dosya Tercümanı:</span>
                                    <span>{{ $visaArchive->translator_name == '' ? 'Sonuç bulunamadı' : $visaArchive->translator_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Teslim Eden Ofis:</span>
                                    <span>{{ $visaArchive->delivery_application_office_name == '' ? 'Sonuç bulunamadı' : $visaArchive->delivery_application_office_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Teslim Eden Personel:</span>
                                    <span>{{ $visaArchive->user_delivery_name == '' ? 'Sonuç bulunamadı' : $visaArchive->user_delivery_name }}</span>
                                </li>
                                @if ($visaArchive->delivery_method == 1)
                                    <li>
                                        <span class="fw-bold">Teslimat Şekli:</span>
                                        <span>Elden kimlik ile</span>
                                    </li>
                                @elseif($visaArchive->delivery_method == 2)
                                    <li>
                                        <span class="fw-bold">Teslimat Şekli:</span>
                                        <span>{{ $visaArchive->courier_company }} </span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Kargo Takip No:</span>
                                        <span>{{ $visaArchive->tracking_number }} </span>
                                    </li>
                                @elseif($visaArchive->delivery_method == 3)
                                    <li>
                                        <span class="fw-bold">Teslimat Şekli:</span>
                                        <span>Başvuru yenileme</span>
                                    </li>
                                @endif
                                <li>
                                    <span class="fw-bold">Arşiv Klasoru:</span>
                                    <span>{{ $visaArchive->archive_folder_name == '' ? 'Sonuç bulunamadı' : $visaArchive->archive_folder_name }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @include('customer.modals.content-load')
    @else
        <div class="card card-dark mb-3">
            <div class="card-body scroll">Herhangi bir arşiv dosyası bulunamadı</div>
        </div>
    @endif
@endsection
@section('js')
    <script>
        function contentLoad(ne, id) {
            var url = "/musteri/ajax/";
            if (ne == 'arsiv-log') {
                url += "vize/arsiv-log";
                $("#contentHead").html('Vize Dosyası İşlem Logları');
                $("#contentLoad").html('İçerik alınıyor...');
            } else if (ne == 'vize-dosya-log') {
                url += "vize-dosya-log";

                $("#contentLoad1").html('İçerik alınıyor...');
                $("#contentHead1").html('Vize Dosyası İşlem Log Detayları');
                $("#footerLoad1").html(
                    '<button class="btn btn-secondary" data-bs-target="#exampleModal" data-bs-toggle="modal">Loglara Dön</button>'
                );
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    if (ne == 'arsiv-log') {
                        $("#contentLoad").html(data);
                    } else if (ne == 'vize-dosya-log') {
                        if (data['content'] == '') {
                            $("#contentLoad1").html('İçerik girişi yapılmadı');
                        } else {
                            $("#contentLoad1").html(data['content']);
                        }
                    }
                },
                error: function(data, status, xhr) {
                    if (ne == 'arsiv-log') {
                        $("#contentLoad").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                    } else if (ne == 'vize-dosya-log') {
                        $("#contentLoad1").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                    }
                }
            });
        }
    </script>
@endsection
