<ul class="nav nav-pills nav-justified mb-3">
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/danisman') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/vize/danisman">Danışman<br>İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/muhasebe') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/vize/muhasebe">Muhasebe<br>İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/tercuman') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/vize/tercuman">Tercüman<br>İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/vize/uzman') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/vize/uzman">Uzman<br>İşlemleri</a>
    </li>
</ul>
