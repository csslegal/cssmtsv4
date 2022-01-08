@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/duyuru">Duyurular</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>

    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Ekle

        </div>
        <div class="card-body">
            <form method="POST" action="/yonetim/duyuru">
                @csrf

                @error('icerik')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <textarea id="editor400" name="icerik">{!! old('icerik') !!}</textarea>

                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>

@endsection
