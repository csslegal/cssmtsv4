@extends('sablon.genel')

@section('title') Müşteri Sorgula @endsection

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
        <form action="" method="POST">
            <div class="input-group input-group-lg mt-5 mb-4">
                <input type="text" class="form-control" name="arama" autocomplete="off"
                    value="{{ isset($arama) ? $arama : '' }}" placeholder="Kayıt sorgula" data-bs-toggle="tooltip"
                    data-bs-placement="bottom" data-bs-html="true"
                    title="Sorgulama Kriterleri <li>İsim Soyisim</li><li>E-Mail</li><li>Telefon</li><li>T.C. No</li><li> Pasaport No</li><li>Dosya Ref. No</li>">
                {{ csrf_field() }}
                <button class="btn btn-primary" type="submit">Ara</button>
            </div>
        </form>
    </div>
    @if (isset($customerDetails))
        <div class="col-md-12 mt-5 mb-3">
            <div class="card card-primary">
                <div class="card-header bg-primary text-white">Bulunan Sonuçlar</div>
                <div class="card-body  scroll">
                    <table id="dataTable" class=" table table-striped table-bordered display table-light"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Adı</th>
                                <th class="text-center">Telefon</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Dosya Ref No</th>
                                <th class="text-center">Dosya Durumu</th>
                                <th class="text-center">Danışman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customerDetails as $customerDetail)
                                <tr>
                                    <td class="text-center">
                                        <a class="text-decoration-none"
                                            href="/musteri/{{ $customerDetail->id }}">{{ $customerDetail->id }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a class="text-decoration-none"
                                            href="/musteri/{{ $customerDetail->id }}">{{ $customerDetail->name }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a class="text-decoration-none"
                                            href="/musteri/{{ $customerDetail->id }}">{{ $customerDetail->telefon }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a class="text-decoration-none"
                                            href="/musteri/{{ $customerDetail->id }}">{{ $customerDetail->email }}</a>
                                    </td>
                                    <td class="text-center">
                                        @if ($customerDetail->visa_file_id == null)
                                            <span class="text-danger"> Veri bulunamadı</span>
                                        @else
                                            <a class="text-decoration-none"
                                                href="/musteri/{{ $customerDetail->id }}/vize">{{ $customerDetail->visa_file_id }}</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($customerDetail->active == '1')
                                            <span class="text-success">Cari Dosya</span>
                                        @elseif ($customerDetail->active=="0")
                                            <span class="text-info">Arşiv Dosya</span>
                                        @elseif ($customerDetail->active == null)
                                            <span class="text-danger">Veri bulunmadı</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($customerDetail->visa_file_id == null)
                                            <span class="text-danger"> Veri bulunamadı</span>
                                        @else
                                            <a class="text-decoration-none"
                                                href="/musteri/{{ $customerDetail->id }}">{{ $customerDetail->user_name }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
