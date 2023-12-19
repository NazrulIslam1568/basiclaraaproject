<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\AddBrand;
use App\Models\Banner;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\BazarName;
use App\Models\ElakaName;
use Auth;

class PageFController extends Controller
{
    public function home(){
        $categories = Category::where('main_category_id','>',0)->orderby('category_name', 'ASC')->get();
        // print_r($categories);die;
        $sliders = Banner::get();
        $brands = AddBrand::orderby('name', 'ASC')->get();
        return view('frontend.page.home')->with(compact('categories','sliders','brands'));
    }
    public function shop(){
        
        $products = Product::orderBy('product_name', 'ASC')->where(['status'=>1])->get();
        return view('frontend.page.shop')->with(compact('products'));
    }
    public function frontend_sub_category_view($category_id = null){
        $category_first = Category::where(['slug'=>$category_id])->count();
        if($category_first > 0){
            $category_first = Category::where(['slug'=>$category_id])->first();
            $categories = Category::where(['parent_id'=>$category_first->id])->where(['status'=>1])->get();
            return view('frontend.page.sub_category_view')->with(compact('category_first','categories'));
        }else{
            return redirect()->back();;
        }
    }
    public function category_product_view($category_id = null){
        $category_first = Category::where(['slug'=>$category_id])->first();
        $products = Product::where(['sub_category_id'=>$category_first->id])->orderBy('product_name', 'ASC')->get();
        return view('frontend.page.category_product_view')->with(compact('products','category_first'));
    }
    public function brand_product_view($brand_id = null){
        $brand_first = AddBrand::where(['slug'=>$brand_id])->first();
        $products = Product::where(['brand'=>$brand_first->name])->get();
        return view('frontend.page.brand_product_view')->with(compact('products','brand_first'));
    }
    public function terms_and_condition(){
        return view('frontend.page.terms_and_condition');
    }
    public function orders(){
        return view('frontend.partials.orders');
    }
    public function balance_history(){
        return view('frontend.partials.balance');
    }
    public function user_profile(){
        return view('frontend.partials.profile');
    }
    public function update_address(Request $request){
        $user_id = Auth::user()->id;
        $data = $request->all();
        // User Address Route
        if($data['division']){
            if($data['district']){
                if($data['upazila']){
                    if($data['bazar_name']){
                        if($data['elaka_name']){
                            if($data['detail_address']){
                                    $division_name = Division::where(['division_id'=>$data['division']])->first();
                                    $district_name = District::where(['district_id'=>$data['district']])->first();
                                    $upazila_name = Upazila::where(['upazila_id'=>$data['upazila']])->first();
                                    $bazar_name = BazarName::where(['bazar_name_id'=>$data['bazar_name']])->first();
                                    $elaka_name = ElakaName::where(['elaka_name_id'=>$data['elaka_name']])->first();
                                    $user = User::find($user_id);
                                    $user->division = $division_name->name;
                                    $user->district = $district_name->name;
                                    $user->upazila = $upazila_name->name;
                                    $user->bazar_name = $bazar_name->bazar_name;
                                    $user->elaka_name = $elaka_name->elaka_name;
                                    $user->detail_address = $data['detail_address'];
                                    $user->update();
                                    return response()->json([
                                        'title'=>'Success',
                                        'message'=>'Your Account Updated Successfull.',
                                        'icon'=>'success',
                                    ]);
                            }else{
                                return response()->json([
                                    'title'=>'Error',
                                    'message'=>'Please Select Your Detail Address',
                                    'icon'=>'warning',
                                ]);
                            }
                        }else{
                            return response()->json([
                                'title'=>'Error',
                                'message'=>'Please Select Your Home Address',
                                'icon'=>'warning',
                            ]);
                        }
                    }else{
                        return response()->json([
                            'title'=>'Error',
                            'message'=>'Please Select Your Nearest Address',
                            'icon'=>'warning',
                        ]);
                    }
                }else{
                    return response()->json([
                        'title'=>'Error',
                        'message'=>'Please Select Your Upazila',
                        'icon'=>'warning',
                    ]);
                }
            }else{
                return response()->json([
                    'title'=>'Error',
                    'message'=>'Please Select Your District',
                    'icon'=>'warning',
                ]);
            }
        }else{
            return response()->json([
                'title'=>'Error',
                'message'=>'Please Select Your Division',
                'icon'=>'warning',
            ]);
        }

    }
    public function change_address(){
        return view('frontend.partials.change-address');
    }
    public function user_balance(){
        return view('frontend.partials.user_balance');
    }
    public function contact_us(){
        return view('frontend.page.contact_us');
    }
    public function about(){
        return view('frontend.page.about');
    }
}
