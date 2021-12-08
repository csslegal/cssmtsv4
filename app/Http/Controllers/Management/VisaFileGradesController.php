<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\MyClass\EnvSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaFileGradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kayitlar = DB::table('visa_file_grades')->get();

        return view('management.visa.file-grades.index')
            ->with(['kayitlar' => $kayitlar]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.visa.file-grades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $url = $request->input('url');
        $env = $request->input('env');

        $request->validate([
            'name' => 'required|max:100min:3',
            'url' => 'required|unique:visa_file_grades,url|max:100min:3',
        ]);
        if ($kayitId = DB::table('visa_file_grades')->insertGetId(
            [
                'name' => $name,
                'url' => $url,
                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]
        )) {
            DB::table('visa_file_grades')
                ->where('id', '=', $kayitId)
                ->update(['orderby' => $kayitId]);
            if ($env != "") {
                $envSet = new EnvSettings();
                $envSet->setEnvironmentValue($env, $kayitId);
            }
            $request->session()
                ->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/vize/dosya-asama');
        } else {
            $request->session()
                ->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/vize/dosya-asama');
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
        $kayit = DB::table('visa_file_grades')->where('id', '=', $id)->first();
        return view('management.visa.file-grades.edit')->with(['kayit' => $kayit]);
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
        $request->validate([
            'name' => 'required|max:100|min:3',
            'aktif' => 'required',
        ]);

        if (is_numeric($id)) {
            if (DB::table('visa_file_grades')->where('id', '=', $id)
                ->update([
                    'name' => $request->input('name'),
                    'active' => $request->input('aktif'),
                    "updated_at" => date('Y-m-d H:i:s')
                ])
            ) {
                if ($request->input('env') != "") {
                    $envSet = new EnvSettings();
                    $envSet->setEnvironmentValue($request->input('env'), $id);
                }
                $request->session()->flash('mesajSuccess', 'Başarıyla güncellendi');
                return redirect('yonetim/vize/dosya-asama');
            } else {
                $request->session()->flash('mesajDanger', 'Güncelleme sıralasında sorun oluştu');
                return redirect('yonetim/vize/dosya-asama');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/vize/dosya-asama');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (is_numeric($id)) {
            if (
                DB::table('visa_file_grades')
                ->where('id', '=', $id)
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/vize/dosya-asama');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/vize/dosya-asama');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/vize/dosya-asama');
        }
    }
}
