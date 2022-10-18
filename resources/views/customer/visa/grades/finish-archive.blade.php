@extends('sablon.genel')

@section('title')
    Sonuçlanmış Dosyalar & Arşiv
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
            <li class="breadcrumb-item active">Sonuçlanmış Dosyalar & Arşiv</li>
        </ol>
    </nav>
    <div class="card card-danger mb-3">
        <div class="card-header bg-danger text-white">Sonuçlanmış Dosyalar & Arşiv İşlemleri</div>
        <div class="card-body scroll">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="mb-2">Arşiv Klasor Adı</label>
                    <select class="form-control" name="folder_name">

                        @for ($year = strtotime('Y'); $year >= strtotime('2006-01-01'); $year = strtotime('-1 year', $year))
                            <option value="CSS -- GENEL ARSIV {{ date('Y', $year) }}"
                                @if ('CSS -- GENEL ARSIV ' . date('Y') == 'CSS -- GENEL ARSIV ' . date('Y', $year)) selected @endif>
                                CSS -- GENEL ARSIV {{ date('Y', $year) }}
                            </option>
                        @endfor
                    </select>
                    @error('folder_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="w-100 mt-2 btn btn-danger text-white btn-lg confirm"
                    data-content="Devam edilsin mi?">Aşamayı Tamamla</button>
            </form>
        </div>
    </div>
@endsection
