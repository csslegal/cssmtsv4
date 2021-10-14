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
            <li class="breadcrumb-item active">Başvuru Sonuç</li>
        </ol>
    </nav>

    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Başvuru Sonuç</div>
        <div class="card-body scroll">
            <form action="basvuru-sonuc" method="POST" id="formSonuc">
                @csrf
                <div class="mb-3">
                    <label>Vize Alındı Mı ?</label>
                    <select name="sonuc" onchange="durum()" id="sonuc" class="form-control ">
                        <option {{ old('sonuc') == 1 ? 'selected' : '' }} value="1">Evet</option>
                        <option {{ old('sonuc') == 0 ? 'selected' : '' }} value="0">Hayır</option>
                    </select>
                    @error('sonuc')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="vt">
                    <label>Vize Tarihi</label>
                    <input type="text" class="form-control datepicker" autocomplete="off" id="vize_tarihi"
                        name="vize_tarihi" />
                    @error('vize_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="rs">
                    <label>Ret Sebebi</label>
                    <input type="text" class="form-control" id="red_sebebi" autocomplete="off" name="red_sebebi" />
                    @error('red_sebebi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="rt">
                    <label>Ret Tarihi</label>
                    <input type="text" class="form-control datepicker1" id="red_tarihi" autocomplete="off"
                        name="red_tarihi" />
                    @error('red_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="r">
                    <div class="checkbox">
                        <label>
                            <input name="tercume" type="checkbox">
                            Ret sonucunu tercümeye gönder</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>
        </div>
    </div>

@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            if ($("#sonuc").val() == 1) {

                $("#rt,#rs,#r").css("display", "none");
                //$("#rt,#rs,#r").hide();
            } else {
                $("#rt").css("display", "block");
                // $("#rt").show();

                $("#vt").css("display", "none");
                // $("#vt").hide();
            }
        });

        function durum() {
            if ($("#sonuc").val() == 1) {

                $("#vt").css("display", "block");
                //  $("#vt").show();

                $("#rt,#rs,#r").css("display", "none");
                //  $("#rt,#rs,#r").hide();

                document.getElementById('red_tarihi').value = '';
                document.getElementById('red_sebebi').value = '';
            } else {
                $("#rt,#rs,#r").css("display", "block");
                // $("#rt,#rs,#r").show();

                $("#vt").css("display", "none");
                //$("#vt").hide();

                document.getElementById('vize_tarihi').value = '';
            }
        }
    </script>
@endsection
