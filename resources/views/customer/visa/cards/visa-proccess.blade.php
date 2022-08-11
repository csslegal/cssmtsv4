<div class="card card-dark mb-3">
    <div class="card-header bg-dark text-white fw-bold">Vize Dosya İşlemleri</div>
    <div class="card-body scroll">
        <div class="row">

            @if (!isset($visaFileDetail) && $visaFileGradesPermitted['permitted'])
                <div class="col-lg-6 col-md-6 col-sm-6 ">
                    <div class="card border-dark mb-2">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Cari Dosya Aç</h5>
                            <p>&nbsp;</p>
                            <a class="btn btn-dark btn-sm float-end" href="vize/dosya-acma"> İşleme Git</a>
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($visaFileDetail))

                @if (session('userTypeId') == 1)
                    <div class="col-lg-6 col-md-6 col-sm-6 ">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Arşive Taşı</h5>
                                <p>Cari dosyayı arşive taşıma</p>
                                <a class="confirm btn btn-dark btn-sm float-end" data-title="Dikkat!"
                                    data-content="Dosya direk arşive taşınacak! Devam edilsin mi?"
                                    href="vize/{{ $visaFileDetail->id }}/arsive-tasima">İşleme Git</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Arşivler</h5>
                        <p>Pasif dosya detayları</p>
                        <a class="btn btn-dark btn-sm float-end" href="vize/arsiv"> İşleme Git</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
