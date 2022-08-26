<?php

namespace App\Http\Controllers\Customer\Visa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id, $visa_file_id)
    {
        if (DB::table('visa_files')->where('id', '=', $visa_file_id)->update(['status' => $request->input('status'), 'updated_at' => date('Y-m-d H:i:s')])) {

            $status = "";

            if ($request->input('status') == 1) {
                $status .= "ACİL";
            } else {
                $status .= "NORMAL";
            }

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => 'Dosya durumu güncelleme',
                'content' => 'Dosya durumu ' . $status . ' olarak güncellendi',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $request->session()->flash('mesajSuccess', 'Güncelleme başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize/');
        } else {

            $request->session()->flash('mesajDanger', 'Güncelleme sırasında sorun oluştu');
            return redirect('/musteri/' . $id . '/vize/');
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
