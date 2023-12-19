<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Khoroch;
use DB;
use Auth;

class PageController extends Controller
{
    public function admin_dashboard(){
        if(Auth::check()){
        if(Auth::user()->role_as == 'Admin' || Auth::user()->role_as == 'Support'){
        $current_date = Carbon::now();
        // Product Year get
        $sub_year_first = Carbon::now()->subYear()->format('Y');
        $current_year = Order::where(['status'=>"Complete"])->whereYear('created_at', '=', $current_date->format('Y'))->sum('total_amount');
        $sub_year = Order::where(['status'=>"Complete"])->whereYear('created_at', '=', $sub_year_first)->sum('total_amount');
        if($current_year==0){
            $year_percent = 0;
        }else{
            $year_percent = (($current_year-$sub_year)/$current_year)*100;
        }
        // Yearly Income Get
        $current_year_khoroch = Khoroch::where(['khoroch_name'=>"Product"])->whereYear('date', '=', $current_date->format('Y'))->sum('tk');
        $sub_year_khoroch = Khoroch::where(['khoroch_name'=>"Product"])->whereYear('date', '=', $sub_year_first)->sum('tk');
        $current_year_income = $current_year - $current_year_khoroch;
        $sub_year_income = $sub_year - $sub_year_khoroch;
        if($current_year_income==0){
            $yearly_income_percent = 0;
        }else{
            $yearly_income_percent = (($current_year_income-$sub_year_income)/$current_year_income)*100;
        }
        
        // Product Month Get
        $sub_month_first = Carbon::now()->subMonth()->format('m');
        $current_month_name = Carbon::now()->format('F');
        $sub_month_name = Carbon::now()->subMonth()->format('F');
        $current_month = Order::where(['status'=>"Complete"])->whereYear('created_at','=',$current_date->format('Y'))->whereMonth('created_at', '=', $current_date->format('m'))->sum('total_amount');
        $sub_month = Order::where(['status'=>"Complete"])->whereYear('created_at','=',$current_date->format('Y'))->whereMonth('created_at', '=', $sub_month_first)->sum('total_amount');
        if($current_month==0){
            $month_percent = 0;
        }else{
            $month_percent = (($current_month-$sub_month)/$current_month)*100;
        }
        // Monthly Income Get
        $current_month_khoroch = Khoroch::where(['khoroch_name'=>"Product"])->whereYear('date','=',$current_date->format('Y'))->whereMonth('date', '=', $current_date->format('m'))->sum('tk');
        $sub_month_income = Khoroch::where(['khoroch_name'=>"Product"])->whereYear('date','=',$current_date->format('Y'))->whereMonth('date', '=', $sub_month_first)->sum('tk');
        $monthly_income = $current_month - $current_month_khoroch;
        $sub_monthly_income = $sub_month - $sub_month_income;
        if($monthly_income==0){
            $monthly_income_percent = 0;
        }else{
            $monthly_income_percent = (($monthly_income-$sub_monthly_income)/$monthly_income)*100;
        }
        // Product Daily Get
        $current_day_first = Carbon::now()->format('d-m-Y');
        $sub_day_first = Carbon::now()->subDay()->format('d');
        $current_day = Order::where(['status'=>"Complete"])->whereYear('created_at','=',$current_date->format('Y'))->whereMonth('created_at','=',$current_date->format('m'))->whereDay('created_at', '=', $current_date->format('d'))->sum('total_amount');
        $sub_day = Order::where(['status'=>"Complete"])->whereYear('created_at','=',$current_date->format('Y'))->whereMonth('created_at','=',$current_date->format('m'))->whereDay('created_at', '=', $sub_day_first)->sum('total_amount');
        if($current_day==0){
            $day_percent = 0;
        }else{
            $day_percent = (($current_day-$sub_day)/$current_day)*100;
        }
        // Current Day Income Get
        $current_day_khoroch= Khoroch::where(['khoroch_name'=>"Product"])->whereYear('date','=',$current_date->format('Y'))->whereMonth('date','=',$current_date->format('m'))->whereDay('date', '=', $current_date->format('d'))->sum('tk');
        $sub_day_khoroch = Khoroch::where(['khoroch_name'=>"Product"])->whereYear('date','=',$current_date->format('Y'))->whereMonth('date','=',$current_date->format('m'))->whereDay('date', '=', $sub_day_first)->sum('tk');
        $current_day_income = $current_day - $current_day_khoroch;
        $sub_day_income = $sub_day - $sub_day_khoroch;
        if($current_day_income==0){
            $daysincome_percent = 0;
        }else{
            $daysincome_percent = (($current_day_income-$sub_day_income)/$current_day_income)*100;
        }
        // echo "<pre>";print_r($sub_day_income);die;

        $total_order = Order::where(['status'=>'Complete'])->sum('total_amount');
        $total_khoroch = Khoroch::where(['khoroch_name'=>"Product"])->sum('tk');
        $total_income = $total_order-$total_khoroch;
        $all_khoroch = Khoroch::where(['khoroch_name'=>"Product"])->sum('tk')+Khoroch::where(['khoroch_name'=>"Personal"])->sum('tk');
        $all_income = $total_order-$all_khoroch;
        // echo "<pre>";print_r($current_day);die;
        return view('backend.page.dashboard')->with(compact('current_year','year_percent','sub_year','sub_year_first','current_month_name','sub_month_name','current_month',
                                                            'sub_month','month_percent','current_day','day_percent','current_day_first','day_percent','sub_day','total_order',
                                                            'sub_year_income','current_year_income','yearly_income_percent','sub_year_khoroch','current_month_khoroch','monthly_income_percent','sub_month_income',
                                                        'sub_monthly_income','current_day_income','daysincome_percent','sub_day_income','total_income','all_income'));
        }else{
            return redirect('/');
        }
        }else{
            return redirect('/');
        }
    }
    public function test(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            $data_get = $data['hlw[1]'];
            print_r($data_get);
        }
        return view('test');
    }
}
