@if (session('userTypeId') == 4 || session('userTypeId') == 7)

    <ul class="nav nav-pills nav-justified mb-3">
        <li class="nav-item m-1">
            <a class="nav-link {{ request()->is('kullanici/vize/danisman') ? 'active bg-dark' : 'bg-danger text-white' }} btn btn-block"
                href="/kullanici/vize/danisman">Danışman İşlemleri</a>
        </li>

        <li class="nav-item m-1">
            <a class="nav-link {{ request()->is('kullanici/vize/tercuman') ? 'active bg-dark' : 'bg-danger text-white' }} btn btn-block"
                href="/kullanici/vize/tercuman">Tercüman İşlemleri</a>
        </li>
        <li class="nav-item m-1">
            <a class="nav-link {{ request()->is('kullanici/vize/uzman') ? 'active bg-dark' : 'bg-danger text-white' }} btn btn-block"
                href="/kullanici/vize/uzman">Uzman İşlemleri</a>
        </li>

    </ul>

@elseif (session('userTypeId')==8)

    <ul class="nav nav-pills nav-justified mb-3">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('kullanici/vize/danisman') ? 'active bg-dark' : 'bg-danger text-white' }} btn btn-block"
                href="/kullanici/vize/danisman">Danışman İşlemleri</a>
        </li>

    </ul>

@endif
