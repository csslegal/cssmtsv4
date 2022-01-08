@extends('sablon.genel')


@section('title') Müşteri Kayıt @endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item active">Müşteri Kayıt</li>
        </ol>
    </nav>
    <div class="card card-primary">
        <div class="card-header bg-primary text-white">Müşteri Kayıt</div>
        <div class="card-body">
            <form method="post" action="/musteri">
                <div class="mb-3">
                    <label for="name" class="form-label">Müşteri Adı</label>
                    <input autocomplete="off" type="text" class="form-control" id="name" name="name"
                        value="{{ old('name') }}">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="telefon" class="form-label">Müşteri Telefon</label>
                    <input id="telefon" autocomplete="off" type="text" class="form-control" name="telefon"
                        value="{{ old('telefon') }}">
                    @error('telefon')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Müşteri E-mail</label>
                    <input id="email" autocomplete="off" type="text" class="form-control" name="email"
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="not" class="form-label">Müşteri Hakkında Not</label>
                    <textarea id="editor200" name="not" class="form-control wysiwyg">{!! old('not') !!}</textarea>
                </div>
                <div class="mb-3">
                    <label for="adres" class="form-label">Müşteri Adresi</label>
                    <input autocomplete="off" type="text" class="form-control" name="adres" value="{{ old('adres') }}">
                </div>
                <div class="mb-3">
                    <label for="adres" class="form-label">Müşteri T.C. Numarası</label>
                    <input type="text" class="form-control" name="tcno" value="{{ old('tcno') }}">
                    @error('tcno')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Başvuru Ofisi</label>
                    <select class="form-select" name="basvuru_ofis">
                        <option value="">Lütfen başvuru ofisini seçin</option>
                        @foreach ($basvuruOfisleri as $basvuruOfisi)
                            <option {{ old('basvuru_ofis') == $basvuruOfisi->id ? 'selected' : '' }}
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
                            <option {{ old('randevu_ofis') == $randevuOfisi->id ? 'selected' : '' }}
                                value="{{ $randevuOfisi->id }}">{{ $randevuOfisi->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- {{ csrf_field() }} -->
                @csrf
                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Kaydet</button>
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

        $('#telefon').change(function() {
            $.ajax({
                url: "/musteri/ajax/telefon-kontrol",
                type: 'POST',
                data: {
                    telefon: $("#telefon").val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(sonuc) {
                    if (sonuc) {
                        $("#telefon").addClass(["border border-danger"]);
                    } else {
                        $("#telefon").addClass(["border border-success"]);
                    }
                }
            });
        });
        $('#email').change(function() {
            $.ajax({
                url: "/musteri/ajax/email-kontrol",
                type: 'POST',
                data: {
                    email: $("#email").val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(sonuc) {
                    if (sonuc) {
                        $("#email").addClass(["border border-danger"]);
                    } else {
                        $("#email").addClass(["border border-success"]);
                    }
                }
            });
        });
    </script>
@endsection
