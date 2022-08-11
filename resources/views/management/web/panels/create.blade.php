@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/panels">Paneller</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>

    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/web/panels">
                @csrf

                <div class="row">
                    <div class="col-12">
                        <label class="">Grubu</label>
                        <select name="grup" id="" class="form-control">
                            <option value="">Seçim yapınız</option>
                            @foreach ($results as $result)
                                <option value="{{ $result->id }}">{{ $result->name }}</option>
                            @endforeach
                        </select>
                        @error('grup')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 g-3">
                        <label class="">Site Adı</label>
                        <input type="text" value="{{ old('site') }}" placeholder="csslegal.com" name="site"
                            class="form-control">
                        @error('site')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 g-3">
                        <label class="">Panel URL</label>
                        <input type="text" value="{{ old('url') != null ? old('url') : 'https://' }}" name="url"
                            placeholder="https://csslegal.com/" class="form-control">
                        @error('url')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button class="w-100 mt-3 btn btn-dark text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>

@endsection
