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
