<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Müşteri Takip Sistemi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    @if (session('userTypeId') == 1)
                        <a class="nav-link {{ request()->is('yonetim') || request()->is('yonetim/vize') || request()->is('yonetim/harici') || request()->is('yonetim/web') || request()->is('yonetim/dilokulu') ? 'active text-white' : '' }}"
                            aria-current="page" href="/yonetim">
                            <i class="bi bi-house-fill"></i>&nbspYönetim İşlemleri</a>
                    @else
                        <a class="nav-link {{ request()->is('kullanici') ? 'active text-white' : '' }}"
                            aria-current="page" href="/kullanici">
                            <i class="bi bi-house-fill"></i>&nbspKullanıcı İşlemleri</a>
                    @endif

                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('musteri/sorgula') ? 'active text-white' : '' }}"
                        href="/musteri/sorgula">
                        <i class="bi bi-search"></i>&nbspMüşteri Sorgula</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('musteri/ekle') ? 'active text-white' : '' }}"
                        href="/musteri/ekle">
                        <i class="bi bi-person-plus-fill"></i>&nbspMüşteri Kayıt</a>
                </li>
                @if (session('userTypeId') == 1)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('yonetim/profil') ? 'active text-white' : '' }}"
                            href="/yonetim/profil">
                            <i class="bi bi-person-fill"></i>&nbspProfilim</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('kullanici/profil') ? 'active text-white' : '' }}"
                            href="/kullanici/profil">
                            <i class="bi bi-person-fill"></i>&nbspProfilim</a>
                    </li>
                    <li class="nav-item">
                        <a id="duyuruSayisi"
                            class="nav-link {{ request()->is('kullanici/duyuru') ? 'active text-white' : '' }}"
                            href="/kullanici/duyuru">
                            <i class="bi bi-stack"></i>&nbspDuyurular</a>
                    </li>
                @endif
                <li class="nav-item  text-danger border-end">
                    <a class="nav-link {{ request()->is('cikis') ? 'active text-white' : '' }}"
                        href="/cikis">
                        <i class="bi bi-door-closed-fill"></i>&nbspGüvenli Çıkış</a>
                </li>
                <li class="nav-item fw-bold">
                    <a class="nav-link  active " href="#">
                        @if (session('userTypeId') == 1)
                            Süresiz Oturum
                        @else
                            Oturum Bitmesine:
                            <span class="text-danger">
                                {{ floor((session('session') - time()) / 60) }} dk.
                                {{ floor((session('session') - time()) % 60) }} sn.
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
