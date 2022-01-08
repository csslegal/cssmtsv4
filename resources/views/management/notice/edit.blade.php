@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/duyuru">Duyurular</a></li>
            <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Düzenle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/duyuru/{{ $kayit->id }}">
                @method('PUT')
                @csrf
                @error('icerik')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <textarea id="editor400"
                    name="icerik">@isset($kayit){!! $kayit->icerik !!}@endisset{!! old('icerik') !!}</textarea>
                    <br>
                    <div class="form-check">
                        <input type="checkbox" name="active" class="form-check-input" @if ($kayit->active == 1) checked @endif>
                        <label class="form-check-label" for="flexCheckChecked">
                            Normal duyuru mu?
                        </label>
                    </div>
                    <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
                </form>
            </div>
        </div>
    @endsection
