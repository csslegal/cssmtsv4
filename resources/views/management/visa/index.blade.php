@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vize İşlemleri</li>
        </ol>
    </nav>

    @include('include.management.visa.nav')

    <div class="card mb-3">
        <div class="card-header text-white bg-danger">Grafikler</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Analizler</h5>
                            <p class="card-text">Analiz grafik detayları.</p>
                            <a href="/yonetim/vize/grafik/index" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Randevu Takvimi</h5>
                            <p class="card-text">Randevu grafik detayları.</p>
                            <a href="/yonetim/vize/grafik/takvim" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header text-white bg-danger">Genel Vize İşlemleri</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Dosya Aşamaları</h5>
                            <p class="card-text">Cari vize dosya aşama detayları.</p>
                            <a href="/yonetim/vize/dosya-asama" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Dosya Aşama Erişimleri</h5>
                            <p class="card-text">Dosya aşama erişim detayları.</p>
                            <a href="/yonetim/vize/dosya-asama-erisim" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Vize Tipleri</h5>
                            <p class="card-text">Vize tipleri detayları.</p>
                            <a href="/yonetim/vize/vize-tipi" class="w-100 mt-2 btn btn-dark">İşlem yap</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Vize Süreleri</h5>
                            <p class="card-text">Vize süreleri detayları.</p>
                            <a href="/yonetim/vize/vize-suresi" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Dosyası Logları</h5>
                            <p class="card-text">Vize dosya log detayları.</p>
                            <a href="/yonetim/vize/logs" class="w-100 mt-2 btn btn-dark">İşlem
                                yap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('js/air-datepicker/air-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('js/fullcalendar/main.css') }}" />
@endsection

@section('js')
    <script src="{{ asset('js/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('js/fullcalendar/locales/tr.js') }}"></script>
    <script src="{{ asset('js/air-datepicker/air-datepicker.js') }}"></script>
    <script src="{{ asset('js/chart.js/chart.min.js') }}"></script>
    <script>
        var loadTime = 100;
        var plusLoadTime = 300;
        //günlük haftalık aylık ve yıllık acılan dosya sayıları
        setTimeout(function() {
            ajax_chart("polarArea", "myChartQuotaDay", "", "/yonetim/ajax/quota-day")
        }, loadTime += plusLoadTime);
        setTimeout(function() {
            ajax_chart("polarArea", "myChartQuotaWeek", "", "/yonetim/ajax/quota-week")
        }, loadTime += plusLoadTime);
        setTimeout(function() {
            ajax_chart("polarArea", "myChartQuotaMount", "", "/yonetim/ajax/quota-mount")
        }, loadTime += plusLoadTime);
        setTimeout(function() {
            ajax_chart("polarArea", "myChartQuotaYear", "", "/yonetim/ajax/quota-year")
        }, loadTime += plusLoadTime);

        //açılan ve tamamlanan dosya sayıları
        setTimeout(function() {
            ajax_chart("bar", "myChart", "Dosya sayısı",
                "/yonetim/ajax/open-made-analist?status={{ request('status') }}&dates={{ request('dates') }}")
        }, loadTime += plusLoadTime);

        //aşamalara göre dosya sayısı
        setTimeout(function() {
            ajax_chart("bar", "myChart1", "Dosya sayısı",
                "/yonetim/ajax/grades-count?status={{ request('status') }}&dates={{ request('dates') }}")
        }, loadTime += plusLoadTime);
        //ofislere gore dosya sayısı
        setTimeout(function() {
            ajax_chart("bar", "myChart2", "Dosya sayısı",
                "/yonetim/ajax/application-office-count?status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime);
        //vize turune göre dosya sayısı
        setTimeout(function() {
            ajax_chart("bubble", "myChart6", "Dosya sayısı",
                "/yonetim/ajax/visa-types-analist?status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime);
        //danışman analızleri
        setTimeout(function() {
            ajax_chart("bubble", "myChart3", "Dosya sayısı",
                "/yonetim/ajax/advisor-analist?status={{ request('status') }}&dates={{ request('dates') }}")
        }, loadTime += plusLoadTime);
        //uzman analızleri
        setTimeout(function() {
            ajax_chart("bubble", "myChart4", "Dosya sayısı",
                "/yonetim/ajax/expert-analist?status={{ request('status') }}&dates={{ request('dates') }}")
        }, loadTime += plusLoadTime);
        //tercuman analizleri
        setTimeout(function() {
            ajax_chart("bubble", "myChart5", "Dosya sayısı",
                "/yonetim/ajax/translator-analist?status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime)

        function ajax_chart(types, id, labell, url, data) {
            var data = data || {};
            var ctx = document.getElementById(id).getContext("2d");
            if (types == "bar" || types == "polarArea") {

                if (id == "myChart") {

                    var chart = new Chart(ctx, {
                        type: types,
                        data: {
                            labels: [],
                            datasets: []
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: ''
                                }
                            },
                        },
                    });
                } else {
                    var chart = new Chart(ctx, {
                        type: types,
                        data: {
                            labels: [],
                            datasets: [{
                                label: labell,
                                backgroundColor: [],
                                borderColor: [],
                                data: [],

                                borderWidth: 1,
                                borderRadius: 20,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: ''
                                }
                            }
                        },
                    });
                }
            } else if (types == "bubble") {
                if (id != "myChart5") {
                    var chart = new Chart(ctx, {
                        type: types,
                        data: {
                            datasets: []
                        },
                        options: {
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return [
                                                context.dataset.label + ' Analizler',
                                                'Olumlu sonuc sayısı: ' + context.parsed.x,
                                                'Olumsuz sonuc sayısı: ' + context.parsed.y,
                                                'Başarı oranı: %' + Math.round(
                                                    context.parsed.x / (context.parsed.x + context.parsed
                                                        .y) *
                                                    100
                                                ),
                                            ];
                                        }
                                    }
                                },
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: ''
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    grace: '5%'
                                },
                                x: {
                                    type: 'linear',
                                    grace: '5%'
                                }
                            }
                        }
                    });
                } else {
                    var chart = new Chart(ctx, {
                        type: types,
                        data: {
                            datasets: []
                        },
                        options: {
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return [
                                                context.dataset.label + ' Analizler',
                                                'Toplam T. sayfa sayısı: ' + context.raw.x,
                                                'Toplam T. kelime sayısı: ' + context.raw.y,
                                            ];
                                        }
                                    }
                                },
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: ''
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    grace: '5%'
                                },
                                x: {
                                    type: 'linear',
                                    grace: '5%'
                                }
                            }
                        }
                    });
                }
            }
            $.getJSON(url, data).done(function(response) {
                chart.options.plugins.title.text = response.title;
                if (types == "bar" || types == "polarArea") {
                    if (id == "myChart") {
                        chart.data.labels = response.labels;
                        chart.data.datasets = response.datasets;
                    } else {
                        chart.data.labels = response.labels;
                        chart.data.datasets[0].data = response.data.quantity;
                        chart.data.datasets[0].borderColor = response.borderColor;
                        chart.data.datasets[0].backgroundColor = response.backgroundColor;
                    }
                } else if (types == "bubble") {
                    chart.data.datasets = response.datasets;
                }
                chart.update(); // finally update our chart
            });
        }
        new AirDatepicker('#dates', {
            isMobile: true,
            autoClose: true,
            range: true,
            buttons: ['today', 'clear'],
            multipleDatesSeparator: '--',
        })
    </script>
@endsection
