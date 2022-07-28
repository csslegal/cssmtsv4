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
            <li class="breadcrumb-item active">Yeniden Alınan Ödemeler Onayı</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Yeniden Alınan Ödemeler</div>
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
                                {{ $receivedPayment->received_euro != '' ? $receivedPayment->received_euro . '$' : '' }}
                                {{ $receivedPayment->received_dolar != '' ? $receivedPayment->received_dolar . '£' : '' }}
                                {{ $receivedPayment->received_pound != '' ? $receivedPayment->received_pound . '€' : '' }}
                            </td>
                            <td>{{ $receivedPayment->payment_date }}</td>
                            <td>{{ $receivedPayment->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="btn-group" role="group" aria-label="Basic example">
                <form method="POST" action="yeniden-alinan-odeme-onay/0">
                    {{ method_field('DELETE') }}
                    @csrf
                    <button class="btn btn-danger text-white m-2 confirm" data-content="Devam edilsin mi?" type="submit">
                        Ödemeleri İptal Et </button>
                </form>
                <form method="POST" action="yeniden-alinan-odeme-onay/1">
                    {{ method_field('PUT') }}
                    @csrf
                    <button class="btn btn-success text-white m-2" type="submit"
                        onClick="this.form.submit(); this.disabled=true;"> Ödemeleri Onayla </button>
                </form>
            </div>
        </div>
    </div>
@endsection
