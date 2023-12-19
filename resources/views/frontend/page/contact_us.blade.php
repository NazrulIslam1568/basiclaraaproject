@extends('frontend.mastering.master')
@section('title')
<title>Contact Us - {{$settings->company_name}}</title>
<meta name="description" content="Contact Now : CEO & Founder : Md. Nazrul Islam. Email : nazrulparves1568@gmail.com">
<meta property="og:description" content="Contact Now : CEO & Founder : Md. Nazrul Islam. Email : nazrulparves1568@gmail.com" />
<meta property="og:title" content="Nimnio.com" />
<meta property="og:url" content="https://nimnio.com/" />
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
            <h1 class="page-title">Contact us</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact us</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container" style="background: #ebebeb; padding-top: 50px;">
            <div class="row">
                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Office</h3>

                        <address>Barishal, Bhola, Bhola Sadar. <br>Contact : 01710-621166</address>
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-4 -->

                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Start a Conversation</h3>

                        <div><a href="mailto:#">support@nimnio.com</a></div>
                        <div><a href="tel:8801710621166">01710-621166</a></div>
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-4 -->

                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Social</h3>

                        <div class="social-icons social-icons-color justify-content-center">
                            <a href="https://www.facebook.com/nimnioonlineshop" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                            <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                            <a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                            <a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                            <a href="#" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                        </div><!-- End .soial-icons -->
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-4 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection