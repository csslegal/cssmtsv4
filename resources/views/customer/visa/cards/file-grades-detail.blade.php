<div class="card card-primary mb-3">
    <div class="card-header bg-danger text-white">Cari Dosya Geçmişi</div>

    <div class="card-body scroll">
        <span class="text-red fw-bold">İşlemler</span>
        <ol>
            @foreach ($visaFileGradesLogs as $visaFileGradesLog)
                <li class="mt-1">
                    <span class="fw-bold">{{ $visaFileGradesLog->subject }}</span>,
                    <span> "{{ $visaFileGradesLog->user_name }}" tarafından {{ $visaFileGradesLog->created_at }}
                        tarihinde yapıldı.
                    </span>
                    <span>
                        <button class=" btn btn-primary btn-sm text-white"
                            onclick="goster('{{ $visaFileGradesLog->id }}')" title="İçeriği göster"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class=" bi bi-file-image"></i>
                            Göster
                        </button>
                    </span>
                    @if ($loop->last && $visaFileGradesPermitted)
                        <span class="float-right">
                            <a href="/musteri/{{ $baseCustomerDetails->id }}/vize/"
                                class="confirm btn btn-sm btn-danger text-white" data-bs-toggle="tooltip"
                                data-title="İşlem sayfasına gitmek istiyor musun?">İşlem
                                yap</a>
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>
