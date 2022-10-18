<div class="card card-danger mb-3">
    <div class="card-header bg-danger text-white">
        Cari Dosya Detayları
        @if (session('userTypeId') == 1)
            <div class="dropdown float-end">
                <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Dosya İşlemleri</a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" onclick="asama();"
                            data-bs-target="#exampleModal">Aşama Güncelle</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" onclick="status();"
                            data-bs-target="#exampleModal">Durum Güncelle</a></li>
                    @if (isset($visaFileDetail))
                        @if (session('userTypeId') == 1)
                            <li><a class="dropdown-item" href="vize/{{ $visaFileDetail->id }}/arsive-tasima">Arşive
                                    Taşıma</a></li>
                        @endif
                    @endif
                </ul>
            </div>

        @endif
    </div>

    <div class="card-body scroll">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <span class="fw-bold">Cari Dosya Detayı</span>
                <ul>
                    <li>
                        <span class="fw-bold">Referans Numarası:</span>
                        <span>{{ $visaFileDetail->id }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Danışman:</span>
                        <span>{{ $visaFileDetail->advisor_name == '' ? 'Sonuç bulunamadı' : $visaFileDetail->advisor_name }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Başvuru Ofisi:</span>
                        <span>{{ $visaFileDetail->application_office_name }}</span>
                    </li>

                    <li>
                        <span class="fw-bold">Vize Tipi:</span>
                        <span>{{ $visaFileDetail->visa_type_name }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Vize Süresi:</span>
                        <span>{{ $visaFileDetail->visa_validity_name }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Dosya Durumu:</span>
                        <span>{{ $visaFileDetail->status == 0 ? 'Normal' : 'Acil' }} Dosya</span>
                    </li>

                </ul>
            </div>
            <div class="col-md-6 col-lg-4">
                <span class=" fw-bold">Randevu Bilgisi</span>
                <ul>
                    <li>
                        <span class="fw-bold">GWF Numarası:</span>
                        <span>{{ $visaFileDetail->visa_appointments_gwf == '' ? 'Sonuç bulunamadı' : $visaFileDetail->visa_appointments_gwf }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Uzman:</span>
                        <span>{{ $visaFileDetail->expert_name == '' ? 'Sonuç bulunamadı' : $visaFileDetail->expert_name }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Randevu Ofisi:</span>
                        <span>{{ $visaFileDetail->appointment_office_name == '' ? 'Sonuç bulunamadı' : $visaFileDetail->appointment_office_name }}</span>
                    </li>

                    <li>
                        <span class="fw-bold">Tarih:</span>
                        <span>{{ $visaFileDetail->visa_appointments_date == '' ? 'Sonuç bulunamadı' : $visaFileDetail->visa_appointments_date }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Saat:</span>
                        <span>{{ $visaFileDetail->visa_appointments_time == '' ? 'Sonuç bulunamadı' : $visaFileDetail->visa_appointments_time }}</span>
                    </li>

                </ul>
            </div>
            <div class="col-md-6 col-lg-4">
                <span class=" fw-bold">Diğer Detaylar</span>
                <ul>

                    @if ($visaFileDetail->visa_result == null)
                        <li>
                            <span class="fw-bold">Sonuç:</span>
                            <span>Sonuç bulunamadı</span>
                        </li>
                    @elseif ($visaFileDetail->visa_result == 1)
                        <li>
                            <span class="fw-bold">Sonuç:</span>
                            <span>Olumlu</span>
                        </li>
                        <li>
                            <span class="fw-bold">Vize Başlangıç Tarihi:</span>
                            <span>{{ $visaFileDetail->visa_start_date }}</span>
                        </li>
                        <li>
                            <span class="fw-bold">Vize Bitiş Tarihi:</span>
                            <span>{{ $visaFileDetail->visa_end_date }}</span>
                        </li>
                        <li>
                            <span class="fw-bold">Vize Teslim Alınma Tarihi:</span>
                            <span>{{ $visaFileDetail->visa_delivery_accepted_date }}</span>
                        </li>
                    @elseif ($visaFileDetail->visa_result == 2)
                        <li>
                            <span class="fw-bold">Sonuç:</span>
                            <span>İade</span>
                        </li>
                    @elseif ($visaFileDetail->visa_result == 0)
                        <li>
                            <span class="fw-bold">Sonuç:</span>
                            <span>Olumsuz</span>
                        </li>
                        <li>
                            <span class="fw-bold">Ret Nedeni:</span>
                            <span>{{ $visaFileDetail->visa_refusal_reason }}</span>
                        </li>
                        <li>
                            <span class="fw-bold">Ret Tarihi:</span>
                            <span>{{ $visaFileDetail->visa_refusal_date }}</span>
                        </li>
                        <li>
                            <span class="fw-bold">Ret Teslim Alınma Tarihi:</span>
                            <span>{{ $visaFileDetail->visa_refusal_delivery_accepted_date }}</span>
                        </li>
                    @endif

                    <li>
                        <span class="fw-bold">Tercüman:</span>
                        <span>{{ $visaFileDetail->translator_name == '' ? 'Sonuç bulunamadı' : $visaFileDetail->translator_name }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
