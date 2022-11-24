@extends('sablon.genel')

@section('title')
    Tercüme Bekleyen Dosyalar
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">Tercüme Bekleyen Dosyalar</li>
        </ol>
    </nav>
    <div class="card card-danger mb-3">
        <div class="card-header bg-danger text-white">Tercüme Bekleyen Dosya İşlemleri</div>
        <div class="card-body scroll">
            <form action="" method="POST">
                @csrf
                @if (session('userTypeId') == 1)
                    <div class="mb-3">
                        <label class="form-label">Dosya Tercümanı</label>
                        <select name="tercuman" class="form-control">
                            <option selected value="">Lütfen seçim yapın</option>
                            @foreach ($users as $user)
                                @if ($user->user_type_id == env('TRANSLATION_USER_TYPE_ID') && $user->active == 1)
                                    <option {{ old('tercuman') == $user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('tercuman')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
                <div class="mb-3">
                    <label class="form-label">Orjinal Sayfa Sayısı</label>
                    <input type="text" name="sayfa" autocomplete="off" class="form-control"
                        placeholder="Sayfa sayısı girin" value="{{ old('sayfa') }}" />
                    @error('sayfa')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Orjinal Kelime Sayısı</label>
                    <input type="text" name="kelime" autocomplete="off" class="form-control"
                        placeholder="Kelime sayısı girin" value="{{ old('kelime') }}" />
                    @error('kelime')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Orjinal Karakter Sayısı</label>
                    <input type="text" name="karakter" autocomplete="off" class="form-control"
                        placeholder="Karakter sayısı girin" value="{{ old('karakter') }}" />
                    @error('karakter')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <hr>
                <div class="mb-3">
                    <label class="form-label">Tercüme Sayfa Sayısı</label>
                    <input type="text" name="tercume-sayfa" autocomplete="off" class="form-control"
                        placeholder="Sayfa sayısı girin" value="{{ old('tercume-sayfa') }}" />
                    @error('tercume-sayfa')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Tercüme Kelime Sayısı</label>
                    <input type="text" name="tercume-kelime" autocomplete="off" class="form-control"
                        placeholder="Kelime sayısı girin" value="{{ old('tercume-kelime') }}" />
                    @error('tercume-kelime')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Tercüme Karakter Sayısı</label>
                    <input type="text" name="tercume-karakter" autocomplete="off" class="form-control"
                        placeholder="Karakter sayısı girin" value="{{ old('tercume-karakter') }}" />
                    @error('tercume-karakter')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="w-100 mt-2 btn btn-secondary text-white confirm" data-title="Dikkat!"
                    data-content="Tercüme bilgileri kaydedilsin mı?">Aşamayı Tamamla</button>
            </form>
        </div>
    </div>
@endsection
