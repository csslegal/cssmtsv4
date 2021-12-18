@extends('sablon.genel')

@section('title') Parmak İzi Verme @endsection

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
            <li class="breadcrumb-item active">Parmak İzi Verme</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Bütün İşlemler</div>
        <div class="card-body scroll">

            <form action="" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 ">
                        <div class="card border-success mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Parmak izi verildi mi?</h5>
                                <p>&nbsp;</p>
                                <button type="submit" name="tamam" value="tamam"
                                    class="confirm btn btn-success float-end text-white" data-title="Dikkat!"
                                    data-content="Devam edilsin mi?">Tamamla</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 ">
                        <div class="card border-info mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Randevu ertelendi mi?</h5>
                                <p>&nbsp;</p>
                                <button type="submit" class="btn btn-info float-end text-white confirm" name="ertele"
                                    value="ertele" data-title="Dikkat!" data-content="Ertelensin mi?">Ertele</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 ">
                        <div class="card border-danger mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Randevu iptal mi?</h5>
                                <p>&nbsp;</p>
                                <button name="iptal" value="iptal" type="submit"
                                    class="btn btn-danger float-end text-white confirm" data-title="Dikkat!"
                                    data-content="İptal edilsin mi?">İptal Et</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
