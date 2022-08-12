@if (isset($baseCustomerDetails))
    <div class="card card-dark mb-3" id="temel">
        <div class="card-header bg-dark text-white">Müşteri Bilgileri
            <a class="float-end text-white" href="/musteri/{{ $baseCustomerDetails->id }}/edit">Güncelle</a>
        </div>

        <div class="card-body scroll">
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li><span class="fw-bold">Adı: </span> {{ $baseCustomerDetails->name }}</li>
                        <li><span class="fw-bold">Telefon: </span> {{ $baseCustomerDetails->phone }}</li>
                        <li><span class="fw-bold">E-mail: </span> {{ $baseCustomerDetails->email }}</li>
                        <li><span class="fw-bold">T.C. Kimlik No: </span>
                            {{ $baseCustomerDetails->tc_number != null ? $baseCustomerDetails->tc_number : 'Kayıt bilgisi yok' }}
                        </li>

                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li><span class="fw-bold">Adres: </span>
                            {{ $baseCustomerDetails->address != null ? $baseCustomerDetails->address : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Pasaport No: </span>
                            {{ $baseCustomerDetails->passport != null ? $baseCustomerDetails->passport : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Pasaport Tarihi: </span>
                            {{ $baseCustomerDetails->passport_date != null ? $baseCustomerDetails->passport_date : 'Kayıt bilgisi yok' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
