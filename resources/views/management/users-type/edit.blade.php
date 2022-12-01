@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/users-type">Kullanıcı Tipleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Düzenle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/users-type/{{ $kayit->id }}">
                @method('PUT')
                @csrf
                <div class="col-12">
                    <label class="form-label">Adı</label>
                    <input type="text" value="@isset($kayit){!! $kayit->name !!}@endisset"
                        name="name" class="form-control">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button class="w-100 mt-3 btn btn-secondary text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
