@extends('sablon.genel')

@section('title')
    Cari Dosya Aç
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
            <li class="breadcrumb-item active">Cari Dosya Aç</li>
        </ol>
    </nav>
    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Cari Dosya Aç</div>
        <div class="card-body scroll">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Vize Tipi</label>
                    <select class="form-select" name="vize-tipi">
                        <option value="">Lütfen seçimi yapınız</option>
                        @foreach ($visaTypes as $visaType)
                            <option value="{{ $visaType->id }}">{{ $visaType->name }}</option>
                        @endforeach
                    </select>
                    @error('vize-tipi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Vize Süresi</label>
                    <select name="vize-sure" class="form-control">
                        <option selected value="">Lütfen seçim yapın</option>
                        @foreach ($visaValidities as $visaValidity)
                            <option {{ old('vize-sure') == $visaValidity->id ? 'selected' : '' }}
                                value="{{ $visaValidity->id }}">{{ $visaValidity->name }}</option>
                        @endforeach
                    </select>
                    @error('vize-sure')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Müşteri T.C. Numarası</label>
                    <input type="text" name="tc_number" autocomplete="off" class="form-control"
                        placeholder="T.C. numarasını giriniz"
                        value="{{ $baseCustomerDetails->tc_number != '' ? $baseCustomerDetails->tc_number : old('tc_number') }}" />
                    @error('tc_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Müşteri Adresi</label>
                    <input type="text" name="address" autocomplete="off" class="form-control" placeholder="Adres giriniz"
                        value="{{ $baseCustomerDetails->address != '' ? $baseCustomerDetails->address : old('address') }}" />
                    @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Başvuru Ofisi</label>
                    <select class="form-select" name="basvuru_ofis">
                        <option value="">Lütfen başvuru ofisini seçin</option>
                        @foreach ($applicationOffices as $applicationOffice)
                            <option {{ old('basvuru_ofis') == $applicationOffice->id ? 'selected' : '' }}
                                value="{{ $applicationOffice->id }}">{{ $applicationOffice->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('basvuru_ofis')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Randevu Ofisi</label>
                    <select class="form-select" name="randevu_ofis">
                        <option value="">Lütfen randevu ofisini seçin</option>
                        @foreach ($appointmentOffices as $appointmentOffice)
                            <option {{ old('randevu_ofis') == $appointmentOffice->id ? 'selected' : '' }}
                                value="{{ $appointmentOffice->id }}">{{ $appointmentOffice->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('randevu_ofis')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    @if (session('userTypeId') == 1)
                        <label>Müşteri Dosya Danışmanı</label>
                        <select name="danisman" class="form-control">
                            <option selected value="">Lütfen seçim yapın</option>
                            @foreach ($users as $user)
                                @if ($user->user_type_id == 2 && $user->active == 1)
                                    <option {{ old('danisman') == $user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif
                    @error('danisman')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="w-100 mt-2 btn btn-dark text-white btn-lg  confirm" data-title="Dikkat!"
                    data-content="Müşteri dosyası açılsın mı?">Aşamayı Tamamla</button>
            </form>
        </div>
    </div>
@endsection
