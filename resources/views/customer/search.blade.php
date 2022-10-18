@extends('sablon.genel')

@section('title')
    Müşteri Sorgula
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
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
            <div class="input-group input-group-lg mt-5 mb-3">
                <input type="text" autofocus class="form-control" name="arama" autocomplete="off"
                    value="{{ isset($arama) ? $arama : '' }}" placeholder="Kayıt sorgula" data-bs-toggle="tooltip"
                    data-bs-placement="bottom" data-bs-html="true"
                    title="İsim Soyisim, E-Posta, Telefon, T.C. No, Pasaport No ve Dosya Ref. No ile müşteri sorgulaması yapılabilir.">
                {{ csrf_field() }}
                <button class="btn btn-danger border" type="submit">Ara</button>
            </div>
        </form>
    </div>
    @if (isset($customerDetails))

        @if ($customerDetails->count() > 0)
            <div class="col-md-12 mt-5 mb-3">
                <div class="card card-danger">
                    <div class="card-header bg-danger text-white">Bulunan Sonuçlar</div>
                    <div class="card-body scroll">
                        <table id="dataTable" class="table table-striped table-bordered display" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Adı</th>
                                    <th class="text-center">Telefon</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Ref.&nbsp;No</th>
                                    <th class="text-center">Durumu</th>
                                    <th class="text-center">Danışman</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customerDetails as $customerDetail)
                                    <tr>
                                        <td class="text-center">
                                            @if ($customerDetail->active == '1')
                                                <a href="/musteri/{{ $customerDetail->id }}/vize">
                                                    {{ $customerDetail->id }}
                                                </a>
                                            @elseif ($customerDetail->active == '0')
                                                <a href="/musteri/{{ $customerDetail->id }}/vize/arsiv">
                                                    {{ $customerDetail->id }}
                                                </a>
                                            @elseif ($customerDetail->active == null)
                                                <span>Kayıt bulunamadı</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="/musteri/{{ $customerDetail->id }}">{{ $customerDetail->name }}</a>

                                        </td>
                                        <td class="text-center">{{ $customerDetail->phone }}</td>
                                        <td class="text-center">{{ $customerDetail->email }}</td>
                                        <td class="text-center">
                                            @if ($customerDetail->visa_file_id == null)
                                                <span>Kayıt bulunamadı</span>
                                            @else
                                                {{ $customerDetail->visa_file_id }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($customerDetail->active == '1')
                                                <span>Cari Dosya</span>
                                            @elseif ($customerDetail->active == '0')
                                                <span>Arşiv Dosya</span>
                                            @elseif ($customerDetail->active == null)
                                                <span>Kayıt bulunamadı</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($customerDetail->visa_file_id == null)
                                                <span>Kayıt bulunamadı</span>
                                            @else
                                                {{ $customerDetail->user_name }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12 mt-5 mb-3">
                <div class="card card-dark">
                    <div class="card-header bg-dark text-white">Bulunan Sonuçlar</div>
                    <div class="card-body scroll">
                        Sonuç bulunamadı, kayıt sayfasına gitmek için
                        <a class="fw-bold text-danger" href="/musteri/create">tıklayınız</a>
                    </div>
                </div>
            </div>
        @endif

    @endif
@endsection
