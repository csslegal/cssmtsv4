<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LoggingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Response $response)
    {
        /**Dosyadaki log kayıtları*/
        $fileLogs = [];
        $logFiles = [];
        $logFileNames = [];

        /**dizindeki log dosyaları*/
        $tempLogFileNames = array_filter(
            scandir(storage_path() . '/logs'),
            fn ($fn) => !str_starts_with($fn, '.') // filter everything that begins with dot
        );

        foreach ($tempLogFileNames as $tempLogFileName) {
            array_push($logFileNames, $tempLogFileName);
        }

        $logFileNames = array_reverse($logFileNames);

        /**gecerli sayfa sayısı*/
        $page = isset($request->page) ? $request->page : 1;
        $page = $page <= 0 ? 1 : $page;

        /**toplam sayfa sayısı*/
        $totalContentCount = count($logFileNames);

        /**her sayfada gösterilecek içerik sayısı*/
        $showContentCount = 10;

        /**kısaltma miktari ne kadaar düsüşise o kadar az button görüntüleecektir. */
        $shortSize = 0;

        /**son sayfa sayısı */
        $endPage = ceil($totalContentCount / $showContentCount);

        /**ilk sayfa sayısı*/
        $startPage = ($page - 1) * $showContentCount;

        /**Bitiş sayfa sayısı buyukse */
        if ($endPage >= $page) {
            for ($i = $startPage; $i < $startPage + $showContentCount; $i++) {
                isset($logFileNames[$i]) ? array_push($logFiles, $logFileNames[$i]) : "";
            }
        }

        return view('management.logging.index')->with([
            'logFiles' => $logFiles,
            'fileLogs' => $fileLogs,
            'pages' => [
                'page' => $page,
                'endPage' => $endPage,
                'shortSize' => $shortSize,
                'totalContentCount' => $totalContentCount,
                'showContentCount' => $showContentCount,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $fileLogs = [];
        $logFiles = [];
        $logFileNames = [];

        $tempLogFileNames = array_filter(
            scandir(storage_path() . '/logs'),
            fn ($fn) => !str_starts_with($fn, '.') // filter everything that begins with dot
        );

        foreach ($tempLogFileNames as $tempLogFileName) {
            array_push($logFileNames, $tempLogFileName);
        }
        $logFileNames = array_reverse($logFileNames);

        /**gecerli sayfa sayısı*/
        $page = isset($request->page) ? $request->page : 1;
        $page = $page <= 0 ? 1 : $page;

        /**toplam sayfa sayısı*/
        $totalContentCount = count($logFileNames);

        /**her sayfada gösterilecek içerik sayısı*/
        $showContentCount = 10;

        /**kısaltma miktari ne kadaar düsüşise o kadar az button görüntüleecektir. */
        $shortSize = 0;

        /**son sayfa sayısı */
        $endPage = ceil($totalContentCount / $showContentCount);

        /**ilk sayfa sayısı*/
        $startPage = ($page - 1) * $showContentCount;

        /**Bitiş sayfa sayısı buyukse */
        if ($endPage >= $page) {
            for ($i = $startPage; $i < $startPage + $showContentCount; $i++) {
                isset($logFileNames[$i]) ? array_push($logFiles, $logFileNames[$i]) : "";
            }
        }

        $logFile = file(storage_path() . '/logs/' . $id);

        foreach ($logFile as $line_num => $line) {
            if (count($logFile) > 0)
                $fileLogs[] = array('line' => $line_num, 'content' => ($line));
        }

        return view('management.logging.index')->with([
            'fileLogs' => $fileLogs,
            'logFiles' => $logFiles,
            'pages' => [
                'page' => $page,
                'endPage' => $endPage,
                'shortSize' => $shortSize,
                'totalContentCount' => $totalContentCount,
                'showContentCount' => $showContentCount,
            ]
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
    public function destroy($id, Request $request)
    {
        if (is_file(storage_path() . '/logs/' . $id)) {
            unlink(storage_path() . '/logs/' . $id);

            $request->session()->flash('mesajSuccess', 'Dosya silindi');
            return redirect('yonetim/logging');
        } else {
            $request->session()->flash('mesajDanger', 'Dosya bulunamadı');
            return redirect('yonetim/logging');
        }
    }
}
