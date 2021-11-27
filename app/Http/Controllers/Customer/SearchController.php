<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\MyClass\InputKontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.search');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputKontrol = new InputKontrol();
        $arama = $inputKontrol->kontrol($request->get('arama'));

        if (strlen($arama) >= 3) {

            $customerDetails = DB::table('customers')
                ->select([
                    "customers.id",
                    "customers.name",
                    "customers.telefon",
                    "customers.email",
                    "customers.tcno",
                    "users.name AS user_name",
                    "visa_files.active",
                    "visa_files.id AS visa_file_id",
                ])
                ->where(function ($query) use ($arama) {
                    $query->orWhere('customers.name', 'LIKE', '%' . $arama . '%');
                    $query->orWhere('customers.email', 'LIKE', '%' . $arama . '%');
                    $query->orWhere('customers.telefon', 'LIKE', '%' . $arama . '%');
                    $query->orWhere('customers.tcno', 'LIKE', '%' . $arama . '%');
                })
                ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
                ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
                ->orWhere('visa_files.id', 'LIKE', '%' . $arama . '%')
                ->orWhere('customers.pasaport', 'LIKE', '%' . $arama . '%')->get();

            //dd($customerDetails);

            if ($customerDetails->count() > 0) {
                return view('customer.search')->with([
                    'customerDetails' => $customerDetails,
                    'arama' => $arama
                ]);
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Farklı bilgiyle tekrar deneyiniz veya <a class="text-white" href="/musteri/ekle">bu linkten</a> yeni müşteri kaydı yapınız!');
                return view('customer.search')->with(['arama' => $arama]);
            }
        } else {
            $request->session()
                ->flash('mesajInfo', 'Sorgulama için yeterli veri giriniz. Girilen: <span class="fw-bold">' . $arama . '</span>');
            return view('customer.search')->with([
                'arama' => $arama
            ]);
        }
    }
}
