@extends('backend.mastering.master')
@section('title')
<title>Add Product Khoroch - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Add Product Khoroch </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Product Khoroch</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Product Khoroch</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form action="{{route('add_product_khoroch')}}" class="col-sm-12" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="khoroch_title">Khoroch Title</label>
                        <input id="khoroch_title" type="text" class="form-control" name="khoroch_title" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input id="amount" type="number" class="form-control" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="datepicker">date</label>
                        <input id="datepicker" type="text" class="form-control" name="date" autocomplete="off" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Product Khoroch</button>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card" id="view_product_table">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title"><input type="search" data-pass="category_view_format" id="search-product-input" placeholder = "Search Your product Khoroch" style="width: 100%; border-radius: 30px; padding: 5px 20px; color: #000;"></h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="category_view_format">
                            <?php $product_khorochs = DB::table('khoroches')->where(['khoroch_name'=>'Product'])->orderBy('id', 'DESC')->get(); ?>
                            @if($product_khorochs)
                            @foreach($product_khorochs as $product_khoroch)
                            <tr>
                                <td>{{$product_khoroch->id}}</td>
                                <td>{{ date('d-m-Y g:i a', strtotime($product_khoroch->date))}}</td>
                                <td>{{$product_khoroch->description}}</td>
                                <td>{{$product_khoroch->tk}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection