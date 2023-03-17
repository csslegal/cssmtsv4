@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web/api-panels">API Paneller</a></li>
            <li class="breadcrumb-item">
                <a href="/yonetim/web/api-panels/{{ $webPanel->id }}">{{ $webPanel->name }} API Paneli</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="/yonetim/web/api-panels/{{ $webPanel->id }}/articles">Ana Yazılar</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/web/api-panels/{{ $webPanel->id }}/articles">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Başlık</label>
                    <input type="text" value="{{ old('title') }}" name="title" class="form-control">
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Açıklama</label>
                    <input type="text" value="{{ old('description') }}" name="description" class="form-control">
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Resim Url</label>
                    <input type="text" value="{{ old('image') }}" name="image" class="form-control">
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">İçerik</label>
                    <textarea id="myeditorinstance" name="content" rows="20" class="form-control"></textarea>
                    @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button class="w-100 mt-3 btn btn-secondary text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance',
            height : "640",
            entity_encoding: 'raw',
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor visualblocks fullscreen insertdatetime media table paste wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic forecolor backcolor | image media | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        });
    </script>
@endsection
