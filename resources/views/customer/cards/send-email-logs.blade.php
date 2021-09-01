@if (isset($customerEmailLogs))
    <div class="card card-primary  mb-3" id="email">
        <div class="card-header bg-primary text-white">Müşteri Gönderilen E-mailler</div>
        <div class="card-body">
            <table id="dataTable" class="table table-striped table-bordered display table-light" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Tarihi</th>
                        <th class="text-center">Gönderen</th>
                        <th class="text-center">Erişim</th>
                        <th class="text-center">Konu</th>
                        <th class="text-center">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerEmailLogs as $customerEmailLog)
                        <tr>
                            <td class="text-center">
                                {{ date('Y-m-d H:i:s', strtotime($customerEmailLog->created_at)) }}
                            </td>
                            <td class="text-center">
                                {{ $customerEmailLog->u_name }}
                            </td>
                            <td class="text-center">
                                {{ $customerEmailLog->a_name }}
                            </td>
                            <td class="text-center">
                                {{ $customerEmailLog->subject }}
                            </td>
                            <td class="text-center">
                                <button class="border btn" onclick="contentLoad('email','{{ $customerEmailLog->id }}')"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal" title="Göster">
                                    <i class="bi bi-image"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endif
