<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\ElakaName;
use App\Models\BazarName;
use DB;

class AddressBController extends Controller
{
    public function add_address(){
        return view('backend.page.address.add_address');
    }
    public function add_address_post(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            if($data['division'] == 0){
                $division = new Division;
                $division->name = $data['address'];
                if(Division::count() > 0){
                    $division_id = Division::orderBy('id', 'DESC')->first();
                    $division->division_id = 'division-'.$division_id->id+1;
                }else{
                    $division->division_id = 'division-1';
                }
                $division->save();
            }else{
                if($data['district_name'] == 0){
                    $district_id = District::orderBy('id', 'DESC')->first();
                    $district = new District;
                    $district->name = $data['address'];
                    if(District::count() > 0){
                        $district->district_id = 'district-'.$district_id->id+1;
                    }else{
                        $district->district_id = 'district-1';
                    }
                    $district->division_id = $data['division'];
                    $district->save();
                }else{
                    if($data['upazila_name'] == 0){
                        $upazila_id = Upazila::orderBy('id', 'DESC')->first();
                        $upazila = new Upazila;
                        $upazila->name = $data['address'];
                        if(Upazila::count() > 0){
                            $upazila->upazila_id = 'upazila-'.$upazila_id->id+1;
                        }else{
                            $upazila->upazila_id = 'upazila-1';
                        }
                        $upazila->district_id = $data['district_name'];

                        $upazila->save();
                    }else{
                        if($data['bazar_name'] == 0){
                            
                            $bazar_name_id = BazarName::orderBy('id', 'DESC')->first();
                            $bazar_name = new BazarName;
                            $bazar_name->bazar_name = $data['address'];
                            if(BazarName::count() > 0){
                                $bazar_name->bazar_name_id = 'bazar_name-'.$bazar_name_id->id+1;
                            }else{
                                $bazar_name->bazar_name_id = 'bazar_name-1';
                            }
                            $bazar_name->upazila_id = $data['upazila_name'];
                            $bazar_name->save();
                        }else{
                            $elaka_name_id = ElakaName::orderBy('id', 'DESC')->first();
                            $elaka_name = new ElakaName;
                            $elaka_name->elaka_name = $data['address'];
                            if(ElakaName::count() > 0){
                                $elaka_name->elaka_name_id = 'elaka_name-'.$elaka_name_id->id+1;
                            }else{
                                $elaka_name->elaka_name_id = 'elaka_name-1';
                            }
                            $elaka_name->bazar_name_id = $data['bazar_name'];
                            $elaka_name->save();
                        }
                    }
                }
            }
        }
    }
    public function view_address(){
        return view('backend.page.address.view_address');
    }
    public function address_hide_show($address_id=null, $table_name=null, $click=null){
        $address = DB::table($click)->find($address_id);
        $table_count = DB::table($click)->where(['id'=>$address_id])->where([$table_name=>1])->count();
        if($table_count > 0){
            DB::table($click)->where(['id'=>$address_id])->update([$table_name=>0]);
            $icon = 'fa-toggle-off';
            $color = '#ed2024';
        }else{
            DB::table($click)->where(['id'=>$address_id])->update([$table_name=>1]);
            $icon = 'fa-toggle-on';
            $color = 'blue';
        }
        return response()->json([
            'icon'=>$icon,
            'color'=>$color
        ]);
    }
    public function add_district_view($district_id = null){
        $district_get = District::where(['division_id'=>$district_id])->get();
        $division_get = Division::where(['division_id'=>$district_id])->get();
        return response()->json([
            'districts'=>$district_get,
            'divisions'=>$division_get,
        ]);
    }
    public function add_upazila_view($upazila_id = null){
        $upazila_get = Upazila::where(['district_id'=>$upazila_id])->get();
        $district_get = District::where(['district_id'=>$upazila_id])->get();
        return response()->json([
            'upazilas'=>$upazila_get,
            'districts'=>$district_get,
        ]);
    }
    public function add_bazar_name_view($bazar_name_id = null){
        $bazar_name_get = BazarName::where(['upazila_id'=>$bazar_name_id])->get();
        $upazila_get = Upazila::where(['upazila_id'=>$bazar_name_id])->get();
        return response()->json([
            'bazar_names'=>$bazar_name_get,
            'upazilas'=>$upazila_get,
        ]);
    }
    public function add_elaka_name_view($elaka_name_id = null){
        $elaka_name_get = ElakaName::where(['bazar_name_id'=>$elaka_name_id])->get();
        $bazar_names = BazarName::where(['bazar_name_id'=>$elaka_name_id])->get();
        return response()->json([
            'elaka_names'=>$elaka_name_get,
            'bazar_names'=>$bazar_names,
        ]);
    }
    public function address_delete($address_id=null, $click=null){
        $table_count = DB::table($click)->where(['id'=>$address_id])->delete();
        return response()->json([
            'icon'=>$table_count
        ]);
    }
}
