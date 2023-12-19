@extends('backend.mastering.master')
@section('title')
<title>Add Address - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Add Product </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Address</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Address</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form id="add-address-form" class="col-sm-12" enctype="multipart/form-data" method="post">
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
                    <div class="form-group add-address bazar_name" style="display:none">
                        <label for="">Bazar Name</label>
                        <select class="form-control" id="nim-bazar_name" name="bazar_name">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="" id="add-address-input">Address Name</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Address</button>
                    <a href="" class="btn btn-primary">View Address</a>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection