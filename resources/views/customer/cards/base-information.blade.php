@if (isset($temelBilgiler))
    <div class="card card-primary mb-3" id="temel">
        <div class="card-header bg-primary text-white">Müşteri Bilgileri</div>

        <div class="card-body scroll">
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li><span class="fw-bold">Adı: </span> {{ $temelBilgiler->name }}</li>
                        <li><span class="fw-bold">Telefon: </span> {{ $temelBilgiler->telefon }}</li>
                        <li><span class="fw-bold">E-mail: </span> {{ $temelBilgiler->email }}</li>
                        <li><span class="fw-bold">T.C. Kimlik No: </span>
                            {{ $temelBilgiler->tcno != null ? $temelBilgiler->tcno : 'Kayıt bilgisi yok' }}</li>
                        <li><span class="fw-bold">Adres: </span>
                            {{ $temelBilgiler->adres != null ? $temelBilgiler->adres : 'Kayıt bilgisi yok' }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li><span class="fw-bold">Başvuru Ofisi:: </span>
                            {{ $temelBilgiler->application_name != null ? $temelBilgiler->application_name : 'Kayıt bilgisi yok' }}</li>
                        <li><span class="fw-bold">Randevu Ofisi: </span>
                            {{ $temelBilgiler->appointment_name != null ? $temelBilgiler->appointment_name : 'Kayıt bilgisi yok' }}</li>
                        <li><span class="fw-bold">Pasaport No: </span>
                            {{ $temelBilgiler->pasaport != null ? $temelBilgiler->pasaport : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Pasaport Tarihi: </span>
                            {{ $temelBilgiler->pasaport_tarihi != null ? $temelBilgiler->pasaport_tarihi : 'Kayıt bilgisi yok' }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="gap-2">
                <a href="/musteri/{{ $temelBilgiler->id }}/duzenle"
                    class="btn btn-danger btn-sm text-white">Düzenle</a>
            </div>
        </div>
    </div>
@endif
