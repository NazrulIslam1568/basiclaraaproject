@extends('backend.mastering.master')
@section('title')
<title>Add Restaurant Items - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Add Restaurant Items </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Restaurant Items</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Restaurant Items</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row" id="sub_category_view">
                    <h4 class="no-product text-center mt-5 w-100 d-none">No Category View</h4>
                    @foreach($all_items as $item)
                    <?php $product = DB::table('products')->where(['parent_category_id'=>$item->id])->first();
                    $product_count = DB::table('products')->where(['parent_category_id'=>$item->id])->count(); ?>
                    <div class="col-6 col-sm-4 col-lg-2 text-center">
                        <a href="{{route('restaurant_add_product',[$restaurant_id,$item->id])}}" class="cat-block">
                            <figure>
                                @if($product_count > 0)
                                <img src="{{asset('frontend/img/product/'.$product->image)}}" style="width:150px;" alt="{{$product->product_name}}">
                                @else
                                <img src="{{asset('image/logo product.webp')}}" style="width:150px;">
                                @endif
                            </figure>
                            <h4 style="color:#fff;">{{$item->category_name}}</h4>
                        </a>
                    </div><!-- End .col-sm-4 col-lg-2 -->
                    @endforeach
                </div><!-- End .row -->
            </div>
        </div>
        </div>
    </div>
</div>
@endsection