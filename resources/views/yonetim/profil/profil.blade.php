@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
        </ol>
    </nav>

    <div class="card card-primary">
        <div class="card-header bg-primary text-white">Profilim</div>
        <div class="card-body">

            <h2>Bilgilerim</h2>
            <div class="row p-4 mb-5 bg-light ">
                <div class="col-6">
                    <ul>
                        <li>
                            Adınız:
                            <span class="fw-bold text-danger">
                                {{ $yonetimBilgileri->name }}
                            </span>
                        </li>
                        <li>
                            E-mail Adresiniz:
                            <span class="fw-bold text-danger">
                                {{ $yonetimBilgileri->email }}
                            </span>
                        </li>
                        <li>
                            Çalışma Ofisi:
                            <span class="fw-bold text-danger">
                                {{ $yonetimBilgileri->bo_name }}
                            </span>
                        </li>
                        <li>
                            <span class="fw-bold">Yetki Seviyesi:</span>
                            <span class="fw-bold text-danger">
                                {{ $yonetimBilgileri->ut_name }}
                            </span>
                        </li>
                        <li>
                            Mesai Saatleri:
                            <span class="fw-bold text-danger">
                                {{ $yonetimBilgileri->giris }} -
                                {{ $yonetimBilgileri->cikis }}
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="col-6">
                    <span class="fw-bold text-primary">Erişim İzinleri</span>
                    <ol>
                        @if (count($erisimIzinleri) > 0)
                            @foreach ($erisimIzinleri as $erisimIzin)
                                <li>{{ $erisimIzin->name }}</li>
                            @endforeach
                        @else
                            <li>Yok</li>
                        @endif
                    </ol>
                </div>
            </div>

            <hr class="my-4">

            <h2>Güncelle</h2>


            <form method="POST" action="/yonetim/profil">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Şifre</label>
                        <input type="password" value="{{ old('password') }}" name="password" class="form-control">
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tekrar Şifre</label>
                        <input type="password" value="{{ old('rePassword') }}" name="rePassword" class="form-control">
                        @error('rePassword')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Güncelle</button>
            </form>
        </div>
    </div>
@endsection
