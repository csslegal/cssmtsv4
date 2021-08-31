@if (session()->has('mesajSuccess'))
    <div class="alert alert-success">{!! session()->get('mesajSuccess') !!}</div>
@elseif (session()->has('mesajDanger'))
    <div class="alert alert-danger">{!! session()->get('mesajDanger') !!}</div>
@elseif (session()->has('mesajInfo'))
    <div class="alert alert-info">{!! session()->get('mesajInfo') !!}</div>
@elseif (session()->has('mesajPrimary'))
    <div class="alert alert-primary ">{!! session()->get('mesajPrimary ') !!}</div>
@endif
