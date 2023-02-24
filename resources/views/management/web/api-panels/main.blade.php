@extends('sablon.yonetim')

@section('title')
    API Panel Anasayfa
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/api-panels">API Paneller</a></li>
            <li class="breadcrumb-item active">{{ $webPanel->name }} API Paneli</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white fw-bold">
            {{ $webPanel->name }}
            <a class="text-white" target="_blank" href="//{{ $webPanel->name }}">
                <i class="bi bi-box-arrow-in-up-right"></i>
            </a>&nbsp;API Paneli
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">Ana Yazılar</h6>
                            <p>Ana içerik detayları.</p>
                            <a href="{{ $webPanel->id }}/articles" class="w-50 mt-2 btn btn-secondary text-white float-end">
                                Git
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">Diğer Yazılar</h6>
                            <p>Diğer içerik detayları.</p>
                            <a href="{{ $webPanel->id }}/others" class="w-50 mt-2 btn btn-secondary text-white float-end">
                                Git
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">Sorular</h6>
                            <p>Soru içerik detayları.</p>
                            <a href="{{ $webPanel->id }}/questions"
                                class="w-50 mt-2 btn btn-secondary text-white float-end">
                                Git
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">Galeri</h6>
                            <p>Sistem üzerindeki panel resimleri.</p>
                            <a href="{{ $webPanel->id }}/gallery" class="w-50 mt-2 btn btn-secondary text-white float-end">
                                Git
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">İletişim Formu</h6>
                            <p>İletişim formu mesajları.</p>
                            <a href="{{ $webPanel->id }}/contact-form"
                                class="w-50 mt-2 btn btn-secondary text-white float-end">
                                Git
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
