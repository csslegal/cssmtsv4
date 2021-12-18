@extends('sablon.genel')

@section('title') Dosya Kapatma Onayı @endsection

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
            <li class="breadcrumb-item active">Dosya Kapatma Onayı</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">İşlemler</div>
        <div class="card-body scroll">

            <form action="" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6 ">
                        <div class="card border-success mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Dosya kapatma isteğini onayla!</h5>
                                <p>&nbsp;</p>
                                <button type="submit" name="onayla" value="onayla"
                                    class="confirm btn btn-success float-end text-white" data-title="Dikkat!"
                                    data-content="Devam edilsin mi?">Tamamla</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 ">
                        <div class="card border-danger mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Dosya kapatma isteğini reddet!</h5>
                                <p>&nbsp;</p>
                                <button type="submit" name="reddet" value="reddet"
                                    class="confirm btn btn-danger float-end text-white" data-title="Dikkat!"
                                    data-content="Devam edilsin mi?">Tamamla</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
