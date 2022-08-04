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
        $kayitlar = DB::table('users')
        ->select([
            'users.id AS id',
            'users.name AS name',
            'users.active AS active',
            'users.unlimited AS unlimited',
            'users.created_at AS created_at',
            'users.updated_at AS updated_at',
            'users_type.name AS ut_name',
            'users_mesai.giris AS giris',
            'users_mesai.cikis AS cikis',
        ])
            ->leftJoin('users_type', 'users_type.id', '=', 'users.user_type_id')
            ->leftJoin('users_mesai', 'users_mesai.user_id', '=', 'users.id')
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

        $giris = $request->input('giris');
        $cikis = $request->input('cikis');

        $accesses = $request->input('erisimler');
        $offices = $request->input('ofisler');

        $request->validate([
            'name' => 'required|max:50|min:3',
            'email' => 'required|unique:users,email|email|max:50|min:3',
            'password' => 'required|max:50|min:8',
            'tip' => 'required|numeric',
            'giris' => 'required',
            'cikis' => 'required',
        ]);

        if ($sorguInsertID = DB::table('users')->insertGetId([
            'name' => $name,
            'email' => $email,
            'password' => base64_encode($password),
            'user_type_id' => $tip,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ])) {
            DB::table('users_mesai')->insert(['giris' => $giris,
                'cikis' => $cikis,
                'user_id' => $sorguInsertID,
                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]);

            if (count((array)$accesses) > 0) {
                $arrayUserAccesses = array();
                foreach ($accesses as $access) {
                    $arrayUserAccesses = array_merge($arrayUserAccesses, array([
                        'user_id' => $sorguInsertID,
                        'access_id' => $access,
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ]));
                }
                DB::table('users_access')->insert($arrayUserAccesses);
            }
            if (count((array)$offices) > 0) {
                $arrayUserOffices = array();
                foreach ($offices as $office) {
                    $arrayUserOffices = array_merge($arrayUserOffices, array([
                        'user_id' => $sorguInsertID,
                        'application_office_id' => $office,
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ]));
                }
                DB::table('users_application_offices')->insert($arrayUserOffices);
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
        $userMesai = DB::table('users_mesai')->where('user_id', '=', $id)->first();
        $accessId = DB::table('users_access')->select('access_id')->where('user_id', '=', $id)->get()->pluck('access_id')->toArray();
        $oficesId = DB::table('users_application_offices')->select('application_office_id')->where('user_id', '=', $id)->get()->pluck('application_office_id')->toArray();

        $kayit = DB::table('users')->where('id', '=', $id)->first();

        return view('management.users.edit')->with([
            'kayit' => $kayit,
            'usersTypes' => $usersTypes,
            'applicationOffices' => $applicationOffices,
            'userAccesses' => $userAccesses,
            'userMesai' => $userMesai,
            'accessId' => $accessId,
            'oficesId' => $oficesId,
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

        $giris = $request->input('giris');
        $cikis = $request->input('cikis');

        $accesses = $request->input('erisimler');
        $offices = $request->input('ofisler');

        $request->validate([
            'name' => 'required|max:50|min:3',
            'email' => 'required|email|max:50|min:3',
            'password' => 'required|max:50|min:8',
            'tip' => 'required|numeric',
            'giris' => 'required',
            'cikis' => 'required',
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
            "updated_at" => date('Y-m-d H:i:s'),
        ])) {
            DB::table('users_mesai')->where('user_id', '=', $id)->delete();
            DB::table('users_mesai')->insert(['giris' => $giris,
                'cikis' => $cikis,
                'user_id' => $id,
                "updated_at" => date('Y-m-d H:i:s'),
            ]);

            if (count((array)$accesses) > 0) {
                DB::table('users_access')->where('user_id', '=', $id)->delete();
                $arrayUserAccesses = array();
                foreach ($accesses as $access) {
                    $arrayUserAccesses = array_merge($arrayUserAccesses, array([
                        'user_id' =>  $id,
                        'access_id' => $access,
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ]));
                }
                DB::table('users_access')->insert($arrayUserAccesses);
            }
            if (count((array)$offices) > 0) {
                DB::table('users_application_offices')->where('user_id', '=', $id)->delete();
                $arrayUserOffices = array();
                foreach ($offices as $office) {
                    $arrayUserOffices = array_merge($arrayUserOffices, array([
                        'user_id' =>  $id,
                        'application_office_id' => $office,
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ]));
                }
                DB::table('users_application_offices')->insert($arrayUserOffices);
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
            DB::table('users')->where('id', '=', $id)->delete();

            $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
            return redirect('yonetim/users');
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/users');
        }
    }
}
