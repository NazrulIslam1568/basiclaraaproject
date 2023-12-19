<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\AddCategory;
use Image;
use Illuminate\Support\Str;
use File;

class CategoryController extends Controller
{
    public function category($main_category_id = null){
        return view('backend.page.category.add_category')->with(compact('main_category_id'));
    }
    public function main_category(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            $category = new AddCategory;
            $category->name = $data['name'];
            $category->slug = Str::slug($data['name']);
            if($request->hasfile('image')){
                $img_tmp = $request->file('image');
                if($img_tmp->isvalid()){
                //image path code
                $file_name = $img_tmp->getClientOriginalName();
                $filename = 'nimnio_home_shop_'.$file_name;
                $img_name = str_replace(' ','-',$filename);
                $img_path = 'frontend/img/category/'.$img_name;
                //image resize
                Image::make($img_tmp)->save($img_path);
                $category->image = $img_name;
                }
            }
            $category->save();
        }
        return view('backend.page.category.main_category');

    }
    public function category_post(Request $request){
        $data = $request->all();
        $category = new Category;
        if($data['parent_id'] == 0){
            $category->main_category_id = $data['main_category_id'];
        }else{
            $category->parent_id = $data['parent_id'];
        }
        $category->category_name = $data['category_name'];
        $category->slug = Str::slug($data['category_name']);
        if($request->hasfile('banner_image')){
            $img_tmp = $request->file('banner_image');
            if($img_tmp->isvalid()){
            //banner_image path code
            $file_name = $img_tmp->getClientOriginalExtension();;
            $filename = $data['category_name'].'.'.$file_name;
            $img_name = str_replace(' ','-',$filename);
            $img_path = 'frontend/img/category/'.$img_name;
            //banner_image resize
            Image::make($img_tmp)->save($img_path);
            $category->banner_image = $img_name;
            }
        }
        if($request->hasfile('icon_image')){
            $img_tmp = $request->file('icon_image');
            if($img_tmp->isvalid()){
            //icon_image path code
            $file_name = $img_tmp->getClientOriginalExtension();;
            $filename = $data['category_name'].$file_name;
            $img_name = str_replace(' ','-',$filename);
            $img_path = 'frontend/img/category/'.$img_name;
            //icon_image resize
            Image::make($img_tmp)->save($img_path);
            $category->icon_image = $img_name;
            }
        }
        $category->save();
        return response()->json([
            'category'=>$data,
        ]);

    }
    public function sub_category_view($id=null){
        $sub_categories = Category::where(['main_category_id'=>$id])->get();
        return response()->json([
            'categories'=>$sub_categories,
        ]);
    }
    public function parent_category_view($id=null){
        $sub_categories = Category::where(['parent_id'=>$id])->orderBy('category_name', 'ASC')->get();
        return response()->json([
            'parent_categories'=>$sub_categories,
        ]);
    }
    public function view_category(){
        return view('backend.page.category.view_category');
    }
    public function category_hide_show($cat_id=null, $table_name=null){
        $category = Category::find($cat_id);
        $table_count = Category::where(['id'=>$cat_id])->where([$table_name=>1])->count();
        if($table_count > 0){
            Category::where(['id'=>$cat_id])->update([$table_name=>0]);
            $icon = 'fa-toggle-off';
            $color = '#ed2024';
        }else{
            Category::where(['id'=>$cat_id])->update([$table_name=>1]);
            $icon = 'fa-toggle-on';
            $color = 'blue';
        }
        return response()->json([
            'icon'=>$icon,
            'color'=>$color,
            'category_name'=>$category->category_name
        ]);
    }
    public function delete_category($id=null){
        $category = Category::find($id);
        $category_image_count = Category::where(['banner_image'=>$category->banner_image])->count();
        $destination = 'frontend/img/category/'.$category->banner_image;
        if($category_image_count < 2){
            if(File::exists($destination))
            {
                File::delete($destination);
            }
        }
        Category::where(['id'=>$id])->delete();
        return redirect()->back();
    }
    public function edit_category(Request $request, $id=null){
        $category = Category::find($id);
        if($request->ismethod('post')){
            $data = $request->all();
            $category->category_name = $data['category_name'];
            if($request->hasfile('banner_image')){
                $category_image_count = Category::where(['banner_image'=>$category->banner_image])->count();
                $destination = 'frontend/img/category/'.$category->banner_image;
                if($category_image_count < 2){
                    if(File::exists($destination))
                    {
                        File::delete($destination);
                    }
                }
                $img_tmp = $request->file('banner_image');
                if($img_tmp->isvalid()){
                //banner_image path code
                $file_name = $img_tmp->getClientOriginalExtension();;
                $filename = $data['category_name'].'.'.$file_name;
                $img_name = str_replace(' ','-',$filename);
                $img_path = 'frontend/img/category/'.$img_name;
                //banner_image resize
                Image::make($img_tmp)->save($img_path);
                $category->banner_image = $img_name;
                }
            }
            if($request->hasfile('icon_image')){
                $category_image_count = Category::where(['banner_image'=>$category->banner_image])->count();
                $destination = 'frontend/img/category/'.$category->banner_image;
                if($category_image_count < 2){
                    if(File::exists($destination))
                    {
                        File::delete($destination);
                    }
                }
                $img_tmp = $request->file('icon_image');
                if($img_tmp->isvalid()){
                //icon_image path code
                $file_name = $img_tmp->getClientOriginalExtension();;
                $filename = $data['category_name'].$file_name;
                $img_name = str_replace(' ','-',$filename);
                $img_path = 'frontend/img/category/'.$img_name;
                //icon_image resize
                Image::make($img_tmp)->save($img_path);
                $category->icon_image = $img_name;
                }
            }
            $category->update();
            return redirect()->back();
        }
        return view('backend.page.category.edit_category')->with(compact('category'));
    }
}
