@extends('sablon.genel')

@section('title')
    Dosya Açma Onayı İşlemi Bekleyen
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">Dosya Açma Onayı İşlemi Bekleyen</li>
        </ol>
    </nav>
    <div class="card card-danger mb-3">
        <div class="card-header bg-danger text-white">Dosya Açma Onayı İşlemleri</div>
        <div class="card-body scroll">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 ">
                    <div class="card border-dark mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Onayla</h5>
                            <p>Onaylandığında "Evrak Bekleyen Dosyalar" aşamasına geçilecektir.</p>
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="tamam" value="tamam">
                                <button type="submit" class="w-100 mt-2 btn btn-secondary float-end text-white"
                                    onClick="this.form.submit(); this.disabled=true;">Onayla</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 ">
                    <div class="card border-dark mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Ret Et</h5>
                            <p>Ret edildiğinde bu dosya ile ilgili bütün kayıtlar silinecektir.</p>
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="iptal" value="iptal">
                                <button type="submit" class="w-100 mt-2 btn btn-secondary float-end text-white"
                                    onClick="this.form.submit(); this.disabled=true;">Ret Et</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection
