@extends('backend.mastering.master')
@section('title')
<title>{{$restaurant->name}} Restaurants - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Edit Restaurants </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Restaurant</a></li>
            <li class="breadcrumb-item active" aria-current="page">edit Restaurnt</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form id="edit-restaurants-form" class="col-sm-12" enctype="multipart/form-data" method="post">
                    <input type="hidden" value="{{$restaurant->id}}" id="restaurant_id_post">
                    <div class="form-group">
                        <label for="nim-division">Division</label>
                        <select name="division" id="nim-division" required class="form-control">
                            <option value="{{$division->division_id}}">{{$division->name}}</option>
                            <?php $divisions = DB::table('divisions')->get(); ?>
                            @foreach($divisions as $division)
                            <option value="{{$division->division_id}}">{{$division->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group add-address district">
                        <label for="">District</label>
                        <select class="form-control" id="nim-district" name="district_name">
                            <option value="{{$district->district_id}}">{{$district->name}}</option>
                        </select>
                    </div>
                    <div class="form-group add-address upazila">
                        <label for="">Upazila</label>
                        <select class="form-control" id="nim-upazila" name="upazila_name">
                            <option value="{{$upazila->upazila_id}}">{{$upazila->name}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" >Restaurant Name</label>
                        <input type="text" class="form-control" name="name" value="{{$restaurant->name}}" required>
                    </div>
                    <div class="form-group">
                        <label for="" >Perchantage</label>
                        <input type="text" class="form-control" name="perchantage" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image">
                        <img src="{{asset('frontend/img/restaurant/'.$restaurant->image)}}" style="width: 100px; height: 100px;">
                    </div>
                    <button type="submit" class="btn btn-success">Edit Restaurant</button>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection