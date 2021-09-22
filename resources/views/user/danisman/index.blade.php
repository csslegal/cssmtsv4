@extends('sablon.genel')
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item active" aria-current="page">Kullanıcı İşlemleri</li>
        </ol>
    </nav>

    @include('user.hosgeldin')

    @if (in_array(1, $userAccesses))
        <div class="card card-primary mb-3">
            <div class="card-header bg-primary text-white">Vize Dosyası İşlemi Bekleyen Müşteriler</div>
            <div class="card-body scroll">
                <table id="dataTableVize" class="table table-striped table-bordered display table-light" style="width:100%">
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
                                    <a href="/musteri/{{ $visaCustomer->id }}">{{ $visaCustomer->visa_file_id }}</a>
                                </td>
                                <td>{{ $visaCustomer->name }}</td>
                                <td>
                                    @if ($visaCustomer->status)
                                        <span>Acil Dosya</span>
                                    @else
                                        <span>Normal Dosya</span>
                                    @endif
                                </td>
                                <td>{{ $visaCustomer->visa_type_name }} / {{ $visaCustomer->visa_sub_type_name }}</td>
                                <td>{{ $visaCustomer->visa_validity_name }}</td>
                                <td>{{ $visaCustomer->visa_file_grades_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    @if (in_array(2, $userAccesses))
        <div class="card card-primary mb-3">
            <div class="card-header bg-primary text-white">Harici Tercüme Dosyası İşlemi Bekleyen Müşteriler</div>
            <div class="card-body scroll">
                <table id="dataTableHarici" class=" table table-striped table-bordered display table-light"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="col-md-1">ID</th>
                            <th class="col-md-2">Müşteri Adı</th>
                            <th class="col-md-3">Vize Tipi</th>
                            <th class="col-md-2">Vize Süresi</th>
                            <th class="col-md-4">Dosya Durumu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a class="text-danger fw-bold" href="/musteri/1">12321</a></td>
                            <td>System Architect</td>
                            <td>Yerleşim Vizeleri </td>
                            <td>6 Ay</td>
                            <td>Müşteri Ödemesi bekleniyor</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    @if (in_array(3, $userAccesses))
        <div class="card card-primary mb-3">
            <div class="card-header bg-primary text-white">Dil Okulu Dosyası İşlemi Bekleyen Müşteriler</div>
            <div class="card-body scroll">
                <table id="dataTableDilOkulu" class=" table table-striped table-bordered display table-light"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="col-md-1">ID</th>
                            <th class="col-md-2">Müşteri Adı</th>
                            <th class="col-md-3">Vize Tipi</th>
                            <th class="col-md-2">Vize Süresi</th>
                            <th class="col-md-4">Dosya Durumu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a class="text-danger fw-bold" href="/musteri/1">12321</a></td>
                            <td>System Architect</td>
                            <td>Yerleşim Vizeleri </td>
                            <td>6 Ay</td>
                            <td>Müşteri Ödemesi bekleniyor</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
