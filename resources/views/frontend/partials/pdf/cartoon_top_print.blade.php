<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$order->ship_name}} || Cartoon Top Print</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('image/single_logo.png')}}">
</head>
<body>
    <main class="main container">
        <div class="row">
            <!-- BEGIN INVOICE -->
            <div class="col-md-12" style="width: 100%; display:flex; justify-content:center; align-items:center;">
                <div style="width: 50%; display:flex; justify-content:center; align-items:center;">
                    <div style="">
                        <?php $setting = DB::table('setting')->first(); ?>
                        <div style="text-align:center;">
                            <img style="width: 250px; height: 100px; margin-bottom: 10px; text-align:center;" src="https://nimnio.com/image/nimnio_logo.png" alt="nimnio">
                        </div>
                        <h2 style="margin:0; margin-top:5px;text-align:center; ">Booking : {{ date('d-m-Y g:i a', strtotime($order->created_at))}}</h2>
                        <h4 style="margin:0; margin-top:5px;">Receiver Name : <span style="font-size:25px;">{{$order->ship_name}}</span></h4>
                        <h4 style="margin:0; margin-top:5px;">Receiver Phone : {{$order->ship_phone}}</h4>
                        <h4 style="margin:0; margin-top:5px; font-weight: 400;"><strong>Receiver Address</strong> : {{$order->ship_division}}, {{$order->ship_district}}<br>
                                            {{$order->ship_upazila}}, {{$order->ship_bazar_name}},<br>
                                            {{$order->ship_elaka_name}}, {{$order->ship_detail_address}}</h4>
                        <h4 style="margin:0; margin-top:5px;">Total Amount : Tk. {{$order->total_amount}}</h4>
                    </div>
                </div>
            </div>
            <!-- END INVOICE -->
        </div>
    </main><!-- End .main -->
</body>
</html>