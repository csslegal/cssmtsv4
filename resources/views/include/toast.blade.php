 @if (session()->has('mesajSuccess'))
 <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
         <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
             <div class="toast-header bg-success text-white border border-success">
                 <strong class="me-auto">İşlem Sonucu</strong>
                 <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
             </div>
             <div class="toast-body bg-dark text-white">{!! session('mesajSuccess') !!}</div>
         </div>
     </div>
 @endif
 @if (session()->has('mesajDanger'))
 <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
         <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
             <div class="toast-header bg-danger text-white border border-danger">
                 <strong class="me-auto">İşlem Sonucu</strong>
                 <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
             </div>
             <div class="toast-body bg-dark text-white">{!! session('mesajDanger') !!}</div>
         </div>
     </div>
 @endif
 @if (session()->has('mesajInfo'))
 <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
         <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
             <div class="toast-header bg-info text-white  border border-info">
                 <strong class="me-auto">İşlem Sonucu</strong>
                 <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
             </div>
             <div class="toast-body bg-dark text-white">{!! session('mesajInfo') !!}</div>
         </div>
     </div>
 @endif
 @if (session()->has('mesajPrimary'))
 <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
         <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
             <div class="toast-header bg-dark text-white  border border-primary">
                 <strong class="me-auto">İşlem Sonucu</strong>
                 <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
             </div>
             <div class="toast-body">{!! session('mesajPrimary') !!}</div>
         </div>
     </div>
 @endif
