@extends('sablon.genel')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">Red Sonucu Tercümesi</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Red Sonucu Tercümesi</div>
        <div class="card-body scroll">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Sayfa Sayısı</label>
                    <input type="text" name="sayfa_sayisi" autocomplete="off" class="form-control"
                        placeholder="Sayfa sayısı girin" value="{{ old('sayfa_sayisi') }}" />
                    @error('sayfa_sayisi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Tercüme Sayfa Sayısı</label>
                    <input type="text" name="tercume_sayfa_sayisi" autocomplete="off" class="form-control"
                        placeholder="Tercüme sayfa sayısı girin" value="{{ old('tercume_sayfa_sayisi') }}" />
                    @error('tercume_sayfa_sayisi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Tercüme Kelime Sayısı</label>
                    <input type="text" name="tercume_kelime_sayisi" autocomplete="off" class="form-control"
                        placeholder="Tercüme kelime sayısı girin" value="{{ old('tercume_kelime_sayisi') }}" />
                    @error('tercume_kelime_sayisi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Tercüme Karakter Sayısı</label>
                    <input type="text" name="tercume_karakter_sayisi" autocomplete="off" class="form-control"
                        placeholder="Tercüme karakter sayısı girin" value="{{ old('tercume_karakter_sayisi') }}" />
                    @error('tercume_karakter_sayisi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-danger text-white confirm"  data-title="Dikkat!"
                    data-content="Devam edilsin mi?">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
