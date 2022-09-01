<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LoggingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /***Dosyadaki log kayıtları */
        $fileLogs = [];

        /***dizindeki log dosyaları */
        $logFiles = array_filter(
            scandir(storage_path() . '/logs'),
            fn ($fn) => !str_starts_with($fn, '.') // filter everything that begins with dot
        );

        return view('management.logging.index')->with([
            'logFiles' => $logFiles,
            'fileLogs' => $fileLogs,
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $logFiles = array_filter(
            scandir(storage_path() . '/logs'),
            fn ($fn) => !str_starts_with($fn, '.') // filter everything that begins with dot
        );


        // from PHP documentations
        $logFile = file(storage_path() . '/logs\/' . $id);
        $fileLogs = [];
        // Loop through an array, show HTML source as HTML source; and line numbers too.
        foreach ($logFile as $line_num => $line) {
            /***
            $explode = explode('local.INFO:', htmlspecialchars($line));
            if (count($explode) > 0)
                $fileLogs[] = array('line' => $line_num, 'date' => $explode[0], 'content' => $explode[1]);

             */
            if (count($logFile) > 0)
                $fileLogs[] = array('line' => $line_num, 'content' => ($line));
        }

        return view('management.logging.index')->with([
            'fileLogs' => $fileLogs,
            'logFiles' => $logFiles,
        ]);
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
