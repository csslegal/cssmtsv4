<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradesCheck
{
    public function handle(Request $request, Closure $next)
    {
        $theLastedURL = request()->segment(count(request()->segments()));
        //dd($theLastedURL);
        $arrayURLS = array(
            'asama-guncelle',
            'durum-guncelle',
            'fatura',
            'odeme',
            'kapatma',
            'arsive-tasima',
            'alinan-odeme-tamamla',
            'yapilan-odeme-tamamla',
            'fatura-kayit-tamamla',
            'yeniden-alinan-odeme-tamamla',
            'iade-bilgileri-tamamla',
        );

        $visaDetail = DB::table('visa_files')
            ->select([
                'visa_files.visa_file_grades_id',
                'visa_file_grades.url'
            ])
            ->join('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->where('visa_files.customer_id', '=', $request->id)
            ->where('visa_files.id', '=', $request->visa_file_id)
            ->where('visa_files.active', '=', 1)
            ->first();

        /**Eğer ( dosya ref no ait dosya aşama yoksa ) veya ( istek yapılan url sistemde yok ) ıse hatalı istek olacak*/
        if ($visaDetail == null || $visaDetail->url != $theLastedURL) {

            /****istisna olarak hatalı fakat genel işlemlerden birisi değilse hatayı devam ettirecek */
            if (!in_array($theLastedURL, $arrayURLS)) {

                if (!is_numeric($theLastedURL)) {
                    $request->session()->flash('mesajDanger', 'Hatalı istek yapıldı');
                    return redirect('/musteri/' . $request->id);
                }
            }
        }
        return $next($request);
    }
}
