@extends('backend.mastering.master')
@section('title')
<title>Add Restaurant - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Add Restaurant </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Restaurant</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Restaurant</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <form action="{{route('add_restaurants_post')}}" class="col-sm-12" enctype="multipart/form-data" method="post">
                @csrf
                    <div class="form-group">
                        <label for="nim-division">Division</label>
                        <select name="division" id="nim-division" required class="form-control">
                            <option value="0">Select Division</option>
                            <?php $divisions = DB::table('divisions')->get(); ?>
                            @foreach($divisions as $division)
                            <option value="{{$division->division_id}}">{{$division->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group add-address district" style="display:none">
                        <label for="">District</label>
                        <select class="form-control" id="nim-district" name="district_name">
                        </select>
                    </div>
                    <div class="form-group add-address upazila" style="display:none">
                        <label for="">Upazila</label>
                        <select class="form-control" id="nim-upazila" name="upazila_name">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Restaurant Name</label>
                        <input type="text" class="form-control" placeholder="Category Name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="">Restaurant Perchantage</label>
                        <input type="text" class="form-control" placeholder="Category Perchantage" name="perchantage" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <button type="submit" class="btn btn-success">Add Category</button>
                    <a href="" class="btn btn-primary">View Category</a>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Division</th>
                                <th>District</th>
                                <th>Upazila</th>
                                <th>Name</th>
                                <th>Perchantage</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $restaurants = DB::table('add_restaurants')->get(); ?>
                            @foreach($restaurants as $restaurant)
                            <?php 
                            $division = DB::table('divisions')->where(['id'=>$restaurant->division_id])->first();
                            $district = DB::table('districts')->where(['id'=>$restaurant->district_id])->first();
                            $upazila = DB::table('upazilas')->where(['id'=>$restaurant->upazila_id])->first();
                            
                            ?>
                            <tr>
                                <th>{{$restaurant->id}}</th>
                                <td>{{$division->name}}</td>
                                <td>{{$district->name}}</td>
                                <td>{{$upazila->name}}</td>
                                <td>{{$restaurant->name}}</td>
                                <td>{{$restaurant->perchantage}}</td>
                                <td>
                                    <a href="{{route('edit_restaurants',$restaurant->id)}}" style="margin:2px;" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection