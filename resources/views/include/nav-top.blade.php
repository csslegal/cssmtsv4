<div id="nav-top" class="container bg-dark mb-3 border">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2">
        <div class="col-md-4">
            <ul class="nav float-start">
                <li class="nav-item">
                    <a href="/" aria-current="page"
                        class="nav-link link-light {{ request()->is('kullanici') || request()->is('yonetim') ? 'active' : '' }}">
                        <i class="bi bi-house-fill"></i>&nbspAna Sayfa</a>
                </li>
                <li class="nav-item">
                    <a href="/musteri/sorgula"
                        class="nav-link link-light {{ request()->is('musteri/sorgula') ? 'active' : '' }}">
                        <i class="bi bi-search"></i>&nbspMüşteri Sorgula</a>
                </li>
            </ul>
        </div>
        <div class="col-md-4 text-center">
            <span id="slogan" class="fs-3 w-100 fw-bold text-danger">Müşteri Takip Sistemi</span>
        </div>
        <div class="col-md-4">
            <ul class="nav float-end">
                @if (isset($notifications) && count($notifications) > 0)
                    <li class="nav-item">
                        <a class="dropdown nav-link link-light px-2 " data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="bi bi-bell-fill"></i>
                            Bildirimler
                            <span class="badge bg-danger text-light">{{ count($notifications) }}</span>
                        </a>
                        <div class="dropdown-menu"
                            style="padding: 0; max-height: 300px; {{ count($notifications) > 4 ? ' overflow-y: scroll;' : '' }}">
                            <div class="list-group">

                                @foreach ($notifications as $notification)
                                    <a href="/musteri/{{ $notification['customer_id'] }}/vize"
                                        class="list-group-item list-group-item-action ">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 text-danger fw-bold">{{ $notification['customer_name'] }}</h6>
                                            <small class="text-muted">{{ $notification['date'] }}</small>
                                        </div>
                                        <p class="mb-1">Son dosya işlemi üzerinden {{ $notification['date'] }} geçti.</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endif
                <li class="nav-item">
                    @if (session('userTypeId') == 1)
                        <a href="/yonetim/profil"
                            class="nav-link link-light px-2 {{ request()->is('yonetim/profil') ? 'active' : '' }}">
                            <i class="bi bi-person-fill"></i>&nbspProfilim
                        </a>
                    @else
                        <a href="/kullanici/profil"
                            class="nav-link link-light px-2 {{ request()->is('kullanici/profil') ? 'active' : '' }}">
                            <i class="bi bi-person-fill"></i>&nbspProfilim
                        </a>
                    @endif
                </li>
                <li class="nav-item">
                    <a href="/cikis" class="nav-link link-light px-2">
                        <i class="bi bi-door-closed-fill"></i>&nbspÇıkış</a>
                </li>
            </ul>
        </div>
    </header>
</div>
