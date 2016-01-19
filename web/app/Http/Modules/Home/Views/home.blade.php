@extends('Home/Layouts/home_layout')
@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection


@section('content')
    <section class="container">
        <div class="row slider-banner m-bottom-sm m-top-md">
            <div class="col-lg-8 col-sm-12">
                <div class="tp-banner-container">
                    <div class="tp-banner">
                        <ul>
                            <li data-transition="3dcurtain-vertical" data-slotamount="5" data-masterspeed="700"
                                data-thumb="/assets/home/img/slider/slider-08.jpg" data-title="Slide">
                                <!-- MAIN IMAGE -->
                                <img src="/assets/home/img/slider/slider-08.jpg" alt="slider" data-bgrepeat="no-repeat"
                                     data-bgfit="cover" data-bgposition="right bottom">
                                <!-- LAYERS -->

                                <!-- LAYER NR. 1 -->
                                <div class="tp-caption mediumlarge_light_white_center text-uppercase tp-resizeme"
                                     data-x="750"
                                     data-y="330"
                                     data-speed="600"
                                     data-start="800"
                                     data-easing="Power3.easeInOut"
                                     data-splitin="line"
                                     data-splitout="line"
                                     data-elementdelay="0.05"
                                     data-endelementdelay="0.05"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; font-weight: 500; letter-spacing: 4px; font-size: 30px;">
                                    SPRING / SUMMER 2015
                                </div>

                                <!-- LAYER NR. 2 -->
                                <div class="tp-caption large_bold_white text-uppercase lfb ltt tp-resizeme"
                                     data-x="470"
                                     data-y="390"
                                     data-speed="600"
                                     data-start="800"
                                     data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                                     data-easing="Power3.easeInOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; letter-spacing: 2px; font-size: 100px;">
                                    new
                                </div>

                                <!-- LAYER NR. 3 -->
                                <div class="tp-caption mediumlarge_light_white_center text-uppercase lfb ltt tp-resizeme"
                                     data-x="720"
                                     data-y="400"
                                     data-speed="600"
                                     data-start="1100"
                                     data-easing="Power3.easeInOut"
                                     data-splitin="line"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; font-size: 100px; letter-spacing: 2px;">
                                    arrivals
                                </div>

                                <!-- LAYER NR. 4 -->
                                <div class="tp-caption mediumlarge_light_white_center text-uppercase tp-resizeme"
                                     data-x="970"
                                     data-y="570"
                                     data-speed="600"
                                     data-start="800"
                                     data-easing="Power3.easeInOut"
                                     data-splitin="line"
                                     data-splitout="line"
                                     data-elementdelay="0.05"
                                     data-endelementdelay="0.05"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; font-weight: 500; letter-spacing: 3px; font-size: 18px; border: 2px solid #fff; padding: 0px 25px;">
                                    shop now
                                </div>
                            </li>

                            <li data-transition="3dcurtain-horizontal" data-slotamount="5" data-masterspeed="700"
                                data-thumb="/assets/home/img/slider/slider-07.jpg" data-title="Slide">
                                <!-- MAIN IMAGE -->
                                <img src="/assets/home/img/slider/slider-07.jpg" alt="slider" data-bgrepeat="no-repeat"
                                     data-bgfit="cover" data-bgposition="right bottom">
                                <!-- LAYERS -->

                                <!-- LAYER NR. 1 -->
                                <div class="tp-caption mediumlarge_light_white_center text-uppercase tp-resizeme"
                                     data-x="750"
                                     data-y="330"
                                     data-speed="600"
                                     data-start="800"
                                     data-easing="Power3.easeInOut"
                                     data-splitin="line"
                                     data-splitout="line"
                                     data-elementdelay="0.05"
                                     data-endelementdelay="0.05"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; font-weight: 500; letter-spacing: 4px; font-size: 30px;">
                                    SPRING / SUMMER 2015
                                </div>

                                <!-- LAYER NR. 2 -->
                                <div class="tp-caption large_bold_white text-uppercase lfb ltt tp-resizeme"
                                     data-x="470"
                                     data-y="390"
                                     data-speed="600"
                                     data-start="800"
                                     data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                                     data-easing="Power3.easeInOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; letter-spacing: 2px; font-size: 100px;">
                                    new
                                </div>

                                <!-- LAYER NR. 3 -->
                                <div class="tp-caption mediumlarge_light_white_center text-uppercase lfb ltt tp-resizeme"
                                     data-x="720"
                                     data-y="400"
                                     data-speed="600"
                                     data-start="1100"
                                     data-easing="Power3.easeInOut"
                                     data-splitin="line"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; font-size: 100px; letter-spacing: 2px;">
                                    arrivals
                                </div>

                                <!-- LAYER NR. 4 -->
                                <div class="tp-caption mediumlarge_light_white_center text-uppercase tp-resizeme"
                                     data-x="970"
                                     data-y="570"
                                     data-speed="600"
                                     data-start="800"
                                     data-easing="Power3.easeInOut"
                                     data-splitin="line"
                                     data-splitout="line"
                                     data-elementdelay="0.05"
                                     data-endelementdelay="0.05"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap; font-weight: 500; letter-spacing: 3px; font-size: 18px; border: 2px solid #fff; padding: 0px 25px;">
                                    shop now
                                </div>
                            </li>
                        </ul>
                        <div class="tp-bannertimer"></div>
                    </div>
                </div>
            </div>
            <!--Slider-->

            <!--Banners-->
            <div class="col-lg-4 col-sm-12">
                <div class="banners">
                    <div class="banner-overlay item-banner">
                        <div class="banner-overlay-text right text-uppercase">
                            <h4>SPRING / SUMMER 2016</h4>

                            <h2>New <span>Arrivals</span></h2>
                        </div>
                    </div>

                    <div class="bg-color-simple center text-uppercase">
                        <h2><span>SALE</span></h2>
                        <h4>CLOTHING & SHOES UP TO 30% OFF</h4>
                    </div>
                </div>
            </div>
            <!--Banners-->


        </div>


    </section>

    <!--Collection-->

    <!--Collection-->
    <section class="container">

        <div class="row m-top-md">
            <h2 style="margin-left: 15px;">SALES OF THE DAY</h2>

            <div class="col-sm-6 col-md-6">
                <div class="post">
                    <div class="post-img-content">
                        <img src="/assets/home/img/collection/1.jpg" class="img-responsive"/>

                    </div>
                    <div class="content row">
                        <div class="pull-left col-md-8">
                            Shoes and Accessories

                            <div class="author">
                                <i class="fa fa-clock"></i> <span class="text"> Rest 1Day 20 hrs</span>
                                <time datetime="2016-01-20">January 20th, 2016</time>
                            </div>
                        </div>
                        <div class=" pull-right pad-5">
                            <a href="#" class="btn btn-success btn-sm">Discover > > </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="post">
                    <div class="post-img-content">
                        <img src="/assets/home/img/collection/2.jpg" class="img-responsive"/>

                    </div>
                    <div class="content row">

                        <div class="pull-left col-md-8">
                            Fashion for Children from 1 month to 10 years

                            <div class="author">
                                <i class="fa fa-clock"></i> <span class="text"> Rest 1Day 20 hrs</span>
                                <time datetime="2016-01-20">January 20th, 2016</time>
                            </div>
                        </div>
                        <div class=" pull-right pad-5">
                            <a href="#" class="btn btn-success btn-sm">Discover</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row m-top-md">
            <div class="col-sm-6 col-md-6">
                <div class="post">
                    <div class="post-img-content">
                        <img src="/assets/home/img/collection/1.jpg" class="img-responsive"/>

                    </div>
                    <div class="content row">
                        <div class="pull-left col-md-8">
                            Shoes and Accessories

                            <div class="author">
                                <i class="fa fa-clock"></i> <span class="text"> Rest 1Day 20 hrs</span>
                                <time datetime="2016-01-20">January 20th, 2016</time>
                            </div>
                        </div>
                        <div class=" pull-right pad-5">
                            <a href="#" class="btn btn-success btn-sm">Discover > > </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="post">
                    <div class="post-img-content">
                        <img src="/assets/home/img/collection/2.jpg" class="img-responsive"/>

                    </div>
                    <div class="content row">

                        <div class="pull-left col-md-8">
                            Fashion for Children from 1 month to 10 years

                            <div class="author">
                                <i class="fa fa-clock"></i> <span class="text"> Rest 1Day 20 hrs</span>
                                <time datetime="2016-01-20">January 20th, 2016</time>
                            </div>
                        </div>
                        <div class=" pull-right pad-5">
                            <a href="#" class="btn btn-success btn-sm">Discover</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </section>
    <!--Features Products-->
    <section class="container">
        <div class="row paddings">
            <div class="col-lg-12">
                <!--Main title-->
                <div class="main-title text-uppercase center">
                    <h3>Upcoming Sales </h3>
                    <hr>
                </div>
                <!--Main title-->

                <!--Carousel-->
                <ul class="carousel-collection list-inline top">
                    <!--item-->
                    <li>
                        <div class="collection-extra text-uppercase">
                            <img src="/assets/home/img/featured-products/product-01.jpg" alt="feature image">
                            <!--Overlay of preview-->
                            <div class="overlay center">
                                <a href="#" title="preview" data-toggle="modal" data-target=".modal-quickview"><i
                                            class="fa fa-plus-circle"></i></a>
                            </div>
                            <!--Overlay of preview-->

                            <div class="text-extra">
                                new
                            </div>

                            <!--Hover Product-->
                            <div class="product-hover center">
                                <span><a href="#">add to bag +</a></span>
                                <span><a href="#">save to closet +</a></span>
                            </div>
                            <!--Hover Product-->
                        </div>
                        <div class="info-collection top-mini">
                            <h4>YX Black T-Shirt</h4>

                            <p>$36.00</p>
                                    <span class="rating-star">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star down"></i>
                                    </span>
                        </div>
                    </li>
                    <!--item-->

                    <!--item-->
                    <li>
                        <div class="collection-extra text-uppercase">
                            <img src="/assets/home/img/featured-products/product-02.jpg" alt="feature image">
                            <!--Overlay of preview-->
                            <div class="overlay center">
                                <a href="#" title="preview" data-toggle="modal" data-target=".modal-quickview"><i
                                            class="fa fa-plus-circle"></i></a>
                            </div>
                            <!--Overlay of preview-->

                            <div class="product-hover center">
                                <span><a href="#">add to bag +</a></span>
                                <span><a href="#">save to closet +</a></span>
                            </div>
                        </div>
                        <div class="info-collection top-mini">
                            <h4>Y4 White Jersey</h4>

                            <p>$36.00</p>
                                    <span class="rating-star">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star down"></i>
                                    </span>
                        </div>
                    </li>
                    <!--item-->

                    <!--item-->
                    <li>
                        <div class="collection-extra text-uppercase">
                            <img src="/assets/home/img/featured-products/product-03.jpg" alt="feature image">
                            <!--Overlay of preview-->
                            <div class="overlay center">
                                <a href="#" title="preview" data-toggle="modal" data-target=".modal-quickview"><i
                                            class="fa fa-plus-circle"></i></a>
                            </div>
                            <!--Overlay of preview-->

                            <div class="product-hover center">
                                <span><a href="#">add to bag +</a></span>
                                <span><a href="#">save to closet +</a></span>
                            </div>
                        </div>
                        <div class="info-collection top-mini">
                            <h4>YX Black T-Shirt</h4>

                            <p>$36.00</p>
                                    <span class="rating-star">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star down"></i>
                                    </span>
                        </div>
                    </li>
                    <!--item-->

                    <!--item-->
                    <li>
                        <div class="collection-extra text-uppercase">
                            <img src="/assets/home/img/featured-products/product-04.jpg" alt="feature image">
                            <!--Overlay of preview-->
                            <div class="overlay center">
                                <a href="#" title="preview" data-toggle="modal" data-target=".modal-quickview"><i
                                            class="fa fa-plus-circle"></i></a>
                            </div>
                            <!--Overlay of preview-->

                            <div class="text-extra">
                                sale
                            </div>
                            <div class="product-hover center">
                                <span><a href="#">add to bag +</a></span>
                                <span><a href="#">save to closet +</a></span>
                            </div>
                        </div>
                        <div class="info-collection top-mini">
                            <h4>Y4 White Jersey</h4>

                            <p class="price-changed"><span>$36.00</span> $25.00</p>
                                    <span class="rating-star">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star down"></i>
                                    </span>
                        </div>
                    </li>
                    <!--item-->
                </ul>
                <!--Carousel-->
            </div>
        </div>
    </section>
    <!--Features Products-->

    <!--Best Sellers-->
    <section class="bg-gray">
        <div class="paddings">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!--Main title-->
                        <div class="main-title text-uppercase center">
                            <h3>Today's Best Sellers</h3>
                            <hr>
                        </div>
                        <!--Main title-->

                        <!--Items Blog-->
                        <ul class="carousel-blog list-inline top">
                            <!--One-->
                            <li>
                                <div class="item-blog">
                                    <img src="/assets/home/img/blog/blog-01.jpg" alt="image blog">

                                    <h3 class="top">NYC City of Fashion</h3>

                                    <p class="top-mini bottom-mini">Etiam sit amet orci eget eros faucibus tincidunt.
                                        Duis
                                        leo. Sed fringilla mauris sit amet nibh. Sed consequat, leo eget bibendum
                                        sodales,
                                        augue velit cursus nunc.</p>

                                </div>
                            </li>
                            <!--One-->

                            <!--two-->
                            <li>
                                <div class="item-blog">
                                    <img src="/assets/home/img/blog/blog-02.jpg" alt="image blog">

                                    <h3 class="top">New York Fashion Week</h3>

                                    <p class="top-mini bottom-mini">Etiam sit amet orci eget eros faucibus tincidunt.
                                        Duis
                                        leo. Sed fringilla mauris sit amet nibh. Sed consequat, leo eget bibendum
                                        sodales,
                                        augue velit cursus nunc.</p>

                                </div>
                            </li>
                            <!--two-->
                        </ul>
                        <!--Items Blog-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Blog-->


@endsection

@section('pagejavascripts')
    <script>
        //======Slider Revolution==============//
        jQuery('.tp-banner').show().revolution(
                {
                    navigationType: "none",
                    navigationArrows: "nexttobullets",
                    navigationStyle: "preview4",

                    keyboardNavigation: "off",

                    navigationHAlign: "center",
                    navigationVAlign: "center",
                    navigationHOffset: 0,
                    navigationVOffset: 20,

                    soloArrowLeftHalign: "left",
                    soloArrowLeftValign: "center",
                    soloArrowLeftHOffset: 20,
                    soloArrowLeftVOffset: 0,

                    soloArrowRightHalign: "right",
                    soloArrowRightValign: "center",
                    soloArrowRightHOffset: 20,
                    soloArrowRightVOffset: 0,
                    dottedOverlay: "none",
                    fullWidth: "on",
                    forceFullWidth: "off",

                    delay: 7000,
                    startwidth: 1170,
                    startheight: 700,
                    hideThumbs: 10,
                });
    </script>
@endsection
