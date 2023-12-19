<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use App\Models\User;
use Auth;
use File;

class ImageController extends Controller
{
    public function profile_picture_update(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            if($request->hasfile('image')){
                $destination = 'frontend/img/user/'.Auth::user()->image;
                if(Auth::user()->image == 'avatar.png'){
                    
                }else{
                    if(File::exists($destination))
                    {
                        File::delete($destination);
                    }    
                }
                $img_tmp = $request->file('image');
                if($img_tmp->isvalid()){
                //image path code
                $file_name = $img_tmp->getClientOriginalName();
                $filename = 'nimnio_home_shop_'.$file_name;
                $img_name = str_replace(' ','-',$filename);
                $img_path = 'frontend/img/user/'.$img_name;
                //image resize
                Image::make($img_tmp)->fit(80)->save($img_path);
                User::where(['id'=>Auth::user()->id])->update(['image'=>$img_name]);
                }
            }
            return response()->json([
                'image_link'=>$img_name,
            ]);
        }
    }
}
