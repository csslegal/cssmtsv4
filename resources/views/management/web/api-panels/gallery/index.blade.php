@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/api-panels">API Paneller</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/api-panels/{{ $webPanel->id }}">{{ $webPanel->name }} API
                    Paneli</a></li>
            <li class="breadcrumb-item active" aria-current="page">Galeri</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Galeri</div>
        <div class="card-body scroll">

            <form action="/yonetim/web/api-panels/{{ $webPanel->id }}/gallery" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Dosya Seçimi</label>
                    <input class="form-control" type="file" name="image">
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Resim Açıklaması</label>
                    <input class="form-control" type="text" name="alt">
                    @error('alt')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-secondary">Yükle</button>
            </form>
            <hr>
            <table id="dataTable" class="table  table-light table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Görünüm</th>
                        <th>Alt</th>
                        <th>E. Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($images as $result)
                        <tr>
                            <td>{{ $result->id }}</td>
                            <td class="w-25">
                                <a href="/uploads/{{ $webPanel->id }}/{{ $result->name }}" target="_blank">
                                    <img src="/uploads/{{ $webPanel->id }}/{{ $result->name }}"
                                        class="img-fluid img-thumbnail" alt="...">
                                </a>
                            </td>
                            <td>{{ $result->alt }}</td>
                            <td>{{ date('Y-m-d', strtotime($result->updated_at)) }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form action="/yonetim/web/api-panels/{{ $webPanel->id }}/gallery/{{ $result->id }}"
                                        method="post">
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
