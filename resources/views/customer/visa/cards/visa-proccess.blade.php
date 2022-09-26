<div class="row">

    @if (!isset($visaFileDetail) && $visaFileGradesPermitted['permitted'])
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Cari Dosya Aç</h5>
                    <p>&nbsp;</p>
                    <a class="btn btn-dark btn-sm float-end" href="vize/dosya-acma"> İşleme Git</a>
                </div>
            </div>
        </div>
    @endif
    <div class="col-lg-6 col-md-6 col-sm-6 ">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title fw-bold">Arşivler</h5>
                <p>Pasif dosya detayları</p>
                <a class="btn btn-dark btn-sm float-end" href="vize/arsiv"> İşleme Git</a>
            </div>
        </div>
    </div>
</div>
