<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\BazarName;
use App\Models\ElakaName;

class AddressController extends Controller
{
    public function add_district_view($district_id = null){
        $district_get = District::where(['division_id'=>$district_id])->where(['status'=>1])->get();
        $division_get = Division::where(['division_id'=>$district_id])->get();
        return response()->json([
            'districts'=>$district_get,
            'divisions'=>$division_get,
        ]);
    }
    public function add_upazila_view($upazila_id = null){
        $upazila_get = Upazila::where(['district_id'=>$upazila_id])->where(['status'=>1])->get();
        $district_get = District::where(['district_id'=>$upazila_id])->get();
        return response()->json([
            'upazilas'=>$upazila_get,
            'districts'=>$district_get,
        ]);
    }
    public function add_bazar_name_view($bazar_name_id = null){
        $bazar_name_get = BazarName::where(['upazila_id'=>$bazar_name_id])->where(['status'=>1])->get();
        $upazila_get = Upazila::where(['upazila_id'=>$bazar_name_id])->get();
        return response()->json([
            'bazar_names'=>$bazar_name_get,
            'upazilas'=>$upazila_get,
        ]);
    }
    public function add_elaka_name_view($elaka_name_id = null){
        $elaka_name_get = ElakaName::where(['bazar_name_id'=>$elaka_name_id])->where(['status'=>1])->get();
        $bazar_names = BazarName::where(['bazar_name_id'=>$elaka_name_id])->get();
        return response()->json([
            'elaka_names'=>$elaka_name_get,
            'bazar_names'=>$bazar_names,
        ]);
    }
}
