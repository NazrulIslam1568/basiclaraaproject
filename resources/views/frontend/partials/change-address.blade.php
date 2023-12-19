
@extends('frontend.mastering.master')
@section('title')
<title>Change Address - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
    <form class="update-address">
    <div class="container" style="padding: 40px;">
        <h3>Change Address</h3>
        <div class="profile-section">
            <div class="checkout__input">
                <p>Division<span>*</span></p>
                <select class="form-control nim-division" name="division">
                    <option value="0">Select Your Division</option>
                    <?php $divisions = DB::table('divisions')->where(['status'=>1])->get(); ?>
                    @foreach($divisions as $division)
                    <option value="division-{{$division->id}}">{{$division->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="checkout__input district" style="display:none">
                <p>District<span>*</span></p>
                <select class="form-control" show_class="" id="nim-district" name="district">
                </select>
            </div>
            <div class="checkout__input upazila" style="display:none">
                <p>Upazila<span>*</span></p>
                <select class="form-control" show_class="" id="nim-upazila" name="upazila">
                </select>
            </div>
            <div class="checkout__input bazar_name" style="display:none">
                <p>Nearest Town<span>*</span></p>
                <select class="form-control" show_class="" id="nim-bazar_name" name="bazar_name">
                </select>
            </div>
            <div class="checkout__input elaka_name" style="display:none">
                <p>Home Address<span>*</span></p>
                <select class="form-control" show_class="" id="nim-elaka_name" name="elaka_name">
                </select>
            </div>
            <div class="checkout__input detail_address" style="display:none">
                <p>Detail Address<span>*</span></p>
                <input name="detail_address" type="text" class="checkout__input__add" placeholder="কিভাবে আপনার বাসা চিনা যাবে ঐ তথ্যটি দিন" >
            </div>
            <div class="d-flex">
                <div class="update-address col-md-6">
                    <button class="update-address" style="font-size: 13px;">Update Address</button>
                </div>
                <div class="change-addresss col-md-6">
                    <a class="cancel-address" style="cursor:pointer; font-weight: 800;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    </form>
</main><!-- End .main -->
@endsection