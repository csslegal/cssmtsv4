<div class="card card-dark  mb-3" id="visa">
    <div class="card-body scroll">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-end">
                    <form action="/yonetim/vize" method="GET">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text ">Dosya Tipi:</span>
                            <select class="form-control" name="status" id="">
                                <option value="cari" @if (request()->get('status') == 'cari') selected @endif>Cari</option>
                                <option value="arsiv" @if (request()->get('status') == 'arsiv') selected @endif>Arşiv</option>
                            </select>
                            <span class="input-group-text ">Tarih Aralığı:</span>
                            <input type="text" name="dates"
                                value="{{ request('dates') ? request('dates') : date('Y-m-01') . '--' . date('Y-m-28') }}"
                                autocomplete="off" id="dates" class="form-control">
                            <button type="submit" class="btn btn-light">Uygula</button>
                        </div>
                    </form>
                </div>
            </div>
            @if ($visaFilesGradesCount != null)
                <div class="col-lg-6 ">
                    <label class="text text-dark fw-bold">Aşamalara Göre</label>
                    <div style="width: 100%">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            @endif
            @if ($visaFilesApplicationOfficeCount != null)
                <div class="col-lg-6">
                    <label class="text text-dark fw-bold">Başvuru Ofislere Göre</label>
                    <div style="width: 100%">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            @endif
            @if ($arrayVisaFilesTranslationsAnalist != null)
                <div class="col-lg-6">
                    <label class="text text-dark fw-bold">Tercüman Vize Dosyası Tercüme Performansı(Sayfa x
                        Kelime)</label>
                    <div style="width: 100%">
                        <canvas id="myChart5"></canvas>
                    </div>
                </div>
            @endif
            @if ($arrayVisaFilesAdvisorsAnalist != null)
                <div class="col-lg-6">
                    <label class="text text-dark fw-bold">Danışman Vize Sonuc Performansı(VİZE x RED)</label>
                    <div style="width: 100%">
                        <canvas id="myChart3"></canvas>
                    </div>
                </div>
            @endif
            @if ($arrayVisaFilesExpertsAnalist != null)
                <div class="col-lg-6">
                    <label class="text text-dark fw-bold">Uzman Vize Sonuc Performansı(VİZE x RED)</label>
                    <div style="width: 100%">
                        <canvas id="myChart4"></canvas>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
