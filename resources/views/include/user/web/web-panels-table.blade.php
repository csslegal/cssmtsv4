@if (in_array(4, $userAccesses))
    <div class="card card-danger mb-3">
        <div class="card-header bg-danger text-white fw-bold">Web Panelleri İşlemleri</div>
        <div class="card-body scroll">
            <table id="dataTable" class=" table  table-light table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center fw-bold">Yetki Seviyesi</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Bitiş Tarihi</th>
                        <th>Eklenme Tarihi</th>
                        <th>Güncelleme Tarihi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($webResults as $result)
                        <tr>
                            @if ($panelsTimeAccess)
                                <td class="text-center fw-bold"><a href="kullanici/web">@if ($result->access) Full Erişim @else Temel Erişim @endif</a></td>
                            @else
                                <td class="text-center fw-bold">@if ($result->access) Full Erişim @else Temel Erişim @endif </td>
                            @endif
                            <td>{{ $result->start_time }}</td>
                            <td>{{ $result->and_time }}</td>
                            <td>{{ $result->created_at }}</td>
                            <td>{{ $result->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
