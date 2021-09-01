@extends('sablon.genel')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">Cari Dosya Aç</li>
        </ol>
    </nav>

    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Cari Dosya Aç</div>

        <div class="card-body scroll">

            <form action="/musteri/{{ $baseCustomerDetails->id }}/vize/dosya-ac" method="POST">

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
                        <option value="">Lütfen vize seçimi yapınız</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger text-white confirm"
                    data-title="Müşteri dosyası açılsın mı?">Tamamla</button>
            </form>
        </div>
    </div>



@endsection

@section('js')
<script>
    function subVisaTypes(id) {
        $.ajax({
            type: 'POST',
            url: "/musteri/ajax/alt-vize-tipi",
            data: {
                'id': id,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                if (data.length != 0) {

                    $('#visaSubType').find('option').remove();
                    $('#visaSubType').append('<option value="">Seçim yapınız</option>');

                    for (var i = 0; i < data.length; i++) {
                        $('#visaSubType').append('<option value="' + data[i]['id'] + '">' +
                            data[i]['name'] + '</option>');
                    }
                } else {
                    $('#visaSubType').find('option').remove();
                    $('#visaSubType').append('<option value="">Farklı vize tipi seçiniz</option>');
                }
            },
            error: function(response, status, xhr) {
                alert('Veri alınırken hata oluştu. Hata: ' + xhr);
            }
        });
    }
</script>
@endsection
