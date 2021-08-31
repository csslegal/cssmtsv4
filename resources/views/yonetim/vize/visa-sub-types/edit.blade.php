@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize/alt-vize-tipi">Alt Vize Tipleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Düzenle</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Düzenle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/vize/alt-vize-tipi/{{ $kayit->id }}">
                @method('PUT')
                @csrf
                <div class="col-12">
                    <label class="form-label">Vize Tipi</label>
                    <select name="vize-tipi" class="form-control">
                        <option value="">Seçim yapınız</option>
                        @foreach ($visaTypes as $visaType)
                            <option {{  $kayit->visa_type_id == $visaType->id ? 'selected' : '' }}
                                value="{{ $visaType->id }}">{{ $visaType->name }}</option>
                        @endforeach
                    </select>
                    @error('vize-tipi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Alt Vize Tipi</label>
                    <input type="text" value="{{  $kayit->name }}" name="name" class="form-control">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
