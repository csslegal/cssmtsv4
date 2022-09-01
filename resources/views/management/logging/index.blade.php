@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sistem Logları</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card card-dark">
                <div class="card-header bg-dark text-white fw-bold">Dizindeki Loglar</div>
                <div class="card-body">
                    <ul>
                        @foreach ($logFiles as $logFile)
                            <li><a href="/yonetim/logging/{{ $logFile }}">{{ $logFile }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 mb-4">
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
                                        <td class="text-wrap" style="width: 100%;">
                                            {{ $fileLog['content'] }}
                                        </td>
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
