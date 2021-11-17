<div class="card card-primary mb-3">
    <div class="card-header bg-primary text-white">Vize Dosya İşlemleri</div>
    <div class="card-body scroll">
        <div class="row">
            @if (!isset($visaFileDetail) && $visaFileGradesPermitted['permitted'])
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card border-primary mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Cari Dosya Aç</h5>
                            <p>&nbsp;</p>
                            <a class="confirm btn btn-primary btn-sm float-end" data-title="Dikkat!"
                                data-content="Devam edilsin mi?" href="vize/dosya-ac"> İşleme Git</a>
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($visaFileDetail))
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card border-secondary mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Ödemeler</h5>
                            <p>Cari dosya ödeme detayları</p>
                            <a class="confirm btn btn-secondary btn-sm float-end" data-title="Dikkat!"
                                data-content="Devam edilsin mi?" href="vize/{{ $visaFileDetail->id }}/odeme"> İşleme
                                Git</a>
                        </div>
                    </div>
                </div>
                <!--<div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card border-success mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Makbuzlar</h5>
                            <p>Cari dosya makbuz detayları</p>
                            <a class="confirm btn btn-success btn-sm float-end" data-title="Dikkat!"
                                data-content="Devam edilsin mi?" href="vize/{{ $visaFileDetail->id }}/makbuz"> İşleme
                                Git</a>
                        </div>
                    </div>
                </div>-->
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card border-danger mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Faturalar</h5>
                            <p>Cari dosya fatura detayları;</p>
                            <a class="confirm btn btn-danger btn-sm text-white float-end" data-title="Dikkat!"
                                data-content="Devam edilsin mi?" href="vize/{{ $visaFileDetail->id }}/faturalar">
                                İşleme Git</a>
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($visaFileDetail))

                @if (!$visaFileGradesPermitted['fileCloseRequestGradeIds'] && $visaFileGradesPermitted['fileCloseRequestGrade'])

                    <div class="col-lg-4 col-md-6 col-sm-6 ">
                        <div class="card border-warning mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Dosya Kapatma</h5>
                                <p>Cari dosya kapatma isteği</p>
                                <a class="confirm btn btn-warning btn-sm float-end text-dark" data-title="Dikkat!"
                                    data-content="Dosya kapatma isteği işlemi! Devam edilsin mi?"
                                    href="vize/{{ $visaFileDetail->id }}/kapatma">
                                    İşleme Yap
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card border-info mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Arşive Taşı</h5>
                            <p>Cari dosyayı arşive taşıma</p>
                            <a class="confirm btn btn-info btn-sm float-end" data-title="Dikkat!"
                                data-content="Dosya direk arşive taşınacak! Devam edilsin mi?"
                                href="vize/{{ $visaFileDetail->id }}/arsive-tasima">
                                İşleme Git</a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-4 col-md-6 col-sm-6 ">
                <div class="card border-dark mb-2">
                    <div class="card-body">
                        <h5 class="card-title">Arşivler</h5>
                        <p>Pasif dosya detayları</p>
                        <a class="confirm btn btn-dark btn-sm float-end" data-title="Dikkat!"
                            data-content="Devam edilsin mi?" href="vize/arsiv"> İşleme Git</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
