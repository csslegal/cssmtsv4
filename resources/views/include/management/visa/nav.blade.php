<ul class="nav nav-pills nav-justified mb-3">
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/danisman') ? 'active bg-dark' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/vize/danisman">Danışman İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/muhasebe') ? 'active bg-dark' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/vize/muhasebe">Muhasebe İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/tercuman') ? 'active bg-dark' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/vize/tercuman">Tercüman İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/uzman') ? 'active bg-dark' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/vize/uzman">Uzman İşlemleri</a>
    </li>
</ul>
