<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use DB;
use Image;
use Auth;
use File;

class ProductController extends Controller
{
    public function add_product(){
        return view('backend.page.product.add_product');
    }
    public function add_product_post(Request $request){
        $products = new Product;
        $code_generator = mt_rand(10,90);
        $last_product = DB::table('products')->orderBy('id', 'DESC')->first();
        $data = $request->all();
        $products->main_category_id = $data['product_main_category'];
        $products->sub_category_id = $data['sub_category'];
        $products->parent_category_id = $data['parent_category'];
        $products->product_name = $data['product_name'];
        $products->type = $data['type'];
        $products->product_weight = $data['product_weight'];
        $products->product_desc = $data['product_description'];
        $products->product_price = $data['price'];
        $products->old_price = $data['old_price'];
        $products->buy_price = $data['buy_price'];
        $products->stock = $data['stock'];
        if(Auth::check()){
            $products->user_id = Auth::user()->id;
        }
        $products->product_code = 'nim'.$code_generator.$last_product->id+1;
        $products->product_url = $data['product_name'].$products->product_code.$data['product_description'];
        if($request->hasfile('image')){
            $img_tmp = $request->file('image');
            if($img_tmp->isvalid()){
            //image path code
            $file_name = $img_tmp->getClientOriginalExtension();
            $filename = 'nimnio_online_shop_'.$data['product_name'].'.'.$file_name;
            $img_name = str_replace(' ','-',$filename);
            $img_path = 'frontend/img/product/'.$img_name;
            //image resize
            Image::make($img_tmp)->encode('webp', 90)->save($img_path);
            $products->image = $img_name;
            }
        }
        $products->brand = $data['brand'];
        $category= Category::where(['id'=>$data['parent_category']])->first();
        $products->category = $category->category_name;
        $products->choice = $data['choice'];
        $products->save();
    }
    public function view_product(){
        return view('backend.page.product.view_product');
    }
    public function view_product_ajax(){
        $products = Product::all();
        return response()->json([
            'products'=>$products,
        ]);
    }
    public function delete_product($id=null){
        $product = DB::table('products')->where(['id'=>$id])->first();
        $all_products = DB::table('products')->where(['image'=>$product->image])->count();
        $destination = 'frontend/img/product/'.$product->image;
        if($all_products < 2){
            if(File::exists($destination))
            {
                File::delete($destination);
            }
        }
        Product::where(['id'=>$id])->delete();
    }
    public function edit_product($id=null){
        $product = Product::find($id);
        return response()->json([
            'product'=>$product,
        ]);
    }
    public function update_product_post(Request $request, $id=null){
        $products = Product::find($id);
        $data = $request->all();
        $all_products = DB::table('products')->where(['image'=>$products->image])->count();
        $products->product_name = $data['product_name'];
        $products->product_desc = $data['product_description'];
        $products->product_price = $data['price'];
        $products->old_price = $data['old_price'];
        $products->buy_price = $data['buy_price'];
        $products->buy_price = $data['buy_price'];
        $products->choice = $data['choice'];
        $products->product_weight = $data['product_weight'];
        if($request->hasfile('image')){
            $destination = 'frontend/img/product/'.$products->image;
            if($all_products < 2){
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
            }
            $img_tmp = $request->file('image');
            if($img_tmp->isvalid()){
            //image path code
            $file_name = $img_tmp->getClientOriginalExtension();
            $filename = 'nimnio_online_shop_'.$data['product_name'].'.'.$file_name;
            $img_name = str_replace(' ','-',$filename);
            $img_path = 'frontend/img/product/'.$img_name;
            //image resize
            Image::make($img_tmp)->encode('webp', 90)->save($img_path);
            $products->image = $img_name;
            }
        }
        $products->update();
    }
    public function update_product_price(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
        }
        return view('backend.page.product.update_product_price');
    }
    public function product_price_update_support(Request $request, $product_price=null, $product_id=null){
        if(Auth::user()->role_as == 'Admin' || Auth::user()->role_as == 'Support'){
            Product::where(['id'=>$product_id])->update(['product_price'=>$product_price]);
            return response()->json([
                'product_id'=>$product_id,
            ]);
        }else{
            return redirect()->back();
        }
    }
    public function product_update_check(){
        return view('backend.page.product.product_update_check');
    }
    public function offer_product(){
        return view('backend.page.product.offer_product');
    }
    public function editable_product(){
        return view('backend.page.product.editable_product');
    }
    public function all_hide_show($id=null, $field_name=null, $db_name=null){
        $product = DB::table($db_name)->find($id);
        $field_count = DB::table($db_name)->where(['id'=>$id])->where([$field_name=>1])->count();
        if($field_count > 0){
            DB::table($db_name)->where(['id'=>$id])->update([$field_name=>0]);
            $icon = 'fa-toggle-off';
            $color = '#ed2024';
        }else{
            DB::table($db_name)->where(['id'=>$id])->update([$field_name=>1]);
            $icon = 'fa-toggle-on';
            $color = 'blue';
        }
        return response()->json([
            'icon'=>$icon,
            'color'=>$color,
            'product_name'=>$product->product_name
        ]);
    }
    public function visible_product(){
        return view('backend.page.product.visible_product');
    }
    public function web_update_product_status_change($table_name, $column_name){
        return($table_name);
    }
}
