@extends('sablon.genel')

@section('title')
    İade Bilgileri Onayı
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
            <li class="breadcrumb-item active">İade Bilgileri Onayı</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">İade Bilgileri</div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-striped table-bordered display table-light " style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlıklar</th>
                        <th>Onay</th>
                        <th>İşlem Yapan</th>
                        <th>Toplam(TL)</th>
                        <th>Detaylar</th>
                        <th>Ödeme Şekli</th>
                        <th>Ödeme Tarihi</th>
                        <th>İşlem Tarihi</th>
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
                                {{ $refundPayment->refund_euro != '' ? $refundPayment->refund_euro . '$' : '' }}
                                {{ $refundPayment->refund_dolar != '' ? $refundPayment->refund_dolar . '£' : '' }}
                                {{ $refundPayment->refund_pound != '' ? $refundPayment->refund_pound . '€' : '' }}
                            </td>
                            <td>{{ $refundPayment->payment_date }}</td>
                            <td>{{ $refundPayment->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="btn-group" role="group" aria-label="Basic example">
                <form method="POST" action="iade-bilgileri-onayi/0">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button class="btn btn-danger text-white m-2 confirm" data-content="Devam edilsin mi?" type="submit">
                        İptal Et </button>
                </form>
                <form method="POST" action="iade-bilgileri-onayi/1">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <button class="btn btn-success text-white m-2" type="submit"
                        onClick="this.form.submit(); this.disabled=true;"> Onayla </button>
                </form>
            </div>
        </div>
    </div>
@endsection
