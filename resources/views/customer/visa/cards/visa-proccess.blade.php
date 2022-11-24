<div class="card card-danger mb-3">
    <div class="card-header bg-danger text-white">Vize Dosyası İşlemleri</div>
    <div class="card-body">
        <div class="row">
            @if (!isset($visaFileDetail) && $visaFileGradesPermitted['permitted'])
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Cari Dosya Aç</h5>
                            <p>&nbsp;</p>
                            <a class="w-100 mt-2 btn btn-block btn-secondary " href="vize/dosya-acma">İşleme yap</a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Arşivler</h5>
                        <p>Pasif dosya detayları</p>
                        <a class="w-100 mt-2 btn btn-block btn-secondary" href="vize/arsiv">İşleme yap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
