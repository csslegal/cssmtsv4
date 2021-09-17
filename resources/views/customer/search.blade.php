@extends('sablon.genel')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item active">Müşteri Sorgula</li>
        </ol>
    </nav>

    <div class="row justify-content-md-center offset-md-2 col-md-8 mt-5">
        <form action="/musteri/sorgula" method="POST">

            <div class="input-group input-group-lg mt-5 mb-4">
                <input type="text" class="form-control" name="arama" autocomplete="off" value="{{ isset($arama) ? $arama : '' }}"
                    placeholder="Kayıt sorgula" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true"
                    title="Sorgulama Kriterleri <li>İsim Soyisim</li><li>E-Mail</li><li>Telefon</li><li>T.C. No</li><li> Pasaport No</li><li>Dosya Ref. No</li>">
                {{ csrf_field() }}
                <button class="btn btn-primary" type="submit">Ara</button>
            </div>
        </form>
    </div>

    @if (isset($customerDetaylari))
        <div class="col-md-12 mt-5 mb-3">
            <div class="card card-primary">
                <div class="card-header bg-primary text-white">Bulunan Sonuçlar</div>
                <div class="card-body">
                    <table id="dataTable" class=" table table-striped table-bordered display table-light"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Adı</th>
                                <th class="text-center">Telefon</th>
                                <th class="text-center">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customerDetaylari as $musteriDetay)
                                <tr>
                                    <td class="text-center"><a class="text-decoration-none"
                                            href="/musteri/{{ $musteriDetay->m_id }}"
                                            class="">{{ $musteriDetay->m_id }}</a></td>
                                    <td class="text-center"><a class="text-decoration-none"
                                            href="/musteri/{{ $musteriDetay->m_id }}"
                                            class="">{{ $musteriDetay->name }}</a></td>
                                    <td class="text-center"><a class="text-decoration-none"
                                            href="/musteri/{{ $musteriDetay->m_id }}"
                                            class="">{{ $musteriDetay->telefon }}</a></td>
                                    <td class="text-center"><a class="text-decoration-none"
                                            href="/musteri/{{ $musteriDetay->m_id }}"
                                            class="">{{ $musteriDetay->email }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
