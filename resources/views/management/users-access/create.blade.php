@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/users-access">Kullanıcı Erişimleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>

    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/users-access">
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
                <button class="w-100 mt-3 btn btn-dark text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>

@endsection
