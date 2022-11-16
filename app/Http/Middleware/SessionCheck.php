<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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

                if ($request->session()->get('userTypeId') == 2) {

                    $notifications = array();

                    /**Ofislere göre dosyalar */
                    $userInformation =  DB::table('users_application_offices')
                        ->where('user_id', '=', $request->session()->get('userId'))
                        ->get()->pluck('application_office_id')->toArray();

                    $activeVisaFiles = DB::table('visa_files')->where('active', '=', 1)
                        ->whereIn('application_office_id', (array) implode(',', $userInformation))->get();

                    foreach ($activeVisaFiles as $activeVisaFile) {

                        $customerName = DB::table('customers')->where('id', '=', $activeVisaFile->customer_id)->first();

                        $activeVisaFileLastLog = DB::table('visa_file_logs')->select('created_at AS date')
                            ->whereDate('created_at', '<', date('Y-m-d', strtotime(date('Y-m-d') . ' -' . env('NOTIFICATION_VISA_LOG_LAST_DAY') . ' days')))
                            ->where('visa_file_id', '=', $activeVisaFile->id)->orderByDesc('id')->first();
                        if ($customerName != null && $activeVisaFileLastLog != null) {
                            array_push($notifications, array(
                                'date' => $activeVisaFileLastLog->date,
                                'visa_file_id' => $activeVisaFile->id,
                                'customer_id' => $customerName->id,
                                'customer_name' => $customerName->name,
                            ));
                        }
                    }
                    array_multisort(array_column($notifications, 'date'), SORT_ASC, $notifications);
                    View::share('notifications', $notifications);
                }
            } else {

                $notifications = array();
                $activeVisaFiles = DB::table('visa_files')->where('visa_files.active', '=', 1)->get();

                foreach ($activeVisaFiles as $activeVisaFile) {

                    $customerName = DB::table('customers')->where('id', '=', $activeVisaFile->customer_id)->first();
                    $activeVisaFileLastLog = DB::table('visa_file_logs')->select('created_at AS date')
                        ->whereDate('created_at', '<', date('Y-m-d', strtotime(date('Y-m-d') . ' -' . env('NOTIFICATION_VISA_LOG_LAST_DAY') . ' days')))
                        ->where('visa_file_id', '=', $activeVisaFile->id)->orderByDesc('id')->first();
                    if ($customerName != null && $activeVisaFileLastLog != null) {
                        array_push($notifications, array(
                            'date' => $activeVisaFileLastLog->date,
                            'visa_file_id' => $activeVisaFile->id,
                            'customer_id' => $customerName->id,
                            'customer_name' => $customerName->name,
                        ));
                    }
                }
                array_multisort(array_column($notifications, 'date'), SORT_ASC, $notifications);
                View::share('notifications', $notifications);
            }
        }
        return $next($request);
    }
}
