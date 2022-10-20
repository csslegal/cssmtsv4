<div class="card card-danger mb-3">
    <div class="card-header bg-danger text-white">Cari Dosya Geçmişi</div>

    <div class="card-body scroll">
        <span class="text-red fw-bold">İşlemler</span>
        <ol>
            @foreach ($visaFileGradesLogs as $visaFileGradesLog)
                <li class="mt-1">
                    <span class="fw-bold">{{ $visaFileGradesLog->subject }}</span>,
                    <span> "{{ $visaFileGradesLog->user_name }}" tarafından {{ $visaFileGradesLog->created_at }}'de
                        yapıldı.
                    </span>
                    <span>
                        <button class="btn btn-sm btn-dark" onclick="goster('{{ $visaFileGradesLog->id }}')"
                            title="İçeriği göster" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class=" bi bi-file-image"></i> Detay
                        </button>
                    </span>
                    @if ($loop->last && $visaFileGradesPermitted['permitted'])
                        <span>
                            <a href="vize/{{ $visaFileDetail->id }}/{{ $visaFileGradesPermitted['grades_url'] }}"
                                class="btn btn-sm btn-dark confirm" data-title="Dikkat!"
                                data-content="{{ $visaFileGradesPermitted['grades_name'] }} aşamasına yönlendirilsin mi?">Sonraki
                                aşama <i class=" bi bi-caret-right"></i></a>
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>
