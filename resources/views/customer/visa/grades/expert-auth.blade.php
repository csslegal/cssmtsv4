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
            <li class="breadcrumb-item active">Uzman Yetkilendirme</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Uzman Vize Tipine Göre Yetki Sayıları</div>
        <div class="card-body scroll">
            <div class="row">
                @foreach ($experts as $expert)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card mb-2">
                            <div class="card-header text-white bg-danger mb-3">
                                {{ $expert->name }}
                            </div>
                            <div class="card-body">
                                @if ($visaFilesExperts->where('expert_id', '=', $expert->id)->count() > 0)
                                    <ul>
                                        @foreach ($visaFilesExperts->where('expert_id', '=', $expert->id)->unique('visa_sub_type_id') as $visaFilesExpert)
                                            <li class="card-text">
                                                {{ $visaFilesExpert->visa_type_name }} /
                                                {{ $visaFilesExpert->visa_sub_type_name }}
                                                :
                                                <span class="fw-bold text-danger">
                                                    {{ $visaFilesExperts->where('expert_id', '=', $expert->id)->where('visa_sub_type_id', '=', $visaFilesExpert->visa_sub_type_id)->count() }}
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
        <div class="card-header bg-primary text-white">Uzman Yetkilendirme</div>
        <div class="card-body scroll">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Cari Dosya Uzmanı</label>
                    <select name="uzman" class="form-control">
                        <option selected value="">Lütfen seçim yapın</option>
                        @foreach ($experts as $expert)
                            <option value="{{ $expert->id }}"
                                {{ old('uzman') == $expert->id ? 'selected' : '' }}>
                                {{ $expert->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('uzman')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-danger text-white btn-block">Aşamayı Tamamla</button>
            </form>
        </div>
    </div>
@endsection
