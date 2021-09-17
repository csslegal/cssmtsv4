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
                            {{ $temelBilgiler->tcno != null ? $temelBilgiler->tcno : 'Kayıt bilgisi yok' }}</li>
                        <li><span class="fw-bold">Randevu Ofisi: </span>
                            {{ $temelBilgiler->tcno != null ? $temelBilgiler->tcno : 'Kayıt bilgisi yok' }}</li>
                        <li><span class="fw-bold">Pasaport No: </span>
                            {{ $temelBilgiler->pasaport != null ? $temelBilgiler->pasaport : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Pasaport Tarihi: </span>
                            {{ $temelBilgiler->pasaport_tarihi != null ? $temelBilgiler->pasaport_tarihi : 'Kayıt bilgisi yok' }}
                        </li>
                        @if (isset($dosyaDetaylari))
                            <span class="fw-bold">Dosya Danışmani:</span>
                            {{ $dosyaDetaylari->u_name != null ? $dosyaDetaylari->u_name : 'Danışman atanmadı' }}
                            <span class="fw-bold">Durum: </span>
                            {!! $dosyaDetaylari->d_aciliyet_durum_id == 0 ? '' : '<span class="glyphicon glyphicon-warning-sign " style="color:red"></span>' !!}
                            {{ $dosyaDetaylari->d_aciliyet_durum_id == 0 ? 'Normal dosya' : 'Acil dosya' }}
                            {!! $dosyaDetaylari->d_aciliyet_durum_id == 0 ? '' : '<span class="glyphicon glyphicon-warning-sign " style="color:red"></span>' !!}
                            <span class="fw-bold">Başvuru Ofisi:</span>
                            {{ $dosyaDetaylari->bo_name != null ? $dosyaDetaylari->bo_name : 'Başvuru ofisi seçilmedi' }}

                            <span class="fw-bold">Randevu Şehri:</span>
                            {{ $dosyaDetaylari->ro_name != null ? $dosyaDetaylari->ro_name : 'Randevu şehri seçilmedi' }}
                        @endif

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
