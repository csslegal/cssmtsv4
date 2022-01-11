@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profilim</li>
        </ol>
    </nav>

    <div class="card card-primary mb-4">
        <div class="card-header bg-primary text-white fw-bold">Profilim</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <span class="fw-bold text-primary">Kullanıcı Detayları</span>
                    <ul>
                        <li>Adınız: {{ $yonetimBilgileri->name }}</li>
                        <li>E-mail Adresiniz: {{ $yonetimBilgileri->email }}</li>
                        <li>Çalışma Ofisi: {{ $yonetimBilgileri->bo_name }}</li>
                        <li>Yetki Seviyesi: {{ $yonetimBilgileri->ut_name }}</li>
                        <li>Mesai Saatleri: {{ $yonetimBilgileri->giris }} - {{ $yonetimBilgileri->cikis }}</li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12">
                    <span class="fw-bold text-primary">Sistem Erişim İzinleri</span>
                    <ol>
                        @if (count($erisimIzinleri) > 0)
                            @foreach ($erisimIzinleri as $erisimIzin)
                                <li>{{ $erisimIzin->name }}</li>
                            @endforeach
                        @else
                            <li>Yok</li>
                        @endif
                    </ol>

                    <hr>
                    <span class="fw-bold text-primary">Sistem Teması</span>
                    <select class="form-control" onchange="themeChange()">
                        <option @if (session('theme') == 'light') selected @endif>Light @if (session('theme') == 'light') teması aktif @endif</option>
                        <option @if (session('theme') == 'dark') selected @endif>Dark @if (session('theme') == 'dark') teması aktif @endif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header bg-primary text-white fw-bold">Şifre Güncelleme</div>
        <div class="card-body">
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

@section('js')
    <script>
        function themeChange() {
            $.ajax({
                url: "/theme",
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(sonuc) {
                    if (sonuc == 1) {
                        window.location.reload(1);
                    }
                }
            });
        }
    </script>
@endsection
