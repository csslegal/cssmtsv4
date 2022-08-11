@extends('sablon.genel')

@section('title')
    Tercüme Tamamlama
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">Tercüme Tamamlama</li>
        </ol>
    </nav>
    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Tercüme Tamamlama</div>
        <div class="card-body scroll">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Orjinal Sayfa Sayısı</label>
                    <input type="text" name="sayfa" autocomplete="off" class="form-control"
                        placeholder="Sayfa sayısı girin" value="{{ old('sayfa') }}" />
                    @error('sayfa')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Orjinal Kelime Sayısı</label>
                    <input type="text" name="kelime" autocomplete="off" class="form-control"
                        placeholder="Kelime sayısı girin" value="{{ old('kelime') }}" />
                    @error('kelime')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Orjinal Karakter Sayısı</label>
                    <input type="text" name="karakter" autocomplete="off" class="form-control"
                        placeholder="Karakter sayısı girin" value="{{ old('karakter') }}" />
                    @error('karakter')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <hr>
                <div class="mb-3">
                    <label>Tercüme Sayfa Sayısı</label>
                    <input type="text" name="tercume-sayfa" autocomplete="off" class="form-control"
                        placeholder="Sayfa sayısı girin" value="{{ old('tercume-sayfa') }}" />
                    @error('tercume-sayfa')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Tercüme Kelime Sayısı</label>
                    <input type="text" name="tercume-kelime" autocomplete="off" class="form-control"
                        placeholder="Kelime sayısı girin" value="{{ old('tercume-kelime') }}" />
                    @error('tercume-kelime')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Tercüme Karakter Sayısı</label>
                    <input type="text" name="tercume-karakter" autocomplete="off" class="form-control"
                        placeholder="Karakter sayısı girin" value="{{ old('tercume-karakter') }}" />
                    @error('tercume-karakter')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="w-100 mt-2 btn btn-dark text-white btn-lg confirm" data-title="Dikkat!"
                    data-content="Tercüme bilgileri kaydedilsin mı?">Aşamayı Tamamla</button>
            </form>
        </div>
    </div>
@endsection
