@extends('sablon.yonetim')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
                    <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Koordinatör</li>
                </ol>
            </nav>
            @include('include.management.visa.nav')

            <div class="card card-primary mb-3">
                <div class="card-header bg-primary text-white">Müşteri Temel Bilgileri Güncelleme İstekleri</div>
                <div class="card-body scroll">

                    <table id="dataTable" class=" table table-striped table-bordered display table-light"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Müşteri Adı</th>
                                <th>İstek Yapan</th>
                                <th>Durumu</th>
                                <th>İstek Tarihi</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($musteriTemelBilgileriGuncellemeIstekleri as $mTBGI)
                                <tr>
                                    <td>
                                        <a class="fw-bold" href="/musteri/{{ $mTBGI->m_id }}">
                                            {{ $mTBGI->m_id }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="fw-bold" href="/musteri/{{ $mTBGI->m_id }}">
                                            {{ $mTBGI->m_name }}
                                        </a>
                                    </td>
                                    <td>{{ $mTBGI->u_name }} </td>
                                    <td>
                                        @if ($mTBGI->onay == 0)
                                            <span class="fw-bold text-danger">Onaysız</span>
                                        @else
                                            <span class="fw-bold text-success">Onaylı</span>
                                        @endif
                                    </td>
                                    <td>{{ $mTBGI->tarih }}</td>
                                    <td>
                                        @if ($mTBGI->onay == 0)
                                            <a class="btn btn-primary btn-sm text-white fw-bold"
                                                href="/yonetim/mTBGI/{{ $mTBGI->mg_id }}/onay">
                                                Onay Ver
                                            </a>
                                        @else
                                            <a class="btn btn-danger btn-sm text-white fw-bold"
                                                href="/yonetim/mTBGI/{{ $mTBGI->mg_id }}/geri-al">
                                                Geri Al
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Müşteri Adı</th>
                                <th>İstek Yapan</th>
                                <th>Durumu</th>
                                <th>İstek Tarihi</th>
                                <th>İşlemler</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
