@extends('sablon.genel')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
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
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white">{{ $visaArchive->id }} Referans Numaralı Arşiv Dosyası</div>
                <div class="card-body scroll">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <span class=" fw-bold">Dosya Detayı</span>
                            <ul>
                                <li>
                                    <span class="fw-bold">Vize Tipi:</span>
                                    <span>{{ $visaArchive->visa_type_name }} /
                                        {{ $visaArchive->visa_sub_type_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Vize Süresi:</span>
                                    <span>{{ $visaArchive->visa_validity_name }}</span>
                                </li>
                                @if ($visaArchive->visa_result)
                                    <li>
                                        <span class="fw-bold">Sonuç:</span>
                                        <span>Olumlu </span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Vize Tarihi:</span>
                                        <span>{{ $visaArchive->visa_date }}</span>
                                    </li>
                                @else
                                    <li>
                                        <span class="fw-bold">Sonuç:</span>
                                        <span>Olumsuz </span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Red Nedeni:</span>
                                        <span>{{ $visaArchive->visa_refusal_reason }}</span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Red Tarihi:</span>
                                        <span>{{ $visaArchive->visa_refusal_date }}</span>
                                    </li>
                                @endif

                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <span class=" fw-bold">Randevu Bilgisi</span>
                            <ul>
                                <li>
                                    <span class="fw-bold">GWF Numarası:</span>
                                    <span>{{ $visaArchive->visa_appointments_gwf == '' ? 'Sonuç bulunamadı' : $visaArchive->visa_appointments_gwf }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Tarih:</span>
                                    <span>{{ $visaArchive->visa_appointments_date == '' ? 'Sonuç bulunamadı' : $visaArchive->visa_appointments_date }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Saat:</span>
                                    <span>{{ $visaArchive->visa_appointments_time == '' ? 'Sonuç bulunamadı' : $visaArchive->visa_appointments_time }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">İşlem Tarihi:</span>
                                    <span>{{ $visaArchive->visa_appointments_created_at == '' ? 'Sonuç bulunamadı' : $visaArchive->visa_appointments_created_at }}</span>
                                </li>

                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <span class=" fw-bold">Teslimat Bilgisi</span>
                            <ul>
                                <li>
                                    <span class="fw-bold">Teslim Eden Ofis:</span>
                                    <span>{{ $visaArchive->application_offices_name == '' ? 'Sonuç bulunamadı' : $visaArchive->application_offices_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">İlgili Personel:</span>
                                    <span>{{ $visaArchive->user_delivery_name == '' ? 'Sonuç bulunamadı' : $visaArchive->user_delivery_name }}</span>
                                </li>
                                @if ($visaArchive->delivery_method == 1)
                                    <li>
                                        <span class="fw-bold">Teslimat Şekli:</span>
                                        <span>Elden kimlik ile</span>
                                    </li>
                                @elseif($visaArchive->delivery_method==2)
                                    <li>
                                        <span class="fw-bold">Teslimat Şekli:</span>
                                        <span>{{ $visaArchive->courier_company }} </span>
                                    </li>
                                    <li>
                                        <span class="fw-bold">Kargo Takip No:</span>
                                        <span>{{ $visaArchive->tracking_number }} </span>
                                    </li>
                                @elseif($visaArchive->delivery_method==3)
                                    <li>
                                        <span class="fw-bold">Teslimat Şekli:</span>
                                        <span>Başvuru yenileme</span>
                                    </li>
                                @endif

                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <span class=" fw-bold">İlgili Personel</span>
                            <ul>
                                <li>
                                    <span class="fw-bold">Danışman:</span>
                                    <span>{{ $visaArchive->advisor_name == '' ? 'Sonuç bulunamadı' : $visaArchive->advisor_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Uzman:</span>
                                    <span>{{ $visaArchive->expert_name == '' ? 'Sonuç bulunamadı' : $visaArchive->expert_name }}</span>
                                </li>
                                <li>
                                    <span class="fw-bold">Tercüman:</span>
                                    <span>{{ $visaArchive->translator_name == '' ? 'Sonuç bulunamadı' : $visaArchive->translator_name }}</span>
                                </li>
                            </ul>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                <div class="card border-danger mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Loglar</h5>
                                        <p>Dosya Logları</p>
                                        <button class="btn btn-primary btn-sm float-end text-white">Göster</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                <div class="card border-danger mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Ödemeler</h5>
                                        <p>Ödeme detayları</p>
                                        <button class="btn btn-primary btn-sm float-end text-white">Göster</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                <div class="card border-danger mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Makbuzlar</h5>
                                        <p>Makbuz detayları</p>
                                        <button class="btn btn-primary btn-sm float-end text-white">Göster</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                <div class="card border-danger mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Faturalar</h5>
                                        <p>Fatura detayları</p>
                                        <button class="btn btn-primary btn-sm float-end text-white">Göster</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-danger">
            Herhangi bir arşiv dosyası bulunamadı.
        </div>
    @endif

@endsection
