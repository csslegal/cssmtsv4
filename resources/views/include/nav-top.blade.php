<div id="nav-top" class="container bg-dark mb-3 border">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2">
        <span id="slogan" class="fs-4 link-light ">Müşteri Takip Sistemi</span>
        <ul class="nav col-12 col-md-auto justify-content-center">
            <li  class="nav-item">
                <a href="/" aria-current="page"
                    class="nav-link link-light {{ request()->is('kullanici') || request()->is('yonetim') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>&nbspAna Sayfa</a>
            </li>
            <li  class="nav-item">
                <a href="/musteri/sorgula"
                    class="nav-link link-light {{ request()->is('musteri/sorgula') ? 'active' : '' }}">
                    <i class="bi bi-search"></i>&nbspMüşteri Sorgula</a>
            </li>
        </ul>
        <ul class="nav text-end">
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
            <li class="nav-item" >
                <a href="/cikis" class="nav-link link-light px-2">
                    <i class="bi bi-door-closed-fill"></i>&nbspÇıkış</a>
            </li>
        </ul>
    </header>
</div>
