@if (in_array(1, $userAccesses))
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white fw-bold">Vize Dosyası İşlemi Bekleyen Müşteriler</div>
        <div class="card-body scroll">
            <table id="dataTableVize" class="table table-striped table-bordered display table-light" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Müşteri Adı</th>
                        <th>Danışman</th>
                        <th>Durumu</th>
                        <th>Vize Tipi</th>
                        <th>Vize Süresi</th>
                        <th>Dosya Aşaması</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visaCustomers as $visaCustomer)
                        <tr class="{{ $visaCustomer->status ? 'text-success' : '' }}">
                            <td><a
                                    href="/musteri/{{ $visaCustomer->id }}/vize">{{ $visaCustomer->visa_file_id }}</a>
                            </td>
                            <td>{{ $visaCustomer->name }}</td>
                            <td>{{ $visaCustomer->u_name }}</td>
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
