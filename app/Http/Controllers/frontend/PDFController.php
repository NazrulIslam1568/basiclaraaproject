<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Order;

class PDFController extends Controller
{
    public function invoice_pdf($id=null){
        $order = Order::find($id);
        $pdf = PDF::loadView('frontend.partials.pdf.invoice_pdf', compact('order'));
        return $pdf->stream('invoice nimnio home shop Order No-'.$id.'.pdf');
    }
    public function download_invoice_pdf($id=null){
        $order = Order::find($id);
        $pdf = PDF::loadView('frontend.partials.pdf.invoice_pdf', compact('order'));
        return $pdf->download('invoice nimnio home shop Order No-'.$id.'.pdf');
    }
    public function cartoon_top_print($id=null){
        $order = Order::find($id);
        $pdf = PDF::loadView('frontend.partials.pdf.cartoon_top_print', compact('order'));
        return $pdf->stream('invoice nimnio home shop Order No-'.$id.'.pdf');
    }
}
