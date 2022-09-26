@extends('sablon.genel')

@section('title')
    Vize Arşivler
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb">
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

    @if ($visaArchives->count() > 0)
        @foreach ($visaArchives as $visaArchive)
            <div class="card border-dark mb-3">
                <div class="card-header bg-dark text-white">{{ $visaArchive->id }} Referans Numaralı Arşiv Dosyası
                </div>
                <div class="card-body scroll">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <span class=" fw-bold">Dosya Detayı</span>
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

                            </ul>
                        </div>
                        <hr>

                        <div class="row">
                            @if (session('userTypeId') == 1 || session('userTypeId') == 2)
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="card border-danger mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Loglar</h5>
                                            <p>Dosya Logları</p>
                                            <button class="btn btn-dark btn-sm float-end text-white"
                                                onclick="contentLoad('arsiv-log','{{ $visaArchive->id }}')"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal" title="Göster">
                                                <i class="bi bi-image"></i> Göster
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Modal -->
        @include('customer.modals.content-load')

        <div class="modal fade" id="exampleModal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel1" aria-hidden="true" style="z-index: 1056">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 id="contentHead1" class="modal-title" id="exampleModalLabel1">İçerik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="contentLoad1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card card-dark mb-3">
            <div class="card-body scroll">Herhangi bir arşiv dosyası bulunamadı</div>
        </div>
    @endif
@endsection
@section('js')
    <script>
        function goster(id) {
            $("#contentLoad1").html('İçerik alınıyor...');
            $("#contentHead1").html('Dosya İşlem Detayları');
            $.ajax({
                type: 'POST',
                url: "/musteri/ajax/vize-dosya-log",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    if (data['content'] == '') {
                        $("#contentLoad1").html('İçerik girişi yapılmadı');
                    } else {
                        $("#contentLoad1").html(data['content']);
                    }
                },
                error: function(data, status, xhr) {
                    $("#contentLoad1").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }

        function contentLoad(ne, id) {
            var url = "/musteri/ajax/vize/";
            if (ne == 'arsiv-log') {
                url += "arsiv-log";
                $("#contentHead").html('Dosya İşlem Geçmişi');
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
                    $("#contentLoad").html(data);
                },
                error: function(data, status, xhr) {
                    $("#contentLoad").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }
    </script>
@endsection
