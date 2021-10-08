@if (isset($customerNotlari))
    <div class="card card-primary mb-3" id="not">
        <div class="card-header bg-primary text-white">Müşteri Notları
            <a data-bs-toggle="modal" data-bs-target="#exampleModalNot" class="float-end fw-bold text-white" href="#">Not
                Ekle</a>

        </div>
        <div class="card-body">
            <table id="dataTable" class="table table-striped table-bordered display table-light" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Tarihi</th>
                        <th class="text-center">Saati</th>
                        <th class="text-center">Kayıt Yapan</th>
                        <th class="text-center">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerNotlari as $not)
                        <tr>
                            <td class="text-center">{{ $not->mn_id }}</td>
                            <td class="text-center">{{ date('Y-m-d', strtotime($not->mn_created_at)) }}</td>
                            <td class="text-center">{{ date('H:i:s', strtotime($not->mn_created_at)) }}</td>
                            <td class="text-center">{{ $not->u_name }}</td>
                            <td class="text-center">
                                <button class="border btn btn-sm" onclick="contentLoad('not','{{ $not->mn_id }}')"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal" title="Göster">
                                    <i class="bi bi-image"></i> Göster
                                </button>
                                @if (session('userTypeId') == 1)
                                    <button class="border btn btn-sm" onclick="notSil('{{ $not->mn_id }}')" title="Sil">
                                        <i class="bi bi-x-lg"></i> Sil
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
