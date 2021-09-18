<?php

namespace App\Http\Controllers\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileOpenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $baseCustomerDetails = DB::table('customers')
            ->where('id', '=', $id)->first();

        $visaValidities = DB::table('visa_validity')->orderBy('orderby')->get();
        $visaTypes = DB::table('visa_types')->orderBy('orderby')->get();
        $language = DB::table('language')->orderBy('orderby')->get();
        $users = DB::table('users')->orderBy('orderby')->get();

        return view('customer.visa.file-open')
            ->with(
                [
                    'baseCustomerDetails' => $baseCustomerDetails,
                    'visaTypes' => $visaTypes,
                    'language' => $language,
                    'users' => $users,
                    'visaValidities' => $visaValidities,

                ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate(
            [
                'vize-tipi' => 'required|numeric',
                'vize-sure' => 'required|numeric',
                'tc-no' => 'required|min:7',
                'adres' => 'required|min:3',
            ]
        );

        $customerActiveFile = DB::table('visa_files')
            ->where('active', '=', 1)
            ->where('customer_id', '=', $id)
            ->get()->count();

        if ($customerActiveFile == 0) {

            $visaFileInsertId = DB::table('visa_files')->insertGetId(
                [
                    'customer_id' => $id,
                    'visa_sub_type_id' => $request->input('vize-tipi'),
                    'visa_validity_id' => $request->input('vize-sure'),
                    'visa_file_grades_id' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );

            do {
                $dosyaRefNumber = rand(10000, 99999);
            } while (DB::table('visa_files')->where('id', '=', $dosyaRefNumber)->count() != 0);

            DB::table('visa_files')
                ->where('id', '=', $visaFileInsertId)
                ->update(['id' => $dosyaRefNumber,]);

            if ($request->session()->get('userTypeId') == 2) {
                DB::table('visa_files')
                    ->where('id', '=', $visaFileInsertId)
                    ->update(['danisman_id' => $request->session()->get('userId'),]);
            } elseif (
                $request->session()->get('userTypeId') == 1 ||
                $request->session()->get('userTypeId') == 4 ||
                $request->session()->get('userTypeId') == 7
            ) {
                DB::table('visa_files')
                    ->where('id', '=', $visaFileInsertId)
                    ->update(['danisman_id' => $request->input('danisman'),]);
            }

            $request->session()
                ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize');
        } else {
            $request->session()
                ->flash('mesajInfo', 'Müşteri aktif dosyası mevcut.');
            return redirect('/musteri/' . $id . '/vize');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
