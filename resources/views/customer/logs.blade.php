@extends('sablon.genel')

@section('title') Müşteri Logları @endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a>
            </li>
            <li class="breadcrumb-item active">Müşteri Logları</li>
        </ol>
    </nav>
    <div class="card card-dark">
        <div class="card-header bg-dark text-white">Müşteri Logları</div>
        <div class="card-body  scroll">
            <table id="dataTable" class=" table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">İşlem Adı</th>
                        <th class="text-center">Önceki</th>
                        <th class="text-center">Sonraki</th>
                        <th class="text-center">İşlem Yapan</th>
                        <th class="text-center">İşlem Tarihi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerLogs as $customerLog)
                        <tr>
                            <td>{{ $customerLog->id }}</td>
                            <td>{{ $customerLog->operation_name }}</td>
                            <td>{{ $customerLog->before }}</td>
                            <td>{{ $customerLog->after }}</td>
                            <td>{{ $customerLog->u_name }}</td>
                            <td>{{ $customerLog->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
