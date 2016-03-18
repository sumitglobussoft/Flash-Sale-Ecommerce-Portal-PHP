@extends('Home/Layouts/home_layout')
@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <style type="text/css" media="screen">
        .modal-dialog {
            width: 1050px;
        }

        .bg-img-row-1 {
            background-image: url("{{$flashsaledetails['campaign_banner']}}") !important;
        }

    </style>
@endsection

@section('content')

    <section class="container">
        <div class="col-md-12 col-lg-12 bg-img-row-1">
            <!--body container row-1 -->
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
                    <a class="shop-now-btn" href="javascript:;"><i class="ionicons ion-ios-cart-outline icon-fs"> </i>
                        SHOP
                        NOW</a>
                </div>
            </div>
        </div>
        <!--Collection-->

        <div class="row">
            <?php if(isset($flashsaledetails) && (!empty($flashsaledetails)))  { ?>
                    <!--body container row-2 -->

            <!-- Filters for mobile/tab-->
            <div class="fixed-menu hidden-lg hidden-md">
                <!-- <i class="fa fa-filter fa-3 text-white"></i> -->
                <span class="iconbar icon-left"></span>
                <span class="iconbar icon-middle"></span>
                <span class="iconbar icon-right"></span>
            </div>

            <div id="filter-md-sm" class="hidden-lg hidden-md">
                <div>
                    <i class="fa fa-minus text-white slide-left"></i>
                </div>

                <div id="filterproducts-sm-md" class='row'>
                    <div class='categories'>
                        <!--categories-->
                        <h3 class="demi-font font-title-categories">
                            Categories
                        </h3>

                        <hr>

                        <div class="dress-types">
                            <!-- Dress Types -->
                            <div>
                                <img src="/assets/images/tops-blk.png" alt="">
                                <span>Tops</span>
                            </div>

                            <div>
                                <img src="/assets/images/frok-blk.png" alt="">
                                <span>Frock</span>
                            </div>

                            <div>
                                <img src="/assets/images/bangle-blk.png" alt="">
                                <span>Bangle</span>
                            </div>

                            <div>
                                <img src="/assets/images/slipper-blk.png" alt="">
                                <span>Shoes</span>
                            </div>

                            <div>
                                <img src="/assets/images/bag-blk.png" alt="">
                                <span>Bag</span>
                            </div>

                            <div>
                                <img src="/assets/images/bangle-blk.png" alt="">
                                <span>Bangle</span>
                            </div>

                            <div>
                                <img src="/assets/images/slipper-blk.png" alt="">
                                <span>Shoes</span>
                            </div>

                            <div>
                                <img src="/assets/images/tops-blk.png" alt="">
                                <span>Tops</span>
                            </div>

                            <div>
                                <img src="/assets/images/bag-blk.png" alt="">
                                <span>Bags</span>
                            </div>
                        </div>
                        <!-- Dress Types -->

                    </div>
                    <!--/categories-->

                    <div class="age">
                        <!--age-->
                        <h3 class="demi-font font-title-categories">
                            Age
                        </h3>
                        <hr>
                        <div class="age-checkboxes">
                            <!--age-checkboxes-->
                            <div title="0 - 24 Months" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="zero-twfo" name="check"/>
                                    <label class="tick" for="zero-twfo"></label>
                                    <label for="zero-twfo" class="label-squaredThree">0 - 24 Months</label>
                                </div>
                            </div>

                            <div title="2 - 4 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="two-four" name="check"/>
                                    <label class="tick" for="two-four"></label>
                                    <label for="two-four" class="label-squaredThree">2 - 4 Years</label>
                                </div>
                            </div>

                            <div title="8 - 14 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="ei-ft" name="check"/>
                                    <label class="tick" for="ei-ft"></label>
                                    <label for="ei-ft" class="label-squaredThree">8 - 14 Years</label>
                                </div>
                            </div>

                            <div title="14 - 18 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="ft-et" name="check"/>
                                    <label class="tick" for="ft-et"></label>
                                    <label for="ft-et" class="label-squaredThree">14 - 18 Years</label>
                                </div>
                            </div>

                            <div title="4 - 8 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="fo-ei" name="check"/>
                                    <label class="tick" for="fo-ei"></label>
                                    <label for="fo-ei" class="label-squaredThree">4 - 8 Years</label>
                                </div>
                            </div>

                            <div title="14 - 18 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="et-pl" name="check"/>
                                    <label class="tick" for="et-pl"></label>
                                    <label for="et-pl" class="label-squaredThree">18+ Years</label>
                                </div>
                            </div>

                        </div>
                        <!--/age-checkboxes-->
                    </div>
                    <!--age-->

                    <div class="sizes">
                        <!--sizes-->
                        <h3 class="demi-font font-title-categories">
                            Sizes
                        </h3>
                        <hr>

                    </div>
                    <!--/sizes-->

                    <div class="brands">
                        <!--brands-->
                        <h3 class="demi-font font-title-categories">
                            Brands
                        </h3>
                        <hr>

                    </div>
                    <!--/brands-->

                    <div class="colors">
                        <!--colors-->
                        <h3 class="demi-font font-title-categories">
                            Colors
                        </h3>
                        <hr>

                    </div>
                    <!--/colors-->
                </div>

            </div>

            <!-- /Filters for mobile/tab-->


            <div class="col-md-3 hidden-xs hidden-sm">
                <!--filters-->
                <div id="filterproducts" class='row'>
                    <div class='categories'>
                        <!--categories-->
                        <h3 class="demi-font font-title-categories">
                            Categories
                        </h3>
                        <hr>
                        <div class="dress-types">
                            <!-- Dress Types -->
                            <div>
                                <img src="/assets/images/tops-blk.png" alt="">
                                <span>Tops</span>
                            </div>

                            <div>
                                <img src="/assets/images/frok-blk.png" alt="">
                                <span>Frock</span>
                            </div>

                            <div>
                                <img src="/assets/images/bangle-blk.png" alt="">
                                <span>Bangle</span>
                            </div>

                            <div>
                                <img src="/assets/images/slipper-blk.png" alt="">
                                <span>Shoes</span>
                            </div>

                            <div>
                                <img src="/assets/images/bag-blk.png" alt="">
                                <span>Bag</span>
                            </div>

                            <div>
                                <img src="/assets/images/bangle-blk.png" alt="">
                                <span>Bangle</span>
                            </div>

                            <div>
                                <img src="/assets/images/slipper-blk.png" alt="">
                                <span>Shoes</span>
                            </div>

                            <div>
                                <img src="/assets/images/tops-blk.png" alt="">
                                <span>Tops</span>
                            </div>

                            <div>
                                <img src="/assets/images/bag-blk.png" alt="">
                                <span>Bags</span>
                            </div>
                        </div>
                        <!-- Dress Types -->

                    </div>
                    <!--/categories-->

                    <div class="age">
                        <!--age-->
                        <h3 class="demi-font font-title-categories">
                            Age
                        </h3>
                        <hr>
                        <div class="age-checkboxes">
                            <!--age-checkboxes-->
                            <div title="0 - 24 Months" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="zero-twfo" name="check"/>
                                    <label class="tick" for="zero-twfo"></label>
                                    <label for="zero-twfo" class="label-squaredThree">0 - 24 Months</label>
                                </div>
                            </div>

                            <div title="2 - 4 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="two-four" name="check"/>
                                    <label class="tick" for="two-four"></label>
                                    <label for="two-four" class="label-squaredThree">2 - 4 Years</label>
                                </div>
                            </div>

                            <div title="8 - 14 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="ei-ft" name="check"/>
                                    <label class="tick" for="ei-ft"></label>
                                    <label for="ei-ft" class="label-squaredThree">8 - 14 Years</label>
                                </div>
                            </div>

                            <div title="14 - 18 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="ft-et" name="check"/>
                                    <label class="tick" for="ft-et"></label>
                                    <label for="ft-et" class="label-squaredThree">14 - 18 Years</label>
                                </div>
                            </div>

                            <div title="4 - 8 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="fo-ei" name="check"/>
                                    <label class="tick" for="fo-ei"></label>
                                    <label for="fo-ei" class="label-squaredThree">4 - 8 Years</label>
                                </div>
                            </div>

                            <div title="14 - 18 Years" class="col-sm-6">
                                <div class="squaredThree">
                                    <input type="checkbox" value="None" id="et-pl" name="check"/>
                                    <label class="tick" for="et-pl"></label>
                                    <label for="et-pl" class="label-squaredThree">18+ Years</label>
                                </div>
                            </div>

                        </div>
                        <!--/age-checkboxes-->


                    </div>
                    <!--age-->

                    <div class="sizes">
                        <!--sizes-->
                        <h3 class="demi-font font-title-categories">
                            Sizes
                        </h3>
                        <hr>

                    </div>
                    <!--/sizes-->

                    <div class="brands">
                        <!--brands-->
                        <h3 class="demi-font font-title-categories">
                            Brands
                        </h3>
                        <hr>

                    </div>
                    <!--/brands-->

                    <div class="colors">
                        <!--colors-->
                        <h3 class="demi-font font-title-categories">
                            Colors
                        </h3>
                        <hr>

                    </div>
                    <!--/colors-->
                </div>
            </div>
            <!--/filters-->

            {{--<div class="col-md-9 col-sm-12" id='products-display'>--}}
            {{--<!--items-->--}}
            {{--<div class="row">--}}
            {{--<div class="col-md-3 col-sm-5 items p-r">--}}

            {{--<div class="image p-r row">--}}
            {{--<img class="img-responsive" src="/assets/images/img-10.png">--}}

            {{--<div class="p-a item-spec">--}}
            {{--<p class="item-name">YX White T-SHIRT</p>--}}

            {{--<p class="item-description">Gray 100% cottonT-shirt for women</p>--}}

            {{--<p class="price">--}}
            {{--<span class="original-price">�89,99</span>--}}
            {{--<span class="discount-price"> �100,99</span>--}}
            {{--</p>--}}

            {{--<p class="discount-percent">15% OFF</p>--}}
            {{--</div>--}}
            {{--</div>--}}


            {{--<div class="quick-view p-a dis-none">--}}
            {{--<i class="fa fa-search"></i>--}}
            {{--<span>quick view</span>--}}
            {{--</div>--}}

            {{--<div class="items-selection-parent row c-s-padding row">--}}
            {{--<div class="col-md-12 add-cart dis-none">--}}
            {{--<img src="/assets/images/shopping-cart-wht.png" width="18" alt="cart">--}}
            {{--<span class='color-white'>add to cart</span>--}}
            {{--</div>--}}
            {{--<div class='colorandsizes dis-none'><!--color and size-->--}}
            {{--<div class="col-xs-6 item-selection-properties"> <!--item - size -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>sizes</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-1-small" name="check"/>--}}
            {{--<label for="item-1-small"></label>--}}
            {{--<span>S</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-1-medium"--}}
            {{--name="check"/>--}}
            {{--<label for="item-1-medium"></label>--}}
            {{--<span>M</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-1-large" name="check"/>--}}
            {{--<label for="item-1-large"></label>--}}
            {{--<span>L</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-1-extra-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-1-extra-large"></label>--}}
            {{--<span>XL</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - size -->--}}


            {{--<div class="col-xs-6 item-selection-properties"> <!--item - color -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>colors</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-1-navy" name="check"/>--}}
            {{--<label for="item-1-navy"></label>--}}
            {{--<span>navy</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-1-red" name="check"/>--}}
            {{--<label for="item-1-red"></label>--}}
            {{--<span>red</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-1-yellow"--}}
            {{--name="check"/>--}}
            {{--<label for="item-1-yellow"></label>--}}
            {{--<span>yellow</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-1-black" name="check"/>--}}
            {{--<label for="item-1-black"></label>--}}
            {{--<span>black</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - color -->--}}

            {{--</div>--}}
            {{--<!--color and size-->--}}

            {{--<!--sizes-->--}}
            {{--</div>--}}


            {{--</div>--}}

                    <!--item-2-->
            <div class="col-md-9 col-sm-12">
                @foreach($flashsaledetails['product_info'] as $key => $val)
                    <div class="col-md-3 col-sm-5 items p-r">

                        <div class="image p-r row">
                            <img class="img-responsive" src="{{$val['image_url']}}">

                            <div class="p-a item-spec">
                                <p class="item-name">{{ $val['product_name'] }}</p>

                                <p class="item-description">{{ $val['short_description'] }}</p>

                                <p class="price">
                                    <span class="original-price">{{ $val['price_total'] }}</span>
                                    <span class="discount-price"> �100,99</span>
                                </p>

                                <p class="discount-percent">15% OFF</p>
                            </div>
                        </div>


                        <div class="quick-view p-a">
                            <i class="fa fa-search"></i>
                            <a data-target="#myModal" data-toggle="modal" href="javascript:void(0);" id="quicks"
                               class="open-project tovar_view quick_view"
                               product-name="<?php echo $val['product_name']; ?>"
                               data-id="<?php echo $val['product_id']; ?>">quick view</a>
                            {{--<span id="quickview" data-id="{{ $val['product_id'] }}">quick view</span>--}}
                        </div>

                        <div class="items-selection-parent row c-s-padding row">
                            <div class="col-md-12 add-cart dis-none">
                                <img src="/assets/images/shopping-cart-wht.png" width="18" alt="cart">
                                <span class='color-white'>add to cart</span>
                            </div>
                            <div class='colorandsizes dis-none'><!--color and size-->
                                <div class="col-xs-6 item-selection-properties"> <!--item - size -->
                                    <!--sizes-->
                                    <div class="row">

                                        <div class="size-choose">
                                            <p class='demi-16'>sizes</p>

                                            <div class='checkbox-style'>
                                                <div class="squaredOne">
                                                    <input type="checkbox" value="None" id="item-2-small"
                                                           name="check"/>
                                                    <label for="item-2-small"></label>
                                                    <span>S</span>
                                                </div>
                                            </div>

                                            <div class='checkbox-style'>
                                                <div class="squaredOne">
                                                    <input type="checkbox" value="None" id="item-2-medium"
                                                           name="check"/>
                                                    <label for="item-2-medium"></label>
                                                    <span>M</span>
                                                </div>
                                            </div>

                                            <div class='checkbox-style'>
                                                <div class="squaredOne">
                                                    <input type="checkbox" value="None" id="item-2-large"
                                                           name="check"/>
                                                    <label for="item-2-large"></label>
                                                    <span>L</span>
                                                </div>
                                            </div>

                                            <div class='checkbox-style'>
                                                <div class="squaredOne">
                                                    <input type="checkbox" value="None" id="item-2-extra-large"
                                                           name="check"/>
                                                    <label for="item-2-extra-large"></label>
                                                    <span>XL</span>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!--item - size -->


                                <div class="col-xs-6 item-selection-properties"> <!--item - color -->
                                    <!--sizes-->
                                    <div class="row">

                                        <div class="size-choose">
                                            <p class='demi-16'>colors</p>

                                            <div class='checkbox-style'>
                                                <div class="squaredOne">
                                                    <input type="checkbox" value="None" id="item-2-navy"
                                                           name="check"/>
                                                    <label for="item-2-navy"></label>
                                                    <span>navy</span>
                                                </div>
                                            </div>

                                            <div class='checkbox-style'>
                                                <div class="squaredOne">
                                                    <input type="checkbox" value="None" id="item-2-red"
                                                           name="check"/>
                                                    <label for="item-2-red"></label>
                                                    <span>red</span>
                                                </div>
                                            </div>

                                            <div class='checkbox-style'>
                                                <div class="squaredOne">
                                                    <input type="checkbox" value="None" id="item-2-yellow"
                                                           name="check"/>
                                                    <label for="item-2-yellow"></label>
                                                    <span>yellow</span>
                                                </div>
                                            </div>

                                            <div class='checkbox-style'>
                                                <div class="squaredOne">
                                                    <input type="checkbox" value="None" id="item-2-black"
                                                           name="check"/>
                                                    <label for="item-2-black"></label>
                                                    <span>black</span>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!--item - color -->

                            </div>
                            <!--color and size-->

                            <!--sizes-->
                        </div>


                    </div>
                @endforeach
            </div>
            <!--/item-2-->

            {{--<!--item-3-->--}}
            {{--<div class="col-md-3 col-sm-5 items p-r">--}}

            {{--<div class="image p-r row">--}}
            {{--<img class="img-responsive" src="/assets/images/img-12.png">--}}

            {{--<div class="p-a item-spec">--}}
            {{--<p class="item-name">YX White T-SHIRT</p>--}}

            {{--<p class="item-description">Gray 100% cottonT-shirt for women</p>--}}

            {{--<p class="price">--}}
            {{--<span class="original-price">�89,99</span>--}}
            {{--<span class="discount-price"> �100,99</span>--}}
            {{--</p>--}}

            {{--<p class="discount-percent">15% OFF</p>--}}
            {{--</div>--}}
            {{--</div>--}}


            {{--<div class="quick-view p-a dis-none">--}}
            {{--<i class="fa fa-search"></i>--}}
            {{--<span>quick view</span>--}}
            {{--</div>--}}

            {{--<div class="items-selection-parent row c-s-padding row">--}}
            {{--<div class="col-md-12 add-cart dis-none">--}}
            {{--<img src="/assets/images/shopping-cart-wht.png" width="18" alt="cart">--}}
            {{--<span class='color-white'>add to cart</span>--}}
            {{--</div>--}}
            {{--<div class='colorandsizes dis-none'><!--color and size-->--}}
            {{--<div class="col-xs-6 item-selection-properties"> <!--item - size -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>sizes</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-3-small"--}}
            {{--name="check"/>--}}
            {{--<label for="item-3-small"></label>--}}
            {{--<span>S</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-3-medium"--}}
            {{--name="check"/>--}}
            {{--<label for="item-3-medium"></label>--}}
            {{--<span>M</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-3-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-3-large"></label>--}}
            {{--<span>L</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-3-extra-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-3-extra-large"></label>--}}
            {{--<span>XL</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - size -->--}}


            {{--<div class="col-xs-6 item-selection-properties"> <!--item - color -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>colors</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-3-navy"--}}
            {{--name="check"/>--}}
            {{--<label for="item-3-navy"></label>--}}
            {{--<span>navy</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-3-red"--}}
            {{--name="check"/>--}}
            {{--<label for="item-3-red"></label>--}}
            {{--<span>red</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-3-yellow"--}}
            {{--name="check"/>--}}
            {{--<label for="item-3-yellow"></label>--}}
            {{--<span>yellow</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-3-black"--}}
            {{--name="check"/>--}}
            {{--<label for="item-3-black"></label>--}}
            {{--<span>black</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - color -->--}}

            {{--</div>--}}
            {{--<!--color and size-->--}}

            {{--<!--sizes-->--}}
            {{--</div>--}}


            {{--</div>--}}
            {{--<!--/item-3-->--}}


            {{--<!--item-4-->--}}
            {{--<div class="col-md-3 col-sm-5 items p-r">--}}

            {{--<div class="image p-r row">--}}
            {{--<img class="img-responsive" src="/assets/images/img-14.png">--}}

            {{--<div class="p-a item-spec">--}}
            {{--<p class="item-name">YX White T-SHIRT</p>--}}

            {{--<p class="item-description">Gray 100% cottonT-shirt for women</p>--}}

            {{--<p class="price">--}}
            {{--<span class="original-price">�89,99</span>--}}
            {{--<span class="discount-price"> �100,99</span>--}}
            {{--</p>--}}

            {{--<p class="discount-percent">15% OFF</p>--}}
            {{--</div>--}}
            {{--</div>--}}


            {{--<div class="quick-view p-a dis-none">--}}
            {{--<i class="fa fa-search"></i>--}}
            {{--<span>quick view</span>--}}
            {{--</div>--}}

            {{--<div class="items-selection-parent row c-s-padding row">--}}
            {{--<div class="col-md-12 add-cart dis-none">--}}
            {{--<img src="/assets/images/shopping-cart-wht.png" width="18" alt="cart">--}}
            {{--<span class='color-white'>add to cart</span>--}}
            {{--</div>--}}
            {{--<div class='colorandsizes dis-none'><!--color and size-->--}}
            {{--<div class="col-xs-6 item-selection-properties"> <!--item - size -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>sizes</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-small"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-small"></label>--}}
            {{--<span>S</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-medium"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-medium"></label>--}}
            {{--<span>M</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-large"></label>--}}
            {{--<span>L</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-extra-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-extra-large"></label>--}}
            {{--<span>XL</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - size -->--}}


            {{--<div class="col-xs-6 item-selection-properties"> <!--item - color -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>colors</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-navy"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-navy"></label>--}}
            {{--<span>navy</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-red"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-red"></label>--}}
            {{--<span>red</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-yellow"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-yellow"></label>--}}
            {{--<span>yellow</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-black"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-black"></label>--}}
            {{--<span>black</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - color -->--}}

            {{--</div>--}}
            {{--<!--color and size-->--}}

            {{--<!--sizes-->--}}
            {{--</div>--}}


            {{--</div>--}}
            {{--<!--/item-4-->--}}


            {{--<!--item-4  copy-->--}}
            {{--<div class="col-md-3 col-sm-5 items p-r">--}}

            {{--<div class="image p-r row">--}}
            {{--<img class="img-responsive" src="/assets/images/img-14.png">--}}

            {{--<div class="p-a item-spec">--}}
            {{--<p class="item-name">YX White T-SHIRT</p>--}}

            {{--<p class="item-description">Gray 100% cottonT-shirt for women</p>--}}

            {{--<p class="price">--}}
            {{--<span class="original-price">�89,99</span>--}}
            {{--<span class="discount-price"> �100,99</span>--}}
            {{--</p>--}}

            {{--<p class="discount-percent">15% OFF</p>--}}
            {{--</div>--}}
            {{--</div>--}}


            {{--<div class="quick-view p-a dis-none">--}}
            {{--<i class="fa fa-search"></i>--}}
            {{--<span>quick view</span>--}}
            {{--</div>--}}

            {{--<div class="items-selection-parent row c-s-padding row">--}}
            {{--<div class="col-md-12 add-cart dis-none">--}}
            {{--<img src="/assets/images/shopping-cart-wht.png" width="18" alt="cart">--}}
            {{--<span class='color-white'>add to cart</span>--}}
            {{--</div>--}}
            {{--<div class='colorandsizes dis-none'><!--color and size-->--}}
            {{--<div class="col-xs-6 item-selection-properties"> <!--item - size -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>sizes</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-small"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-small"></label>--}}
            {{--<span>S</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-medium"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-medium"></label>--}}
            {{--<span>M</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-large"></label>--}}
            {{--<span>L</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-extra-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-extra-large"></label>--}}
            {{--<span>XL</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - size -->--}}


            {{--<div class="col-xs-6 item-selection-properties"> <!--item - color -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>colors</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-navy"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-navy"></label>--}}
            {{--<span>navy</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-red"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-red"></label>--}}
            {{--<span>red</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-yellow"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-yellow"></label>--}}
            {{--<span>yellow</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-black"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-black"></label>--}}
            {{--<span>black</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - color -->--}}

            {{--</div>--}}
            {{--<!--color and size-->--}}

            {{--<!--sizes-->--}}
            {{--</div>--}}


            {{--</div>--}}
            {{--<!--/item-4 copy-->--}}

            {{--<!--item-4  copy-->--}}
            {{--<div class="col-md-3 col-sm-5 items p-r">--}}

            {{--<div class="image p-r row">--}}
            {{--<img class="img-responsive" src="/assets/images/img-14.png">--}}

            {{--<div class="p-a item-spec">--}}
            {{--<p class="item-name">YX White T-SHIRT</p>--}}

            {{--<p class="item-description">Gray 100% cottonT-shirt for women</p>--}}

            {{--<p class="price">--}}
            {{--<span class="original-price">�89,99</span>--}}
            {{--<span class="discount-price"> �100,99</span>--}}
            {{--</p>--}}

            {{--<p class="discount-percent">15% OFF</p>--}}
            {{--</div>--}}
            {{--</div>--}}


            {{--<div class="quick-view p-a dis-none">--}}
            {{--<i class="fa fa-search"></i>--}}
            {{--<span>quick view</span>--}}
            {{--</div>--}}

            {{--<div class="items-selection-parent row c-s-padding row">--}}
            {{--<div class="col-md-12 add-cart dis-none">--}}
            {{--<img src="/assets/images/shopping-cart-wht.png" width="18" alt="cart">--}}
            {{--<span class='color-white'>add to cart</span>--}}
            {{--</div>--}}
            {{--<div class='colorandsizes dis-none'><!--color and size-->--}}
            {{--<div class="col-xs-6 item-selection-properties"> <!--item - size -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>sizes</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-small"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-small"></label>--}}
            {{--<span>S</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-medium"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-medium"></label>--}}
            {{--<span>M</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-large"></label>--}}
            {{--<span>L</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-extra-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-extra-large"></label>--}}
            {{--<span>XL</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - size -->--}}


            {{--<div class="col-xs-6 item-selection-properties"> <!--item - color -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>colors</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-navy"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-navy"></label>--}}
            {{--<span>navy</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-red"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-red"></label>--}}
            {{--<span>red</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-yellow"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-yellow"></label>--}}
            {{--<span>yellow</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-black"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-black"></label>--}}
            {{--<span>black</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - color -->--}}

            {{--</div>--}}
            {{--<!--color and size-->--}}

            {{--<!--sizes-->--}}
            {{--</div>--}}


            {{--</div>--}}
            {{--<!--/item-4 copy-->--}}


            {{--<!--item-4  copy-->--}}
            {{--<div class="col-md-3 col-sm-5 items p-r">--}}

            {{--<div class="image p-r row">--}}
            {{--<img class="img-responsive" src="/assets/images/img-14.png">--}}

            {{--<div class="p-a item-spec">--}}
            {{--<p class="item-name">YX White T-SHIRT</p>--}}

            {{--<p class="item-description">Gray 100% cottonT-shirt for women</p>--}}

            {{--<p class="price">--}}
            {{--<span class="original-price">�89,99</span>--}}
            {{--<span class="discount-price"> �100,99</span>--}}
            {{--</p>--}}

            {{--<p class="discount-percent">15% OFF</p>--}}
            {{--</div>--}}
            {{--</div>--}}


            {{--<div class="quick-view p-a dis-none">--}}
            {{--<i class="fa fa-search"></i>--}}
            {{--<span>quick view</span>--}}
            {{--</div>--}}

            {{--<div class="items-selection-parent row c-s-padding row">--}}
            {{--<div class="col-md-12 add-cart dis-none">--}}
            {{--<img src="/assets/images/shopping-cart-wht.png" width="18" alt="cart">--}}
            {{--<span class='color-white'>add to cart</span>--}}
            {{--</div>--}}
            {{--<div class='colorandsizes dis-none'><!--color and size-->--}}
            {{--<div class="col-xs-6 item-selection-properties"> <!--item - size -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>sizes</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-small"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-small"></label>--}}
            {{--<span>S</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-medium"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-medium"></label>--}}
            {{--<span>M</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-large"></label>--}}
            {{--<span>L</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-extra-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-extra-large"></label>--}}
            {{--<span>XL</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - size -->--}}


            {{--<div class="col-xs-6 item-selection-properties"> <!--item - color -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>colors</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-navy"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-navy"></label>--}}
            {{--<span>navy</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-red"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-red"></label>--}}
            {{--<span>red</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-yellow"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-yellow"></label>--}}
            {{--<span>yellow</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-black"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-black"></label>--}}
            {{--<span>black</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - color -->--}}

            {{--</div>--}}
            {{--<!--color and size-->--}}

            {{--<!--sizes-->--}}
            {{--</div>--}}


            {{--</div>--}}
            {{--<!--/item-4 copy-->--}}

            {{--<!--item-4  copy-->--}}
            {{--<div class="col-md-3 col-sm-5 items p-r">--}}

            {{--<div class="image p-r row">--}}
            {{--<img class="img-responsive" src="/assets/images/img-14.png">--}}

            {{--<div class="p-a item-spec">--}}
            {{--<p class="item-name">YX White T-SHIRT</p>--}}

            {{--<p class="item-description">Gray 100% cottonT-shirt for women</p>--}}

            {{--<p class="price">--}}
            {{--<span class="original-price">�89,99</span>--}}
            {{--<span class="discount-price"> �100,99</span>--}}
            {{--</p>--}}

            {{--<p class="discount-percent">15% OFF</p>--}}
            {{--</div>--}}
            {{--</div>--}}


            {{--<div class="quick-view p-a dis-none">--}}
            {{--<i class="fa fa-search"></i>--}}
            {{--<span>quick view</span>--}}
            {{--</div>--}}

            {{--<div class="items-selection-parent row c-s-padding row">--}}
            {{--<div class="col-md-12 add-cart dis-none">--}}
            {{--<img src="/assets/images/shopping-cart-wht.png" width="18" alt="cart">--}}
            {{--<span class='color-white'>add to cart</span>--}}
            {{--</div>--}}
            {{--<div class='colorandsizes dis-none'><!--color and size-->--}}
            {{--<div class="col-xs-6 item-selection-properties"> <!--item - size -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>sizes</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-small"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-small"></label>--}}
            {{--<span>S</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-medium"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-medium"></label>--}}
            {{--<span>M</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-large"></label>--}}
            {{--<span>L</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-extra-large"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-extra-large"></label>--}}
            {{--<span>XL</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - size -->--}}


            {{--<div class="col-xs-6 item-selection-properties"> <!--item - color -->--}}
            {{--<!--sizes-->--}}
            {{--<div class="row">--}}

            {{--<div class="size-choose">--}}
            {{--<p class='demi-16'>colors</p>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-navy"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-navy"></label>--}}
            {{--<span>navy</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-red"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-red"></label>--}}
            {{--<span>red</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-yellow"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-yellow"></label>--}}
            {{--<span>yellow</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class='checkbox-style'>--}}
            {{--<div class="squaredOne">--}}
            {{--<input type="checkbox" value="None" id="item-4-black"--}}
            {{--name="check"/>--}}
            {{--<label for="item-4-black"></label>--}}
            {{--<span>black</span>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--<!--item - color -->--}}

            {{--</div>--}}
            {{--<!--color and size-->--}}

            {{--<!--sizes-->--}}
            {{--</div>--}}


            {{--</div>--}}
            {{--<!--/item-4 copy-->--}}

            {{--</div>--}}


            {{--</div>--}}
                    <!--/items-->
            <?php } else {
                echo "No Data Found";
            }?>
        </div>
        <!--/body container row-2 -->


        </div>
        <!--/bodywrapper -->


        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content boder-rad-0">
                    <div class="modal-body">
                        <div class="container-fluid modal-quickview">
                            <!--body container -->
                            <div class="row padding">
                                <div class="col-md-12">
                                    <div class="col-md-1 product-thumbs-list">

                                        <ul class="remove-list-style-modal">
                                            {{--<!-- <li><img src="assets/images/arrow-up.png" alt="arrow-up" class="img-responsive"></li> -->--}}
                                            {{--<a href="#" class="selected" data-full="assets/images/modal-pic-4.png"><img class="img-responsive" src="assets/images/modal-pic-4.png" /></a>--}}
                                            {{--<a href="#" data-full="assets/images/modal-pic-5.png"><img class="img-responsive" src="assets/images/modal-pic-5.png" /></a>--}}
                                            {{--<a href="#" data-full="assets/images/modal-pic-1.png"><img class="img-responsive" src="assets/images/modal-pic-1.png" /></a>--}}
                                            {{--<a href="#" data-full="assets/images/modal-pic-2.png"><img class="img-responsive" src="assets/images/modal-pic-2.png" /></a>--}}
                                            {{--<a href="#" data-full="assets/images/modal-pic-3.png"><img class="img-responsive" src="assets/images/modal-pic-3.png" /></a>--}}
                                            {{--</ul>--}}

                                        </ul>
                                    </div>
                                    <div class="col-md-4 quick-view-img">

                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-6" id="prods">
                                                <div class="reviews-and-ratings">
                                                    <div class="stars">
                                                        <i class="fa fa-star fa-1"></i>
                                                        <i class="fa fa-star fa-1"></i>
                                                        <i class="fa fa-star fa-1"></i>
                                                        <i class="fa fa-star-o fa-1"></i>
                                                        <i class="fa fa-star-o fa-1"></i>
                                                    </div>
                                                    <div class="reviews">
                                                        <span class="review count">1 </span>Review(s) |
                                                        <a href="#">Add Your Review</a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6 delivery-status">
                                                <div class="pul-right">
                                                    <img src="assets/images/delivery-van-modal.png" alt="delivery van">
                                                    FREE DELIVERY
                                                </div>
                                            </div>
                                        </div><!--row-1-->

                                        <div class="bdr-btm-col col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <h3 id="price-total">
                                                            {{--<span class="discounted-price">€89,99</span>  --}}
                                                        </h3>
                                                        <h3 class="offer-discount">15% OFF</h3>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pull-right">
                                                    <div class="row">
                                                        <p class="mar-top-10 text-color-lg">Product code: <span
                                                                    class="product-code text-color-dg"> 275</span></p>
                                                        <p class="text-color-lg">Availablity: <span
                                                                    class="availablity text-color-dg">In Stock</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--row-2-->

                                        <div class="col-md-12 bdr-btm-col">
                                            <div class="row">
                                                <p><b> QUICK OVERVIEW:</b></p>
                                                <p class="tp-pro">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempora,
                                                    accusamus maxime quidem alias odit dolores cum porro repudiandae
                                                    enim doloribus, tenetur voluptatem quasi soluta nam provident nemo
                                                    vero, excepturi mollitia.
                                                </p>
                                            </div>
                                        </div><!--row-3-->

                                        <div class="col-md-12 bdr-btm-col paddr-10">
                                            <div class="row">
                                                {{--<p class="sub-head">SIZE</p>--}}
                                                {{--<div class='checkbox-style'>--}}
                                                {{--<div class="squaredOne">--}}
                                                {{--<input type="checkbox" value="None" id="modal-size-small"--}}
                                                {{--name="check"/>--}}
                                                {{--<label for="modal-size-small"></label>--}}
                                                {{--<span></span>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                <div class="col-md-6">
                                                    <div class="clearfix">
                                                        <p class="pull-left">Select Size</p>
                                                    </div>
                                                    <select class="basic sizes" id="productsize">

                                                    </select>
                                                </div>
                                                {{--<div class="col-md-6">--}}
                                                {{--<div class="clearfix">--}}
                                                {{--<p class="pull-left">Select quantity</p>--}}
                                                {{--</div>--}}
                                                {{--<select class="basic productquantity">--}}
                                                {{--<option value="">QTY</option>--}}
                                                {{--</select>--}}
                                                {{--</div>--}}
                                            </div>

                                            {{--<div class="pull-left">--}}
                                            {{--<label class="control-label">Size:</label>--}}
                                            {{--<select class="form-control input-sm" id="select-size" data-prodid="" onchange="selsizeoption(this.value)">--}}

                                            {{--</select>--}}
                                            {{--</div>--}}
                                        </div><!--row-4-->

                                        <div class="col-md-12 bdr-btm-col paddr-10">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="clearfix">
                                                        <p class="pull-left">Select Color</p>
                                                    </div>
                                                    <select class="basic color" id="productcolor">
                                                        <option value="">Color</option>
                                                    </select>
                                                </div>
                                                {{--<p class="sub-head">COLOR</p>--}}
                                            </div>
                                        </div><!--row-5-->

                                        <div class="col-md-12 bdr-btm-col paddr-10">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="sub-head">Quantity</p>
                                                    <div class="form-group width-100">
                                                        <label for="" class="control-label decrease-quan"><i
                                                                    class="fa fa-minus"></i> </label>
                                                        <input type="text" class="form-control input_count"
                                                               name="input-item-count"
                                                               id="input-item-count" min="0">
                                                        <label for="" class="control-label increase-quan"><i
                                                                    class="fa fa-plus"></i> </label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--row-6-->

                                    </div>
                                </div>
                            </div>

                            <!--/body container -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection


@section('pagejavascripts')
    <script type="text/javascript" src="/assets/scripts/jquery.mThumbnailScroller.js"></script>
    <script src="/assets/scripts/jquery-ui.js" type="text/javascript"></script>
    <script type="text/javascript" src="/assets/scripts/fancybox.js"></script>
    <script type="text/javascript" src="/assets/scripts/script.js"></script>


    <script type="text/javascript">

        $('#filterproducts').affix({
            offset: {
                top: $('#filterproducts').offset().top
            }
        });

        $('.fixed-menu , .slide-left').on('click', function () {
            $("#filter-md-sm, .fixed-menu ").toggle("slide");
        });

        // $(document).scroll(function(){
        //     if($('#filter-products').hasClass('affix')){
        //         $('#products-display').addClass('col-md-offset-3');
        //     } else {
        //         $('#products-display').removeClass('col-md-offset-3');
        //     }
        // });

        $(document).ready(function () {

        });
        // closing the listening on a click
        // $('.quick-view-img img').on('click', function(){
        //   var modalImage = $(this).attr('src');
        //   $.fancybox.open(modalImage);
        // });


        $("#input-item-count").bind("change mouseleave", function () {

            var str_test = $("#input-item-count").val();

            if (/\D/.test(str_test)) {
                $("#input-item-count").val('1');
            }
        });

        $(".increase-quan").on('click', function () {
            var tar_ele = $(this).siblings("input:text");
            if (isNaN(parseInt(tar_ele.val()))) {
                tar_ele.val('1');
            }
            value = parseInt(tar_ele.val()) + 1;
            tar_ele.val(value);
        });
        $(".decrease-quan").on('click', function () {
            var tar_ele = $(this).siblings("input:text");
            if (isNaN(parseInt(tar_ele.val()))) {
                tar_ele.val('1');
            }
            value = parseInt(tar_ele.val()) - 1;
            tar_ele.val(value);
        });

        (function ($) {
            $(window).load(function () {
                $(".product-thumbs-list").mThumbnailScroller({
                    axis: "y",
                    type: "click-thumb",
                    theme: "buttons-out" //change to "y" for vertical scroller
                });
            });
        })(jQuery);


        //        $('.quick-view.p-a').on('click', function () {
        //            $('#myModal').modal("show");
        //        }
        //  FOR QUICK VIEW OF PRODUCT IN MODAL      //
        $(document.body).on('click', '#quicks', function () {
            var prodId = $(this).attr('data-id');
            var productName = $(this).attr('product-name');
            $.ajax({
                url: '/flashsale-ajax-handler',
                type: 'POST',
                datatype: 'json',
                data: {
                    method: 'getProductDetailsForPopUp',
                    prodId: prodId
                },
                success: function (response) {
                    var response = $.parseJSON(response);
                    var optionResponse = [];
                    $.each(response['actualData'],function(actindex,actval){
                        response[actindex] = actval;
                    });
                    $('#prods').html('<span class="prodcut_name">' + response['product_name'] + '</span>');
                    $('#price-total').html('<span class="real-price">' + response['price_total'] + '</span>');
                    var image = [];
                    var otherimg = [];
                    $(".remove-list-style-modal").empty();
                    $('.quick-view-img').empty();
                    $.each(response['image_url'].split(","), function (index, value) {
                        image[index] = value;
                        if (index == 0) {
                            $('.quick-view-img').append('<img src="' + value + '" alt="zoomed" class="img-responsive">');
                        }
                        $(".remove-list-style-modal").append('<a data-full="' + value + '" href="#" class="slide_thumb ' + ((index == 0) ? 'selected' : '') + '"><img src="' + value + '" class="img-responsive"></a>');
                        $.each(response['variant'],function(variantindex,variantvalue){
//                            $.each(variantvalue,function(newvkey,newvvalue){
                                optionResponse[variantindex] = variantvalue['Color'];
//                            });
                        });
                        console.log(optionResponse);
                        $('#productsize').append('<option value="">Size</option>');
                        $('a').click(function () {
                            var largeImage = $(this).attr('data-full');
                            $('.selected').removeClass();
                            $(this).addClass('selected');
                            $('.quick-view-img img').hide();
                            $('.quick-view-img img').attr('src', largeImage);
                            $('.quick-view-img img').fadeIn();
                        });
                    });

                }
            });
        });
    </script>
@endsection