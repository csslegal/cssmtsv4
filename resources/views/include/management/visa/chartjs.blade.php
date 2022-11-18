<div class="row">
    <div class="col-12">
        <h2>Kota Grafikleri</h2>
    </div>
    <div class="col-xxl-3 col-lg-6 col-md-6">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChartQuotaDay"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-lg-6 col-md-6"">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChartQuotaWeek"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-lg-6 col-md-6"">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChartQuotaMount"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-lg-6 col-md-6"">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChartQuotaYear"></canvas></div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <h2> Analiz Grafikleri
            <div class="float-end">
                <form action="/yonetim/vize#pills-chartjs" method="GET">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-danger text-white">Dosya Tipi:</span>
                        <select class="form-control" name="status" id="">
                            <option value="cari" @if (request()->get('status') == 'cari') selected @endif>
                                Cari
                            </option>
                            <option value="arsiv" @if (request()->get('status') == 'arsiv') selected @endif>
                                Arşiv
                            </option>
                            <option value="all" @if (request()->get('status') == 'all') selected @endif>
                                Tümü
                            </option>
                        </select>
                        <span class="input-group-text bg-danger text-white">Tarih Aralığı:</span>
                        <input type="text" name="dates"
                            value="{{ request('dates') ? request('dates') : date('Y-m-01') . '--' . date('Y-m-28') }}"
                            autocomplete="off" id="dates" class="form-control">
                        <button type="submit" class="btn btn-dark">Uygula</button>
                    </div>
                </form>
            </div>
        </h2>

    </div>
    <div class="col-xxl-4 col-xl-6 col-lg-6">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChart"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-xl-6 col-lg-6">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChart1"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-xl-6 col-lg-6">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChart2"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-xl-6 col-lg-6">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChart6"></canvas></div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <h2> Personel Grafikleri
            <div class="float-end">
                <form action="/yonetim/vize#pills-chartjs" method="GET">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-danger text-white">Dosya Tipi:</span>
                        <select class="form-control" name="status" id="">
                            <option value="cari" @if (request()->get('status') == 'cari') selected @endif>
                                Cari
                            </option>
                            <option value="arsiv" @if (request()->get('status') == 'arsiv') selected @endif>
                                Arşiv
                            </option>
                            <option value="all" @if (request()->get('status') == 'all') selected @endif>
                                Tümü
                            </option>
                        </select>
                        <span class="input-group-text bg-danger text-white">Tarih Aralığı:</span>
                        <input type="text" name="dates"
                            value="{{ request('dates') ? request('dates') : date('Y-m-01') . '--' . date('Y-m-28') }}"
                            autocomplete="off" id="dates" class="form-control">
                        <button type="submit" class="btn btn-dark">Uygula</button>
                    </div>
                </form>
            </div>
        </h2>
    </div>
    <div class="col-xxl-4 col-xl-6 col-lg-6">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChart3"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-xl-6 col-lg-6">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChart4"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-xl-6 col-lg-6">
        <div class="card mb-1">
            <div class="card-body">
                <div style="width: 100%"><canvas id="myChart5"></canvas></div>
            </div>
        </div>
    </div>
</div>
