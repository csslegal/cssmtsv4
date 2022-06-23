@if (isset($customerVisaLogs))
    <div class="card card-primary  mb-3" id="visa">
        <div class="card-header bg-primary text-white">Müşteri Vize Dosyası Logları</div>
        <div class="card-body scroll">
            <table id="dataTableVize" class="table table-striped table-bordered display table-light" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">İşlem Tarihi</th>
                        <th class="text-center">İşlem Yapan</th>
                        <th class="text-center">Müşteri Adı</th>
                        <th>Aşama</th>
                        <th class="text-center">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerVisaLogs as $customerVisaLog)
                        <tr>
                            <td class="text-center">
                                {{ date('Y-m-d H:i:s', strtotime($customerVisaLog->created_at)) }}
                            </td>
                            <td class="text-center">
                                {{ $customerVisaLog->u_name }}
                            </td>
                            <td class="text-center"> {{ $customerVisaLog->c_name }} </td>

                            <td>
                                {{ $customerVisaLog->subject }}
                            </td>
                            <td class="text-center">
                                <button class="border btn btn-sm"
                                    onclick="contentLoad('visa','{{ $customerVisaLog->id }}')" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" title="Göster">
                                    <i class="bi bi-image"></i> Göster
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
