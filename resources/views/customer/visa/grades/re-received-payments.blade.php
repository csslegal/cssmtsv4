@extends('sablon.genel')

@section('title')
    Yeniden Alınan Ödemeler
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
            <li class="breadcrumb-item active">Yeniden Alınan Ödemeler</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Yeniden Alınan Ödemeyi Kaydet</div>
        <div class="card-body scroll">
            <form method="post" action="">
                @csrf
                <label class="form-label fw-bold"> Ödeme Türleri Başlıkları</label>
                <div class="row mb-3">
                    <div class="col-md-4 ">
                        @foreach ($receivedPaymentTypes->slice(0, 5) as $receivedPaymentType)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="odeme_tipleri[]" tabindex="1"
                                    value="{{ $receivedPaymentType->name }}"
                                    @if (is_array(old('odeme_tipleri')) && in_array($receivedPaymentType->name, old('odeme_tipleri'))) checked @endif>
                                {{ $receivedPaymentType->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        @foreach ($receivedPaymentTypes->slice(5, 5) as $receivedPaymentType)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="odeme_tipleri[]" tabindex="1"
                                    value="{{ $receivedPaymentType->name }}"
                                    @if (is_array(old('odeme_tipleri')) && in_array($receivedPaymentType->name, old('odeme_tipleri'))) checked @endif>
                                {{ $receivedPaymentType->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        @foreach ($receivedPaymentTypes->slice(10, 5) as $receivedPaymentType)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="odeme_tipleri[]" tabindex="1"
                                    value="{{ $receivedPaymentType->name }}"
                                    @if (is_array(old('odeme_tipleri')) && in_array($receivedPaymentType->name, old('odeme_tipleri'))) checked @endif>
                                {{ $receivedPaymentType->name }}
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
                        <label class="form-label"> Alınan Miktar (TL)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9 ">
                                <input type="text" class="form-control" name="alinan_tl" value="{{ old('alinan_tl') }}" tabindex="2"
                                    autocomplete="off" placeholder="Ödeme miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="tl_kurus" value="{{ old('tl_kurus') }}"
                                    autocomplete="off" value="00" placeholder="Kuruş">
                            </div>
                        </div>
                        @error('alinan_tl')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> Alınan Miktar (Pound)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9 ">
                                <input type="text" class="form-control" name="alinan_pound" tabindex="2"
                                    value="{{ old('alinan_pound') }}" autocomplete="off" placeholder="Ödeme miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="pound_kurus"
                                    value="{{ old('pound_kurus') }}" autocomplete="off" placeholder="Penny">
                            </div>
                        </div>
                        @error('alinan_pound')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> Alınan Miktar (Euro)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9 ">
                                <input type="text" class="form-control" name="alinan_euro" tabindex="2"
                                    value="{{ old('alinan_euro') }}" autocomplete="off" placeholder="Ödeme miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="euro_kurus"
                                    value="{{ old('euro_kurus') }}" autocomplete="off" placeholder="Sent">
                            </div>
                        </div>
                        @error('alinan_euro')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> Alınan Miktar (Dolar)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9">
                                <input type="text" class="form-control" name="alinan_dolar" tabindex="2"
                                    value="{{ old('alinan_dolar') }}" autocomplete="off" placeholder="Ödeme miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="dolar_kurus"
                                    value="{{ old('dolar_kurus') }}" autocomplete="off" placeholder="Sent">
                            </div>
                        </div>
                        @error('alinan_dolar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <label class="form-label">Alınan (TL) Toplam Miktar</label>
                <div class="row mb-3">
                    <div class="col-md-8 col-sm-9">
                        <input type="text" class="form-control" name="alinan_toplam" tabindex="3"
                            value="{{ old('alinan_toplam') }}" autocomplete="off" placeholder="Toplam alınan ödeme">
                    </div>
                    <div class="col-md-4 col-sm-3">
                        <input type="text" class="form-control" name="toplam_kurus"
                            value="{{ old('toplam_kurus') }}" autocomplete="off" placeholder="Kuruş">
                    </div>
                    @error('alinan_toplam')
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
                        <option selected value="EFT">EFT</option>
                        <option value="KREDİ KARTI">KREDİ KARTI</option>
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
                        placeholder="Ödeme alınma tarihi" />
                    @error('odeme_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary confirm" data-content="Devam edilsin mi?" tabindex="6">Yeniden Ödeme
                    Kaydet</button>
                @if (count($receivedPayments) > 0)
                    <a href="/musteri/{{ $baseCustomerDetails->id }}/vize/{{ $baseCustomerDetails->visa_file_id }}/yeniden-alinan-odeme-tamamla"
                        class="btn btn-danger text-white confirm" data-content="Devam edilsin mi?" tabindex="7">Aşamayı Tamamla</a>
                @endif
            </form>
        </div>
    </div>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Alınan Ödemeler</div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-striped table-bordered display table-light " style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlıklar</th>
                        <th>Onay</th>
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
                    @foreach ($receivedPayments as $receivedPayment)
                        <tr>
                            <td>{{ $receivedPayment->id }}</td>
                            <td>{{ $receivedPayment->name }}</td>
                            <td>
                                @if ($receivedPayment->confirm)
                                    <span class='text-success'>Onaylı</span>
                                @else
                                    <span class=' text-danger'>Onaysız</span>
                                @endif
                            </td>
                            <td>{{ $receivedPayment->user_name }}</td>
                            <td>{{ $receivedPayment->payment_total }}</td>
                            <td>{{ $receivedPayment->payment_method }}</td>
                            <td>
                                {{ $receivedPayment->received_tl != '' ? $receivedPayment->received_tl . 'TL' : '' }}
                                {{ $receivedPayment->received_euro != '' ? $receivedPayment->received_euro . '£' : '' }}
                                {{ $receivedPayment->received_dolar != '' ? $receivedPayment->received_dolar . '$' : '' }}
                                {{ $receivedPayment->received_pound != '' ? $receivedPayment->received_pound . '€' : '' }}
                            </td>
                            <td>{{ $receivedPayment->payment_date }}</td>
                            <td>{{ $receivedPayment->created_at }}</td>
                            <td>
                                <form method="POST" action="yeniden-alinan-odeme/{{ $receivedPayment->id }}">
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
