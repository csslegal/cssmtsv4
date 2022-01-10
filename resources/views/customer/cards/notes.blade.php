@if (isset($customerNotes))
    <div class="card card-primary mb-3" id="not">
        <div class="card-header bg-primary text-white">Müşteri Notları
            <a data-bs-toggle="modal" data-bs-target="#exampleModalNot" class="float-end fw-bold text-white" href="#">Not
                Ekle</a>

        </div>
        <div class="card-body scroll">
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
                    @foreach ($customerNotes as $customerNote)
                        <tr>
                            <td class="text-center">{{ $customerNote->id }}</td>
                            <td class="text-center">{{ date('Y-m-d', strtotime($customerNote->created_at)) }}</td>
                            <td class="text-center">{{ date('H:i:s', strtotime($customerNote->created_at)) }}</td>
                            <td class="text-center">{{ $customerNote->u_name }}</td>
                            <td class="text-center">
                                <button class="border btn btn-sm"
                                    onclick="contentLoad('not','{{ $customerNote->id }}')" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" title="Göster">
                                    <i class="bi bi-image"></i> Göster
                                </button>
                                @if (session('userTypeId') == 1)
                                    <button class="border btn btn-sm" onclick="notSil('{{ $customerNote->id }}')"
                                        title="Sil">
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
