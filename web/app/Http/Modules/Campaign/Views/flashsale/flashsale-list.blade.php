@extends('Home/Layouts/home_layout')
@section('pageheadcontent')
    {{--OPTIONAL--}}
    <link href="/assets/global/css/etalage.css" media="screen" rel="stylesheet" type="text/css">
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <style type="text/css" media="screen">
        .modal-dialog {
            width: 1050px;
        }

        .bg-img-row-1 {
            background-image: url("{{$flashsaledetails['campaign_banner']}}") !important;
        }

    </style>
    <style>
        .etalage_zoom_preview {
            opacity: 1 !important;
        }

        li.etalage_zoom_area div:last-child {
            width: 440px !important;
            /*height: 440px !important;*/
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
                            <a class="product-link" title="{{ $val['product_name'] }}" data-gilt-test="pdp-url"
                               href="/product-details/{{$val['product_id']}}/{{str_replace(" ","-",$val['product_name'])}}?orign=flashsale">
                                <img class="img-responsive" id="image-res{{$val['product_id']}}"
                                     src="{{$val['image_url']}}" main-image="{{$val['image_url']}}">

                                <div class="p-a item-spec">
                                    <p class="item-name">{{ $val['product_name'] }}</p>

                                    <p class="item-description">{{ $val['short_description'] }}</p>

                                    <p class="price">
                                        <span class="original-price">{{ $val['price_total'] }}</span>
                                        <span class="discount-price"> �100,99</span>
                                    </p>

                                    {{--<p class="discount-percent">15% OFF</p>--}}
                                </div>
                            </a>
                        </div>


                        <div class="quick-view p-a">
                            <i class="fa fa-search"></i>
                            <a href="javascript:void(0);" id="quicks"
                               class="open-project tovar_view quick_view quicks"
                               product-name="<?php echo $val['product_name']; ?>"
                               data-id="<?php echo $val['product_id']; ?>">quick view</a>
                            {{--<span id="quickview" data-id="{{ $val['product_id'] }}">quick view</span>--}}
                        </div>
                        <?php  $optionIds = explode(",", $val['option_ids']); ?>
                        <div class="items-selection-parent row c-s-padding row">
                            <div class="col-md-12 add-cart dis-none">
                                <div class="quick-add-submit">
                                    <img src="/assets/images/shopping-cart-wht.png" width="18" alt="cart">
                                    <button class="cartOptions" style="background: orange;" type="button" id="cart"
                                            data-option="<?php echo implode(",", $optionIds);?>"
                                            value="Add to cart">Add to cart
                                    </button>
                                    {{--<input class="add-to-cart show active" type="submit"--}}
                                    {{--data-gilt-test="button-add-to-cart" value="Add to Cart">--}}
                                </div>
                            </div>
                            <div class='colorandsizes dis-none'><!--color and size-->

                                <?php //if(isset($variantData) && (!empty($variantData)) )  {
                                $optionNames = explode(",", $val['option_names']);
                                $optionIds = explode(",", $val['option_ids']);
                                $variantData = explode("____", $val['variant_datas']);
                                //                                if (!empty($val['variant_ids_combination'])) {
                                //                                    $variantCombination = array_unique(explode(",", str_replace('_', ',', $val['variant_ids_combination'])));
                                //  $combined = implode(",", $variantCombination);
                                $variantCombination = $val['variant_ids_combination'];
                                //                                } else {
                                //                                    $variantCombination = '';
                                //                                }
                                ?>
                                @foreach($optionNames as $oKey =>$oValue)
                                    <div class="col-xs-6 item-selection-properties"> <!--item - color -->
                                        <div class="row">
                                            <p class='demi-16'>{{$oValue}}</p>
                                            @foreach(json_decode($variantData[$oKey]) as $vKey=>$vValue)
                                                <div class='checkbox-style'>
                                                    <div class="squaredOne">
                                                        {{--<input name="name" id="id" type="checkbox"  id="option_variant_{{$vValue->VID}}"/>--}}
                                                        {{--<input type="checkbox" onclick="if(this.checked){myFunction()}" id="option_variant_{{$vValue->VID}}">--}}
                                                        <span class="variant" data-variant="{{$vValue->VID}}" value="">
                                                        <input type="checkbox" name="options[]" value="{{$vValue->VID}}"
                                                               data-combination="<?php echo $variantCombination;?>"
                                                               data-variant-name="{{$vValue->VN}}"
                                                               class="vari"
                                                               id="item-{{$vValue->VID}}">
                                                        <label for="item-{{$vValue->VID}}"></label>
                                                            {{$vValue->VN}}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                <?php// } ?>
                            </div>
                            <!--color and size-->

                            <!--sizes-->
                        </div>


                    </div>
                    @endforeach
            </div>
            <?php } else {
                echo "No Data Found";
            }?>
        </div>
        <!--/body container row-2 -->


        </div>
        <!--/bodywrapper -->


        {{--<div id="myModal" class="modal fade" role="dialog">--}}
        {{--<div class="modal-dialog">--}}

        {{--<!-- Modal content-->--}}
        {{--<div class="modal-content boder-rad-0">--}}
        {{--<div class="modal-body">--}}
        {{--<div class="container-fluid modal-quickview">--}}
        {{--<!--body container -->--}}
        {{--<div class="row padding">--}}
        {{--<div class="col-md-12">--}}
        {{--<div class="col-md-1 product-thumbs-list">--}}
        {{--<div class="col-md-6 clearfix">--}}

        {{--<ul class="remove-list-style-modal">--}}
        {{--<ul id="etalage" class="image_zoom remove-list-style-modal" style="margin-bottom: 0; padding-bottom: 0;">--}}
        {{--<!-- <li><img src="assets/images/arrow-up.png" alt="arrow-up" class="img-responsive"></li> -->--}}
        {{--<a href="#" class="selected" data-full="assets/images/modal-pic-4.png"><img class="img-responsive" src="assets/images/modal-pic-4.png" /></a>--}}
        {{--<a href="#" data-full="assets/images/modal-pic-5.png"><img class="img-responsive" src="assets/images/modal-pic-5.png" /></a>--}}
        {{--<a href="#" data-full="assets/images/modal-pic-1.png"><img class="img-responsive" src="assets/images/modal-pic-1.png" /></a>--}}
        {{--<a href="#" data-full="assets/images/modal-pic-2.png"><img class="img-responsive" src="assets/images/modal-pic-2.png" /></a>--}}
        {{--<a href="#" data-full="assets/images/modal-pic-3.png"><img class="img-responsive" src="assets/images/modal-pic-3.png" /></a>--}}
        {{--</ul>--}}
        {{--<li>--}}
        {{--<img class="etalage_thumb_image" src="" />--}}
        {{--<img class="etalage_source_image" src="" />--}}
        {{--</li>--}}
        {{--<ul id="etalage" class="image_zoom"--}}
        {{--style="margin-bottom: 0; padding-bottom: 0;">--}}
        {{--<li>--}}
        {{--<img class="etalage_thumb_image" src=""/>--}}
        {{--<img class="etalage_source_image" src=""/>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</ul>--}}
        {{--</div>--}}
        {{--<div class="col-md-4 quick-view-img">--}}

        {{--</div>--}}
        {{--<div class="col-md-6">--}}
        {{--<div class="row">--}}
        {{--<div class="col-md-6" id="prods">--}}
        {{--<div class="reviews-and-ratings">--}}
        {{--<div class="stars">--}}
        {{--<i class="fa fa-star fa-1"></i>--}}
        {{--<i class="fa fa-star fa-1"></i>--}}
        {{--<i class="fa fa-star fa-1"></i>--}}
        {{--<i class="fa fa-star-o fa-1"></i>--}}
        {{--<i class="fa fa-star-o fa-1"></i>--}}
        {{--</div>--}}
        {{--<div class="reviews">--}}
        {{--<span class="review count">1 </span>Review(s) |--}}
        {{--<a href="#">Add Your Review</a>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--</div>--}}
        {{--<div class="col-md-6 delivery-status">--}}
        {{--<div class="pul-right">--}}
        {{--<img src="assets/images/delivery-van-modal.png"--}}
        {{--alt="delivery van">--}}
        {{--FREE DELIVERY--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div><!--row-1-->--}}

        {{--<div class="bdr-btm-col col-md-12">--}}
        {{--<div class="row">--}}
        {{--<div class="col-md-6">--}}
        {{--<div class="row">--}}
        {{--<h3 id="price-total">--}}
        {{--<span class="discounted-price">€89,99</span>  --}}
        {{--</h3>--}}
        {{--<h3 class="offer-discount">15% OFF</h3>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-md-6 pull-right">--}}
        {{--<div class="row">--}}
        {{--<p class="mar-top-10 text-color-lg">Product code: <span--}}
        {{--class="product-code text-color-dg"> 275</span>--}}
        {{--</p>--}}
        {{--<p class="text-color-lg available">Availablity:</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div><!--row-2-->--}}

        {{--<div class="col-md-12 bdr-btm-col">--}}
        {{--<div class="row">--}}
        {{--<p><b> QUICK OVERVIEW:</b></p>--}}
        {{--<p class="tp-pro" id="full_description">--}}
        {{--</p>--}}
        {{--</div>--}}
        {{--</div><!--row-3-->--}}

        {{--<div class="option-details col-md-12 bdr-btm-col"--}}
        {{--id="option-details"></div>--}}
        {{--<div class="discount-value col-md-12 bdr-btm-col"--}}
        {{--id="discount-value"></div>--}}
        {{--<div class="col-md-12 bdr-btm-col paddr-10">--}}
        {{--<div class="row">--}}
        {{--<div class="col-md-6">--}}
        {{--<p class="sub-head">Quantity</p>--}}
        {{--<div class="form-group width-100">--}}
        {{--<label for="" class="control-label decrease-quan"><i--}}
        {{--class="fa fa-minus"></i> </label>--}}
        {{--<input type="text" class="form-control input_count"--}}
        {{--name="input-item-count"--}}
        {{--id="input-item-count" min="0">--}}
        {{--<label for="" class="control-label increase-quan"><i--}}
        {{--class="fa fa-plus"></i> </label>--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row">--}}
        {{--<a role="button" href="#"--}}
        {{--class="btn btn-primary btn-lg brdr_non pading_lr top15_margin add-to-cart">Add--}}
        {{--to cart</a>--}}
        {{--<a role="button" href="#"--}}
        {{--class="btn btn-primary btn-lg brdr_non pading_lr top15_margin buy-now">Buy</a>--}}
        {{--<a role="button" href="#"--}}
        {{--class="btn btn-primary btn-lg brdr_non pading_lr top15_margin add-to-wishlist">Add--}}
        {{--to Whishlist</a>--}}
        {{--</div>--}}
        {{--</div><!--row-6-->--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<!--/body container -->--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--</div>--}}
        {{--</div>--}}
    </section>

@endsection

@section('pagejavascripts')


    {{--<script type="text/javascript">--}}

    {{--$('#filterproducts').affix({--}}
    {{--offset: {--}}
    {{--top: $('#filterproducts').offset().top--}}
    {{--}--}}
    {{--});--}}

    {{--$('.fixed-menu , .slide-left').on('click', function () {--}}
    {{--$("#filter-md-sm, .fixed-menu ").toggle("slide");--}}
    {{--});--}}

    {{--// $(document).scroll(function(){--}}
    {{--//     if($('#filter-products').hasClass('affix')){--}}
    {{--//         $('#products-display').addClass('col-md-offset-3');--}}
    {{--//     } else {--}}
    {{--//         $('#products-display').removeClass('col-md-offset-3');--}}
    {{--//     }--}}
    {{--// });--}}

    {{--$(document).ready(function () {--}}

    {{--});--}}
    {{--// closing the listening on a click--}}
    {{--// $('.quick-view-img img').on('click', function(){--}}
    {{--//   var modalImage = $(this).attr('src');--}}
    {{--//   $.fancybox.open(modalImage);--}}
    {{--// });--}}


    {{--$("#input-item-count").bind("change mouseleave", function () {--}}

    {{--var str_test = $("#input-item-count").val();--}}

    {{--if (/\D/.test(str_test)) {--}}
    {{--$("#input-item-count").val('1');--}}
    {{--}--}}
    {{--});--}}

    {{--$(".increase-quan").on('click', function () {--}}
    {{--var tar_ele = $(this).siblings("input:text");--}}
    {{--if (isNaN(parseInt(tar_ele.val()))) {--}}
    {{--tar_ele.val('1');--}}
    {{--}--}}
    {{--value = parseInt(tar_ele.val()) + 1;--}}
    {{--tar_ele.val(value);--}}
    {{--});--}}
    {{--$(".decrease-quan").on('click', function () {--}}
    {{--var tar_ele = $(this).siblings("input:text");--}}
    {{--if (isNaN(parseInt(tar_ele.val()))) {--}}
    {{--tar_ele.val('1');--}}
    {{--}--}}
    {{--value = parseInt(tar_ele.val()) - 1;--}}
    {{--tar_ele.val(value);--}}
    {{--});--}}

    {{--(function ($) {--}}
    {{--$(window).load(function () {--}}
    {{--//                $(".product-thumbs-list").mThumbnailScroller({--}}
    {{--//                    axis: "y",--}}
    {{--//                    type: "click-thumb",--}}
    {{--//                    theme: "buttons-out" //change to "y" for vertical scroller--}}
    {{--//                });--}}
    {{--});--}}
    {{--})(jQuery);--}}


    {{--//        $('.quick-view.p-a').on('click', function () {--}}
    {{--//            $('#myModal').modal("show");--}}
    {{--//        }--}}
    {{--//  FOR QUICK VIEW OF PRODUCT IN MODAL      //--}}
    {{--var actualResponse = [];--}}
    {{--var discountPrice = [];--}}
    {{--var discounts = [];--}}
    {{--var combinedVariantIds = [];--}}
    {{--$(document.body).on('click', '#quicks', function () {--}}
    {{--var prodId = $(this).attr('data-id');--}}
    {{--var productName = $(this).attr('product-name');--}}
    {{--//            var mainImage =  document.getElementById("image-res"+prodId).attr('main-image');--}}
    {{--var mainImage = $('#image-res' + prodId).attr('main-image');--}}
    {{--$.ajax({--}}
    {{--url: '/flashsale-ajax-handler',--}}
    {{--type: 'POST',--}}
    {{--datatype: 'json',--}}
    {{--data: {--}}
    {{--method: 'getProductDetailsForPopUp',--}}
    {{--prodId: prodId--}}
    {{--},--}}
    {{--success: function (response) {--}}
    {{--var response = $.parseJSON(response);--}}
    {{--var optionResponse = [];--}}
    {{--$.each(response, function (actindex, actval) {--}}
    {{--actualResponse[actindex] = actval;--}}
    {{--});--}}
    {{--$('#prods').html('<span class="prodcut_name">' + actualResponse['product_name'] + '</span>');--}}
    {{--$('#price-total').html('<span class="real-price">' + actualResponse['price_total'] + '</span>');--}}
    {{--$('#full_description').html(actualResponse['short_description']);--}}
    {{--if (actualResponse['in_stock'] != 0) {--}}
    {{--availableResponse = 'InStock';--}}
    {{--}--}}
    {{--else {--}}
    {{--availableResponse = 'Outofstock';--}}
    {{--}--}}
    {{--$('.available').html('<span class="availablity text-color-dg">Available: ' + availableResponse + '</span>');--}}
    {{--$("#discount-value").empty();--}}
    {{--var toAppendProductVariant = '';--}}
    {{--if ($.parseJSON(response['quantity_discount'] != '')) {--}}
    {{--toAppendProductVariant += '<div class="portlet-body">';--}}
    {{--toAppendProductVariant += '<div class="table-scrollable">Our quantity discounts:</div>';--}}
    {{--toAppendProductVariant += '<table class="table table-bordered table-hover">';--}}
    {{--toAppendProductVariant += '<thead>';--}}
    {{--toAppendProductVariant += '<tr>';--}}
    {{--toAppendProductVariant += '<th>Quantity</th>';--}}
    {{--toAppendProductVariant += '<th>Price</th>';--}}
    {{--$.each($.parseJSON(response['quantity_discount']), function (discountIndex, discountValue) {--}}
    {{--if (discountValue['quantity'] != null && discountValue['value'] != null && discountValue['type'] != null) {--}}
    {{--//                            toAppendProductVariant += '<th>' + discountValue['quantity'] + '</th>';--}}
    {{--toAppendProductVariant += '</tr>';--}}
    {{--toAppendProductVariant += '</thead>';--}}
    {{--toAppendProductVariant += '<tbody>';--}}
    {{--toAppendProductVariant += '<tr>';--}}
    {{--toAppendProductVariant += '<td>' + discountValue['quantity'] + '</td>';--}}
    {{--toAppendProductVariant += '<td><span>' + discountValue['value'] + '</span>' + ((discountValue['type']) ? '%' : '$') + '</td>';--}}
    {{--toAppendProductVariant += '</tr>';--}}

    {{--}--}}
    {{--else {--}}
    {{--toAppendProductVariant += '<span></span>';--}}
    {{--}--}}
    {{--});--}}
    {{--toAppendProductVariant += '</tbody>';--}}
    {{--toAppendProductVariant += '</table>';--}}
    {{--toAppendProductVariant += '</div>';--}}
    {{--toAppendProductVariant += '</div>';--}}
    {{--toAppendProductVariant += '</div>';--}}
    {{--}--}}
    {{--$("#discount-value").append(toAppendProductVariant);--}}
    {{--var image = [];--}}
    {{--var otherimg = [];--}}
    {{--$("#etalage").empty();--}}
    {{--$('.quick-view-img').empty();--}}
    {{--$.each(response['image_urls'].split(","), function (index, value) {--}}
    {{--image[index] = value;--}}
    {{--if (response['image_url']) {--}}
    {{--$("#etalage").append('<li><img class="etalage_thumb_image" src="..' + mainImage + '" alt="" />');--}}
    {{--$('#etalage').append('<img class="etalage_source_image" src="..' + mainImage + '" alt="" /></li>');--}}
    {{--}--}}
    {{--$("#etalage").append('<li><img class="etalage_thumb_image" src="..' + value + '" alt="" />');--}}
    {{--$('#etalage').append('<img class="etalage_source_image" src="..' + value + '" alt="" /></li>');--}}

    {{--});--}}
    {{--var combination = [];--}}
    {{--if (response['variant_ids_combination'] != '' && response['variant_ids_combination'] != null) {--}}
    {{--var array1 = $.unique((response['variant_ids_combination'].replace(/_+/g, ',')).split(','));--}}
    {{--combinedVariantIds = $.unique((response['variant_ids_combination'].replace(/_+/g, ',')).split(','));--}}
    {{--}--}}
    {{--$("#option-details").empty();--}}
    {{--var toAppendOptionDetails = '';--}}
    {{--$.each(response['options'], function (optionIndex, optionValue) {--}}
    {{--toAppendOptionDetails += '<div class="col-md-12 bdr-btm-col paddr-10 option-variant-container" style="margin-bottom: 3%">';--}}
    {{--toAppendOptionDetails += '<div class="row">';--}}
    {{--toAppendOptionDetails += '<div class="col-md-12">';--}}
    {{--toAppendOptionDetails += '<div class="clearfix" id="option_id_"' + optionValue['option_id'] + '>';--}}
    {{--toAppendOptionDetails += '<div class="form-group">';--}}
    {{--toAppendOptionDetails += '<label class="col-sm-3 control-label">Select ' + optionValue['option_name'] + '</label>';--}}
    {{--toAppendOptionDetails += '<div class="col-sm-4">';--}}
    {{--//                         TODO check for type--}}


    {{--toAppendOptionDetails += '<select class="pull-right basic form-control option">';--}}
    {{--toAppendOptionDetails += '<option  value="">Select...</option>';--}}
    {{--$.each(optionValue['variantData']['variant_id'], function (i, v) {--}}
    {{--toAppendOptionDetails += '<option prod-id="' + response['product_id'] + '" data-id="' + optionValue['variantData']['variant_id'][i] + '" pricemodifier="' + optionValue['variantData']['price_modifier'][i] + '" value="' + optionValue['variantData']['variant_id'][i] + '" class="option-variant">' + optionValue['variantData']['variant_name'][i] + '</option>';--}}
    {{--});--}}
    {{--toAppendOptionDetails += '</select>';--}}
    {{--//                       TODO end- check for type--}}
    {{--toAppendOptionDetails += '</div>';--}}
    {{--toAppendOptionDetails += '</div>';--}}
    {{--toAppendOptionDetails += '</div>';--}}
    {{--toAppendOptionDetails += '</div>';--}}
    {{--toAppendOptionDetails += '</div>';--}}
    {{--toAppendOptionDetails += '</div>';--}}
    {{--});--}}

    {{--$("#option-details").append(toAppendOptionDetails);--}}
    {{--$('#etalage').etalage({--}}
    {{--thumb_image_width: 400,--}}
    {{--thumb_image_height: 400,--}}
    {{--source_image_width: 900,--}}
    {{--source_image_height: 1200,--}}
    {{--show_hint: true,--}}
    {{--click_callback: function (image_anchor, instance_id) {--}}
    {{--alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');--}}
    {{--}--}}
    {{--});--}}
    {{--$('#myModal').modal("show");--}}
    {{--}--}}
    {{--});--}}

    {{--});--}}

    {{--$(document.body).on('change', '.option', function () {--}}

    {{--var obj = $(this);--}}
    {{--var variantId = obj.val();--}}
    {{--var prodId = $('.option-variant').attr('prod-id');--}}
    {{--if (actualResponse['variant_ids_combintaion'] != null && actualResponse['variant_ids_combination'] != '') {--}}
    {{--if (obj.val() == '') {--}}
    {{--$('.option-variant').each(function () {--}}
    {{--//                    if ($(".option option:selected")) {--}}
    {{--//   console.log(this);--}}
    {{--//                        this.disabled = false;--}}
    {{--//                    this.disabled = "";--}}
    {{--$(this).removeAttr("disabled");--}}
    {{--console.log(this);--}}
    {{--//  console.log($('.option-variant').attr('disabled',false));--}}
    {{--//                 }--}}
    {{--});--}}
    {{--}--}}
    {{--}--}}

    {{--var selectedCombination = [];--}}
    {{--$.each($(".option option:selected"), function (i, v) {--}}
    {{--selectedCombination.push($(this).val());--}}
    {{--});--}}
    {{--$('.option').not(this).find('.option-variant:not(:first-child)').prop('disabled', true);--}}

    {{--$.each(combinedVariantIds, function (i, v) {--}}
    {{--$('.option-variant[data-id="' + v + '"]').prop('disabled', false);--}}
    {{--// console.log($('.option-variant[data-id="' + v + '"]').prop('disabled', false));--}}
    {{--});--}}

    {{--// }--}}
    {{--var priceModifier = $(this).attr('pricemodifier');--}}
    {{--var image = [];--}}
    {{--$.ajax({--}}
    {{--url: '/flashsale-ajax-handler',--}}
    {{--type: 'POST',--}}
    {{--datatype: 'json',--}}
    {{--data: {--}}
    {{--method: 'getOptionVariantDetails',--}}
    {{--priceModifier: priceModifier,--}}
    {{--variantId: variantId,--}}
    {{--prodId: prodId,--}}
    {{--selectedCombination: selectedCombination--}}
    {{--},--}}
    {{--success: function (response) {--}}
    {{--response = $.parseJSON(response);--}}
    {{--if (response['variant_ids_combination'] != '' && response['variant_ids_combination'] != null) {--}}
    {{--var variantPrice = Number(parseFloat(response['price_modifier']).toFixed(3)) + Number(parseFloat(actualResponse['price_total']).toFixed(3));--}}
    {{--if (variantPrice) {--}}
    {{--$('#price-total').html('<span class="real">' + variantPrice + '</span>');--}}
    {{--} else {--}}
    {{--$('#price-total').html('<span class="real">' + actualResponse['price_total'] + '</span>');--}}
    {{--}--}}
    {{--$("#etalage").empty();--}}
    {{--if (response['image_urls'] != '' && response['image_urls'] != null) {--}}
    {{--$("#etalage").append('<li><img class="etalage_thumb_image" src="..' + response['image_urls'] + '" alt="" / >');--}}
    {{--$('#etalage').append('<img class="etalage_source_image" src="..' + response['image_urls'] + '" alt="" /></li>');--}}
    {{--} else {--}}
    {{--$("#etalage").append('<li><img class="etalage_thumb_image" src="..' + actualResponse['image_url'] + '" alt="" / >');--}}
    {{--$('#etalage').append('<img class="etalage_source_image" src="..' + actualResponse['image_url'] + '" alt="" /></li>');--}}
    {{--}--}}
    {{--$('#etalage').etalage({--}}
    {{--thumb_image_width: 400,--}}
    {{--thumb_image_height: 400,--}}
    {{--source_image_width: 900,--}}
    {{--source_image_height: 1200,--}}
    {{--show_hint: true,--}}
    {{--click_callback: function (image_anchor, instance_id) {--}}
    {{--alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');--}}
    {{--}--}}
    {{--});--}}
    {{--} else {--}}
    {{--var variantPrice = Number(parseFloat(response['price_modifier']).toFixed(3)) + Number(parseFloat(actualResponse['price_total']).toFixed(3));--}}
    {{--if (variantPrice) {--}}
    {{--$('#price-total').html('<span class="real">' + variantPrice + '</span>');--}}
    {{--} else {--}}
    {{--$('#price-total').html('<span class="real">' + actualResponse['price_total'] + '</span>');--}}
    {{--}--}}
    {{--$("#etalage").empty();--}}
    {{--$('.quick-view-img').empty();--}}
    {{--$.each(actualResponse['image_urls'].split(","), function (index, value) {--}}
    {{--image[index] = value;--}}
    {{--$("#etalage").append('<li><img class="etalage_thumb_image" src="..' + value + '" alt="" />');--}}
    {{--$('#etalage').append('<img class="etalage_source_image" src="..' + value + '" alt="" /></li>');--}}
    {{--});--}}
    {{--$('#etalage').etalage({--}}
    {{--thumb_image_width: 400,--}}
    {{--thumb_image_height: 400,--}}
    {{--source_image_width: 900,--}}
    {{--source_image_height: 1200,--}}
    {{--show_hint: true,--}}
    {{--click_callback: function (image_anchor, instance_id) {--}}
    {{--alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');--}}
    {{--}--}}
    {{--});--}}
    {{--}--}}
    {{--}--}}
    {{--});--}}

    {{--});--}}


    {{--//        $(document.body).on('click', '.option-variant', function () {--}}
    {{--//            var priceModifier = $(this).attr('pricemodifier');--}}
    {{--//            var variantId = $(this).attr('value');--}}
    {{--//            var image = [];--}}
    {{--//            $.ajax({--}}
    {{--//                url: '/flashsale-ajax-handler',--}}
    {{--//                type: 'POST',--}}
    {{--//                datatype: 'json',--}}
    {{--//                data: {--}}
    {{--//                    method: 'getOptionVariantDetails',--}}
    {{--//                    priceModifier: priceModifier,--}}
    {{--//                    variantId: variantId--}}
    {{--//                },--}}
    {{--//                success: function (response) {--}}
    {{--//                    response = $.parseJSON(response);--}}
    {{--//                    // console.log(response);--}}
    {{--//                    var variantPrice = Number(parseFloat(response['price_modifier']).toFixed(3)) + Number(parseFloat(actualResponse['price_total']).toFixed(3));--}}
    {{--//                    $('#price-total').html('<span class="real">' + variantPrice + '</span>');--}}
    {{--//                    $("#etalage").empty();--}}
    {{--//                    $.each(response['image_urls'].split(","), function (index, value) {--}}
    {{--//                        image[index] = value;--}}
    {{--////                        if (index == 0) {--}}
    {{--////                            $('#etalage').append('<img class="etalage_thumb_image" src="' + value + '" alt="zoomed" class="img-responsive">');--}}
    {{--////                            $('#etalage').append('<img class="etalage_source_image" src="' + value + '" alt="zoomed" class="img-responsive">');--}}
    {{--////                        }--}}
    {{--////                        $(".remove-list-style-modal").append('<a data-full="' + value + '" href="#" class="slide_thumb ' + ((index == 0) ? 'selected' : '') + '"><img src="' + value + '" class="img-responsive"></a>');--}}
    {{--//                        $("#etalage").append('<li><img class="etalage_thumb_image" src="..' + value + '" alt="" />');--}}
    {{--//                        $('#etalage').append('<img class="etalage_source_image" src="..' + value + '" alt="" /></li>');--}}
    {{--////                        $('a').click(function () {--}}
    {{--////                            var largeImage = $(this).attr('data-full');--}}
    {{--////                            $('.selected').removeClass();--}}
    {{--////                            $(this).addClass('selected');--}}
    {{--////                            $('.quick-view-img img').hide();--}}
    {{--////                            $('.quick-view-img img').attr('src', largeImage);--}}
    {{--////                            $('.quick-view-img img').fadeIn();--}}
    {{--////                        });--}}
    {{--//--}}
    {{--//                    });--}}
    {{--////                    $("#etalage").append('<li><img class="etalage_thumb_image" src="..' + value + '" alt="" />');--}}
    {{--////                    $('#etalage').append('<img class="etalage_source_image" src="..' + value + '" alt="" /></li>');--}}
    {{--////                     console.log((actualResponse['price_total']));--}}
    {{--////                    console.log(actualResponse['price_total']);--}}
    {{--//                }--}}
    {{--//            });--}}
    {{--//        });--}}

    {{--$(document.body).on('click', '.quicks', function () {--}}

    {{--$('#myModal').modal("hide");--}}

    {{--});--}}

    {{--var variantID = [];--}}
    {{--$(document).ready(function () {--}}

    {{--$(document.body).on('click', '.variant', function (e) {--}}
    {{--e.preventDefault();--}}
    {{--var obj = $(this);--}}
    {{--var inputField = obj.parents("div.item-selection-properties").find("input");--}}
    {{--inputField.removeAttr("checked");--}}
    {{--var variantIds = obj.find('input').attr('checked', 'checked').val();--}}
    {{--var combination = obj.parents("div.item-selection-properties").find("input").attr('data-combination');--}}
    {{--//                var variantName = obj.parents("div.item-selection-properties").find("input").attr('data-variant-name');--}}
    {{--obj.toggleClass('checked-variant');--}}
    {{--var allVariants = obj.parents(".colorandsizes").find(".variant");--}}
    {{--// console.log(allVariants);--}}
    {{--if (obj.hasClass("checked-variant")) {--}}
    {{--if (jQuery.inArray(variantIds, $.unique((combination.replace(/_+/g, ',')).split(','))) !== -1) {--}}
    {{--$.each(allVariants, function (i, v) {--}}
    {{--if (jQuery.inArray($(this).attr("data-variant"), $.unique((combination.replace(/_+/g, ',')).split(','))) == -1) {--}}
    {{--$(this).addClass('hide');--}}
    {{--}--}}
    {{--});--}}
    {{--}--}}
    {{--} else {--}}
    {{--allVariants.removeClass('hide');--}}
    {{--}--}}
    {{--});--}}


    {{--$(document.body).on('click', '.cartOptions', function () {--}}
    {{--var obj = $(this);--}}
    {{--var selected = [];--}}
    {{--$(obj.parents('div.items-selection-parent').find("input")).each(function () {--}}
    {{--if ($(this).attr("checked")) {--}}
    {{--selected.push($(this).val());--}}
    {{--}--}}
    {{--});--}}
    {{--if (selected.length > 1) {--}}
    {{--var finalSelect = selected;--}}
    {{--} else {--}}
    {{--var finalSelect = selected;--}}
    {{--toastr["error"]("Select Both Options");--}}
    {{--}--}}
    {{--//--}}
    {{--//                    console.log(obj.parents("div.item-selection-properties").find("input").attr('checked', 'checked').val());--}}
    {{--//                console.log(selected);--}}
    {{--//                console.log("cvnh");--}}
    {{--//                console.log(obj.parents("div.item-selection-properties").find('input'));--}}
    {{--//                console.log(obj.find('input').attr('checked', 'checked').val());--}}

    {{--//                }--}}
    {{--//                console.log(selected);--}}
    {{--});--}}
    {{--});--}}


    {{--</script>--}}
@endsection
