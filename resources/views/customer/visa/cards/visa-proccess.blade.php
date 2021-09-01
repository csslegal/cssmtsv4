<div class="alert alert-primary alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Vize İşlemleri</h4>
    <div class="row">
        <div class="col-md-6">
            <ul>
                <li class="fw-bold">Cari dosya açmak için
                    <a class="text-danger" href="/musteri/{{ $baseCustomerDetails->id }}/vize/dosya-ac">tıkla</a>
                </li>
                <li>Cari dosyayı kapatmak için
                    <a class="fw-bold text-danger" href="/musteri/{{ $baseCustomerDetails->id }}">tıkla</a>
                </li>
                <li>Cari dosyayı arşive taşımak için
                    <a class="fw-bold text-danger" href="/musteri/{{ $baseCustomerDetails->id }}">tıkla</a>
                </li>
                <li>Müşteri sayfasına gitmek için
                    <a class="fw-bold" href="/musteri/{{ $baseCustomerDetails->id }}">tıkla</a>
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <ul>
                <li>Cari dosya ödemeleri için
                    <a class="fw-bold text-danger" href="/musteri/{{ $baseCustomerDetails->id }}">tıkla</a>
                </li>
                <li>Cari dosya makbuzları için
                    <a class="fw-bold text-danger" href="/musteri/{{ $baseCustomerDetails->id }}">tıkla</a>
                </li>
                <li>Cari dosya faturaları için
                    <a class="fw-bold text-danger" href="/musteri/{{ $baseCustomerDetails->id }}">tıkla</a>
                </li>
                <li class="fw-bold">Arşiv dosyaları için
                    <a class="text-danger" href="/musteri/{{ $baseCustomerDetails->id }}">tıkla</a>
                </li>
            </ul>
        </div>
    </div>
</div>
