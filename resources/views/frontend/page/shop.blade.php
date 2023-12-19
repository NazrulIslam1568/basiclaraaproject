@extends('frontend.mastering.master')
@section('title')
<title>Shop - {{$settings->company_name}}</title>
<meta name="description" content="nimnio.com is Bangladeshi online grocery shop. All Product Page.">
<meta property="og:description" content="Nimnio is Bangladeshi Online Grocery Shop." />
<meta property="og:title" content="Nimnio Online Shop" />
<meta property="og:url" content="https://nimnio.com/shop" />
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
            <h1 class="page-title">Shops<span></span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active"><a href="elements-list.html">Shops</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="container">
            <h2 class="title text-center mb-3">All Products</h2><!-- End .title -->
            <div class="row">
             @include('frontend.partials.product.product')
            </div><!-- End .row -->
            <hr class="mt-0 mb-5" />
        </div><!-- End .container -->
</main><!-- End .main -->
@endsection