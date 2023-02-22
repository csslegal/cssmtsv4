@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/api-panels">API Paneller</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/api-panels/{{$webPanel->id}}">{{$webPanel->name}} API Paneli</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ana Yazılar</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Ana Yazılar
            <a class="float-end text-white" href="articles/create">Ekle</a>
        </div>
        <div class="card-body scroll">
            <table id="dataTable" class="table  table-light table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Resim</th>
                        <th>Başlık</th>
                        <th>Hit</th>
                        <th>E. Tarih</th>
                        <th>G. Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $result)
                        <tr>
                            <td>{{ $result->id }}</td>
                            <td class="w-25"><img class="img-fluid img-thumbnail" src="{{ $result->image }}" alt="..."></td>
                            <td>{{ $result->title }}</td>
                            <td>{{ $result->hit }}</td>
                            <td>{{ date('Y-m-d', strtotime($result->created_at)) }}</td>
                            <td>{{ date('Y-m-d', strtotime($result->updated_at)) }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="articles/{{ $result->id }}/edit">
                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle">
                                            <i class="bi bi-pencil-square "></i>
                                        </button>
                                    </a>
                                    <form action="articles/{{ $result->id }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Sil">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
