@if (isset($baseCustomerDetails))
    <div class="card card-primary mb-3" id="temel">
        <div class="card-header bg-primary text-white">Müşteri Bilgileri</div>

        <div class="card-body scroll">
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li><span class="fw-bold">Adı: </span> {{ $baseCustomerDetails->name }}</li>
                        <li><span class="fw-bold">Telefon: </span> {{ $baseCustomerDetails->telefon }}</li>
                        <li><span class="fw-bold">E-mail: </span> {{ $baseCustomerDetails->email }}</li>
                        <li><span class="fw-bold">T.C. Kimlik No: </span>
                            {{ $baseCustomerDetails->tcno != null ? $baseCustomerDetails->tcno : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Adres: </span>
                            {{ $baseCustomerDetails->adres != null ? $baseCustomerDetails->adres : 'Kayıt bilgisi yok' }}
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li><span class="fw-bold">Başvuru Ofisi:: </span>
                            {{ $baseCustomerDetails->application_name != null ? $baseCustomerDetails->application_name : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Randevu Ofisi: </span>
                            {{ $baseCustomerDetails->appointment_name != null ? $baseCustomerDetails->appointment_name : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Pasaport No: </span>
                            {{ $baseCustomerDetails->pasaport != null ? $baseCustomerDetails->pasaport : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Pasaport Tarihi: </span>
                            {{ $baseCustomerDetails->pasaport_tarihi != null ? $baseCustomerDetails->pasaport_tarihi : 'Kayıt bilgisi yok' }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="gap-2">
                <a href="/musteri/{{ $baseCustomerDetails->id }}/duzenle"
                    class="btn btn-danger btn-sm text-white">Düzenle</a>
            </div>
        </div>
    </div>
@endif
