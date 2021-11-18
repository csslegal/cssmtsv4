<div class="card card-primary mb-3">
    <div class="card-header bg-primary text-white fw-bold">Bilgi E-mail Gönder</div>
    <div class="card-body scroll">
        <form action="/musteri/{{ $baseCustomerDetails->id }}/vize/bilgi-emaili" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Dil</label>
                <select id="dil" name="dil" class="form-select">
                    @foreach ($language as $lang)
                        <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                    @endforeach
                </select>
                @error('dil')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Vize Tipi</label>
                <select class="form-select" name="vize" onchange="subVisaTypes($(this).val());">
                    <option value="">Lütfen seçimi yapınız</option>
                    @foreach ($visaTypes as $visaType)
                        <option value="{{ $visaType->id }}">{{ $visaType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Alt Vize Tipi</label>
                <select id="visaSubType" class="form-select" name="alt_vize">
                    <option value="">Vize tipi seçimi yapınız</option>
                </select>
                @error('alt_vize')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-sm btn-danger text-white confirm" data-title="Dikkat!"
                data-content="E-mail gönderilsin mi?">Tamamla</button>
        </form>
    </div>
</div>
