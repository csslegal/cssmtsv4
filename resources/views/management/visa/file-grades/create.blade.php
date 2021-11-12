@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize/dosya-asama">Dosya Aşamaları</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Ekle</div>
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
                            <option value="VISA_FILE_OPEN_GRADES_ID">Dosya Açma İşlemi</option>
                            <option value="VISA_PAYMENT_CONFIRM_GRADES_ID">Alınan Ödeme Onayı İşlemi</option>
                            <option value="VISA_TRANSLATOR_AUTH_GRADES_ID">Tercüme Yetkilendirme</option>
                            <option value="VISA_TRANSLATION_GRADES_ID">Tercüme Tamamlama İşlemi</option>
                            <option value="VISA_EXPERT_AUTH_GRADES_ID">Uzman Yetkilendirme İşlemi</option>
                            <option value="VISA_APPOINTMENT_GRADES_ID">Randevu Bilgileri İşlemi</option>
                            <option value="VISA_DACTYLOGRAM_GRADES_ID">Parmak İzi İşlemi</option>
                            <option value="VISA_MADE_PAYMENT_GRADES_ID">Yapılan Ödeme İşlemi</option>
                            <option value="VISA_INVOICE_SAVE_GRADES_ID">Fatura Kayıt İşlemi</option>
                            <option value="VISA_APPOINTMENT_PUTOFF_GRADES_ID">Randevu Erteleme İşlemi</option>
                            <option value="VISA_APPOINTMENT_CANCEL_GRADES_ID">Randevu İptali İşlemi</option>
                            <option value="VISA_RE_PAYMENT_CONFIRM_GRADES_ID">Yeniden Alınan Ödeme Onayı İşlemi</option>
                            <option value="VISA_FILE_DELIVERY_GRADES_ID">Dosya Teslim İşlemi</option>
                            <option value="VISA_FILE_CLOSED_GRADES_ID">Dosya Kapandı İşlemi(Arşiv)</option>
                            <option value="VISA_FILE_REFUSAL_GRADES_ID">Vize Reddi Tercüme İşlemi</option>
                            <option value="VISA_FILE_CLOSE_REQUEST_GRADES_ID">Dosya Kapama İsteği İşlemi</option>
                            <option value="VISA_FILE_CLOSE_CONFIRM_GRADES_ID">Dosya Kapama Onayı İşlemi</option>
                            <option value="VISA_FILE_REFUND_GRADES_ID">Dosya İade Bilgileri İşlemi</option>
                            <option value="VISA_FILE_REFUND_CONFIRM_GRADES_ID">Dosya İade Bilgileri Onayı İşlemi</option>
                        </select>
                        @error('env')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-danger text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
