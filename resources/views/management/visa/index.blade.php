@extends('sablon.yonetim')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol id="breadcrumb" class="breadcrumb p-2 ">
                    <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vize İşlemleri</li>
                </ol>
            </nav>

            @include('include.management.visa.nav')

            <!-- vize dosyaları logları-->
            @include('include.management.visa.logs')

            <!-- Modal -->
            @include('include.management.content-load')

            <div class="card">
                <div class="card-header text-white bg-primary mb-3">Genel Vize İşlemleri</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Dosya Aşamaları</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countFileGrades }} dosya aşaması sistemde
                                        kayıtlı. </p>
                                    <a href="/yonetim/vize/dosya-asama" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Dosya Aşama Erişimleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaFileGradesUsersType }} kullanıcı
                                        tipi erişimleri sistemde kayıtlı. </p>
                                    <a href="/yonetim/vize/dosya-asama-erisim" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Vize Tipleri</h5>
                                    <p class="card-text fw-bold"> Toplam {{ $countVisaTypes }} vize tipi sistemde kayıtlı.
                                    </p>
                                    <a href="/yonetim/vize/vize-tipi" class="btn btn-primary float-end">Git</a>
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
                                    <a href="/yonetim/vize/vize-suresi" class="btn btn-primary float-end">Git</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
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
                    if (data['content']==='') {
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
    </script>
@endsection
