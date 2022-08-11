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
    <div class="card card-dark">
        <div class="card-header bg-dark text-white">Müşteri Kayıt</div>
        <div class="card-body scroll">
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
                    <label for="phone" class="form-label">Müşteri Telefon</label>
                    <input id="phone" autocomplete="off" type="text" class="form-control" name="phone"
                        value="{{ old('phone') }}">
                    @error('phone')
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
                    <label for="" class="form-label">Müşteri Açık Adresi</label>
                    <input autocomplete="off" type="text" class="form-control" name="address" value="{{ old('address') }}">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Müşteri T.C. Numarası</label>
                    <input type="text" class="form-control" name="tc_number" value="{{ old('tc_number') }}">
                    @error('tc_number')
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
                </div>

                <!-- {{ csrf_field() }} -->
                @csrf
                <button class="w-100 mt-3 btn btn-dark text-white btn-lg confirm" data-content="Devam edilsin mi?" type="submit">Kaydet</button>
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

        $('#phone').change(function() {
            $.ajax({
                url: "/musteri/ajax/phone-kontrol",
                type: 'POST',
                data: {
                    phone: $("#phone").val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(sonuc) {
                    if (sonuc) {
                        $("#phone").addClass(["border border-danger"]);
                    } else {
                        $("#phone").addClass(["border border-success"]);
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
