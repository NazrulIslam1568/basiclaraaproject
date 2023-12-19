
@extends('frontend.mastering.master')
@section('title')
<title>User Profile - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
    <form class="update-address">
    <div class="container" style="padding: 40px;">
        <h3>Your Profile</h3>
        <div class="profile-section">
            <div class="form-group position-relative">
                <label for="full-name">Your Full Name</label>
                <input type="text" msg-id="name-update-message" value="{{Auth::user()->name}}" class="form-control" id="full-name" disabled>
            </div>
            <div class="form-group position-relative">
                <label for="full-name">Your Phone Number</label>
                <input type="text" msg-id="name-update-message" value="{{Auth::user()->phone_no}}" class="form-control" id="full-name" disabled>
            </div>
            <?php $division = Auth::user()->division; ?>
            @if(empty($division))
            <div class="checkout__input">
                <p>Division<span>*</span></p>
                <select class="form-control nim-division" name="division">
                    <option value="0">Select Your Division</option>
                    <?php $divisions = DB::table('divisions')->get(); ?>
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
            <button class="update-address-btn">Update Address</button>
            @else
            <div class="checkout__input ">
                <p>Division<span>*</span></p>
                <input type="hidden" value="{{Auth::user()->division}}" name="division">
                <select class="form-control nim-division" style="-webkit-appearance: none;" name="division" disabled>
                    <option value="{{Auth::user()->division}}">{{Auth::user()->division}}</option>
                </select>
            </div>
            <div class="checkout__input district ">
                <p>District<span>*</span></p>
                <input type="hidden" value="{{Auth::user()->district}}" name="district">
                <select class="form-control" style="-webkit-appearance: none;" name="district" disabled>
                <option value="{{Auth::user()->district}}">{{Auth::user()->district}}</option>
                </select>
            </div>
            <div class="checkout__input upazila ">
                <p>Upazilla<span>*</span></p>
                <input type="hidden" value="{{Auth::user()->upazila}}" name="upazila">
                <select class="form-control" style="-webkit-appearance: none;" name="upazila" disabled>
                <option value="{{Auth::user()->upazila}}">{{Auth::user()->upazila}}</option>
                </select>
            </div>
            <div class="checkout__input upazila ">
                <p>Nearest Town<span>*</span></p>
                <input type="hidden" value="{{Auth::user()->bazar_name}}" name="bazar_name">
                <select class="form-control" style="-webkit-appearance: none;" name="bazar_name" disabled>
                <option value="{{Auth::user()->bazar_name}}">{{Auth::user()->bazar_name}}</option>
                </select>
            </div>
            <div class="checkout__input upazila ">
                <p>Home Address<span>*</span></p>
                <input type="hidden" value="{{Auth::user()->elaka_name}}" name="elaka_name">
                <select class="form-control" style="-webkit-appearance: none;" name="elaka_name" disabled>
                <option value="{{Auth::user()->elaka_name}}">{{Auth::user()->elaka_name}}</option>
                </select>
            </div>
            <div class="checkout__input ">
                <p>Detail Address<span>*</span></p>
                <input type="hidden" value="{{Auth::user()->detail_address}}" name="detail_address">
                <input name="detail_address" type="text" class="checkout__input__add" value="{{Auth::user()->detail_address}}" disabled>
            </div>
            <button class="change-address">Change Address</button>
            @endif
        </div>
    </div>
    </form>
</main><!-- End .main -->
@endsection