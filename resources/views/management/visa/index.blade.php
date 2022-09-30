@extends('sablon.yonetim')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol id="breadcrumb" class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vize İşlemleri</li>
                </ol>
            </nav>

            @include('include.management.visa.nav')


            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item me-2" role="presentation">
                    <a href="/yonetim/vize#pills-calendar" class="nav-link bg-dark text-light active"
                        id="pills-calendar-tab" data-bs-toggle="pill" data-bs-target="#pills-calendar" role="tab"
                        aria-controls="pills-calendar" aria-selected="true">Randevu Takvimi</a>
                </li>
                <li class="nav-item me-2" role="presentation">
                    <a href="/yonetim/vize#pills-chartjs" class="nav-link bg-dark text-light mr-2" id="pills-chartjs-tab"
                        data-bs-toggle="pill" data-bs-target="#pills-chartjs" role="tab" aria-controls="pills-chartjs"
                        aria-selected="false">Grafikler</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="/yonetim/vize#pills-logs" class="nav-link bg-dark text-light" id="pills-logs-tab"
                        data-bs-toggle="pill" role="tab" aria-controls="pills-logs" aria-selected="false">Dosya
                        Logları</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-calendar" role="tabpanel"
                    aria-labelledby="pills-calendar-tab" tabindex="0"> @include('include.management.visa.calendar')</div>
                <div class="tab-pane fade" id="pills-chartjs" role="tabpanel" aria-labelledby="pills-chartjs-tab"
                    tabindex="0"> @include('include.management.visa.chartjs')</div>
                <div class="tab-pane fade" id="pills-logs" role="tabpanel" aria-labelledby="pills-logs-tab" tabindex="0">
                    @include('include.management.visa.logs')</div>

            </div>
            <!-- Modal -->
            @include('include.management.content-load')

            <div class="card">
                <div class="card-header text-white bg-dark mb-3">Genel Vize İşlemleri</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Dosya Aşamaları</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countFileGrades }} dosya aşaması sistemde
                                        kayıtlı. </p>
                                    <a href="/yonetim/vize/dosya-asama" class="btn btn-dark float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Dosya Aşama Erişimleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaFileGradesUsersType }} kullanıcı
                                        tipi erişimleri sistemde kayıtlı. </p>
                                    <a href="/yonetim/vize/dosya-asama-erisim" class="btn btn-dark float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Vize Tipleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaTypes }} vize tipi sistemde kayıtlı.
                                    </p>
                                    <a href="/yonetim/vize/vize-tipi" class="btn btn-dark float-end">Git</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Vize Süreleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaValidity }} vize süresi sistemde
                                        kayıtlı.
                                    </p>
                                    <a href="/yonetim/vize/vize-suresi" class="btn btn-dark float-end">Git</a>
                                </div>
                            </div>
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
        new AirDatepicker('#dates', {
            isMobile: true,
            autoClose: true,
            range: true,
            buttons: ['today', 'clear'],
            multipleDatesSeparator: '--',
        })

        function contentLoad(ne, id) {
            var url = "";
            if (ne == 'not') {
                url = "/musteri/ajax/not-goster";
            } else if (ne == 'email') {
                url = "/musteri/ajax/email-log-goster";
            } else if (ne == 'visa') {
                url = "/musteri/ajax/visa-log-goster";
            }
            $("#contentLoad").html('İçerik alınıyor...');
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    if (data['content'] === '') {
                        $("#contentLoad").html('İçerik bulunamadı');
                    } else {
                        $("#contentLoad").html(data['content']);
                    }
                },
                error: function(data, status, xhr) {
                    $("#contentLoad").html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }

        function notSil(id) {
            $.ajax({
                type: 'POST',
                url: "/musteri/ajax/not-sil",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    location.reload();
                },
                error: function(data, status, xhr) {
                    alert(xhr);
                }
            });
        }

        function shuffle(array) {
            let currentIndex = array.length,
                randomIndex;
            while (currentIndex != 0) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;
                [array[currentIndex], array[randomIndex]] = [
                    array[randomIndex], array[currentIndex]
                ];
            }
            return array;
        }

        const borderColor = [
            'rgba(21, 89, 84, 1)',
            'rgba(255, 162, 0, 1)',
            'rgba(103, 39, 112, 1)',
            'rgba(255, 55, 18, 1)',
            'rgba(29, 17, 72, 1)',
            'rgba(242, 202, 151, 1)',
            'rgba(119, 124, 238, 1)',
            'rgba(238, 119, 119, 1)',
            'rgba(141, 56, 201, 1)',
            'rgba(102, 152, 255, 1)',
            'rgba(56, 124, 68, 1)',
            'rgba(76, 196, 23, 1)',
        ];

        const backgroundColor = [
            'rgba(21, 89, 84, 0.5)',
            'rgba(255, 162, 0, 0.5)',
            'rgba(103, 39, 112, 0.5)',
            'rgba(255, 55, 18, 0.5)',
            'rgba(29, 17, 72, 0.5)',
            'rgba(242, 202, 151, 0.5)',
            'rgba(119, 124, 238, 0.5)',
            'rgba(238, 119, 119, 0.5)',
            'rgba(141, 56, 201, 0.5)',
            'rgba(102, 152, 255, 0.5)',
            'rgba(56, 124, 68, 0.5)',
            'rgba(76, 196, 23, 0.5)',
        ];

        @if ($visaFilesOpenMadeCount != null)
            /**Dosya açma ve yapılma sayısı**/
            new Chart(
                document.getElementById('myChart0'), {
                    type: 'bar',
                    data: {
                        labels: {!! $visaFilesOpenMadeCount[0] !!},
                        datasets: [{
                            label: 'Açılan Dosya Sayısı',
                            data: {!! $visaFilesOpenMadeCount[1] !!},
                            borderColor: 'rgba(255, 55, 18, 1)',
                            backgroundColor: 'rgba(255, 55, 18, 0.5)',
                            borderWidth: 1,
                            borderRadius: 20,
                            borderSkipped: false,
                        }, {
                            label: 'Yapılan Dosya Sayısı',
                            data: {!! $visaFilesOpenMadeCount[2] !!},
                            borderColor: 'rgba(21, 89, 84, 1)',
                            backgroundColor: 'rgba(21, 89, 84, 0.5)',
                            borderWidth: 1,
                            borderRadius: 20,
                            borderSkipped: false,
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
                                text: 'Dosya Açma ve Tamamlama Analizleri (Son 12 Ay)'
                            }
                        },
                    },
                }
            );
        @endif

        @if ($visaFilesGradesCount != null)
            /**Dosya Aşamalarına Göre Cari Dosya Sayısı**/
            @php
                $gradesKey = [];
                $gradesValue = [];
                foreach ($visaFilesGradesCount as $col => $val) {
                    $stringArrayKey = explode(' ', $col);
                    array_push($gradesKey, $stringArrayKey[0] . ' ' . $stringArrayKey[1]);
                    array_push($gradesValue, $val);
                }
                $gradesKeys = '"' . implode('", "', $gradesKey) . '"';
                $gradesValues = implode(', ', $gradesValue);
            @endphp
            new Chart(
                document.getElementById('myChart'), {
                    type: 'bar',
                    data: {
                        labels: [{!! $gradesKeys !!}],
                        datasets: [{
                            label: 'Dosya Sayısı',
                            backgroundColor: shuffle(backgroundColor),
                            borderColor: shuffle(borderColor),
                            data: [{!! $gradesValues !!}],
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Aşamalara Göre Analizler (Seçilen Tarihler Arası)'
                            }
                        }
                    },
                }
            );
        @endif

        @if ($visaFilesApplicationOfficeCount != null)
            /**Başvuru Ofisine Göre Cari Dosya Sayısı**/
            @php
                $applicationOfficeKey = [];
                $applicationOfficeValue = [];
                foreach ($visaFilesApplicationOfficeCount as $col => $val) {
                    array_push($applicationOfficeKey, $col);
                    array_push($applicationOfficeValue, $val);
                }
                $applicationOfficeKeys = '"' . implode('", "', $applicationOfficeKey) . '"';
                $applicationOfficeValues = implode(', ', $applicationOfficeValue);
            @endphp
            new Chart(
                document.getElementById('myChart2'), {
                    type: 'bar',
                    data: {
                        labels: [{!! $applicationOfficeKeys !!}],
                        datasets: [{
                            label: ' Dosya Sayısı',
                            backgroundColor: shuffle(backgroundColor),
                            borderColor: shuffle(borderColor),
                            data: [{!! $applicationOfficeValues !!}],
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Başvuru Ofislere Göre Analizler (Seçilen Tarihler Arası)'
                            }
                        }
                    },
                }
            );
        @endif

        @if ($arrayVisaFilesAdvisorsAnalist != null)
            /**Danışman Vize Sounucu Performansı*/
            @php
                $arrayColors = ['rgb(21, 89, 84)', 'rgb(255, 162, 0)', 'rgb(103, 39, 112)', 'rgb(255, 55, 18)', 'rgb(29, 17, 72)', 'rgb(242, 202, 151)', 'rgb(119, 124, 238)', 'rgb(238, 119, 119)', 'rgb(141, 56, 201)', 'rgb(102, 152, 255)', 'rgb(56, 124, 68)', 'rgb(76, 196, 23)'];
                $data = '';
                foreach ($arrayVisaFilesAdvisorsAnalist as $arrayVisaFilesAdvisorAnalist) {
                    //array random index
                    $randomIndex = rand(0, count($arrayColors) - 1);
                    $data .= "{label: '" . $arrayVisaFilesAdvisorAnalist[0] . "',data: [{x: " . $arrayVisaFilesAdvisorAnalist[1] . ',y: ' . $arrayVisaFilesAdvisorAnalist[2] . ',r: ' . env('ANALIST_RADIUS_DEFAULT_ORAN') . "}, ],backgroundColor: '" . $arrayColors[$randomIndex] . "'},";
                }
            @endphp
            new Chart(document.getElementById('myChart3'), {
                type: 'bubble',
                data: {
                    datasets: [{!! $data !!}]
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
                                            context.parsed.x / (context.parsed.x + context.parsed.y) * 100
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
                            text: 'Danışman Vize Sonuc Analizleri(VİZE x RED & Seçilen Tarihler Arası)'
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
        @endif

        @if ($arrayVisaFilesExpertsAnalist != null)
            /**Uzman Vize Sounucu Performansı*/
            @php
                $arrayColors2 = ['rgb(21, 89, 84)', 'rgb(255, 162, 0)', 'rgb(103, 39, 112)', 'rgb(255, 55, 18)', 'rgb(29, 17, 72)', 'rgb(242, 202, 151)', 'rgb(119, 124, 238)', 'rgb(238, 119, 119)', 'rgb(141, 56, 201)', 'rgb(102, 152, 255)', 'rgb(56, 124, 68)', 'rgb(76, 196, 23)'];
                $data = '';
                foreach ($arrayVisaFilesExpertsAnalist as $arrayVisaFilesExpertAnalist) {
                    //array random index
                    $randomIndex = rand(0, count($arrayColors2) - 1);
                    $data .= "{label: '" . $arrayVisaFilesExpertAnalist[0] . "',data: [{x: " . $arrayVisaFilesExpertAnalist[1] . ',y: ' . $arrayVisaFilesExpertAnalist[2] . ',r: ' . env('ANALIST_RADIUS_DEFAULT_ORAN') . "}, ],backgroundColor: '" . $arrayColors2[$randomIndex] . "'},";
                }
            @endphp
            new Chart(document.getElementById('myChart4'), {
                type: 'bubble',
                data: {
                    datasets: [{!! $data !!}]
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
                                            context.parsed.x / (context.parsed.x + context.parsed.y) * 100
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
                            text: 'Uzman Vize Sonuc Analizleri(VİZE x RED & Seçilen Tarihler Arası)'
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
                },
            });
        @endif

        @if ($arrayVisaFilesTranslationsAnalist != null)
            /**tercuman analizleri**/
            @php
                $arrayColors3 = ['rgb(21, 89, 84)', 'rgb(255, 162, 0)', 'rgb(103, 39, 112)', 'rgb(255, 55, 18)', 'rgb(29, 17, 72)', 'rgb(242, 202, 151)', 'rgb(119, 124, 238)', 'rgb(238, 119, 119)', 'rgb(141, 56, 201)', 'rgb(102, 152, 255)', 'rgb(56, 124, 68)', 'rgb(76, 196, 23)'];
                $data = '';
                foreach ($arrayVisaFilesTranslationsAnalist as $arrayVisaFilesTranslationAnalist) {
                    $randomIndex = rand(0, count($arrayColors3) - 1);
                    $data .= "{label: '" . $arrayVisaFilesTranslationAnalist[0] . "',data: [{x: " . $arrayVisaFilesTranslationAnalist[2] . ',y: ' . $arrayVisaFilesTranslationAnalist[3] . ',r: ' . env('ANALIST_RADIUS_DEFAULT_ORAN') . "}, ],backgroundColor: '" . $arrayColors3[$randomIndex] . "'},";
                }
            @endphp
            new Chart(document.getElementById('myChart5'), {
                type: 'bubble',
                data: {
                    datasets: [{!! $data !!}]
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
                            text: 'Tercüman Vize Dosyası Tercüme Analizleri(Sayfa x Kelime & Seçilen Tarihler Arası)'
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
                },
            });
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'tr',
                themeSystem: 'bootstrap5',
                height: '450px',
                buttonIcons: true,
                hiddenDays: [0, 6],
                fixedWeekCount: false,
                headerToolbar: {
                    left: 'title',
                    right: 'today prev,next'
                },
                eventSources: [{
                    url: '/kullanici/ajax/calendar-event',
                    method: 'POST',
                    extraParams: {
                        _token: '{{ csrf_token() }}',
                        user_id: '{{ session('userId') }}',
                        user_type_id: '{{ session('userTypeId') }}',
                    }
                }],
                eventClick: function(event, jsEvent, view) {
                    jQuery('#contentHead').html(event.event.title);
                    jQuery('#contentLoad').html(event.event.extendedProps.description);
                    var exampleModal = document.getElementById('exampleModal');
                    var modal = bootstrap.Modal.getInstance(exampleModal);
                    jQuery('#exampleModal').modal('show')
                }
            });
            calendar.render();
        });

        jQuery(document).ready(function($) {
            $('#pills-tab a[href="/yonetim/vize' + window.location.hash + '"]').tab('show');
        });
    </script>
@endsection
