<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Image;

class BannerController extends Controller
{
    public function add_banner(Request $request){
        $banner = Slider::count();
        // print_r($banner);
        if($request->ismethod('post')){
            $data = $request->all();
            $banner = new Slider;
            $banner->slider_name = $data['slider_name'];
            $banner->slider_no = Slider::count() + 1;
            $banner->image_url = $data['url'];
            if($request->hasfile('image')){
                echo $img_tmp = $request->file('image');
                if($img_tmp->isvalid()){
                   //image path code
                $file_name = $img_tmp->getClientOriginalName();
                $filename = 'nimnio_'.$file_name;
                $img_path = 'image/banner/'.$filename;
                //image resize
                Image::make($img_tmp)->save($img_path);
                $banner->image = $filename; 
                }
            }
            $banner->save();
            return redirect()->back();
        }
        return view('backend.page.banner.add_banner');
    }
}
