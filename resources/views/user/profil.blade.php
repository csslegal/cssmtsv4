@extends('sablon.genel')

@section('title') Profil - Kullanıcı Oturum @endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/kullanici">Kullanıcı İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profilim</li>
        </ol>
    </nav>

    <div class="card card-primary">
        <div class="card-header bg-primary text-white fw-bold">Profilim</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <ul>
                        <li>Adınız:
                            <span class="fw-bold text-danger"> {{ $kullaniciBilgileri->u_name }} </span>
                        </li>
                        <li>E-mail Adresiniz:
                            <span class="fw-bold text-danger"> {{ $kullaniciBilgileri->u_email }} </span>
                        </li>
                        <li>Çalışma Ofisi:
                            <span class="fw-bold text-danger"> {{ $kullaniciBilgileri->bo_name }} </span>
                        </li>
                        <li>
                            <span class="fw-bold">Yetki Seviyesi:</span>
                            <span class="fw-bold text-danger"> {{ $kullaniciBilgileri->ut_name }} </span>
                        </li>
                        <li>Mesai Saatleri:
                            <span class="fw-bold text-danger">
                                {{ $kullaniciBilgileri->giris }} - {{ $kullaniciBilgileri->cikis }}
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12">
                    <span class="fw-bold text-primary">Sistem Erişim İzinleri</span>
                    <ul>
                        @if (count($erisimIzinleri) > 0)
                            @foreach ($erisimIzinleri as $erisimIzin)
                                <li>{{ $erisimIzin->name }}</li>
                            @endforeach
                        @else
                            <li>Yok</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header bg-primary text-white fw-bold">Şifre Güncelleme</div>
        <div class="card-body">
            <form method="POST" action="/kullanici/profil">
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
