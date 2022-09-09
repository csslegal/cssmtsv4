<div class="card card-dark  mb-3" id="visa">
    <div class="card-header bg-dark text-white">Chart JS Logları
        <div class="float-end">
            <form action="/yonetim/vize" method="GET">
                <div class="input-group input-group-sm">
                    <span class="input-group-text ">Tarih Aralığı:</span>
                    <input type="text" name="dates"
                        value="{{ request('dates') ? request('dates') : date('Y-m-01') . '--' . date('Y-m-28') }}"
                        autocomplete="off" id="dates" class="form-control">
                    <button type="submit" class="btn btn-light">Uygula</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body scroll">
        <div class="row">
            <div class="col-lg-12 ">
                <label class="text text-dark fw-bold">Aşamalara Göre</label>
                <div style="height: auto;width: 310px; margin: 0 auto">
                    <canvas id="myChart"></canvas>
                </div>
            </div>

            <div class="col-lg-6">
                <label class="text text-dark fw-bold">Başvuru Ofislere Göre</label>
                <div style="height: auto;width: 310px; margin: 0 auto">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="text text-dark fw-bold">Danışman Vize Sonuc Performansı(VİZE x
                    RED)</label>
                <div style="height: auto;width: 310px; margin: 0 auto">
                    <canvas id="myChart3"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
