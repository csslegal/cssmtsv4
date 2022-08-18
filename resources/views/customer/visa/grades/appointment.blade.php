@extends('sablon.genel')

@section('title')
    Parmak İzi Verme
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
            <li class="breadcrumb-item active">Randevusu Alınmış Dosyalar</li>
        </ol>
    </nav>
    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Randevusu Alınmış Dosya İşlemleri</div>
        <div class="card-body scroll">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 ">
                    <div class="card border-success mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Parmak izi verildi mi?</h5>
                            <p>Müşteri dosyası parmak izi verme işlemi tamamlanır</p>
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="tamam" value="tamam">
                                <button type="submit" class="btn btn-success float-end text-white"
                                    onClick="this.form.submit(); this.disabled=true;">Tamamla</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 ">
                    <div class="card border-info mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Randevu ertelendi mi?</h5>
                            <p>Müşteri dosyası "Başvuru bekleyen dosyalar" aşamasına alınır</p>
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="ertele" value="ertele">
                                <button type="submit" class="btn btn-info float-end text-white"
                                    onClick="this.form.submit(); this.disabled=true;">Ertele</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
