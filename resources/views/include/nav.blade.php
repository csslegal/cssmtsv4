<div class="text-center mb-5">
    <div class="mt-5">
        <img class="w-100 p-1" src="{{ asset('storage/logo.png') }}" alt="logo">
    </div>
</div>
<div class="card mb-3">
    <ul class="nav flex-column">
        @if (session('userTypeId') == 1)
            <li class="nav-item pt-1">
                <a class="nav-link {{ request()->is('yonetim') || request()->is('yonetim/vize') || request()->is('yonetim/harici') || request()->is('yonetim/web') || request()->is('yonetim/dilokulu') ? 'active bg-primary text-white' : '' }}"
                    aria-current="page" href="/yonetim">
                    <i class="bi bi-house-fill"></i>&nbspYönetim İşlemleri</a>
            </li>
        @else
            <li class="nav-item pt-1">
                <a class="nav-link {{ request()->is('kullanici') ? 'active bg-primary text-white' : '' }}"
                    aria-current="page" href="/kullanici">
                    <i class="bi bi-house-fill"></i>&nbspKullanıcı İşlemleri</a>
            </li>
        @endif

        <li class="nav-item pt-1">
            <a class="nav-link {{ request()->is('musteri/sorgula') ? 'active bg-primary text-white' : '' }}"
                href="/musteri/sorgula">
                <i class="bi bi-search"></i>&nbspMüşteri Sorgula</a>
        </li>
        <li class="nav-item pt-1 ">
            <a class="nav-link {{ request()->is('musteri/create') ? 'active bg-primary text-white' : '' }}"
                href="/musteri/create">
                <i class="bi bi-person-plus-fill"></i>&nbspMüşteri Kayıt</a>
        </li>
        @if (session('userTypeId') == 1)
            <li class="nav-item pt-1">
                <a class="nav-link {{ request()->is('yonetim/profil') ? 'active bg-primary text-white' : '' }}"
                    href="/yonetim/profil">
                    <i class="bi bi-person-fill"></i>&nbspProfilim</a>
            </li>
        @else
            <li class="nav-item pt-1">
                <a class="nav-link {{ request()->is('kullanici/profil') ? 'active bg-primary text-white' : '' }}"
                    href="/kullanici/profil">
                    <i class="bi bi-person-fill"></i>&nbspProfilim</a>
            </li>
            <li class="nav-item pt-1">
                <a id="duyuruSayisi"
                    class="nav-link {{ request()->is('kullanici/duyuru') ? 'active bg-primary text-white' : '' }}"
                    href="/kullanici/duyuru">
                    <i class="bi bi-stack"></i>&nbspDuyurular</a>
            </li>
        @endif

        <li class="nav-item pt-1">
            <a class="nav-link {{ request()->is('cikis') ? 'active bg-primary text-white' : '' }}" href="/cikis">
                <i class="bi bi-door-closed-fill"></i>&nbspGüvenli Çıkış</a>
        </li>




    </ul>
</div>

<div class="card mb-3">
    <div class="card-header bg-primary text-white ">
        @if (session('userTypeId') == 1)
            <i class="bi bi-tower"></i>Oturum Bilgisi
        @else
            <i class="bi bi-tower"></i>Oturum Bilgisi
        @endif
    </div>
    <div class="card-body">
        @if (session('userTypeId') == 1)
            <div class="fw-bold text-success">Süresiz oturum</div>
        @else
            <div class="fw-bold ">
                Süreli oturum <br>
                Çıkışa:
                <span class="text-danger">
                    {{ floor((session('session') - time()) / 60) }} dk.
                    {{ floor((session('session') - time()) % 60) }} sn.
                </span>
            </div>
        @endif
    </div>
</div>
