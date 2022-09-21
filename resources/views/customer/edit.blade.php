@extends('sablon.genel')

@section('title')
    Müşteri Düzenle
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb">
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

    <div class="card card-dark">
        <div class="card-header bg-dark text-white">Müşteri Düzenle</div>
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
                        <label for="phone" class="form-label">Müşteri Telefon</label>
                        <input class="form-control" name="phone" autocomplete="off" type="text"
                            value="{{ $baseCustomerDetails->phone != '' ? $baseCustomerDetails->phone : '' }}">
                        @error('phone')
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
                    <label for="address" class="form-label">Müşteri Adresi</label>
                    <input autocomplete="off" type="text" class="form-control" name="address"
                        value="{{ $baseCustomerDetails->address != '' ? $baseCustomerDetails->address : old('address') }}">
                    @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Müşteri T.C. Numarası</label>
                    <input type="text" class="form-control" name="tc_number"
                        value="{{ $baseCustomerDetails->tc_number != '' ? $baseCustomerDetails->tc_number : old('tc_number') }}">
                    @error('tc_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Pasaport Numarası</label>
                    <input type="text" name="passport" placeholder="Müşteri güncel pasaport numarası"
                        class="form-control" autocomplete="off"
                        value="{{ $baseCustomerDetails->passport != '' ? $baseCustomerDetails->passport : old('passport') }}">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label ">Pasaport Tarihi</label>
                    <input type="text" class="form-control datepicker" name="passport_date" autocomplete="off"
                        placeholder="Müşteri güncel pasport tarihi"
                        value="{{ $baseCustomerDetails->passport_date != '' ? $baseCustomerDetails->passport_date : old('passport_date') }}">
                </div>

                <div class="mb-3">
                    <label for="">E-mail gönderilsin mi?</label>&nbsp;
                    <input name="email-onay" type="checkbox"
                        {{ $baseCustomerDetails->information_confirm == 1 ? 'checked' : '' }} />
                </div>
                @csrf
                <button class="w-100 mt-3 btn btn-dark text-white " type="submit">Kaydet</button>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('js/air-datepicker/air-datepicker.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/air-datepicker/air-datepicker.js') }}"></script>
    <script>
        new AirDatepicker('.datepicker', {
            isMobile: true,
            autoClose: true,
            buttons: ['today', 'clear'],

        })
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
