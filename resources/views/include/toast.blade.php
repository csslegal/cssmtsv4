 @if (session()->has('mesajSuccess'))
     <div class="position-fixed bottom-0 end-0 p-3 m-1" style="z-index: 11">
         <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
             <div class="toast-header bg-success text-white border border-info">
                 <strong class="me-auto">İşlem Sonucu</strong>
                 <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
             </div>
             <div class="toast-body bg-primary text-white">
                 {!! session('mesajSuccess') !!}
             </div>
         </div>
     </div>
 @endif
 @if (session()->has('mesajDanger'))
     <div class="position-fixed bottom-0 end-0 p-3 m-1" style="z-index: 11">
         <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
             <div class="toast-header bg-danger text-white  border border-info">
                 <strong class="me-auto">İşlem Sonucu</strong>
                 <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
             </div>
             <div class="toast-body bg-primary text-white">
                 {!! session('mesajDanger') !!}
             </div>
         </div>
     </div>
 @endif
 @if (session()->has('mesajInfo'))
     <div class="position-fixed bottom-0 end-0 p-3 m-1" style="z-index: 11">
         <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
             <div class="toast-header bg-info text-white  border border-info">
                 <strong class="me-auto">İşlem Sonucu</strong>
                 <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
             </div>
             <div class="toast-body bg-primary text-white">
                 {!! session('mesajInfo') !!}
             </div>
         </div>
     </div>
 @endif
 @if (session()->has('mesajPrimary'))
     <div class="position-fixed bottom-0 end-0 p-3 m-1" style="z-index: 11">
         <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
             <div class="toast-header bg-primary text-white  border border-info">
                 <strong class="me-auto">İşlem Sonucu</strong>
                 <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
             </div>
             <div class="toast-body">
                 {!! session('mesajPrimary') !!}
             </div>
         </div>
     </div>
 @endif
