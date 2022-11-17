<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\MyClass\GetTimeAgo;

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
        if (!($request->session()->get('userTypeId') == 1)) {

            return redirect('/');
        }
        $getTimeAgo = new GetTimeAgo();

        $notifications = array();
        $activeVisaFiles = DB::table('visa_files')->where('visa_files.active', '=', 1)->get();

        foreach ($activeVisaFiles as $activeVisaFile) {

            $customerName = DB::table('customers')->where('id', '=', $activeVisaFile->customer_id)->first();
            $activeVisaFileLastLog = DB::table('visa_file_logs')
            ->select('created_at AS date')
            ->where('visa_file_id', '=', $activeVisaFile->id)->orderByDesc('id')->first();

            if ($customerName != null && $activeVisaFileLastLog != null && ($activeVisaFileLastLog->date <= date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -' . env('NOTIFICATION_VISA_LOG_LAST_DAY') . ' days')))) {
                array_push($notifications, array(
                    'date' => $getTimeAgo->getTimeAgo(strtotime($activeVisaFileLastLog->date)),
                    'created_at' =>$activeVisaFileLastLog->date,
                    'visa_file_id' => $activeVisaFile->id,
                    'customer_id' => $customerName->id,
                    'customer_name' => $customerName->name,
                ));
            }
        }
        array_multisort(array_column($notifications, 'created_at'), SORT_ASC, $notifications);
        View::share('notifications', $notifications);

        return $next($request);
    }
}
