<div class="row">
    @if (in_array(1, $userAccesses))
        <div class="col-xl-4 col-lg-6">
            <div class="card border-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Vize İşlemleri</h5>
                    <ul>
                        <li>Müşteri cari veya arşiv dosyası bulunamadı</li>
                        <li>
                            <span class="fw-bold">
                                Son İşlem ve Tarihi:
                            </span>
                            Dosya işlemleriyle ilgili veri bulunamadı
                        </li>
                    </ul>
                    <a href="/musteri/{{ $temelBilgiler->id }}/vize" class="btn btn-primary float-end">Git</a>
                </div>
            </div>
        </div>
    @endif
    @if (in_array(2, $userAccesses))
        <div class="col-xl-4 col-lg-6">
            <div class="card border-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Harici Tercüme İşlemleri</h5>
                    <ul>
                        <li>Aktif dosyası var</li>
                        <li>
                            <span class="fw-bold">
                                Son İşlem ve Tarihi:
                            </span>
                            Başvuru ödeme alınması bekleniyor tamamlandı <br>{{ date('Y-m-d H:i:s') }}
                        </li>
                    </ul>
                    <a href="/musteri/{{ $temelBilgiler->id }}/harici" class="btn btn-primary float-end">Git</a>
                </div>
            </div>
        </div>
    @endif
    @if (in_array(3, $userAccesses))
        <div class="col-xl-4 col-lg-6">
            <div class="card border-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dil Okulu İşlemleri</h5>
                    <ul>
                        <li>Aktif dosyası var</li>
                        <li>
                            <span class="fw-bold">
                                Son İşlem ve Tarihi:
                            </span>
                            Başvuru ödeme alınması bekleniyor tamamlandı <br>{{ date('Y-m-d H:i:s') }}
                        </li>
                    </ul>
                    <a href="/musteri/{{ $temelBilgiler->id }}/dilokulu" class="btn btn-primary float-end">Git</a>
                </div>
            </div>
        </div>
    @endif
</div>
