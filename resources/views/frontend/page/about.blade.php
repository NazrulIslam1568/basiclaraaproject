@extends('frontend.mastering.master')
@section('title')
<title>About - {{$settings->company_name}}</title>
<meta name="description" content="Ceo & Founder : Md. Nazrul Islam. Facebook : https://www.facebook.com/nazrulparves1568/">
<meta property="og:description" content="Nimnio is Bangladeshi Online Grocery Shop." />
<meta property="og:title" content="Nimnio Online Shop" />
<meta property="og:url" content="https://nimnio.com/about" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="en-us" />
<meta property="og:locale:alternate" content="en-us" />
<meta property="og:site_name" content="nimnio.com" />
<meta property="og:image" content="https://nimnio.com/image/nimnio_logo.png" />
<meta property="og:image:url" content="https://nimnio.com/image/nimnio_logo.png" />
<meta property="og:image:size" content="300" />
@endsection
@section('main_layouts')  
<main class="main">
    <div class="page-header text-center">
        <div class="container">
            <h1 class="page-title">About</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container" style="background: #ebebeb; padding-top: 50px;">
        <h2 class="title text-center mb-4">Meet Our Team</h2><!-- End .title text-center mb-2 -->
            <div class="row">
                <?php $teams = DB::table('teams')->get(); ?>
                @foreach($teams as $team)
                <div class="col-md-3">
                    <div class="member member-anim text-center">
                        <figure class="member-media">
                            <img src="{{asset('image/user/'.$team->image)}}" class="w-100" alt="{{$team->name}}">
                            <figcaption class="member-overlay">
                                <div class="member-overlay-content">
                                    <h3 class="member-title">{{$team->name}}<span>{{$team->designation}}</span></h3><!-- End .member-title -->
                                    <div class="social-icons social-icons-simple">
                                        <a href="{{$team->fb_link}}" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                        @if($team->twitter_link)
                                        <a href="{{$team->twitter_link}}" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                        @endif
                                        @if($team->youtube_link)
                                        <a href="{{$team->youtube_link}}" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                        @endif
                                        @if($team->instagram_link)
                                        <a href="{{$team->instagram_link}}" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                        @endif
                                    </div><!-- End .soial-icons -->
                                </div><!-- End .member-overlay-content -->
                            </figcaption><!-- End .member-overlay -->
                        </figure><!-- End .member-media -->
                        <div class="member-content">
                            <h3 class="member-title">{{$team->name}}<span>{{$team->designation}}</span></h3><!-- End .member-title -->
                        </div><!-- End .member-content -->
                    </div><!-- End .member -->
                </div><!-- End .col-md-4 -->
                @endforeach
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection