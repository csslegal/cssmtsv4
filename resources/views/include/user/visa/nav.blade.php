<ul class="nav nav-pills nav-justified mb-3">
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('kullanici/vize/danisman') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/kullanici/vize/danisman">Danışman<br>İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('kullanici/vize/ofis-sorumlusu') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/kullanici/vize/ofis-sorumlusu">Ofis&nbsp;Sorumlusu<br>İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('kullanici/vize/tercuman') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/kullanici/vize/tercuman">Tercüman<br>İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('kullanici/vize/uzman') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/kullanici/vize/uzman">Uzman<br>İşlemleri</a>
    </li>

    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('kullanici/vize') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/kullanici/vize">Koordinatör<br>İşlemleri</a>
    </li>
</ul>
