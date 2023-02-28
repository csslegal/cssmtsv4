<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebArticlesController extends Controller
{

    public function index($panel_id)
    {
        $webPanel = DB::table('web_panels')->where('id', '=', $panel_id)->first();
        $articles  = DB::table('web_articles')->where('panel_id', '=', $panel_id)->get();
        return view('management.web.api-panels.articles.index')->with([
            'articles' => $articles,
            'webPanel' => $webPanel
        ]);
    }

    public function create($panel_id)
    {
        $webPanel = DB::table('web_panels')->where('id', '=', $panel_id)->first();
        return view('management.web.api-panels.articles.create')->with([
            'webPanel' => $webPanel
        ]);;
    }

    public function store($panel_id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:200min:3',
            'description' => 'required',
            'content' => 'required',
            'image' => 'required',
        ]);

        if (DB::table('web_articles')->insert([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'image' => $request->input('image'),
            'url' => Str::of($request->input('title'))->slug('-'),
            'panel_id' => $panel_id,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ])) {
            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/web/api-panels/' . $panel_id . '/articles');
        } else {
            $request->session()->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/web/api-panels/' . $panel_id . '/articles');
        }
    }

    public function show($panel_id)
    {
        //
    }

    public function edit($panel_id, $article_id)
    {
        $webPanel = DB::table('web_panels')->where('id', '=', $panel_id)->first();
        $article = DB::table('web_articles')->where('id', '=', $article_id)->first();

        return view('management.web.api-panels.articles.edit')->with([
            'article' => $article,
            'webPanel' => $webPanel
        ]);
    }

    public function update($panel_id, $article_id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:200min:3',
            'description' => 'required',
            'content' => 'required',
            'image' => 'required',
        ]);

        if (DB::table('web_articles')->where('id', '=', $article_id)->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'image' => $request->input('image'),
            "updated_at" => date('Y-m-d H:i:s'),
        ])) {
            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/web/api-panels/' . $panel_id . '/articles');
        } else {
            $request->session()->flash('mesajDanger', 'Kayıt sıralasında sorun oluştu');
            return redirect('yonetim/web/api-panels/' . $panel_id . '/articles');
        }
    }

    public function destroy($panel_id, $article_id, Request $request)
    {
        if (is_numeric($article_id)) {
            if (DB::table('web_articles')->where('id', '=', $article_id)->delete()) {
                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/web/api-panels/' . $panel_id . '/articles');
            } else {
                $request->session()->flash('mesajDanger', 'Silinme sıralasında sorun oluştu');
                return redirect('yonetim/web/api-panels/' . $panel_id . '/articles');
            }
        } else {
            $request->session()->flash('mesajDanger', 'ID alınırken sorun oluştu');
            return redirect('yonetim/web/api-panels');
        }
    }
}
