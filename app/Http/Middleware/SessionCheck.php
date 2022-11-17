<?php

namespace App\Http\Middleware;

use App\MyClass\GetTimeAgo;
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
        $getTimeAgo = new GetTimeAgo();

        if (!$request->session()->has('session')) {
            /** oturum yoksa */
            return redirect('/');
        } else {
            /** oturum varsa */
            if ($request->session()->get('userTypeId') == 1) {
                /** admin oturum suresi yok */
                $notifications = array();
                $activeVisaFiles = DB::table('visa_files')->where('visa_files.active', '=', 1)->get();
                foreach ($activeVisaFiles as $activeVisaFile) {

                    $customerName = DB::table('customers')->where('id', '=', $activeVisaFile->customer_id)->first();
                    $activeVisaFileLastLog = DB::table('visa_file_logs')->select('created_at AS date')
                        ->where('visa_file_id', '=', $activeVisaFile->id)->orderByDesc('id')->first();

                    if (
                        $customerName != null && $activeVisaFileLastLog != null &&
                        ($activeVisaFileLastLog->date <= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -' . env('NOTIFICATION_VISA_LOG_LAST_DAY') . ' days')))
                    ) {

                        array_push($notifications, array(
                            'date' => $getTimeAgo->getTimeAgo(strtotime($activeVisaFileLastLog->date)),
                            'created_at' => $activeVisaFileLastLog->date,
                            'visa_file_id' => $activeVisaFile->id,
                            'customer_id' => $customerName->id,
                            'customer_name' => $customerName->name,
                        ));
                    }
                }
                array_multisort(array_column($notifications, 'created_at'), SORT_ASC, $notifications);
                View::share('notifications', $notifications);
            } else if ($request->session()->get('userTypeId') == 6) {
                /** muhasebe bildirimi */
                if ($request->session()->get('session') - time() <= 0) {
                    /** oturum suresi var */
                    $request->session()->forget('session');
                    $request->session()->forget('userId');
                    $request->session()->forget('userTypeId');
                    $request->session()->forget('userName');
                    return redirect('/');
                }
                $notifications = array();
                $activeVisaFiles = DB::table('visa_files')
                    ->whereIn('visa_file_grades_id', [
                        env('VISA_FILE_OPEN_CONFIRM_GRADES_ID'),
                        env('VISA_APPLICATION_PAID_GRADES_ID')
                    ])
                    ->where('active', '=', 1)->get();
                foreach ($activeVisaFiles as $activeVisaFile) {

                    $customerName = DB::table('customers')->where('id', '=', $activeVisaFile->customer_id)->first();
                    $activeVisaFileLastLog = DB::table('visa_file_logs')->select('created_at AS date')
                        ->where('visa_file_id', '=', $activeVisaFile->id)->orderByDesc('id')->first();

                    if (
                        $customerName != null && $activeVisaFileLastLog != null &&
                        ($activeVisaFileLastLog->date <= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -' . env('NOTIFICATION_VISA_LOG_LAST_DAY') . ' days')))
                    ) {
                        array_push($notifications, array(
                            'date' => $getTimeAgo->getTimeAgo(strtotime($activeVisaFileLastLog->date)),
                            'created_at' => $activeVisaFileLastLog->date,
                            'visa_file_id' => $activeVisaFile->id,
                            'customer_id' => $customerName->id,
                            'customer_name' => $customerName->name,
                        ));
                    }
                }
                array_multisort(array_column($notifications, 'created_at'), SORT_ASC, $notifications);
                View::share('notifications', $notifications);
            } else if ($request->session()->get('userTypeId') == 5) {
                /** uzman bildirimi */
                if ($request->session()->get('session') - time() <= 0) {
                    /** oturum suresi var */
                    $request->session()->forget('session');
                    $request->session()->forget('userId');
                    $request->session()->forget('userTypeId');
                    $request->session()->forget('userName');
                    return redirect('/');
                }
                $notifications = array();
                $activeVisaFiles = DB::table('visa_files')
                    ->whereIn('visa_file_grades_id', [
                        env('VISA_TRANSLATIONS_WAIT_GRADES_ID'),
                    ])
                    ->where('active', '=', 1)->get();
                foreach ($activeVisaFiles as $activeVisaFile) {

                    $customerName = DB::table('customers')->where('id', '=', $activeVisaFile->customer_id)->first();
                    $activeVisaFileLastLog = DB::table('visa_file_logs')->select('created_at AS date')
                        ->where('visa_file_id', '=', $activeVisaFile->id)->orderByDesc('id')->first();

                    if (
                        $customerName != null && $activeVisaFileLastLog != null &&
                        ($activeVisaFileLastLog->date <= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -' . env('NOTIFICATION_VISA_LOG_LAST_DAY') . ' days')))
                    ) {
                        array_push($notifications, array(
                            'date' => $getTimeAgo->getTimeAgo(strtotime($activeVisaFileLastLog->date)),
                            'created_at' => $activeVisaFileLastLog->date,
                            'visa_file_id' => $activeVisaFile->id,
                            'customer_id' => $customerName->id,
                            'customer_name' => $customerName->name,
                        ));
                    }
                }
                array_multisort(array_column($notifications, 'created_at'), SORT_ASC, $notifications);
                View::share('notifications', $notifications);
            } else if ($request->session()->get('userTypeId') == 3) {
                /** uzman bildirimi */
                if ($request->session()->get('session') - time() <= 0) {
                    /** oturum suresi var */
                    $request->session()->forget('session');
                    $request->session()->forget('userId');
                    $request->session()->forget('userTypeId');
                    $request->session()->forget('userName');
                    return redirect('/');
                }
                $notifications = array();
                $activeVisaFiles = DB::table('visa_files')
                    ->whereIn('visa_file_grades_id', [
                        env('VISA_CONTROL_WAIT_GRADES_ID'),
                        env('VISA_APPLICATION_WAIT_GRADES_ID'),
                    ])
                    ->where('active', '=', 1)->get();
                foreach ($activeVisaFiles as $activeVisaFile) {

                    $customerName = DB::table('customers')->where('id', '=', $activeVisaFile->customer_id)->first();
                    $activeVisaFileLastLog = DB::table('visa_file_logs')->select('created_at AS date')
                        ->where('visa_file_id', '=', $activeVisaFile->id)->orderByDesc('id')->first();

                    if (
                        $customerName != null && $activeVisaFileLastLog != null &&
                        ($activeVisaFileLastLog->date <= date('Y-m-d', strtotime(date('Y-m-d H:i:s') . ' -' . env('NOTIFICATION_VISA_LOG_LAST_DAY') . ' days')))
                    ) {
                        array_push($notifications, array(
                            'date' => $getTimeAgo->getTimeAgo(strtotime($activeVisaFileLastLog->date)),
                            'created_at' => $activeVisaFileLastLog->date,
                            'visa_file_id' => $activeVisaFile->id,
                            'customer_id' => $customerName->id,
                            'customer_name' => $customerName->name,
                        ));
                    }
                }
                array_multisort(array_column($notifications, 'created_at'), SORT_ASC, $notifications);
                View::share('notifications', $notifications);
            } else if ($request->session()->get('userTypeId') == 2) {
                /** danışman bildirimi */
                if ($request->session()->get('session') - time() <= 0) {
                    /** oturum suresi var */
                    $request->session()->forget('session');
                    $request->session()->forget('userId');
                    $request->session()->forget('userTypeId');
                    $request->session()->forget('userName');
                    return redirect('/');
                }
                $notifications = array();
                $userInformation =  DB::table('users_application_offices')
                    ->where('user_id', '=', $request->session()->get('userId'))
                    ->get()
                    ->pluck('application_office_id')
                    ->toArray();
                $activeVisaFiles = DB::table('visa_files')->where('active', '=', 1)
                    ->whereIn('application_office_id', (array) implode(',', $userInformation))->get();
                foreach ($activeVisaFiles as $activeVisaFile) {

                    $customerName = DB::table('customers')
                        ->where('id', '=', $activeVisaFile->customer_id)->first();
                    $activeVisaFileLastLog = DB::table('visa_file_logs')->select('created_at AS date')
                        ->where('visa_file_id', '=', $activeVisaFile->id)->orderByDesc('id')->first();

                    if (
                        $customerName != null && $activeVisaFileLastLog != null &&
                        ($activeVisaFileLastLog->date <= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -' . env('NOTIFICATION_VISA_LOG_LAST_DAY') . ' days')))
                    ) {
                        array_push($notifications, array(
                            'date' => $getTimeAgo->getTimeAgo(strtotime($activeVisaFileLastLog->date)),
                            'created_at' => $activeVisaFileLastLog->date,
                            'visa_file_id' => $activeVisaFile->id,
                            'customer_id' => $customerName->id,
                            'customer_name' => $customerName->name,
                        ));
                    }
                }
                array_multisort(array_column($notifications, 'created_at'), SORT_ASC, $notifications);
                View::share('notifications', $notifications);
            } else {
                /** Bildirim olmayan diğer kullanıcılar */
                if ($request->session()->get('session') - time() <= 0) {
                    /** oturum suresi var */
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
