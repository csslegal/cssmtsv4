<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradesCheck
{
    public function handle(Request $request, Closure $next)
    {
        /**Eğer dosya ref no ait dosya aşama var mı yo mu*/

        if (
            DB::table('visa_files')
            ->where('customer_id', '=', $request->id)
            ->where('id', '=', $request->visa_file_id)
            ->where('active', '=', 1)
            ->get()->count() == 0
        ) {

            $request->session()->flash('mesajSuccess','Hatalı istek yapıldı');
            return redirect('/musteri/' . $request->id);
        }
        return $next($request);
    }
}
