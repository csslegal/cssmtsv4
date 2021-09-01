<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ManagementCheck
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
        if(!($request->session()->get('userTypeId')==1)){

            return redirect(config('app.url'));
        }
        return $next($request);
    }
}
