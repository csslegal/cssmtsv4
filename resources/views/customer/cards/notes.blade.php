@if (isset($customerNotes))
    <div class="card card-dark mb-3" id="not">
        <div class="card-header bg-dark text-white">Müşteri Notları
            <a data-bs-toggle="modal" data-bs-target="#exampleModalNot" class="float-end fw-bold text-white" href="#">Not
                Ekle</a>

        </div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kayıt Yapan</th>
                        <th>Tarihi</th>
                        <th>Saati</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerNotes as $customerNote)
                        <tr>
                            <td>{{ $customerNote->id }}</td>
                            <td>{{ $customerNote->u_name }}</td>
                            <td>{{ date('Y-m-d', strtotime($customerNote->created_at)) }}</td>
                            <td>{{ date('H:i:s', strtotime($customerNote->created_at)) }}</td>
                            <td>
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
