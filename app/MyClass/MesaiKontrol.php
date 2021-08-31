<?php

namespace App\MyClass;

use DateTime;
use Illuminate\Support\Facades\DB;

class MesaiKontrol
{
    public $id;


    public function __construct($id)
    {
        $this->id = $id;
    }

    public function mesaiSaatiKayitliMi()
    {
        //kullanıcı id göre sistemde kayıtlı giriş cıkış saatlerini alma
        $usersGirisCikisSaati = DB::table('users_mesai')
            ->select('giris', 'cikis')
            ->where('user_id', '=', $this->id)
            ->get();
        if ($usersGirisCikisSaati->count() > 0) {
            return $usersGirisCikisSaati->first();
        } else {
            return null;
        }
    }

    /**
     * @user_id bağlı mesai saati içerisinde mi kontrolü
     * @return True OR False
     */
    public function kontrol()
    {
        $mesaiSaati = $this->mesaiSaatiKayitliMi();

        if ($mesaiSaati != null) {

            $mesaiSaatiGirisParcala = explode(':', $mesaiSaati->giris);
            $mesaiSaatiCikisParcala = explode(':', $mesaiSaati->cikis);

            /**
             * zamanları saniyeye cevirerek iki sart sağlanırsa mesai içerisinde oldugunun
             * bilgisi sıfırdan buyuk olması sebebi ile giris için gerekli izni verecektir.
             */

            $simdikiZaman = strtotime('now');

            $girisZaman = strtotime($mesaiSaatiGirisParcala[0] . ':' . $mesaiSaatiGirisParcala[1] . ':00');
            $cikisZaman = strtotime($mesaiSaatiCikisParcala[0] . ':' . $mesaiSaatiCikisParcala[1] . ':00');

            //dd($girisZaman . " " . $simdikiZaman. " " .$cikisZaman);

            if ($girisZaman <= $simdikiZaman && $simdikiZaman <= $cikisZaman) {
                return 1;
            } else {
                //dd("sdf");
                return 0;
            }
        } else {
            return 2;
        }
    }
}
