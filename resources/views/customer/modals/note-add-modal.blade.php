<div class="modal fade" id="exampleModalNot" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="/musteri/{{ $baseCustomerDetails->id }}/not-ekle">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Müşteri Notu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="not" class="form-label">Müşteri Notu Giriniz</label>
                        <textarea id="editor200" name="not" rows="20"
                            class="form-control">{!! old('not') !!}</textarea>
                        @error('not')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-danger text-white" data-bs-dismiss="modal">Tamamla</button>
                </div>
            </form>
        </div>
    </div>
</div>
