@extends('sablon.genel')

@section('title')
    Müşteri Düzenle
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a>
            </li>
            <li class="breadcrumb-item active">Müşteri Düzenle</li>
        </ol>
    </nav>

    <div class="card card-primary">
        <div class="card-header bg-primary text-white">Müşteri Düzenle</div>
        <div class="card-body scroll">
            <form method="post" action="/musteri/{{ $baseCustomerDetails->id }}">
                @method('PUT')
                <div class="border border-1 p-2 mb-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Müşteri Adı</label>
                        <input class="form-control" name="name" id="name" autocomplete="off" type="text"
                            value="{{ $baseCustomerDetails->name != '' ? $baseCustomerDetails->name : '' }}">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="telefon" class="form-label">Müşteri Telefon</label>
                        <input class="form-control" name="telefon" autocomplete="off" type="text"
                            value="{{ $baseCustomerDetails->telefon != '' ? $baseCustomerDetails->telefon : '' }}">
                        @error('telefon')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Müşteri E-mail</label>
                        <input class="form-control" name="email" autocomplete="off" type="text"
                            value="{{ $baseCustomerDetails->email != '' ? $baseCustomerDetails->email : '' }}">
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="adres" class="form-label">Müşteri Adresi</label>
                    <input autocomplete="off" type="text" class="form-control" name="adres"
                        value="{{ $baseCustomerDetails->adres != '' ? $baseCustomerDetails->adres : old('adres') }}">
                    @error('adres')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="adres" class="form-label">Müşteri T.C. Numarası</label>
                    <input type="text" class="form-control" name="tcno"
                        value="{{ $baseCustomerDetails->tcno != '' ? $baseCustomerDetails->tcno : old('tcno') }}">
                    @error('tcno')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Başvuru Ofisi</label>
                    <select class="form-select" name="basvuru_ofis">
                        <option value="">Lütfen başvuru ofisini seçin</option>
                        @foreach ($basvuruOfisleri as $basvuruOfisi)
                            <option
                                {{ $baseCustomerDetails->application_office_id == $basvuruOfisi->id ? 'selected' : '' }}
                                value="{{ $basvuruOfisi->id }}">{{ $basvuruOfisi->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Randevu Ofisi</label>
                    <select class="form-select" name="randevu_ofis">
                        <option value="">Randevu ofisini seçiniz</option>
                        @foreach ($randevuOfisleri as $randevuOfisi)
                            <option
                                {{ $baseCustomerDetails->appointment_office_id == $randevuOfisi->id ? 'selected' : '' }}
                                value="{{ $randevuOfisi->id }}">{{ $randevuOfisi->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="adres" class="form-label">Pasaport Numarası</label>
                    <input type="text" name="pasaport" placeholder="Müşteri güncel pasaport numarası"
                        class="form-control" autocomplete="off"
                        value="{{ $baseCustomerDetails->pasaport != '' ? $baseCustomerDetails->pasaport : old('pasaport') }}">
                </div>
                <div class="mb-3">
                    <label for="adres" class="form-label ">Pasaport Tarihi</label>
                    <input type="text" class="form-control datepicker" name="pasaport_tarihi" autocomplete="off"
                        placeholder="Müşteri güncel pasport tarihi"
                        value="{{ $baseCustomerDetails->pasaport_tarihi != '' ? $baseCustomerDetails->pasaport_tarihi : old('pasaport_tarihi') }}">
                </div>

                <div class="mb-3">
                    <label for="">E-mail gönderilsin mi?</label>&nbsp;
                    <input name="email-onay" type="checkbox"
                        {{ $baseCustomerDetails->bilgilendirme_onayi == 1 ? 'checked' : '' }} />
                </div>
                @csrf
                <button class="w-100 mt-3 btn btn-danger text-white " type="submit">Kaydet</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#name').change(function() {
            $.ajax({
                url: "/musteri/ajax/name-kontrol",
                type: 'POST',
                data: {
                    name: $("#name").val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(sonuc) {
                    if (sonuc) {
                        $("#name").addClass(["border border-danger"]);
                    } else {
                        $("#name").addClass(["border border-success"]);
                    }
                }
            });
        });
    </script>
@endsection
