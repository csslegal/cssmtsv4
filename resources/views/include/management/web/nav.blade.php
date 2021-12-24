<ul class="nav nav-pills nav-justified mb-3">

    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/web/writer') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/web/writer">Metin&nbsp;Yazarı<br>İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/web/editor') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/web/editor">Editor<br>İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/web/graphic') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/web/graphic">Grafiker<br>İşlemleri</a>
    </li>
    <li class="nav-item m-1">
        <a class="nav-link {{ request()->is('yonetim/web/engineer') ? 'active bg-primary' : 'bg-danger text-white' }} btn btn-block"
            href="/yonetim/web/engineer">Mühendis<br>İşlemleri</a>
    </li>
</ul>
