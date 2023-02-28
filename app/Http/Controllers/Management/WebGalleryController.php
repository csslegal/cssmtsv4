<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class WebGalleryController extends Controller
{
    public function index($panel_id)
    {
        $webPanel = DB::table('web_panels')->where('id', '=', $panel_id)->first();
        $images  = DB::table('web_gallery')->where('panel_id', '=', $panel_id)->get();

        return view('management.web.api-panels.gallery.index')->with([
            'images' => $images,
            'webPanel' => $webPanel
        ]);
    }
    public function store($panel_id, Request $request)
    {


        if ($request->hasFile('image')) {
            $path = 'uploads/' . $panel_id;

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $image = Image::make($request->file('image'));
            $imageName = Str::slug($request->input('alt')) . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();

            $image->save(public_path('uploads/' . $panel_id . '/') . $imageName);

            DB::table('web_gallery')->insert([
                'name' => $imageName,
                'alt' => $request->input('alt'),
                'panel_id' => $panel_id,
                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]);
            $request->session()->flash('mesajSuccess', 'Başarıyla kaydedildi');
            return redirect('yonetim/web/api-panels/' . $panel_id . '/gallery');
        }
    }

    public function destroy($panel_id, $id, Request $request)
    {
        if (DB::table('web_gallery')->where('id', '=', $id)->count() > 0) {

            $image = DB::table('web_gallery')->where('id', '=', $id)->first();
            $image_path = 'uploads/' . $panel_id . '/' . $image->name;

            if (File::exists($image_path)) {
                //File::delete($image_path);
                unlink($image_path);
                DB::table('web_gallery')->where('id', '=', $id)->delete();

                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/web/api-panels/' . $panel_id . '/gallery');
            } else {
                DB::table('web_gallery')->where('id', '=', $id)->delete();

                $request->session()->flash('mesajSuccess', 'Başarıyla silindi');
                return redirect('yonetim/web/api-panels/' . $panel_id . '/gallery');
            }
        }
    }
}
