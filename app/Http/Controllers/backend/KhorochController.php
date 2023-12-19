<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Khoroch;
use Carbon\Carbon;


class KhorochController extends Controller
{
    public function add_product_khoroch(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            $product_khoroch = new Khoroch;
            $product_khoroch->khoroch_name = 'Product';
            $product_khoroch->description = $data['khoroch_title'];
            $product_khoroch->tk =  $data['amount'];
            $product_khoroch->date =  Carbon::parse($data['date'])->format('Y-m-d');
            $product_khoroch->save();
        }
        return view('backend.page.khoroch.add_product_khoroch');
    }
    public function add_personal_khoroch(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            $product_khoroch = new Khoroch;
            $product_khoroch->khoroch_name = 'Personal';
            $product_khoroch->description = $data['khoroch_title'];
            $product_khoroch->tk =  $data['amount'];
            $product_khoroch->date =  Carbon::parse($data['date'])->format('Y-m-d');
            $product_khoroch->save();
        }
        return view('backend.page.khoroch.add_personal_khoroch');
    }
}
