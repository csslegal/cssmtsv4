@if (in_array(1, $userAccesses))

    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Randevu Takvimi</div>
        <div class="card-body scroll">
            <div id='calendar'></div>
        </div>
    </div>

    @foreach ($visaGradesAccesses as $visaGradesAccess)
        <div class="card card-dark mb-3">
            <div class="card-header bg-dark text-white">{{ $visaGradesAccess->name }}</div>
            <div class="card-body scroll">
                <table id="dataTableVize{{ $visaGradesAccess->id }}" class="table table-striped table-bordered display"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Müşteri Adı</th>
                            <th>Danışman</th>
                            <!--<th>Başvuru Ofisi</th>-->
                            <th>Durumu</th>
                            <th>Vize Tipi</th>
                            <th>Vize Süresi</th>
                            <th>Dosya Aşaması</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visaCustomers as $visaCustomer)
                            @if ($visaCustomer->visa_file_grades_id == $visaGradesAccess->id)
                                <tr class="{{ $visaCustomer->status ? 'text-success' : '' }}">
                                    <td> <a
                                            href="/musteri/{{ $visaCustomer->id }}/vize">{{ $visaCustomer->visa_file_id }}</a>
                                    </td>
                                    <td>
                                        <a href="/musteri/{{ $visaCustomer->id }}/vize">{{ $visaCustomer->name }}</a>
                                    </td>
                                    <td>{{ $visaCustomer->u_name }}</td>
                                    <!--<td>{{ $visaCustomer->application_office_name }}</td>-->
                                    <td>
                                        @if ($visaCustomer->status)
                                            <span>Acil Dosya</span>
                                        @else
                                            <span>Normal Dosya</span>
                                        @endif
                                    </td>
                                    <td>{{ $visaCustomer->visa_type_name }}</td>
                                    <td>{{ $visaCustomer->visa_validity_name }}</td>
                                    <td>{{ $visaCustomer->visa_file_grades_name }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endif
