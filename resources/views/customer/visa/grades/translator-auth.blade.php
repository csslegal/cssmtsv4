@extends('sablon.genel')

@section('title') Tercüman Yetkilendirme @endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol  id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">Tercüman Yetkilendirme</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Tercüman Vize Tipine Göre Yetki Sayıları</div>
        <div class="card-body scroll">
            <div class="row">
                @foreach ($translators as $translator)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card mb-2">
                            <div class="card-header text-white bg-danger mb-3">
                                {{ $translator->name }}
                            </div>
                            <div class="card-body">
                                @if ($visaFilesTranslators->where('translator_id', '=', $translator->id)->count() > 0)
                                    <ul>
                                        @foreach ($visaFilesTranslators->where('translator_id', '=', $translator->id)->unique('visa_sub_type_id') as $visaFilesTranslator)
                                            <li class="card-text">
                                                {{ $visaFilesTranslator->visa_type_name }} /
                                                {{ $visaFilesTranslator->visa_sub_type_name }}
                                                :
                                                <span class="fw-bold text-danger">
                                                    {{ $visaFilesTranslators->where('translator_id', '=', $translator->id)->where('visa_sub_type_id', '=', $visaFilesTranslator->visa_sub_type_id)->count() }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-danger fw-bold">Cari dosyası bulunamadı</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Tercüman Yetkilendirme</div>
        <div class="card-body scroll">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Cari Dosya Tercümanı</label>
                    <select name="tercuman" class="form-control">
                        <option selected value="">Lütfen seçim yapın</option>
                        @foreach ($translators as $translator)
                            <option value="{{ $translator->id }}"
                                {{ old('tercuman') == $translator->id ? 'selected' : '' }}>
                                {{ $translator->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tercuman')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-danger text-white btn-block">Aşamayı Tamamla</button>
            </form>
        </div>
    </div>
@endsection
