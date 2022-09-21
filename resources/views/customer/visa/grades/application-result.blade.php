@extends('sablon.genel')

@section('title')
    Başvuru Sonuç
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb">
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

    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Başvuru Sonuç</div>
        <div class="card-body scroll">
            <form action="" method="POST" id="formSonuc">
                @csrf
                <div class="mb-3">
                    <label>Başvuru Sonucu</label>
                    <select name="sonuc" onchange="durum()" id="sonuc" class="form-control ">
                        <option selected value="1">Olumlu</option>
                        <option value="0">Olumsuz</option>
                        <option value="2">İade</option>
                    </select>
                    @error('sonuc')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="vbat">
                    <label>Vize Başlangıç Tarihi</label>
                    <input type="text" class="form-control datepicker" autocomplete="off" id="vize_baslangic_tarihi"
                        name="vize_baslangic_tarihi"
                        value="{{ old('vize_baslangic_tarihi') ? old('vize_baslangic_tarihi') : '' }}" />
                    @error('vize_baslangic_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="vbit">
                    <label>Vize Bitiş Tarihi</label>
                    <input type="text" class="form-control datepicker1" autocomplete="off" id="vize_bitis_tarihi"
                        name="vize_bitis_tarihi" value="{{ old('vize_bitis_tarihi') ? old('vize_bitis_tarihi') : '' }}" />
                    @error('vize_bitis_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="vta">
                    <label>Vize Teslim Alınma Tarihi</label>
                    <input type="text" class="form-control datepicker2" autocomplete="off" id="vize_teslim_alinma_tarihi"
                        name="vize_teslim_alinma_tarihi"
                        value="{{ old('vize_teslim_alinma_tarihi') ? old('vize_teslim_alinma_tarihi') : '' }}" />
                    @error('vize_teslim_alinma_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="rs">
                    <label>Ret Sebebi</label>
                    <input type="text" class="form-control" id="red_sebebi" autocomplete="off" name="red_sebebi"
                        value="{{ old('red_sebebi') ? old('red_sebebi') : '' }}" />
                    @error('red_sebebi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="rt">
                    <label>Ret Tarihi</label>
                    <input type="text" class="form-control datepicker3" id="red_tarihi" autocomplete="off"
                        name="red_tarihi" value="{{ old('red_tarihi') ? old('red_tarihi') : '' }}" />
                    @error('red_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="rat">
                    <label>Ret Teslim Alınma Tarihi</label>
                    <input type="text" class="form-control datepicker4" id="red_teslim_alinma_tarihi" autocomplete="off"
                        name="red_teslim_alinma_tarihi"
                        value="{{ old('red_teslim_alinma_tarihi') ? old('red_teslim_alinma_tarihi') : '' }}" />
                    @error('red_teslim_alinma_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="w-100 mt-3 btn btn-dark text-white btn-lg confirm"
                    data-content="Devam edilsin mi?">Aşamayı Tamamla</button>
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
        new AirDatepicker('.datepicker1', {
            isMobile: true,
            autoClose: true,
            buttons: ['today', 'clear'],
        })
        new AirDatepicker('.datepicker2', {
            isMobile: true,
            autoClose: true,
            buttons: ['today', 'clear'],
        })
        new AirDatepicker('.datepicker3', {
            isMobile: true,
            autoClose: true,
            buttons: ['today', 'clear'],
        })
        new AirDatepicker('.datepicker4', {
            isMobile: true,
            autoClose: true,
            buttons: ['today', 'clear'],
        })
        $(document).ready(function() {
            if ($("#sonuc").val() == 1) {
                $("#rs,#rt,#rat").css("display", "none");
                $("vbat,#vbit,#vta").css("display", "block");
            } else if ($("#sonuc").val() == 0) {
                $("#rs,#rt,#rat").css("display", "block");
                $("vbat,#vbit,#vta").css("display", "none");
            } else {
                $("vbat,#vbit,#vta").css("display", "none");
                $("#rs,#rt,#rat").css("display", "none");
            }
        });

        function durum() {
            if ($("#sonuc").val() == 1) {

                $("#rs,#rt,#rat").css("display", "none");
                $("#vbat,#vbit,#vta").css("display", "block");

                document.getElementById('red_tarihi').value = '';
                document.getElementById('red_teslim_alinma_tarihi').value = '';
                document.getElementById('red_sebebi').value = '';
            } else if ($("#sonuc").val() == 0) {

                $("#rs,#rt,#rat").css("display", "block");
                $("#vbat,#vbit,#vta").css("display", "none");

                document.getElementById('vize_baslangic_tarihi').value = '';
                document.getElementById('vize_bitis_tarihi').value = '';
                document.getElementById('vize_teslim_alinma_tarihi').value = '';
            } else {

                $("#rs,#rt,#rat").css("display", "none");
                $("#vbat,#vbit,#vta").css("display", "none");

                document.getElementById('red_tarihi').value = '';
                document.getElementById('red_teslim_alinma_tarihi').value = '';
                document.getElementById('red_sebebi').value = '';

                document.getElementById('vize_baslangic_tarihi').value = '';
                document.getElementById('vize_bitis_tarihi').value = '';
                document.getElementById('vize_teslim_alinma_tarihi').value = '';
            }
        }
    </script>
@endsection
