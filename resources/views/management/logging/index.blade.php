@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sistem Logları</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card card-dark">
                <div class="card-header bg-dark text-white fw-bold">Dizindeki Loglar</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($logFiles as $logFile)
                            <li class="list-group-item">
                                <a href="/yonetim/logging/{{ $logFile }}">{{ $logFile }}</a>
                                <span class="badge">
                                    <form action="/yonetim/logging/{{ $logFile }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="bg-light text-dark confirm" data-title="Log silinsin mi?" type="submit">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-sm justify-content-center">
                            @if ($pages['totalContentCount'] > $pages['showContentCount'])
                                <!---->
                                @if ($pages['page'] > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="?page={{ $pages['page'] - 1 }}">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif

                                <!---->
                                @if ($pages['page'] == 1)
                                    <li class="page-item">
                                        <a class="page-link active" href="?page=1">1</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="?page=1">1</a>
                                    </li>
                                @endif

                                <!---->
                                @if ($pages['page'] - $pages['shortSize'] > 2)
                                    {{ '..' }}
                                    @php $i = $pages['page'] -  $pages['shortSize']; @endphp
                                @else
                                    @php $i = 2; @endphp
                                @endif

                                <!---->
                                @for ($i; $i <= $pages['page'] + $pages['shortSize']; $i++)
                                    @if ($i == $pages['page'])
                                        <li class="page-item">
                                            <a class="page-link active"
                                                href="?page={{ $i }}">{{ $i }}</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                        </li>
                                    @endif

                                    @if ($i == $pages['endPage'])
                                        @php break; @endphp
                                    @endif
                                @endfor

                                <!---->
                                @if ($pages['page'] + $pages['shortSize'] < $pages['endPage'] - 1)
                                    {{ '..' }}
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="?page={{ $pages['endPage'] }}">{{ $pages['endPage'] }}</a>
                                    </li>
                                @elseif ($pages['page'] + $pages['shortSize'] == $pages['endPage'] - 1)
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="?page={{ $pages['endPage'] }}">{{ $pages['endPage'] }}</a>
                                    </li>
                                @endif

                                <!---->
                                @if ($pages['page'] < $pages['endPage'])
                                    <li class="page-item">
                                        <a class="page-link" href="?page={{ $pages['page'] + 1 }}">
                                            <span aria-hidden="true">&raquo;</span></a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-md-9 mb-3">
            <div class="card card-dark">
                <div class="card-header bg-dark text-white fw-bold">Log Detayları</div>
                <div class="card-body">
                    @if (count($fileLogs) > 0)
                        <table id="dataTableVize" class="table table-striped table-bordered display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>İçerik</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fileLogs as $fileLog)
                                    @php
                                    @endphp
                                    <tr>
                                        <td>{{ $fileLog['line'] }}</td>
                                        <td class="text-wrap" style="width: 100%;">{{ $fileLog['content'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif (count($fileLogs) == 0)
                        Dosya seçimi yapılmadı.
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
