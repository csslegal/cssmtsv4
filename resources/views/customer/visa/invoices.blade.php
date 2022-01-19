@extends('sablon.genel')

@section('title') Vize Faturalar @endsection

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
            <li class="breadcrumb-item active">Faturalar</li>
        </ol>
    </nav>
    @if (isset($invoices))
        <div class="card card-primary mb-3">
            <div class="card-header bg-primary text-white">Faturalar
                @if ($visaFileInvoiceGradesPermitted)
                    <a class="float-end text-white" data-bs-toggle="modal" data-bs-target="#invoices" href="#">Ekle</a>
                @endif
            </div>
            <div class="card-body scroll">
                <table id="dataTable" class="table table-striped table-bordered display table-light " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>İşlem Yapan</th>
                            <th>Toplam Ödeme</th>
                            <th>Toplam Matrah</th>
                            <th>Fatura Numarası</th>
                            <th>Fatura Tarihi</th>
                            <th>İşlem Tarihi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->name }}</td>
                                <td>{{ $invoice->payment }}</td>
                                <td>{{ $invoice->matrah }}</td>
                                <td>{{ $invoice->number }}</td>
                                <td>{{ $invoice->date }}</td>
                                <td>{{ $invoice->created_at }}</td>
                                <td>
                                    @if ($visaFileInvoiceGradesPermitted)
                                        <form method="POST" action="fatura/{{ $invoice->id }}">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" data-bs-toggle="tooltip" data-bs-placement="right"
                                                title="Sil">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <div class="modal fade" id="invoices" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="invoicesLabel" style="display: none;" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoicesLabel">Fatura Kayıt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="fatura">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Toplam Ödeme(Yansıtma) TL</label>
                            <div class="row">
                                <div class="col-md-8  col-sm-9 ">
                                    <input type="text" class="form-control" name="odeme" autocomplete="off"
                                        value="{{ old('odeme') }}" placeholder="Toplam ödeme miktarı">
                                </div>
                                <div class="col-md-4  col-sm-3">
                                    <input type="text" class="form-control" name="odeme_kurus" autocomplete="off"
                                        value="{{ old('odeme_kurus') }}" placeholder="Kuruş">
                                </div>
                            </div>
                            @error('odeme')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Toplam Matrahı</label>
                            <div class="row">
                                <div class="col-md-8  col-sm-9 ">
                                    <input type="text" class="form-control" name="matrah" autocomplete="off"
                                        value="{{ old('matrah') }}" placeholder="Toplam ödeme matrahı">
                                </div>
                                <div class="col-md-4  col-sm-3">
                                    <input type="text" class="form-control" name="matrah_kurus" autocomplete="off"
                                        value="{{ old('matrah_kurus') }}" placeholder="Kuruş">
                                </div>
                            </div>
                            @error('matrah')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fatura Numarası</label>
                            <input type="text" name="numara" autocomplete="off" placeholder="Fatura numarası gir"
                                value="{{ old('numara') }}" class="form-control" />
                            @error('numara')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fatura Tarihi </label>
                            <input type="text" name="tarih" autocomplete="off" class="form-control datepicker"
                                value="{{ old('tarih') }}" placeholder="Fatura tarihi gir" />
                            @error('tarih')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(window).on('load', function() {
            @if ($errors->has('odeme') || $errors->has('matrah') || $errors->has('numara') || $errors->has('tarih'))
                $('#invoices').modal('show');
            @endif
        });
    </script>
@endsection
