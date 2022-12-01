@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol  id="breadcrumb" class="breadcrumb">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize/vize-suresi">Vize Süreleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/vize/vize-suresi">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label"> Adı</label>
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-secondary text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
