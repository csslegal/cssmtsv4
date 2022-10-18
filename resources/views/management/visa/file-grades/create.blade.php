@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize/dosya-asama">Dosya Aşamaları</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>
    <div class="card card-dark mb-3">
        <div class="card-header bg-dark text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/vize/dosya-asama">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label"> Adı</label>
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Url</label>
                        <input type="text" value="{{ old('url') }}" name="url" class="form-control">
                        @error('url')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Env Bağlantısı</label>
                        <select name="env" class="form-control">
                            <option value="">Seçim yapınız</option>
                            <option value="VISA_FILE_OPEN_GRADES_ID">Dosya Açma İşlemi Başlatıldı</option>
                            <option value="VISA_FILE_OPEN_CONFIRM_GRADES_ID">Dosya Açma Onayı Bekleyen</option>
                            <option value="VISA_DOCUMENT_WAIT_GRADES_ID">Evrak Bekleyen Dosyalar</option>
                            <option value="VISA_CONTROL_WAIT_GRADES_ID">Kontrol Bekleyen Dosyalar</option>
                            <option value="VISA_TRANSLATIONS_COMPLETED_GRADES_ID">Tercüme Bekleyen Dosyalar</option>
                            <option value="VISA_APPOINTMENT_COMPLETED_GRADES_ID">Başvuru Bekleyen Dosyalar</option>
                            <option value="VISA_APPLICATION_PAID_GRADES_ID">Başvuru Ödemesi Bekleyen Dosyalar</option>
                            <option value="VISA_DACTYLOGRAM_GRADES_ID">Randevusu Alınmış Dosyalar</option>
                            <option value="VISA_APPLICATION_RESULT_GRADES_ID">Sonuç Bekleyen Dosyalar</option>
                            <option value="VISA_FILE_DELIVERY_GRADES_ID">Dosya Teslim Bekleyen</option>
                            <option value="VISA_FILE_CLOSED_GRADES_ID">Sonuçlanmış Dosyalar & Arşiv</option>
                        </select>
                        @error('env')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="w-100 mt-3 btn btn-dark text-white btn-lg" type="submit">Tamamla</button>
                </div>
            </form>
        </div>
    </div>
@endsection
