@extends('sablon.genel')

@section('title') Randevu Erteleme @endsection

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
            <li class="breadcrumb-item active">Randevu Erteleme</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Randevu Bilgileri</div>
        <div class="card-body scroll">
            <form action="" method="POST">

                <div class="mb-3">
                    <label>GWF Numarası</label>
                    <input type="text" disabled name="gwf" autocomplete="off" class="form-control"
                        placeholder="GWF numarası girin" value="{{ $customerAppointment->gwf }}" />
                    @error('gwf')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Hesap Adı</label>
                    <input type="text" disabled name="hesap_adi" autocomplete="off" class="form-control"
                        placeholder="Hesap adını girin" value="{{ $customerAppointment->name }}" />
                    @error('hesap_adi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Hesap Şifresi</label>
                    <input type="text" disabled name="sifre" autocomplete="off" class="form-control"
                        placeholder="Hesap şifresi girin" value="{{ $customerAppointment->password }}" />
                    @error('sifre')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Randevu Tarihi</label>
                    <input type="text" name="tarih" autocomplete="off" class="datepicker form-control"
                        placeholder="Randevu tarihi girin" value="{{ $customerAppointment->date }}" />
                    @error('tarih')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Randevu Saati</label>
                    <select name="saat" class="form-control">
                        <option value="">Seçim yapınız</option>
                        @foreach ($times as $time)
                            <option {{ $time->name == $customerAppointment->time ? 'selected' : '' }}
                                value="{{ $time->name }}">
                                {{ $time->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('saat')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success text-white">Ödemesiz Aşamayı Tamamla</button>
                <button type="submit" name="odemeli" value="odemeli" class="btn btn-danger text-white">Ödemeli Aşamayı
                    Tamamla</button>
                @csrf
            </form>
        </div>
    </div>
@endsection
