@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profilim</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white fw-bold">Profilim</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <span class="fw-bold text-dark">Kullanıcı Detayları</span>
                    <ul>
                        <li>Adınız: {{ $managementInformations->name }}</li>
                        <li>E-mail Adresiniz: {{ $managementInformations->email }}</li>
                        <li>Yetki Seviyesi: {{ $managementInformations->ut_name }}</li>
                        <li>Mesai Saatleri: {{ $managementInformations->giris }} - {{ $managementInformations->cikis }}</li>
                    </ul>
                    <hr>
                    <span class="fw-bold text-dark">Sistem Teması</span>
                    <select class="form-control" onchange="themeChange()">
                        <option @if (session('theme') == 'light') selected @endif>Light @if (session('theme') == 'light')
                                teması aktif
                            @endif
                        </option>
                        <option @if (session('theme') == 'dark') selected @endif>Dark @if (session('theme') == 'dark')
                                teması aktif
                            @endif
                        </option>
                    </select>
                    <hr>
                </div>
                <div class="col-md-6 col-sm-12">
                    <span class="fw-bold text-dark">Yetkiler</span>
                    @if (count($userAccesses) > 0)
                        <ol>
                            @foreach ($userAccesses as $userAccess)
                                <li>{{ $userAccess->name }}</li>
                            @endforeach
                        </ol>
                    @else
                        </br> Yok
                    @endif
                    <hr>
                    <span class="fw-bold text-dark">Çalışma Ofisleri</span>
                    @if (count($userOffices) > 0)
                        <ol>
                            @foreach ($userOffices as $userOffice)
                                <li>{{ $userOffice->name }}</li>
                            @endforeach
                        </ol>
                    @else
                        </br> Yok
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-danger text-white fw-bold">Şifre Güncelleme</div>
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
                <button class="w-100 mt-3 btn btn-dark text-white btn-lg" type="submit">Güncelle</button>
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
