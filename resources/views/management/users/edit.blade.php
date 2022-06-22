@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/users">Kullanıcı</a></li>
            <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Düzenle</div>
        <div class="card-body">


            <form method="POST" action="/yonetim/users/{{ $kayit->id }}">
                @method('PUT')
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Adı</label>
                        <input type="text" value="{{ $kayit->name }}" name="name" class="form-control" />
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">E-mail</label>
                        <input type="text" value="{{ $kayit->email }}" name="email" class="form-control">
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Şifre</label>
                        <input type="text" value="{{ base64_decode($kayit->password) }}" name="password"
                            class="form-control">
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Kullanıcı Tipi</label>
                        <select name="tip" class="form-control">
                            <option value="">Seçim Yapınız</option>
                            @foreach ($usersTypes as $userType)
                                <option {{ $kayit->user_type_id == $userType->id ? 'selected' : '' }}
                                    value="{{ $userType->id }}">
                                    {{ $userType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tip')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Kullanıcı Erişimleri</label>
                        @foreach ($userAccesses as $userAccess)
                            <div class="form-check">
                                <input name="userAccess[]" class="form-check-input" type="checkbox"
                                    value="{{ $userAccess->id }}" @if (in_array($userAccess->id, $accessId)) checked @endif>
                                <label class="form-check-label" for="flexCheckDefault">{{ $userAccess->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mesai Ofisi</label>
                        <select name="ofis" class="form-control">
                            <option value="">Seçim Yapınız</option>
                            @foreach ($applicationOffices as $applicationOffice)
                                <option {{ $kayit->application_office_id == $applicationOffice->id ? 'selected' : '' }}
                                    value="{{ $applicationOffice->id }}">
                                    {{ $applicationOffice->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('ofis')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mesai Saati</label>
                        @error('mesaiGiris')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="input-group mb-3">
                            <input name="mesaiGiris" type="text" class="form-control" placeholder="08:00"
                                value="{{ old('mesaiGiris') ? old('mesaiGiris') : '08:00' }}">
                            <span class="input-group-text">-</span>
                            <input name="mesaiCikis" type="text" class="form-control" placeholder="18:00"
                                value="{{ old('mesaiCikis') ? old('mesaiCikis') : '18:00' }}">
                        </div>
                        @error('mesaiCikis')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Hesap Durumu</label>
                        <select name="durum" class="form-control">
                            <option value="">Seçim Yapınız</option>
                            <option {{ $kayit->active == 1 ? 'selected' : '' }} value="1">Normal Hesap</option>
                            <option {{ $kayit->active == 0 ? 'selected' : '' }} value="0">Pasif Hesap</option>
                        </select>
                        @error('durum')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Giriş Durumu</label>
                        <select name="kisitli" class="form-control">
                            <option @if ($kayit->unlimited == 1) selected @endif value="1">Kısıtlamasız</option>
                            <option @if ($kayit->unlimited == 0) selected @endif value="0">Kısıtlamalı</option>
                        </select>
                        @error('kisitli')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
