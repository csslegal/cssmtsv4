<?php


namespace App\MyClass;


use Illuminate\Support\Facades\DB;

class Sorting
{
    public $id, $table, $guncelOrderbyDegeri = 0, $bulunanOrderbyId, $bulunanOrderbyDegeri;

    /**
     * YukariAsagiSiralama constructor.
     * @param $table tablo adı
     * @param $id tablodaki yeniden sıralanacak id değeri
     */
    public function __construct($table, $id)
    {
        $this->id = $id;
        $this->table = $table;
    }

    /**
     * eger kendisinden büyük orderby yok ise işlem yapılmayacak
     * @return bool
     */
    public function yukariKontrol()
    {
        $guncelOrderby = DB::table($this->table)
            ->select('orderby')
            ->where(
                ['id' => $this->id]
            )->first();
        $bulunanOrderby = DB::table($this->table)
            ->select('id', 'orderby')
            ->where("orderby", "<", $guncelOrderby->orderby)
            ->orderBy('orderby', 'desc')
            ->first();

        if ($bulunanOrderby != null) {

            $this->guncelOrderbyDegeri = $guncelOrderby->orderby;
            $this->bulunanOrderbyId = $bulunanOrderby->id;
            $this->bulunanOrderbyDegeri = $bulunanOrderby->orderby;

            return true;

        } else {
            return false;
        }
    }

    /**
     *var olan orderby bilgisini kendisinden büyük olan orderby bilgisi ile değiştirilecek
     */
    public function yukari()
    {
        $guncelOrderbyQ = DB::update('update ' . $this->table . ' set orderby = ' . $this->bulunanOrderbyDegeri . ' where id = ?', [$this->id]);
        $buyulOrderbyQ = DB::update('update ' . $this->table . ' set orderby = ' . $this->guncelOrderbyDegeri . ' where id = ?', [$this->bulunanOrderbyId]);
    }

    /**
     * eger kendisinden küçük orderby yok ise işlem yapılmayacak
     * @return bool
     */
    public function asagiKontrol()
    {
        $guncelOrderby = DB::table($this->table)
            ->select('orderby')
            ->where(
                ['id' => $this->id]
            )->first();
        $bulunanOrderby = DB::table($this->table)
            ->select('id', 'orderby')
            ->where("orderby", ">", $guncelOrderby->orderby)
            ->orderBy('orderby', 'ASC')
            ->first();

        if ($bulunanOrderby != null) {

            $this->guncelOrderbyDegeri = $guncelOrderby->orderby;
            $this->bulunanOrderbyId = $bulunanOrderby->id;
            $this->bulunanOrderbyDegeri = $bulunanOrderby->orderby;

            return true;

        } else {
            return false;
        }
    }

    /**
     * var olan orderby bilgisini kendisinden küçük olan orderby bilgisi ile değiştirilecek
     */
    public function asagi()
    {
        $guncelOrderbyQ = DB::update('update ' . $this->table . ' set orderby = ' . $this->bulunanOrderbyDegeri . ' where id = ?', [$this->id]);
        $kucukOrderbyQ = DB::update('update ' . $this->table . ' set orderby = ' . $this->guncelOrderbyDegeri . ' where id = ?', [$this->bulunanOrderbyId]);
    }
}
