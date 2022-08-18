@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/panels">Paneller</a></li>
            <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
        </ol>
    </nav>
    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Düzenle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/web/panels/{{ $result->id }}">
                @method('PUT')
                @csrf
                <div class="col-12">
                    <label class="">Grubu</label>
                    <select name="grup" id="" class="form-control">
                        <option value="">Seçim yapınız</option>
                        @foreach ($resultGroups as $resultGroup)
                            <option {{ $resultGroup->id == $result->group_id ? 'selected' : '' }}
                                value="{{ $resultGroup->id }}">{{ $resultGroup->name }}</option>
                        @endforeach
                    </select>
                    @error('grup')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Site Adı</label>
                    <input type="text" value="@isset($result){!! $result->name !!}@endisset" name="site"
                            class="form-control" />
                        @error('site')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Site URL</label>
                        <input type="text" value="@isset($result){!! $result->url !!}@endisset" name="url"
                                class="form-control" />
                            @error('url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="w-100 mt-3 btn btn-dark text-white btn-lg" type="submit">Tamamla</button>
                    </form>
                </div>
            </div>
        @endsection
