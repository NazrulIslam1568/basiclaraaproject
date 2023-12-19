<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponBController extends Controller
{
    public function add_coupon(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            $coupon = new Coupon;
            $coupon->coupon_name = $data['coupon_name'];
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date =  Carbon::parse($data['expiry_date'])->format('Y-m-d');
            $coupon->status = 1;
            $coupon->save();
            return redirect()->back();
        }
        return view('backend.page.coupon.add_coupon');
    }

    public function coupon_status_change($coupon_id=null){
        $coupon_first = Coupon::where(['id'=>$coupon_id])->first();
        $coupon_status_check = $coupon_first->status;
        if($coupon_status_check == 1){
            Coupon::where(['id'=>$coupon_id])->update(['status'=>0]);
            return response()->json([
                'status'=>'fa-toggle-off',
                'color'=>'#ed2024',
                'remove_class'=>'fa-toggle-on',
            ]);
        }else{
            Coupon::where(['id'=>$coupon_id])->update(['status'=>1]);
            return response()->json([
                'status'=>'fa-toggle-on',
                'color'=>'blue',
                'remove_class'=>'fa-toggle-off',

            ]);
        }
        
    }
    public function coupon_delete($id=null){
        Coupon::where(['id'=>$id])->delete();
        return redirect()->back();
    }
}
