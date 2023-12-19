<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddRestaurant;
use App\Models\Upazila;
use App\Models\Division;
use App\Models\District;
use App\Models\Category;
use App\Models\Product;
use App\Models\RestaurantProduct;
use Auth;
use Image;
use File;
use DB;

class RestaurantController extends Controller
{
    public function add_restaurants(){
        return view('backend.page.restaurant.add_restaurants');
    }
    public function add_restaurants_post(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            $division_id = Division::where(['division_id'=>$data['division']])->first();
            $district_id = District::where(['district_id'=>$data['district_name']])->first();
            $upazila_id = Upazila::where(['upazila_id'=>$data['upazila_name']])->first();
            $restaurant = new AddRestaurant;
            $restaurant->division_id = $division_id->id;
            $restaurant->district_id = $district_id->id;
            $restaurant->upazila_id = $upazila_id->id;
            $restaurant->name = $data['name'];
            $restaurant->perchantage = $data['perchantage'];
            if($request->hasfile('image')){
                $img_tmp = $request->file('image');
                if($img_tmp->isvalid()){
                //image path code
                $file_name = $img_tmp->getClientOriginalExtension();
                $filename = 'nimnio_online_shop_'.$data['name'].'.'.$file_name;
                $img_name = str_replace(' ','-',$filename);
                $img_path = 'frontend/img/restaurant/'.$img_name;
                //image resize
                Image::make($img_tmp)->encode('webp', 90)->save($img_path);
                $restaurant->image = $img_name;
                }
            }
            $restaurant->save();
        }
        return redirect()->back();
    }
    public function edit_restaurants($id=null){
        $restaurant = AddRestaurant::where(['id'=>$id])->first();
        $division = Division::where(['id'=>$restaurant->division_id])->first();
        $district = District::where(['id'=>$restaurant->district_id])->first();
        $upazila = Upazila::where(['id'=>$restaurant->upazila_id])->first();
        // print($district->name);die;
        return view('backend.page.restaurant.edit_restaurant')->with(compact('division','district','upazila','restaurant'));
    }
    public function edit_restaurants_post(Request $request, $id=null){
        if($request->ismethod('post')){
            $data = $request->all();
            $division_id = Division::where(['division_id'=>$data['division']])->first();
            $district_id = District::where(['district_id'=>$data['district_name']])->first();
            $upazila_id = Upazila::where(['upazila_id'=>$data['upazila_name']])->first();
            $restaurant = AddRestaurant::find($id);
            $restaurant->division_id = $division_id->id;
            $restaurant->district_id = $district_id->id;
            $restaurant->upazila_id = $upazila_id->id;
            $restaurant->name = $data['name'];
            $restaurant->perchantage = $data['perchantage'];
            if($request->hasfile('image')){
                $restaurant_image_count = AddRestaurant::where(['image'=>$restaurant->image])->count();
                $destination = 'frontend/img/restaurant/'.$restaurant->image;
                if($restaurant_image_count < 2){
                    if(File::exists($destination))
                    {
                        File::delete($destination);
                    }
                }
                $img_tmp = $request->file('image');
                if($img_tmp->isvalid()){
                //image path code
                $file_name = $img_tmp->getClientOriginalExtension();
                $filename = 'nimnio_online_shop_'.$data['name'].'.'.$file_name;
                $img_name = str_replace(' ','-',$filename);
                $img_path = 'frontend/img/restaurant/'.$img_name;
                //image resize
                Image::make($img_tmp)->encode('webp', 90)->save($img_path);
                $restaurant->image = $img_name;
                }
            }
            $restaurant->update();
            return response()->json([
                'id'=>$data,
            ]);
        }
        
    }
    public function add_restaurant_product(){
        $restaurants = AddRestaurant::orderBy('name', 'ASC')->get();
        return view('backend.page.restaurant.add_restaurant_product')->with(compact('restaurants'));
    }
    public function restaurant_all_item($restaurant_id=null){
        $category = Category::where(['slug'=>'restaurant'])->first();
        $all_items = Category::where(['parent_id'=>$category->id])->orderBy('category_name', 'ASC')->get();
        return view('backend.page.restaurant.restaurant_all_item')->with(compact('all_items','restaurant_id'));
    }
    public function restaurant_add_product($restaurant_id = null, $category_id = null){
        $restaurant = AddRestaurant::where(['id'=>$restaurant_id])->first();
        $category = Category::where(['id'=>$category_id])->first();
        $products = Product::where(['parent_category_id'=>$category_id])->get();
        // print($products);die;
        return view('backend.page.restaurant.add_final_restaurant_product')->with(compact('products','restaurant','category'));
    }
    public function add_restaurant_product_post(Request $request, $restaurant_id = null, $category_id = null){
        if($request->ismethod('post')){
            $data = $request->all();
            $code_generator = mt_rand(10,90);
            $last_product = RestaurantProduct::orderBy('id', 'DESC')->first();
            // print_r($data);
            $restaurant_product = new RestaurantProduct;
            $restaurant_product->status = 1;
            $restaurant_product->restaurant_id = $restaurant_id;
            $restaurant_product->category_id = $category_id;
            if($data['main_product_id']){
                $restaurant_product->main_product_id = $data['main_product_id'];
            }else{
                $restaurant_product->main_product_id = 1148;
            }
            if($last_product){
                $restaurant_product->product_code = 'res'.$code_generator.$last_product->id+1;
            }else{
                $restaurant_product->product_code = 'res'.$code_generator.'1';
            }
            $restaurant_product->product_name = $data['product_name'];
            $restaurant_product->product_url = $data['product_name'].$restaurant_product->product_code;
            $restaurant_product->product_weight = $data['product_weight'];
            $restaurant_product->user_id = Auth::user()->id;
            $restaurant_product->product_price = $data['price'];
            $restaurant_product->save();
            return redirect()->back();
        }
    }
    public function edit_restaurant_product($restaurant_id = null){
        $restaurant_product = RestaurantProduct::where(['id'=>$restaurant_id])->first();
        return view('backend.page.restaurant.edit_final_restaurant_product')->with(compact('restaurant_id','restaurant_product'));
    }
    public function edit_restaurant_product_post(Request $request, $restaurant_id = null){
        if($request->ismethod('post')){
            $data = $request->all();
            $restaurant_product = RestaurantProduct::find($restaurant_id);
            $restaurant_product->product_name = $data['product_name'];
            $restaurant_product->product_weight = $data['product_weight'];
            $restaurant_product->product_price = $data['price'];
            $restaurant_product->update();
        }
        return redirect(route('restaurant_add_product',[$restaurant_product->restaurant_id,$restaurant_product->category_id]));
    }
    public function restaurant_visible_status_0(){
        DB::table('products')->where(['type'=>'restaurant'])->update(['status'=>0, 'visible'=>0]);
        return redirect()->back();
    }
}
