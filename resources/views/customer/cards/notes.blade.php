@if (isset($customerNotes))
    <div class="card card-danger mb-3">
        <div class="card-header bg-danger text-white" id="notes">Müşteri Notları</div>
        <div class="card-body scroll">
            <div class="row">
                <div class="col-12">
                    <form action="/musteri/{{ $baseCustomerDetails->id }}/notes" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Not Yaz</label>
                            <textarea id="editor200" name="note" rows="20" class="form-control">{!! old('not') !!}</textarea>
                            @error('note')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-100 mb-2 btn btn-dark text-white confirm{{ session('userTypeId') == 1 ? 1 : '' }}"
                            data-title="Dikkat!" data-content="Müşteri notu kaydedilsin mi?">Kaydet</button>
                    </form>
                </div>
                <div class="w-100 mb-1">
                    <hr>
                </div>
                <div class="col-12">
                    <div class="card card-danger mb-3">
                        <div class="card-header bg-danger text-white">Alınan Notlar</div>
                        <div class="card-body">
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
                                                <div class="btn-group">
                                                    <button
                                                        class="btn btn-dark btn-sm"onclick="contentLoad('not','{{ $customerNote->id }}')"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal">Notu Göster</button>
                                                    @if (session('userTypeId') == 1)
                                                        <form method="post"
                                                            action="/musteri/{{ $baseCustomerDetails->id }}/notes/{{ $customerNote->id }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button class="btn btn-danger btn-sm confirm2"
                                                                data-title="Dikkat!"
                                                                data-content="Müşteri notu silinsin mi? İşlem geri alınamaz...">Sil</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
