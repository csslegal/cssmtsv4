@if (isset($baseCustomerDetails))
    <div class="card card-danger mb-3" id="temel">
        <div class="card-header bg-danger text-white">Müşteri Bilgileri
            <div class="dropdown float-end">
                <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Müşteri İşlemleri
                </a>
                <ul class="dropdown-menu">
                    @if (session('userTypeId') == 1 || session('userTypeId') == 2)
                        <li>
                            <a class="dropdown-item" href="/musteri/{{ $baseCustomerDetails->id }}/edit">
                                Bilgi Güncelleme
                            </a>
                        </li>
                    @endif
                    @if (session('userTypeId') == 1)
                        <li>
                            <a class="dropdown-item" href="/musteri/{{ $baseCustomerDetails->id }}/logs">
                                Log Gösterme
                            </a>
                        </li>
                        <li>
                            <form action="/musteri/{{ $baseCustomerDetails->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="dropdown-item confirm" data-title="Dikkat!"
                                    data-content="Müşteri hesabı silinsin mi? İşlem geri alınamaz...">
                                    Hesap Silme
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="card-body scroll">
            <div class="row">
                <div class="col-sm-6 border-bottom border-end">
                    <p class="fw-bold">Adı</p>
                    <p class="text-muted">{{ $baseCustomerDetails->name }}</p>
                </div>
                <div class="col-sm-6 mt-4 mt-sm-0 border-bottom">
                    <p class="fw-bold">Telefonu</p>
                    <p class="text-muted">{{ $baseCustomerDetails->phone }}</p>
                </div>
                <div class="col-sm-6 pt-2 border-bottom border-end">
                    <p class="fw-bold">E-postası</p>
                    <p class="text-muted">{{ $baseCustomerDetails->email }}</p>
                </div>
                <div class="col-sm-6 pt-2 border-bottom">
                    <p class="fw-bold">Adresi</p>
                    <p class="text-muted">
                        {{ $baseCustomerDetails->address != null ? $baseCustomerDetails->address : 'Kayıt bilgisi yok' }}
                    </p>
                </div>
                <div class="col-sm-6 pt-2 border-bottom border-end">
                    <p class="fw-bold">T.C. Kimlik No</p>
                    <p class="text-muted">
                        {{ $baseCustomerDetails->tc_number != null ? $baseCustomerDetails->tc_number : 'Kayıt bilgisi yok' }}
                    </p>
                </div>
                <div class="col-sm-6 pt-2 border-bottom">
                    <p class="fw-bold">Pasaport Numarası</p>
                    <p class="text-muted">
                        {{ $baseCustomerDetails->passport != null ? $baseCustomerDetails->passport : 'Kayıt bilgisi yok' }}
                    </p>
                </div>
                <div class="col-sm-6 pt-2 border-end">
                    <p class="fw-bold">Pasaport Tarihi</p>
                    <p class="text-muted">
                        {{ $baseCustomerDetails->passport_date != null ? $baseCustomerDetails->passport_date : 'Kayıt bilgisi yok' }}
                    </p>
                </div>
                <div class="col-sm-6 pt-2">
                    <p class="fw-bold">E-posta Onayı</p>
                    <p class="text-muted">
                        {{ $baseCustomerDetails->information_confirm == 1 ? 'Onaylı' : 'Onaysız' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
