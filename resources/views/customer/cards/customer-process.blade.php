<div class="alert alert-primary alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Müşteri Sayfası</h4>
    <div class="row">
        <div class="col-md-6">
            <ul>
                <li class="">
                    <form action="/musteri/destroy" method="POST">
                        @csrf
                        Müşteri hesap silmek için
                        <input type="hidden" name="id" value="{{ $temelBilgiler->id }}">
                        <button class="confirm btn btn-sm btn-danger text-white" data-title="Dikkat!"
                            data-content="Müşteri silinsin mi?">tıkla</button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <ul>
                <li class="">Müşteri bilgileri logları için
                    <a class="text-danger" href="/musteri/{{ $temelBilgiler->id }}/logs">tıkla</a>
                </li>
            </ul>
        </div>
    </div>
</div>
