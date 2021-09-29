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

                    <table id="dataTable" class=" table table-striped table-bordered display table-light" style="width:100%">
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
                            @foreach ($mTBGIS as $mTBGI)
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
                    </table>
                </div>
            </div>

            <div class="card card-primary mb-3">
                <div class="card-header bg-primary text-white">Vize Dosyası İşlemi Bekleyen Müşteriler</div>
                <div class="card-body scroll">
                    <table id="dataTableVize" class="table table-striped table-bordered display table-light"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Müşteri Adı</th>
                                <th>Durumu</th>
                                <th>Vize Tipi</th>
                                <th>Vize Süresi</th>
                                <th>Dosya Aşaması</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visaCustomers as $visaCustomer)
                                <tr class="{{ $visaCustomer->status ? 'text-success' : '' }}">
                                    <td>
                                        <a
                                            href="/musteri/{{ $visaCustomer->id }}/vize">{{ $visaCustomer->visa_file_id }}</a>
                                    </td>
                                    <td>{{ $visaCustomer->name }}</td>
                                    <td>
                                        @if ($visaCustomer->status)
                                            <span>Acil Dosya</span>
                                        @else
                                            <span>Normal Dosya</span>
                                        @endif
                                    </td>
                                    <td>{{ $visaCustomer->visa_type_name }} / {{ $visaCustomer->visa_sub_type_name }}
                                    </td>
                                    <td>{{ $visaCustomer->visa_validity_name }}</td>
                                    <td>{{ $visaCustomer->visa_file_grades_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
