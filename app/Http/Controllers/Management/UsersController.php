<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kayitlar = DB::table('users AS u')
            ->select(
                'u.id AS u_id',
                'u.name AS u_name',
                'u.active AS u_active',
                'u.unlimited AS u_unlimited',
                'u.created_at AS u_created_at',
                'u.updated_at AS u_updated_at',
                'ut.name AS ut_name',
                'um.giris AS um_giris',
                'um.cikis AS um_cikis',
                'bo.name AS bo_name',
            )
            ->leftJoin('users_type AS ut', 'ut.id', '=', 'u.user_type_id')
            ->leftJoin('users_mesai AS um', 'um.user_id', '=', 'u.id')
            ->leftJoin('application_offices AS bo', 'bo.id', '=', 'u.application_office_id')
            ->get();

        return view('management.users.index')->with(['kayitlar' => $kayitlar]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usersTypes = DB::table('users_type')->get();
        $applicationOffices = DB::table('application_offices')->get();
        $userAccesses = DB::table('access')->get();

        return view('management.users.create')->with([
            'usersTypes' => $usersTypes,
            'applicationOffices' => $applicationOffices,
            'userAccesses' => $userAccesses,
        ]);
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
        $password = $request->input('password');
        $email = $request->input('email');
        $tip = $request->input('tip');
        $ofisId = $request->input('ofis');
        $mesaiGiris = $request->input('mesaiGiris');
        $mesaiCikis = $request->input('mesaiCikis');
        $userAccesses = $request->input('userAccess');

        $request->validate([
            'name' => 'required|max:50|min:3',
            'email' => 'required|unique:users,email|email|max:50|min:3',
            'password' => 'required|max:50|min:8',
            'mesaiGiris' => 'required',
            'mesaiCikis' => 'required',
            'tip' => 'required|numeric',
            'ofis' => 'required|numeric'
        ]);

        if ($sorguInsertID = DB::table('users')->insertGetId([
            'name' => $name,
            'email' => $email,
            'password' => base64_encode($password),
            'user_type_id' => $tip,
            'application_office_id' => $ofisId,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ])) {
            DB::table('users_mesai')->insert([
                'giris' => $mesaiGiris,
                'cikis' => $mesaiCikis,
                'user_id' => $sorguInsertID,
                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]);

            if (count((array)$userAccesses) > 0) {

                $arrayUserAccesses = array();
                foreach ($userAccesses as $userAccess) {
                    $arrayUserAccesses = array_merge(
                        $arrayUserAccesses,
                        array([
                            'user_id' => $sorguInsertID,
                            'access_id' => $userAccess,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ])
                    );
                }
                DB::table('users_access')->insert($arrayUserAccesses);
            }
            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/users');
        } else {
            $request->session()->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/users');
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

        $usersTypes = DB::table('users_type')->get();
        $applicationOffices = DB::table('application_offices')->get();
        $userAccesses = DB::table('access')->get();
        $accessId = DB::table('users_access')
            ->select('access_id')
            ->where('user_id', '=', $id)
            ->get()->pluck('access_id')->toArray();

        //dd($accessId);

        $kayit = DB::table('users')->where('id', '=', $id)->first();

        return view('management.users.edit')->with([
            'kayit' => $kayit,
            'usersTypes' => $usersTypes,
            'applicationOffices' => $applicationOffices,
            'userAccesses' => $userAccesses,
            'accessId' => $accessId,
        ]);
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
        $name = $request->input('name');
        $password = $request->input('password');
        $email = $request->input('email');
        $tip = $request->input('tip');
        $active = $request->input('durum');
        $unlimited = $request->input('kisitli');
        $ofisId = $request->input('ofis');
        $mesaiGiris = $request->input('mesaiGiris');
        $mesaiCikis = $request->input('mesaiCikis');
        $userAccesses = $request->input('userAccess');
        $request->validate([
            'name' => 'required|max:50|min:3',
            'email' => 'required|email|max:50|min:3',
            'password' => 'required|max:50|min:8',
            'mesaiGiris' => 'required',
            'mesaiCikis' => 'required',
            'tip' => 'required|numeric',
            'ofis' => 'required|numeric',
            'durum' => 'required|numeric',
            'kisitli' => 'required|numeric'
        ]);

        if (DB::table('users')->where('id', '=', $id)->update([
            'name' => $name,
            'email' => $email,
            'active' => $active,
            'unlimited' => $unlimited,
            'password' => base64_encode($password),
            'user_type_id' => $tip,
            'application_office_id' => $ofisId,
            "updated_at" => date('Y-m-d H:i:s'),
        ])) {

            DB::table('users_mesai')->where('user_id', '=', $id)->delete();
            DB::table('users_mesai')->insert([
                'giris' => $mesaiGiris,
                'cikis' => $mesaiCikis,
                'user_id' => $id,
                "updated_at" => date('Y-m-d H:i:s'),
            ]);

            if (count((array)$userAccesses) > 0) {

                DB::table('users_access')->where('user_id', '=', $id)->delete();
                $arrayUserAccesses = array();
                foreach ($userAccesses as $userAccess) {
                    $arrayUserAccesses = array_merge(
                        $arrayUserAccesses,
                        array([
                            'user_id' =>  $id,
                            'access_id' => $userAccess,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ])
                    );
                }
                DB::table('users_access')->insert($arrayUserAccesses);
            } else {
                DB::table('users_access')->where('user_id', '=', $id)->delete();
            }
            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/users');
        } else {
            $request->session()->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/users');
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
            if (DB::table('users')->where('id', '=', $id)->delete()) {
                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/users');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/users');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/users');
        }
    }
}
