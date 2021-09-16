@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize/dosya-asama-erisim">Dosya Aşama Erişimleri</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/vize/dosya-asama-erisim">
                @csrf
                <div class="row g-3">
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
                        <label class="form-label fw-bold">Dosya Aşamaları</label>
                        @foreach ($visaFileGrades as $visaFileGrade)
                            <div class="form-check">
                                <input name="dosya-asamalari[]" class="form-check-input" type="checkbox" multiple
                                    value="{{ $visaFileGrade->id }}">
                                <label class="form-check-label" for="flexCheckDefault">{{ $visaFileGrade->name }}</label>
                            </div>
                        @endforeach
                        @error('dosya-asamalari')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
