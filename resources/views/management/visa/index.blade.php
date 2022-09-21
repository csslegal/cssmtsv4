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

            <!-- vize dosyaları logları-->
            @include('include.management.visa.chartjs')

            <!-- vize dosyaları logları-->
            @include('include.management.visa.logs')

            <!-- Modal -->
            @include('include.management.content-load')

            <div class="card">
                <div class="card-header text-white bg-dark mb-3">Genel Vize İşlemleri</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Dosya Aşamaları</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countFileGrades }} dosya aşaması sistemde
                                        kayıtlı. </p>
                                    <a href="/yonetim/vize/dosya-asama" class="btn btn-dark float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Dosya Aşama Erişimleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaFileGradesUsersType }} kullanıcı
                                        tipi erişimleri sistemde kayıtlı. </p>
                                    <a href="/yonetim/vize/dosya-asama-erisim" class="btn btn-dark float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Vize Tipleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaTypes }} vize tipi sistemde kayıtlı.
                                    </p>
                                    <a href="/yonetim/vize/vize-tipi" class="btn btn-dark float-end">Git</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
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
@endsection

@section('js')
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
                    //olumlu sonuc sıfır ise
                    if ($arrayVisaFilesAdvisorAnalist[1] == 0) {
                        //olumsuz sonuc
                        if ($arrayVisaFilesAdvisorAnalist[2] == 0) {
                            //radıus default
                            $arrayVisaFilesAdvisorAnalistRadius = env('ANALIST_RADIUS_DEFAULT_ORAN');
                        } else {
                            $arrayVisaFilesAdvisorAnalistRadius = env('ANALIST_RADIUS_DOWN_ORAN');
                        }
                        //olumsu sonuc var ise
                    } else {
                        //olumsuz yok ise
                        if ($arrayVisaFilesAdvisorAnalist[2] == 0) {
                            $arrayVisaFilesAdvisorAnalistRadius = env('ANALIST_RADIUS_UP_ORAN');
                        } else {
                            //hem olumlu hemde olumsuz sonuclar var ise oranı al
                            $arrayVisaFilesAdvisorAnalistRadius = round(($arrayVisaFilesAdvisorAnalist[1] / ($arrayVisaFilesAdvisorAnalist[1] + $arrayVisaFilesAdvisorAnalist[2])) * env('ANALIST_RADIUS_DEFAULT_ORAN'));
                        }
                    }
                    $data .= "{label: '" . $arrayVisaFilesAdvisorAnalist[0] . "',data: [{x: " . $arrayVisaFilesAdvisorAnalist[1] . ',y: ' . $arrayVisaFilesAdvisorAnalist[2] . ',r: ' . $arrayVisaFilesAdvisorAnalistRadius . "}, ],backgroundColor: '" . $arrayColors[$randomIndex] . "'},";
                }
            @endphp
            new Chart(document.getElementById('myChart3'), {
                type: 'bubble',
                data: {
                    datasets: [
                        {!! $data !!}
                    ]
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

        @if ($arrayVisaFilesExpertsAnalist != null)
            /**Uzman Vize Sounucu Performansı*/
            @php
                $arrayColors2 = ['rgb(21, 89, 84)', 'rgb(255, 162, 0)', 'rgb(103, 39, 112)', 'rgb(255, 55, 18)', 'rgb(29, 17, 72)', 'rgb(242, 202, 151)', 'rgb(119, 124, 238)', 'rgb(238, 119, 119)', 'rgb(141, 56, 201)', 'rgb(102, 152, 255)', 'rgb(56, 124, 68)', 'rgb(76, 196, 23)'];
                $data = '';
                foreach ($arrayVisaFilesExpertsAnalist as $arrayVisaFilesExpertAnalist) {
                    //array random index
                    $randomIndex = rand(0, count($arrayColors2) - 1);
                    //olumlu sonuc sıfır ise
                    if ($arrayVisaFilesExpertAnalist[1] == 0) {
                        //olumsuz sonuc
                        if ($arrayVisaFilesExpertAnalist[2] == 0) {
                            //radıus default
                            $arrayVisaFilesExpertAnalistRadius = env('ANALIST_RADIUS_DEFAULT_ORAN');
                        } else {
                            $arrayVisaFilesExpertAnalistRadius = env('ANALIST_RADIUS_DOWN_ORAN');
                        }
                        //olumsu sonuc var ise
                    } else {
                        //olumsuz yok ise
                        if ($arrayVisaFilesExpertAnalist[2] == 0) {
                            $arrayVisaFilesExpertAnalistRadius = env('ANALIST_RADIUS_UP_ORAN');
                        } else {
                            //hem olumlu hemde olumsuz sonuclar var ise oranı al
                            $arrayVisaFilesExpertAnalistRadius = round(($arrayVisaFilesExpertAnalist[1] / ($arrayVisaFilesExpertAnalist[1] + $arrayVisaFilesExpertAnalist[2])) * env('ANALIST_RADIUS_DEFAULT_ORAN'));
                        }
                    }
                    $data .= "{label: '" . $arrayVisaFilesExpertAnalist[0] . "',data: [{x: " . $arrayVisaFilesExpertAnalist[1] . ',y: ' . $arrayVisaFilesExpertAnalist[2] . ',r: ' . $arrayVisaFilesExpertAnalistRadius . "}, ],backgroundColor: '" . $arrayColors2[$randomIndex] . "'},";
                }
            @endphp
            new Chart(document.getElementById('myChart4'), {
                type: 'bubble',
                data: {
                    datasets: [
                        {!! $data !!}
                    ]
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

                    $arrayVisaFilesTranslationAnalistRadius = round(($arrayVisaFilesTranslationAnalist[1] / $allVisaFileCount) * env('ANALIST_RADIUS_DEFAULT_ORAN'));

                    if ($arrayVisaFilesTranslationAnalistRadius < 20) {
                        $arrayVisaFilesTranslationAnalistRadius = 20;
                    } elseif ($arrayVisaFilesTranslationAnalistRadius > 40) {
                        $arrayVisaFilesTranslationAnalistRadius = 40;
                    }
                    $data .= "{label: '" . $arrayVisaFilesTranslationAnalist[0] . "',data: [{x: " . $arrayVisaFilesTranslationAnalist[2] . ',y: ' . $arrayVisaFilesTranslationAnalist[3] . ',r: ' . $arrayVisaFilesTranslationAnalistRadius . "}, ],backgroundColor: '" . $arrayColors3[$randomIndex] . "'},";
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
    </script>
@endsection
