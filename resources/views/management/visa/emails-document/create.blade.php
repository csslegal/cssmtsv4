@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol  id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize/evrak-emaili">Evrak Listesi E-mailleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/vize/evrak-emaili">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Dil</label>
                        <select name="dil" class="form-control">
                            <option value="">Seçim yapınız</option>
                            @foreach ($language as $lang)
                                <option {{ old('dil') == $lang->id ? 'selected' : '' }}
                                    value="{{ $lang->id }}">{{ $lang->name }}</option>
                            @endforeach
                        </select>
                        @error('dil')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Vize Tipi</label>
                        <select name="vize-tipi" class="form-control">
                            <option value="">Seçim yapınız</option>
                            @foreach ($visaSubTypes as $visaSubType)
                                <option {{ old('vize-tipi') == $visaSubType->id ? 'selected' : '' }}
                                    value="{{ $visaSubType->id }}">{{ $visaSubType->vt_name." / ".$visaSubType->vst_name }}</option>
                            @endforeach
                        </select>
                        @error('vize-tipi')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bilgi E-maill İçeriği</label>
                        <textarea id="editor400" name="icerik" class="form-control wysiwyg">{!! old('icerik') !!}</textarea>
                        @error('icerik')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
