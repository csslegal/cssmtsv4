<?php

namespace App\MyClass;

class InputKontrol
{

    /**
     *
     */
    public function kontrol($kontrolEdilecekVeri)
    {
        return stripslashes(addslashes(htmlspecialchars(strip_tags($kontrolEdilecekVeri))));
    }
}
