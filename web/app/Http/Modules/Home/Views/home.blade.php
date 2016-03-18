@extends('Home/Layouts/home_layout')
@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection

@section('content')
    <section class="container">
        {{--<div class="container"><!--body container -->--}}
        <div class="row"><!--body container row-1 -->
            <div class="col-md-12 col-lg-12 bg-img-row-1">

                <div class="row">

                    <div class="col-md-2 col-sm-3 col-sm-offset-8 col-md-offset-9 col-xs-8 col-xs-offset-1 row-1-info-style">
                        <h2 class="demi-font"><a href="javascript:;">Spring 2015</a></h2>

                        <h3 class="regular-font"><a href="javascript:;">Collection</a></h3>
                        <ul>
                            <li>Tops</li>
                            <li>Knitwears</li>
                            <li>Dresses</li>
                            <li>Denims</li>
                            <li>Bottoms</li>
                        </ul>
                        <a class="shop-now-btn" href=""><i
                                    class="ionicons ion-ios-cart-outline icon-fs"> </i> SHOP NOW</a>
                    </div>

                </div>

            </div>
        </div>
        <!--/body container row-1 -->

        <div class="col-sm-12 main-banner-n" id='content'><!--section left -->

            <div class="main-grid">
                <div class="row"><!--section left row-1 -->


                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c  p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-7.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">15%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="shopping cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-6.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">52%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="Shopping Cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="grid-item width-2D grid-item-height2">--}}
                        {{--<div class="div-content s-1-c p-r margin-gutter g-item">--}}

                            {{--<img src="" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">23%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r height-2-vertical">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img src="/assets/images/van.png" class="van-cart-img"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img src="/assets/images/shopping-cart-wht.png" class="cart-img"--}}
                                             {{--alt="Shopping Cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c  p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-6.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">15%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="shopping cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-7.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">52%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="Shopping Cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c  p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-6.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">15%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="shopping cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    @foreach($flashsaledetails as $key =>  $val)
                    <div class="grid-item">
                        <div class="div-content s-1-c p-r margin-gutter g-item">

                            <img src="{{ $val['campaign_banner'] }}" class="img-responsive display-images" alt="img">

                            <div class="p-a discount-inblock">
                                <p class="t-w p-r dis-1"><?php if($val['discount_type'] == 1){ echo 'Flat'.' '.$val['discount_value']; } else{ echo $val['discount_value'].'%'; } ?></p>
                            </div>
                            <img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">

                            <p class="text-white txt-dsi-inline">FREE DELIVERY</p>
                            <img src="/assets/images/time.png" alt="" class="inner-img-time">

                            <p class="text-white txt-dsi-inline">VALID UNTIL {{ date('d-F-Y',strtotime($val['available_upto'])) }}</p>

                            <div class="overlay p-a">
                                <div class="p-a-overlay"></div>
                                <div class="z-i p-r">
                                    <h2 class='offer'><?php if($val['discount_type'] == 1){ echo 'Flat'.' '.$val['discount_value']; } else{ echo $val['discount_value'].'%'; } ?></h2>

                                    <p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"
                                                          alt="Delivery Van">FREE DELIVERY</p>

                                    <p class="t-w-d">
                                        <img class="cart-img" src="/assets/images/shopping-cart-wht.png"
                                             alt="Shopping Cart"> VALID UNTIL
                                        <span class="date">{{ date('d-F-Y',($val['available_upto'])) }}</span>
                                    </p>
                                    <a href="/flashsale-details/<?php echo $val['campaign_id'] ?>" class="link-btn">SHOP NOW</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                    {{--<div class="grid-item width-2D grid-item-height2">--}}
                        {{--<div class="div-content s-1-c p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-8.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">23%</p>--}}
                            {{--</div>--}}
                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r height-2-vertical">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img src="/assets/images/van.png" class="van-cart-img"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img src="/assets/images/shopping-cart-wht.png" class="cart-img"--}}
                                             {{--alt="Shopping Cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c  p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-7.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">15%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="shopping cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-6.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">52%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="Shopping Cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c  p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-7.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">15%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="shopping cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-6.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">52%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="Shopping Cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="grid-item width-2D grid-item-height2">--}}
                        {{--<div class="div-content s-1-c p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-8.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">23%</p>--}}
                            {{--</div>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r height-2-vertical">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img src="/assets/images/van.png" class="van-cart-img"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img src="/assets/images/shopping-cart-wht.png" class="cart-img"--}}
                                             {{--alt="Shopping Cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c  p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-6.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">15%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="shopping cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="grid-item">--}}
                        {{--<div class="div-content s-1-c p-r margin-gutter g-item">--}}
                            {{--<img src="/assets/images/img-7.png" class="img-responsive display-images" alt="img">--}}

                            {{--<div class="p-a discount-inblock">--}}
                                {{--<p class="t-w p-r dis-1">52%</p>--}}
                            {{--</div>--}}
                            {{--<img src="/assets/images/delivery.png" alt="" class="inner-img-dvan">--}}

                            {{--<p class="text-white txt-dsi-inline">FREE DELIVERY</p>--}}
                            {{--<img src="/assets/images/time.png" alt="" class="inner-img-time">--}}

                            {{--<p class="text-white txt-dsi-inline">VALID UNTIL YYYY-MM-DD</p>--}}

                            {{--<div class="overlay p-a">--}}
                                {{--<div class="p-a-overlay"></div>--}}
                                {{--<div class="z-i p-r">--}}
                                    {{--<h2 class='offer'>50%</h2>--}}

                                    {{--<p class='t-w-d'><img class="van-cart-img" src="/assets/images/van.png"--}}
                                                          {{--alt="Delivery Van">FREE DELIVERY</p>--}}

                                    {{--<p class="t-w-d">--}}
                                        {{--<img class="cart-img" src="/assets/images/shopping-cart-wht.png"--}}
                                             {{--alt="Shopping Cart"> VALID UNTIL--}}
                                        {{--<span class="date">YYYY-MM-DD</span>--}}
                                    {{--</p>--}}
                                    {{--<a href="javascript:;" class="link-btn">SHOP NOW</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}

                </div>
                <!--/section left row-1 -->
            </div>
            <!-- /main grid -->
        </div>
        <!--/section left -->
        {{--</div><!--/body container -->--}}
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
    //  console.log("<?php echo \App::getLocale();?>");
    </script>
@endsection
