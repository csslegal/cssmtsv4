@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/panels">Paneller</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/web/panels">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <label  class="form-label">Grubu</label>
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
                    <div class="col-12">
                        <label  class="form-label">Panel Statusu</label>
                        <select name="panel_status" id="" class="form-control">
                            <option value="1">Site Paneli</option>
                            <option value="0">Web API paneli</option>
                        </select>
                        @error('panel_status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 g-3">
                        <label  class="form-label">Site Adı</label>
                        <input type="text" value="{{ old('site') }}" placeholder="csslegal.com" name="site"
                            class="form-control">
                        @error('site')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 g-3">
                        <label  class="form-label">Panel URL</label>
                        <input type="text" value="{{ old('url') != null ? old('url') : 'https://' }}" name="url"
                            placeholder="https://csslegal.com/" class="form-control">
                        @error('url')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-secondary text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
