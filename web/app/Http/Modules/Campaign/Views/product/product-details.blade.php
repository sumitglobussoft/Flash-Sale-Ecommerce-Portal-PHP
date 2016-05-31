@extends('Home/Layouts/home_layout')
@section('pageheadcontent')
    {{--OPTIONAL--}}
    <link href="/assets/global/css/etalage.css" media="screen" rel="stylesheet" type="text/css">
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
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

    <div class="container">
        <!--body container -->

        <div class="row">
            <!--body container row-2 -->
            <div class="modal-content boder-rad-0">
                <div class="modal-body">
                    <div class="container-fluid modal-quickview">
                        <!--body container -->
                        <div class="row padding">
                            <div class="col-md-12">
                                <div class="col-md-6 clearfix">
                                    <ul id="etalage"> <!--  style="width: 100%"-->
                                        <?php
                                        if (isset($productdetails)) {
                                        foreach (explode(",", $productdetails['image_urls']) as $value) {
                                        ?>
                                        <li>
                                            <img class="etalage_thumb_image" src="<?php echo $value; ?>"/>
                                            <img class="etalage_source_image" src="<?php echo $value; ?>"/>

                                        </li>
                                        <?php
                                        }
                                        }
                                        ?>

                                    </ul>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{$productdetails['product_name']}}
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
                                                    <h3 id="price-total" data-price="{{$productdetails['price_total']}}"><span
                                                                class="discounted-price">{{$productdetails['price_total']}}</span>
                                                    </h3>
                                                    <h3 class="offer-discount">15% OFF</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pull-right">
                                                <div class="row">
                                                    <p class="mar-top-10 text-color-lg">Product code: <span
                                                                class="product-code text-color-dg"> 275</span></p>
                                                    <p class="text-color-lg">Availablity: <span
                                                                class="availablity text-color-dg"><?php echo ($productdetails['in_stock'] != 0) ? 'InStock' : 'Outofstock';?></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--row-2-->

                                    <div class="col-md-12 bdr-btm-col">
                                        <div class="row">
                                            <p><b> QUICK OVERVIEW:</b></p>
                                            <p class="tp-pro">
                                               {{$productdetails['short_description']}}
                                            </p>
                                        </div>
                                    </div><!--row-3-->


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

                                    <?php $combination = [];
                                    if ($productdetails['variant_ids_combination'] != '' && $productdetails['variant_ids_combination'] != null) {
                                        $array1 = array_unique(explode(",", str_replace('_', ',', $productdetails['variant_ids_combination'])));
                                        $combinedVariantIds = array_unique(explode(",", str_replace('_', ',', $productdetails['variant_ids_combination'])));
                                    }?>
                                    @foreach($productdetails['options'] as $optionKey => $optionVal)
                                        <div class="col-md-12 bdr-btm-col paddr-10 option-variant-container"
                                             style="margin-bottom: 3%">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="clearfix" id="option_id_{{$optionVal['option_id']}}">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Select {{$optionVal['option_name']}} </label>
                                                            <div class="col-sm-4">
                                                                <select class="pull-right basic form-control option">
                                                                    <option value="">Select...</option>
                                                                    @foreach($optionVal['variantData']['variant_id']  as $variantKey => $variantVal)
                                                                        <option prod-id="{{$productdetails['product_id']}}"
                                                                                data-id="{{$optionVal['variantData']['variant_id'][$variantKey]}}"
                                                                                pricemodifier="{{$optionVal['variantData']['price_modifier'][$variantKey]}}"
                                                                                value="{{$optionVal['variantData']['variant_id'][$variantKey]}}"
                                                                                class="option-variant">{{$optionVal['variantData']['variant_name'][$variantKey]}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <?php if(isset($productdetails['quantity_discount']) && $productdetails['quantity_discount'] != '') {?>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">Our quantity
                                            discounts:
                                        </div>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                @foreach(json_decode($productdetails['quantity_discount']) as $qKey => $qVal)
                                                    <?php  if ($qVal->quantity != null && $qVal->value != null &&
                                                    $qVal->type != null) { ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?php echo $qVal->quantity; ?></td>
                                                <td>
                                                    <span><?php echo $qVal->value; ?></span><?php echo ($qVal->type) ? '%' : '$' ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php } ?>
                                    <!--row-5-->

                                    <div class="col-md-12 bdr-btm-col paddr-10">
                                        <div class="col-md-5">
                                            <p class="sub-head">Quantity</p>
                                            <div class="form-group width-100">
                                                <label for=""
                                                       class="control-label decrease-quan"><i
                                                            class="fa fa-minus"></i>
                                                </label>
                                                <input type="text" class="form-control"
                                                       name="input-item-count"
                                                       id="input-item-count"
                                                       style="padding:0; text-align:center; width:50px;margin-left: 6px;">
                                                <label for=""
                                                       class="control-label increase-quan"><i
                                                            class="fa fa-plus"></i>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="row">
                                                <a role="button" href="#"
                                                   class="btn btn-primary btn-lg brdr_non pading_lr top15_margin">Add
                                                    to
                                                    cart</a>
                                                <a role="button" href="#"
                                                   class="btn btn-primary btn-lg brdr_non pading_lr top15_margin">Buy</a>
                                            </div>
                                        </div>
                                    </div><!--row-6-->

                                </div>
                            </div>

                            <div class="col-md-12 top_margin">
                                <ul class="nav nav-tabs br_n" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#home" aria-controls="home" role="tab"
                                           data-toggle="tab"
                                           class="brdr_non tt">Description</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#profile" aria-controls="profile"
                                           role="tab" data-toggle="tab"
                                           class="brdr_non tt">Details</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#messages" aria-controls="messages"
                                           role="tab" data-toggle="tab"
                                           class="brdr_non tt">Reviews</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">
                                      {{$productdetails['full_description']}}
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile">
                                        <strong>Material Details</strong>:<br>Gold<br>Diamond<br><br><strong>Tags
                                            Available</strong> = Fashion.<br><br>
                                        <div>
                                            <strong>Gross Weight: </strong><span
                                                    id="product_total_weight">11.35 g</span>
                                        </div>
                                        <br>
                                        <div>
                                            <strong>Gold Weight: </strong><span
                                                    id="product_gold_weight">-- </span>
                                        </div>
                                        <br>
                                        <div>
                                            <strong>Silver Weight: </strong><span
                                                    id="product_silver_weight">--</span>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="messages">
                                        <div id="appenderror"><h3
                                                    style="float:left;position:relative;left:35%;color:red">
                                                No Review
                                                for this Product</h3><br><br></div>
                                        <div id="writenewreview" class="clearfix">
                                            <h3>WRITE A REVIEW</h3>
                                            <p>Now please write a (short) review....(min.
                                                200, max. 2000 characters)</p>
                                                                        <textarea name="review_textarea"
                                                                                  id="review_textarea"></textarea><span
                                                    class="success_error1"></span><br>
                                            <span class="success_error"></span>
                                            <div class="stars pull-left">
                                                <label class="pull-left rating-box-label top15_margin">Your
                                                    Rate:</label>
                                                <input type="radio" value="5"
                                                       class="star star-5" id="star-5"
                                                       name="star">
                                                <label class="star star-5"
                                                       for="star-5"></label>
                                                <input type="radio" value="4"
                                                       class="star star-4" id="star-4"
                                                       name="star">
                                                <label class="star star-4"
                                                       for="star-4"></label>
                                                <input type="radio" value="3"
                                                       class="star star-3" id="star-3"
                                                       name="star">
                                                <label class="star star-3"
                                                       for="star-3"></label>
                                                <input type="radio" value="2"
                                                       class="star star-2" id="star-2"
                                                       name="star">
                                                <label class="star star-2"
                                                       for="star-2"></label>
                                                <input type="radio" value="1"
                                                       class="star star-1" id="star-1"
                                                       name="star">
                                                <label class="star star-1"
                                                       for="star-1"></label>
                                            </div>

                                            <input type="submit" value="Submit a review"
                                                   data-id="252" id="submitbutton"
                                                   class="btn btn-primary btn-lg brdr_non pading_lr pull-right">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--/body container -->
                    </div>
                </div>
            </div>
        </div>
        <!--/body container row-2 -->
    </div>

@endsection
@section('pagejavascripts')
    <script type="text/javascript"
            src="/assets/scripts/jquery.mThumbnailScroller.js"></script>
    <script src="/assets/scripts/jquery-ui.js" type="text/javascript"></script>
    <script type="text/javascript" src="/assets/scripts/fancybox.js"></script>
    <script type="text/javascript" src="/assets/scripts/script.js"></script>
    <script type="text/javascript"
            src="/assets/global/plugins/jquery.etalage.min.js"></script>

    <script type="text/javascript">

        //        $('#filterproducts').affix({
        //            offset: {
        //                top: $('#filterproducts').offset().top
        //            }
        //        });

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
//                $(".product-thumbs-list").mThumbnailScroller({
//                    axis: "y",
//                    type: "click-thumb",
//                    theme: "buttons-out" //change to "y" for vertical scroller
//                });
            });
        })(jQuery);

        var actualResponse = [];
        var combinedVariantIds = [];
        $(window).on("load",function () {

             actualResponse['price_total'] = "<?php echo $productdetails['price_total']; ?>"
             actualResponse['product_name'] = "<?php echo $productdetails['product_name']; ?>"
             actualResponse['variant_ids_combination'] = "<?php echo $productdetails['variant_ids_combination']; ?>"
             actualResponse['image_url'] = "<?php echo $productdetails['image_url']; ?>"
             actualResponse['image_urls'] = "<?php echo $productdetails['image_urls']; ?>"
             actualResponse['variant_ids_combination'] = "<?php echo $productdetails['variant_ids_combination']; ?>"
             console.log(actualResponse['variant_ids_combination']);
//            if (actualResponse['variant_ids_combintaion'] != null && actualResponse['variant_ids_combination'] != '') {
                combinedVariantIds = ("<?php echo implode(',',array_unique(explode(',',str_replace('_', ',', $productdetails['variant_ids_combination']))));?>").split(',')
//            }

        });


        //        $('.quick-view.p-a').on('click', function () {
        //            $('#myModal').modal("show");
        //        }
        //  FOR QUICK VIEW OF PRODUCT IN MODAL      //
//        var actualResponse = [];
//        var discountPrice = [];
//        var discounts = [];
//        var combinedVariantIds = [];
//        $(document.body).on('click', '#quicks', function () {
//            var prodId = $(this).attr('data-id');
//            var productName = $(this).attr('product-name');
//            $.ajax({
//                url: '/flashsale-ajax-handler',
//                type: 'POST',
//                datatype: 'json',
//                data: {
//                    method: 'getProductDetailsForPopUp',
//                    prodId: prodId
//                },
//                success: function (response) {
//                    var response = $.parseJSON(response);
//                    var optionResponse = [];
//                    $.each(response, function (actindex, actval) {
//                        actualResponse[actindex] = actval;
//                    });
//                    $('#prods').html('<span class="prodcut_name">' + actualResponse['product_name'] + '</span>');
//                    $('#price-total').html('<span class="real-price">' + actualResponse['price_total'] + '</span>');
//                    if (actualResponse['in_stock'] != '') {
//                        availableResponse = 'InStock';
//                    }
//                    else {
//                        availableResponse = 'Outofstock';
//                    }
//                    $('.available').html('<span class="availablity text-color-dg">Available: ' + availableResponse + '</span>');
//                    $("#discount-value").empty();
//                    var toAppendProductVariant = '';
//                    if ($.parseJSON(response['quantity_discount'] != '')) {
//                        toAppendProductVariant += '<div class="portlet-body">';
//                        toAppendProductVariant += '<div class="table-scrollable">Our quantity discounts:</div>';
//                        toAppendProductVariant += '<table class="table table-bordered table-hover">';
//                        toAppendProductVariant += '<thead>';
//                        toAppendProductVariant += '<tr>';
//                        toAppendProductVariant += '<th>Quantity</th>';
//                        toAppendProductVariant += '<th>Price</th>';
//                        $.each($.parseJSON(response['quantity_discount']), function (discountIndex, discountValue) {
//                            if (discountValue['quantity'] != null && discountValue['value'] != null && discountValue['type'] != null) {
////                            toAppendProductVariant += '<th>' + discountValue['quantity'] + '</th>';
//                                toAppendProductVariant += '</tr>';
//                                toAppendProductVariant += '</thead>';
//                                toAppendProductVariant += '<tbody>';
//                                toAppendProductVariant += '<tr>';
//                                toAppendProductVariant += '<td>' + discountValue['quantity'] + '</td>';
//                                toAppendProductVariant += '<td><span>' + discountValue['value'] + '</span>' + ((discountValue['type']) ? '%' : '$') + '</td>';
//                                toAppendProductVariant += '</tr>';
//
//                            }
//                            else {
//                                toAppendProductVariant += '<span></span>';
//                            }
//                        });
//                        toAppendProductVariant += '</tbody>';
//                        toAppendProductVariant += '</table>';
//                        toAppendProductVariant += '</div>';
//                        toAppendProductVariant += '</div>';
//                        toAppendProductVariant += '</div>';
//                    }
//                    $("#discount-value").append(toAppendProductVariant);
//                    var image = [];
//                    var otherimg = [];
//                    $("#etalage").empty();
//                    $('.quick-view-img').empty();
//                    $.each(response['image_urls'].split(","), function (index, value) {
//                        image[index] = value;
//                        $("#etalage").append('<li><img class="etalage_thumb_image" src="..' + value + '" alt="" />');
//                        $('#etalage').append('<img class="etalage_source_image" src="..' + value + '" alt="" /></li>');
//
//                    });
//                    var combination = [];
//                    if (response['variant_ids_combination'] != '' && response['variant_ids_combination'] != null) {
//                        var array1 = $.unique((response['variant_ids_combination'].replace(/_+/g, ',')).split(','));
//                        combinedVariantIds = $.unique((response['variant_ids_combination'].replace(/_+/g, ',')).split(','));
//                    }
//                    $("#option-details").empty();
//                    var toAppendOptionDetails = '';
//                    $.each(response['options'], function (optionIndex, optionValue) {
//                        toAppendOptionDetails += '<div class="col-md-12 bdr-btm-col paddr-10 option-variant-container" style="margin-bottom: 3%">';
//                        toAppendOptionDetails += '<div class="row">';
//                        toAppendOptionDetails += '<div class="col-md-12">';
//                        toAppendOptionDetails += '<div class="clearfix" id="option_id_"' + optionValue['option_id'] + '>';
//                        toAppendOptionDetails += '<div class="form-group">';
//                        toAppendOptionDetails += '<label class="col-sm-3 control-label">Select ' + optionValue['option_name'] + '</label>';
//                        toAppendOptionDetails += '<div class="col-sm-4">';
////                         TODO check for type
//
//
//                        toAppendOptionDetails += '<select class="pull-right basic form-control option">';
//                        toAppendOptionDetails += '<option  value="">Select...</option>';
//                        $.each(optionValue['variantData']['variant_id'], function (i, v) {
//                            toAppendOptionDetails += '<option prod-id="' + response['product_id'] + '" data-id="' + optionValue['variantData']['variant_id'][i] + '" pricemodifier="' + optionValue['variantData']['price_modifier'][i] + '" value="' + optionValue['variantData']['variant_id'][i] + '" class="option-variant">' + optionValue['variantData']['variant_name'][i] + '</option>';
//                        });
//                        toAppendOptionDetails += '</select>';
////                       TODO end- check for type
//                        toAppendOptionDetails += '</div>';
//                        toAppendOptionDetails += '</div>';
//                        toAppendOptionDetails += '</div>';
//                        toAppendOptionDetails += '</div>';
//                        toAppendOptionDetails += '</div>';
//                        toAppendOptionDetails += '</div>';
//                    });
//
//                    $("#option-details").append(toAppendOptionDetails);
//                    $('#etalage').etalage({
//                        thumb_image_width: 400,
//                        thumb_image_height: 400,
//                        source_image_width: 900,
//                        source_image_height: 1200,
//                        show_hint: true,
//                        click_callback: function (image_anchor, instance_id) {
//                            alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
//                        }
//                    });
//                    $('#myModal').modal("show");
//                }
//            });
//
//        });

        $(document.body).on('change', '.option', function () {

            var obj = $(this);
            var variantId = obj.val();
            var prodId = $('.option-variant').attr('prod-id');
            if (actualResponse['variant_ids_combintaion'] != null && actualResponse['variant_ids_combination'] != '') {
                if (obj.val() == '') {
                    $('.option-variant').each(function () {
//                    if ($(".option option:selected")) {
                        //   console.log(this);
//                        this.disabled = false;
//                    this.disabled = "";
                        $(this).removeAttr("disabled");
                      //  console.log(this);
                        //  console.log($('.option-variant').attr('disabled',false));
//                 }
                    });
                }
            }

            var selectedCombination = [];
            $.each($(".option option:selected"), function (i, v) {
                selectedCombination.push($(this).val());
            });
            $('.option').not(this).find('.option-variant:not(:first-child)').prop('disabled', true);

            $.each(combinedVariantIds, function (i, v) {
                console.log(v);
                $('.option-variant[data-id="' + v + '"]').prop('disabled', false);
                // console.log($('.option-variant[data-id="' + v + '"]').prop('disabled', false));
            });

            // }
            var priceModifier = $(this).attr('pricemodifier');
            var image = [];
            $.ajax({
                url: '/flashsale-ajax-handler',
                type: 'POST',
                datatype: 'json',
                data: {
                    method: 'getOptionVariantDetails',
                    priceModifier: priceModifier,
                    variantId: variantId,
                    prodId: prodId,
                    selectedCombination: selectedCombination
                },
                success: function (response) {
                    response = $.parseJSON(response);
                    if (response['variant_ids_combination'] != '' && response['variant_ids_combination'] != null) {
                        console.log(response['variant_ids_combination']);
                        var variantPrice = Number(parseFloat(response['price_modifier']).toFixed(3)) + Number(parseFloat(actualResponse['price_total']).toFixed(3));
                        if (variantPrice) {
                            $('#price-total').html('<span class="real">' + variantPrice + '</span>');
                        } else {
                            $('#price-total').html('<span class="real">' + actualResponse['price_total'] + '</span>');
                        }
                        $("#etalage").empty();
                        if (response['image_urls'] != '' && response['image_urls'] != null) {
                            $("#etalage").append('<li><img class="etalage_thumb_image" src="' + response['image_urls'] + '" alt="" / >');
                            $('#etalage').append('<img class="etalage_source_image" src="' + response['image_urls'] + '" alt="" /></li>');
                        } else {
                            $("#etalage").append('<li><img class="etalage_thumb_image" src="' + actualResponse['image_url'] + '" alt="" / >');
                            $('#etalage').append('<img class="etalage_source_image" src="' + actualResponse['image_url'] + '" alt="" /></li>');
                        }
                        $('#etalage').etalage({
                            thumb_image_width: 400,
                            thumb_image_height: 400,
                            source_image_width: 900,
                            source_image_height: 1200,
                            show_hint: true,
                            click_callback: function (image_anchor, instance_id) {
                                alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
                            }
                        });
                    } else {
                        var variantPrice = Number(parseFloat(response['price_modifier']).toFixed(3)) + Number(parseFloat(actualResponse['price_total']).toFixed(3));
                        if (variantPrice) {
                            $('#price-total').html('<span class="real">' + variantPrice + '</span>');
                        } else {
                            $('#price-total').html('<span class="real">' + actualResponse['price_total'] + '</span>');
                        }
                        $("#etalage").empty();
                        $('.quick-view-img').empty();
                        $.each(actualResponse['image_urls'].split(","), function (index, value) {
                            image[index] = value;
                            $("#etalage").append('<li><img class="etalage_thumb_image" src="' + value + '" alt="" />');
                            $('#etalage').append('<img class="etalage_source_image" src="' + value + '" alt="" /></li>');
                        });
                        $('#etalage').etalage({
                            thumb_image_width: 400,
                            thumb_image_height: 400,
                            source_image_width: 900,
                            source_image_height: 1200,
                            show_hint: true,
                            click_callback: function (image_anchor, instance_id) {
                                alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
                            }
                        });
                    }
                }
            });

        });


        //        $(document.body).on('click', '.option-variant', function () {
        //            var priceModifier = $(this).attr('pricemodifier');
        //            var variantId = $(this).attr('value');
        //            var image = [];
        //            $.ajax({
        //                url: '/flashsale-ajax-handler',
        //                type: 'POST',
        //                datatype: 'json',
        //                data: {
        //                    method: 'getOptionVariantDetails',
        //                    priceModifier: priceModifier,
        //                    variantId: variantId
        //                },
        //                success: function (response) {
        //                    response = $.parseJSON(response);
        //                    // console.log(response);
        //                    var variantPrice = Number(parseFloat(response['price_modifier']).toFixed(3)) + Number(parseFloat(actualResponse['price_total']).toFixed(3));
        //                    $('#price-total').html('<span class="real">' + variantPrice + '</span>');
        //                    $("#etalage").empty();
        //                    $.each(response['image_urls'].split(","), function (index, value) {
        //                        image[index] = value;
        ////                        if (index == 0) {
        ////                            $('#etalage').append('<img class="etalage_thumb_image" src="' + value + '" alt="zoomed" class="img-responsive">');
        ////                            $('#etalage').append('<img class="etalage_source_image" src="' + value + '" alt="zoomed" class="img-responsive">');
        ////                        }
        ////                        $(".remove-list-style-modal").append('<a data-full="' + value + '" href="#" class="slide_thumb ' + ((index == 0) ? 'selected' : '') + '"><img src="' + value + '" class="img-responsive"></a>');
        //                        $("#etalage").append('<li><img class="etalage_thumb_image" src="..' + value + '" alt="" />');
        //                        $('#etalage').append('<img class="etalage_source_image" src="..' + value + '" alt="" /></li>');
        ////                        $('a').click(function () {
        ////                            var largeImage = $(this).attr('data-full');
        ////                            $('.selected').removeClass();
        ////                            $(this).addClass('selected');
        ////                            $('.quick-view-img img').hide();
        ////                            $('.quick-view-img img').attr('src', largeImage);
        ////                            $('.quick-view-img img').fadeIn();
        ////                        });
        //
        //                    });
        ////                    $("#etalage").append('<li><img class="etalage_thumb_image" src="..' + value + '" alt="" />');
        ////                    $('#etalage').append('<img class="etalage_source_image" src="..' + value + '" alt="" /></li>');
        ////                     console.log((actualResponse['price_total']));
        ////                    console.log(actualResponse['price_total']);
        //                }
        //            });
        //        });

        $(document.body).on('click', '.quicks', function () {

            $('#myModal').modal("hide");

        });
        jQuery(document).ready(function ($) {
            $('#etalage').etalage({
                thumb_image_width: 400,
                thumb_image_height: 400,
                source_image_width: 900,
                source_image_height: 1200,
                show_hint: true,
                click_callback: function (image_anchor, instance_id) {
                    alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
                }
            });
        });




    </script>

@endsection