<ul id="managament-nav" class="nav nav-pills nav-justified mb-3">
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/danisman') ? 'text-danger' : 'text-light' }} btn btn-block bg-dark "
            href="/yonetim/vize/danisman">Danışman İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/muhasebe') ? ' text-danger' : 'text-light' }} btn btn-block bg-dark"
            href="/yonetim/vize/muhasebe">Muhasebe İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/tercuman') ? 'text-danger' : 'text-light' }} btn btn-block bg-dark"
            href="/yonetim/vize/tercuman">Tercüman İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/uzman') ? 'text-danger' : 'text-light' }} btn btn-block bg-dark"
            href="/yonetim/vize/uzman">Uzman İşlemleri</a>
    </li>
</ul>
