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
            <li class="breadcrumb-item active">Dosya Teslimatı</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Dosya Teslim Et</div>
        <div class="card-body scroll">
            <form action="teslimat-bilgisi" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Teslim Edilme Şekli </label>
                    <select name="teslimat_sekli" onchange="delivery()" id="teslimat_sekli" class="form-control">
                        <option {{ old('teslimat_sekli') == 1 ? ' selected ' : '' }} value="1">Elden kimlik ile</option>
                        <option {{ old('teslimat_sekli') == 2 ? ' selected ' : '' }} value="2">Kargo ile</option>
                        <option {{ old('teslimat_sekli') == 3 ? ' selected ' : '' }} value="3">Başvuru yenileme</option>
                    </select>
                    @error('teslimat_sekli')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="k">
                    <label>Kargolar</label>
                    <select class="form-control" name="kargo_firmasi" id="kargo_firmasi">
                        <option value="">Seçim yapınız</option>
                        <option {{ old('kargo_firmasi') == 'Yurtiçi Kargo' ? ' selected ' : '' }} value="Yurtiçi Kargo">
                            Yurtiçi Kargo</option>
                        <option {{ old('kargo_firmasi') == 'Aras Kargo' ? ' selected ' : '' }} value="Aras Kargo">Aras
                            Kargo</option>
                        <option {{ old('kargo_firmasi') == 'Dhl Kargo' ? ' selected ' : '' }} value="Dhl Kargo">Dhl Kargo
                        </option>
                        <option {{ old('kargo_firmasi') == 'Mng Kargo' ? ' selected ' : '' }} value="Mng Kargo">Mng Kargo
                        </option>
                        <option {{ old('kargo_firmasi') == 'Sürat Kargo' ? ' selected ' : '' }} value="Sürat Kargo">Sürat
                            Kargo</option>
                        <option {{ old('kargo_firmasi') == 'Tnt Kargo' ? ' selected ' : '' }} value="Tnt Kargo">Tnt Kargo
                        </option>
                        <option {{ old('kargo_firmasi') == 'Ups Kargo' ? ' selected ' : '' }} value="Ups Kargo">Ups Kargo
                        </option>
                        <option {{ old('kargo_firmasi') == 'Varan Kargo' ? ' selected ' : '' }} value="Varan Kargo">Varan
                            Kargo</option>
                        <option {{ old('kargo_firmasi') == 'Metro Kargo' ? ' selected ' : '' }} value="Metro Kargo">Metro
                            Kargo</option>
                        <option {{ old('kargo_firmasi') == 'Fillo Kargo' ? ' selected ' : '' }} value="Fillo Kargo">Fillo
                            Kargo</option>
                        <option {{ old('kargo_firmasi') == 'Ptt Kargo' ? ' selected ' : '' }} value="Ptt Kargo">Ptt Kargo
                        </option>
                    </select>
                    @error('kargo_firmasi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="kn">
                    <label>Kargo Takip Numarası</label>
                    <input type="text" class="form-control" name="kargo_takip_no" id="kargo_takip_no"
                        value="{{ old('kargo_takip_no') }}" />
                    @error('kargo_takip_no')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="bo">
                    <label>Teslim Edilen Ofis</label>
                    <select class="form-control" name="ofis" id="ofis">
                        <option value="">Seçim yapınız</option>
                        @foreach ($applicationOffices as $applicationOffice)
                            <option {{ old('ofis') == $applicationOffice->id ? ' selected ' : '' }}
                                value="{{ $applicationOffice->id }}">{{ $applicationOffice->name }}</option>
                        @endforeach
                    </select>
                    @error('ofis')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            if ($("#teslimat_sekli").val() == 1) {
                $("#k,#kn,#bo").hide();
                $("#bo").show();

            } else if ($("#teslimat_sekli").val() == 2) {
                $("#k,#kn,#bo").hide();
                $("#k,#kn,#bo").show();

            } else if ($("#teslimat_sekli").val() == 3) {
                $("#k,#kn,#bo").hide();
                $("#bo").show();

            } else {
                $("#k,#kn,#bo").hide();
            }
        });

        function delivery() {
            if ($("#teslimat_sekli").val() == 1) {
                $("#bo").show();
                $("#k,#kn").hide();
                document.getElementById('kargo_firmasi').selectedIndex = 0;
                document.getElementById('kargo_takip_no').value = '';
            } else if ($("#teslimat_sekli").val() == 2) {
                $("#k,#kn,#bo").show();

            } else if ($("#teslimat_sekli").val() == 3) {
                $("#bo").show();
                $("#k,#kn").hide();
                document.getElementById('kargo_firmasi').selectedIndex = 0;
                document.getElementById('kargo_takip_no').value = '';
            } else {
                $("#k,#kn,#bo").hide();
                document.getElementById('kargo_firmasi').selectedIndex = 0;
                document.getElementById('kargo_takip_no').value = '';
                document.getElementById('ofis').selectedIndex = 0;
            }
        }
    </script>
@endsection
