@extends('sablon.genel')

@section('title')
    Yapılan Ödemeler
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
            <li class="breadcrumb-item active">Yapılan Ödemeler</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Yapılan Ödemeyi Kaydet</div>
        <div class="card-body scroll">
            <form method="post" action="">
                @csrf
                <label class="form-label fw-bold"> Ödeme Türleri Başlıkları</label>
                <div class="row mb-3">
                    <div class="col-md-4 ">
                        @foreach ($madePaymentTypes->slice(0, 5) as $madePaymentType)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="odeme_tipleri[]" tabindex="1"
                                    value="{{ $madePaymentType->name }}" @if (is_array(old('odeme_tipleri')) && in_array($madePaymentType->name, old('odeme_tipleri'))) checked @endif>
                                {{ $madePaymentType->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        @foreach ($madePaymentTypes->slice(5, 5) as $madePaymentType)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="odeme_tipleri[]" tabindex="1"
                                    value="{{ $madePaymentType->name }}" @if (is_array(old('odeme_tipleri')) && in_array($madePaymentType->name, old('odeme_tipleri'))) checked @endif>
                                {{ $madePaymentType->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        @foreach ($madePaymentTypes->slice(10, 5) as $madePaymentType)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="odeme_tipleri[]" tabindex="1"
                                    value="{{ $madePaymentType->name }}" @if (is_array(old('odeme_tipleri')) && in_array($madePaymentType->name, old('odeme_tipleri'))) checked @endif>
                                {{ $madePaymentType->name }}
                            </div>
                        @endforeach
                    </div>
                    @error('odeme_tipleri')
                        <div class="col-md-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> Yapılan Miktar (TL)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9 ">
                                <input type="text" class="form-control" name="yapilan_tl" tabindex="2"
                                    value="{{ old('yapilan_tl') }}" autocomplete="off" placeholder="Ödeme miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="tl_kurus" value="{{ old('tl_kurus') }}"
                                    autocomplete="off" value="00" placeholder="Kuruş">
                            </div>
                        </div>
                        @error('yapilan_tl')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> Yapılan Miktar (Pound)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9 ">
                                <input type="text" class="form-control" name="yapilan_pound" tabindex="2"
                                    value="{{ old('yapilan_pound') }}" autocomplete="off" placeholder="Ödeme miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="pound_kurus"
                                    value="{{ old('pound_kurus') }}" autocomplete="off" placeholder="Penny">
                            </div>
                        </div>
                        @error('yapilan_pound')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> Yapılan Miktar (Euro)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9 ">
                                <input type="text" class="form-control" name="yapilan_euro" tabindex="2"
                                    value="{{ old('yapilan_euro') }}" autocomplete="off" placeholder="Ödeme miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="euro_kurus"
                                    value="{{ old('euro_kurus') }}" autocomplete="off" placeholder="Sent">
                            </div>
                        </div>
                        @error('yapilan_euro')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> Yapılan Miktar (Dolar)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9">
                                <input type="text" class="form-control" name="yapilan_dolar" tabindex="2"
                                    value="{{ old('yapilan_dolar') }}" autocomplete="off" placeholder="Ödeme miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="dolar_kurus"
                                    value="{{ old('dolar_kurus') }}" autocomplete="off" placeholder="Sent">
                            </div>
                        </div>
                        @error('yapilan_dolar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <label class="form-label">Yapılan (TL) Toplam Miktar</label>
                <div class="row mb-3">
                    <div class="col-md-8 col-sm-9">
                        <input type="text" class="form-control" name="yapilan_toplam" tabindex="3"
                            value="{{ old('yapilan_toplam') }}" autocomplete="off" placeholder="Toplam yapılan ödeme">
                    </div>
                    <div class="col-md-4 col-sm-3">
                        <input type="text" class="form-control" name="toplam_kurus"
                            value="{{ old('toplam_kurus') }}" autocomplete="off" placeholder="Kuruş">
                    </div>
                    @error('yapilan_toplam')
                        <div class="col-md-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ödeme Şekli</label>
                    <select name="odeme_sekli" class=" form-control" tabindex="4">
                        <option value="">Seçim yapınız</option>
                        <option value="NAKİT">NAKİT</option>
                        <option value="EFT">EFT</option>
                        <option selected value="KREDİ KARTI">KREDİ KARTI</option>
                        <option value="MAİL ORDER">MAİL ORDER</option>
                        <option value="KARGO NAKİT">KARGO NAKİT</option>
                        <option value="PTT">PTT</option>
                        <option value="MONEY GRAM">MONEY GRAM</option>
                        <option value="WESTERN UNİON">WESTERN UNİON</option>
                    </select>
                    @error('odeme_sekli')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ödeme Tarihi</label>
                    <input type="text" class="form-control datepicker" name="odeme_tarihi" tabindex="5"
                        value="{{ old('odeme_tarihi') == '' ? '' : old('odeme_tarihi') }}" autocomplete="off"
                        placeholder="Ödeme yapılma tarihi" />
                    @error('odeme_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary confirm" data-content="Devam edilsin mi?"
                    tabindex="6">Ödeme Kaydet</button>
                @if (count($madePayments) > 0)
                    <a href="yapilan-odeme-tamamla" class="btn btn-danger text-white confirm"
                        data-content="Devam edilsin mi?" tabindex="7">Aşamayı Tamamla</a>
                @endif
            </form>
        </div>
    </div>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Yapılan Ödemeler</div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-striped table-bordered display table-light " style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlıklar</th>
                        <th>İşlem Yapan</th>
                        <th>Toplam(TL)</th>
                        <th>Ödeme Şekli</th>
                        <th>Detaylar</th>
                        <th>Ödeme Tarihi</th>
                        <th>İşlem Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($madePayments as $madePayment)
                        <tr>
                            <td>{{ $madePayment->id }}</td>
                            <td>{{ $madePayment->name }}</td>
                            <td>{{ $madePayment->user_name }}</td>
                            <td>{{ $madePayment->payment_total }}</td>
                            <td>{{ $madePayment->payment_method }}</td>
                            <td>
                                {{ $madePayment->made_tl != '' ? $madePayment->made_tl . 'TL' : '' }}
                                {{ $madePayment->made_euro != '' ? $madePayment->made_euro . '£' : '' }}
                                {{ $madePayment->made_dolar != '' ? $madePayment->made_dolar . '$' : '' }}
                                {{ $madePayment->made_pound != '' ? $madePayment->made_pound . '€' : '' }}
                            </td>
                            <td>{{ $madePayment->payment_date }}</td>
                            <td>{{ $madePayment->created_at }}</td>
                            <td>
                                <form method="POST" action="yapilan-odeme/{{ $madePayment->id }}">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Sil">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
