@if (session('userTypeId') == 1)
    <div class="card card-primary mb-3" id="temel">
        <div class="card-header bg-primary text-white">Müşteri İşlemleri</div>

        <div class="card-body scroll">
            <div class="row">
                <div class="col-xl-4 col-lg-4">
                    <div class="card border-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Müşteri Hesabı Silme</h5>
                            <br>
                            <p>Müşteri hesabı silme</p>
                            <form action="" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="id" value="{{ $baseCustomerDetails->id }}">
                                <button class="confirm btn btn-primary text-white float-end" data-title="Dikkat!"
                                    data-content="Müşteri silinsin mi?">İşlem yap</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="card border-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Müşteri Logları</h5>
                            <br>
                            <p>Müşteri loglarını gösterme</p>
                            <a href="/musteri/{{ $baseCustomerDetails->id }}/logs"
                                class="btn btn-primary text-white float-end">Git</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
