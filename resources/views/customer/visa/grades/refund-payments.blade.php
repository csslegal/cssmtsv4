@extends('sablon.genel')

@section('title') İade Bilgileri @endsection

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
            <li class="breadcrumb-item active">İade Bilgileri İşlemi</li>
        </ol>
    </nav>
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

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-secondary mb-3">
        <div class="card-header bg-secondary text-white">Yapılan Ödemeler</div>
        <div class="card-body scroll">
            <table id="dataTableVize" class="table table-striped table-bordered display table-light " style="width:100%">
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-danger mb-3">
        <div class="card-header bg-danger text-white">İade Bilgileri</div>
        <div class="card-body scroll">
            <table id="dataTableHarici" class="table table-striped table-bordered display table-light " style="width:100%">
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
                    @foreach ($refundPayments as $refundPayment)
                        <tr>
                            <td>{{ $refundPayment->id }}</td>
                            <td>{{ $refundPayment->name }}</td>
                            <td>
                                @if ($refundPayment->confirm)
                                    <span class='text-success'>Onaylı</span>
                                @else
                                    <span class=' text-danger'>Onaysız</span>
                                @endif
                            </td>
                            <td>{{ $refundPayment->user_name }}</td>
                            <td>{{ $refundPayment->payment_total }}</td>
                            <td>{{ $refundPayment->payment_method }}</td>
                            <td>
                                {{ $refundPayment->refund_tl != '' ? $refundPayment->refund_tl . 'TL' : '' }}
                                {{ $refundPayment->refund_euro != '' ? $refundPayment->refund_euro . '£' : '' }}
                                {{ $refundPayment->refund_dolar != '' ? $refundPayment->refund_dolar . '$' : '' }}
                                {{ $refundPayment->refund_pound != '' ? $refundPayment->refund_pound . '€' : '' }}
                            </td>
                            <td>{{ $refundPayment->payment_date }}</td>
                            <td>{{ $refundPayment->created_at }}</td>
                            <td>
                                <form method="POST" action="iade-bilgileri/{{ $refundPayment->id }}">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" data-bs-toggle="tooltip" data-bs-placement="right" title="Sil">
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

    <div class="card card-danger mb-3">
        <div class="card-header bg-danger text-white">İade Bilgisi Kaydet</div>
        <div class="card-body scroll">
            <form action="" method="POST">
                @csrf
                <label class="form-label fw-bold"> İade Türleri Başlıkları</label>
                <div class="row mb-3">
                    <div class="col-md-4 ">
                        @foreach ($refundPaymentTypes->slice(0, 5) as $refundPaymentType)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="iade_tipleri[]"
                                    value="{{ $refundPaymentType->name }}" @if (is_array(old('iade_tipleri')) && in_array($refundPaymentType->name, old('iade_tipleri'))) checked @endif>
                                {{ $refundPaymentType->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        @foreach ($refundPaymentTypes->slice(5, 5) as $refundPaymentType)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="iade_tipleri[]"
                                    value="{{ $refundPaymentType->name }}" @if (is_array(old('iade_tipleri')) && in_array($refundPaymentType->name, old('iade_tipleri'))) checked @endif>
                                {{ $refundPaymentType->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        @foreach ($refundPaymentTypes->slice(10, 5) as $refundPaymentType)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="iade_tipleri[]"
                                    value="{{ $refundPaymentType->name }}" @if (is_array(old('iade_tipleri')) && in_array($refundPaymentType->name, old('iade_tipleri'))) checked @endif>
                                {{ $refundPaymentType->name }}
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        @error('iade_tipleri')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> İade Miktar (TL)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9 ">
                                <input type="text" class="form-control" name="iade_tl" value="{{ old('iade_tl') }}"
                                    autocomplete="off" placeholder="İade miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="tl_kurus" value="{{ old('tl_kurus') }}"
                                    autocomplete="off" value="00" placeholder="Kuruş">
                            </div>
                        </div>
                        @error('iade_tl')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> İade Miktar (Pound)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9 ">
                                <input type="text" class="form-control" name="iade_pound"
                                    value="{{ old('iade_pound') }}" autocomplete="off" placeholder="İade miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="pound_kurus"
                                    value="{{ old('pound_kurus') }}" autocomplete="off" placeholder="Penny">
                            </div>
                        </div>
                        @error('iade_pound')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> İade Miktar (Euro)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9 ">
                                <input type="text" class="form-control" name="iade_euro" value="{{ old('iade_euro') }}"
                                    autocomplete="off" placeholder="İade miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="euro_kurus"
                                    value="{{ old('euro_kurus') }}" autocomplete="off" placeholder="Sent">
                            </div>
                        </div>
                        @error('iade_euro')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label"> İade Miktar (Dolar)</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9">
                                <input type="text" class="form-control" name="iade_dolar"
                                    value="{{ old('iade_dolar') }}" autocomplete="off" placeholder="İade miktarı">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="dolar_kurus"
                                    value="{{ old('dolar_kurus') }}" autocomplete="off" placeholder="Sent">
                            </div>
                        </div>
                        @error('iade_dolar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <label class="form-label">İade (TL) Toplam Miktar</label>
                <div class="row mb-3">
                    <div class="col-md-8 col-sm-9">
                        <input type="text" class="form-control" name="iade_toplam" value="{{ old('iade_toplam') }}"
                            autocomplete="off" placeholder="Toplam yapılan iade">
                    </div>
                    <div class="col-md-4 col-sm-3">
                        <input type="text" class="form-control" name="toplam_kurus" value="{{ old('toplam_kurus') }}"
                            autocomplete="off" placeholder="Kuruş">
                    </div>
                    <div class="col-12">
                        @error('iade_toplam')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">İade Şekli</label>
                    <select name="iade_sekli" class=" form-control">
                        <option {{ old('iade_sekli') == '' ? 'selected' : '' }} value="">Seçim yapınız</option>
                        <option {{ old('iade_sekli') == 'NAKİT' ? 'selected' : '' }} value="NAKİT">NAKİT</option>
                        <option {{ old('iade_sekli') == 'EFT' ? 'selected' : '' }} value="EFT">EFT</option>
                        <option {{ old('iade_sekli') == 'KREDİ KARTI' ? 'selected' : '' }} value="KREDİ KARTI">KREDİ
                            KARTI</option>
                        <option {{ old('iade_sekli') == 'MAİL ORDER' ? 'selected' : '' }} value="MAİL ORDER">MAİL ORDER
                        </option>
                        <option {{ old('iade_sekli') == 'KARGO NAKİT' ? 'selected' : '' }} value="KARGO NAKİT">KARGO
                            NAKİT</option>
                        <option {{ old('iade_sekli') == 'PTT' ? 'selected' : '' }} value="PTT">PTT</option>
                        <option {{ old('iade_sekli') == 'MONEY GRAM' ? 'selected' : '' }} value="MONEY GRAM">MONEY GRAM
                        </option>
                        <option {{ old('iade_sekli') == 'WESTERN UNİON' ? 'selected' : '' }} value="WESTERN UNİON">
                            WESTERN UNİON</option>
                    </select>
                    @error('iade_sekli')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">İade Tarihi</label>
                    <input type="text" class="form-control datepicker" name="iade_tarihi"
                        value="{{ old('iade_tarihi') == '' ? '' : old('iade_tarihi') }}" autocomplete="off"
                        placeholder="İade tarihi" />
                    @error('iade_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Kaydet</button>

                @if (count($refundPayments) > 0)
                    <a href="/musteri/{{ $baseCustomerDetails->id }}/vize/{{ $baseCustomerDetails->visa_file_id }}/iade-bilgileri-tamamla"
                        class="btn btn-danger text-white">Aşamayı Tamamla</a>
                @endif
            </form>
        </div>
    </div>
@endsection
