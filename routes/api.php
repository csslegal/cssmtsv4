<?php

use App\Models\Articles;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;

use App\Models\Questions;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionCollection;

use App\Models\Others;
use App\Http\Resources\OtherResource;
use App\Http\Resources\OtherCollection;

use App\Models\ContactForm;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {

    Route::get('article/{url}', function ($url, Request $request) {
        if (
            Articles::where('url',  $url)->count() > 0  &&
            DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
        ) return new ArticleResource(Articles::where('url',  $url)->first());
        else return response()->json(["data" => []]);
    });
    Route::get('{panel_id}/articles', function ($panel_id, Request $request) {
        if (
            is_numeric($panel_id) &&
            DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
        ) {
            if (Articles::where('panel_id', $panel_id)->count() > 0)
                return new ArticleCollection(Articles::where('panel_id',  $panel_id)->orderBy('id', 'DESC')->get());
            else return response()->json(["data" => []]);
        } else return response()->json(["data" => []]);
    });
    Route::get('question/{url}', function ($url, Request $request) {
        if (
            Questions::where('url',  $url)->count() > 0 &&
            DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
        ) return new QuestionResource(Questions::where('url',  $url)->first());
        else return response()->json(["data" => []]);
    });
    Route::get('{panel_id}/questions', function ($panel_id, Request $request) {
        if (
            is_numeric($panel_id) &&
            DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
        ) {
            if (Questions::where('panel_id', $panel_id)->count() > 0)
                return new QuestionCollection(Questions::where('panel_id',  $panel_id)->orderBy('id', 'DESC')->get());
            else return response()->json(["data" => []]);
        } else return response()->json(["data" => []]);
    });
    Route::get('other/{url}', function ($url, Request $request) {
        if (
            Others::where('url',  $url)->count() > 0 &&
            DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
        ) return new OtherResource(Others::where('url',  $url)->first());
        else return response()->json(["data" => []]);
    });
    Route::get('{panel_id}/others', function ($panel_id, Request $request) {
        if (
            is_numeric($panel_id) &&
            DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
        ) {
            if (Others::where('panel_id', $panel_id)->count() > 0)
                return new OtherCollection(Others::where('panel_id',  $panel_id)->orderBy('id', 'DESC')->get());
            else return response()->json(["data" => []]);
        } else return response()->json(["data" => []]);
    });
    Route::group(['prefix' => 'count'], function () {
        Route::get('question/{id}', function ($id, Request $request) {
            if (
                is_numeric($id) &&
                DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
            ) Questions::where('id', $id)->update(['hit' => DB::raw('hit+1')]);
        });
        Route::get('article/{id}', function ($id, Request $request) {
            if (
                is_numeric($id) &&
                DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
            ) Articles::where('id', $id)->update(['hit' => DB::raw('hit+1')]);
        });
        Route::get('other/{id}', function ($id, Request $request) {
            if (
                is_numeric($id) &&
                DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
            ) Others::where('id', $id)->update(['hit' => DB::raw('hit+1')]);
        });
    });
    Route::group(['prefix' => 'contact'], function () {
        Route::post('/', function (Request $request) {
            if (
                is_numeric($request->panel_id) &&
                DB::table("web_panels")->where('token', '=', $request->token)->count() > 0
            ) {
                $contactForm = new ContactForm();
                $contactForm->name = $request->name;
                $contactForm->phone = $request->phone;
                $contactForm->panel_id = $request->panel_id;
                $contactForm->email = $request->email;
                $contactForm->subject = $request->subject;
                $contactForm->content = $request->content;
                $contactForm->save();
                return response()->json(["data" => ["message" => "Mesajınız başarıyla kaydı alındı"]]);
            } else {
                return response()->json(["data" => ["message" => "Hatalı istek yapıldı"]]);
            }
        });
    });
});
