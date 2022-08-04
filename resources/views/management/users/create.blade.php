@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/users">Kullanıcı</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/users">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Kullanıcı Adı</label>
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Kullanıcı Tipi</label>
                        <select name="tip" class="form-control">
                            <option value="">Seçim Yapınız</option>
                            @foreach ($usersTypes as $userType)
                                <option {{ old('tip') == $userType->id ? 'selected' : '' }} value="{{ $userType->id }}">
                                    {{ $userType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tip')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">E-mail</label>
                        <input type="text" value="{{ old('email') }}" name="email" class="form-control">
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Şifre</label>
                        <input type="text" value="{{ old('password') }}" name="password" class="form-control">
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mesai Saati</label>
                        @error('giris')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="input-group mb-3">
                            <input name="giris" type="text" class="form-control" placeholder="08:00"
                                value="{{ old('giris') ? old('giris') : '08:00' }}">
                            <span class="input-group-text">-</span>
                            <input name="cikis" type="text" class="form-control" placeholder="21:00"
                                value="{{ old('cikis') ? old('cikis') : '21:00' }}">
                        </div>
                        @error('cikis')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Kullanıcı Erişimleri</label>
                        @foreach ($userAccesses as $userAccess)
                            <div class="form-check">
                                <input name="erisimler[]" class="form-check-input" type="checkbox" multiple
                                    value="{{ $userAccess->id }}">
                                <label class="form-check-label">{{ $userAccess->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Mesai Ofisleri</label>
                        @foreach ($applicationOffices as $applicationOffice)
                            <div class="form-check">
                                <input name="ofisler[]" class="form-check-input" type="checkbox" multiple
                                    value="{{ $applicationOffice->id }}">
                                <label class="form-check-label">{{ $applicationOffice->name }}</label>
                            </div>
                        @endforeach
                        @error('ofis')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
