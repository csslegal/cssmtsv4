<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * oturum yoksa her halukarda index sayfasına yonlendirilecek
         */

        if (!$request->session()->has('session')) {
            return redirect('/');
        }
        /**
         * oturum varsa ve admin değilse oturum suresine tabi olacak
         */
        if ($request->session()->has('session')) {

            if ($request->session()->get('userTypeId') != 1) {

                if ($request->session()->get('session') - time() <= 0) {
                    //tipi admin olanlar için oturum zamanı sınırsız

                    $request->session()->forget('session');
                    $request->session()->forget('userId');
                    $request->session()->forget('userTypeId');
                    $request->session()->forget('userName');

                    return redirect('/');
                }
            }
        }
        return $next($request);

    }
}
