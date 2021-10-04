<div class="card card-primary mb-3">
    <div class="card-header bg-danger text-white">Cari Dosya Geçmişi</div>

    <div class="card-body scroll">
        <span class="text-red fw-bold">İşlemler</span>
        <ol reversed>
            @foreach ($visaFileGradesLogs as $visaFileGradesLog)
                <li class="mt-1">
                    <span class="fw-bold">{{ $visaFileGradesLog->subject }}</span>,
                    <span> "{{ $visaFileGradesLog->user_name }}" tarafından {{ $visaFileGradesLog->created_at }}'de
                        yapıldı.
                    </span>
                    <span>
                        <button class="btn btn-sm text-dark border" onclick="goster('{{ $visaFileGradesLog->id }}')"
                            title="İçeriği göster" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class=" bi bi-file-image"></i> Detay
                        </button>
                    </span>
                    @if ($loop->first && $visaFileGradesPermitted['permitted'])
                        <span>
                            <a href="vize/{{ $visaFileDetail->id }}/{{ $visaFileGradesPermitted['grades_url'] }}"
                                class="confirm btn btn-sm btn-danger text-white" data-title="Devam edilsin mi?">Sonraki
                                işleme git</a>
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>
