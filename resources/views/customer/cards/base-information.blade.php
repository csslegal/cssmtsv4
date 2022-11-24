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
                <div class="col-md-6">
                    <ul>
                        <li><span class="fw-bold">Müşteri Adı: </span> {{ $baseCustomerDetails->name }}</li>
                        <li><span class="fw-bold">Telefon: </span> {{ $baseCustomerDetails->phone }}</li>
                        <li><span class="fw-bold">E-posta: </span> {{ $baseCustomerDetails->email }}</li>
                        <li><span class="fw-bold">E-posta Onayı: </span>
                            {{ $baseCustomerDetails->information_confirm == 1 ? 'Gönderme Onaylı' : 'Gönderme Onaysız' }}
                        </li>

                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li><span class="fw-bold">Müşteri Adresi: </span>
                            {{ $baseCustomerDetails->address != null ? $baseCustomerDetails->address : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">T.C. Kimlik No: </span>
                            {{ $baseCustomerDetails->tc_number != null ? $baseCustomerDetails->tc_number : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Pasaport Numarası: </span>
                            {{ $baseCustomerDetails->passport != null ? $baseCustomerDetails->passport : 'Kayıt bilgisi yok' }}
                        </li>
                        <li><span class="fw-bold">Pasaport Tarihi: </span>
                            {{ $baseCustomerDetails->passport_date != null ? $baseCustomerDetails->passport_date : 'Kayıt bilgisi yok' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
