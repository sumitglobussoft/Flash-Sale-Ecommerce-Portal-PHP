@extends('Admin/Layouts/adminlayout')

@section('title', 'Manage Stores')

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <style>
        label.error {
            font-weight: normal;
            color: #FF0000 !important;
        }

        .store-status {
            position: absolute;
            right: 60px;
            top: 4px;
        }

        .inline-block {
            display: inline-block;
        }

        .m-top-md {
            margin-top: 20px;
        }

        .font-60 {
            font-size: 60px;
        }

        .flex {
            display: flex;
        }

        .full-width {
            width: 100%;
        }

        .p-left-sm {
            padding-left: 10px
        }

        .paddingLR-xs {
            padding-left: 5px;
            padding-right: 5px;
        }

        .m-right-xs {
            margin-right: 5px;
        }

        .m-right-sm {
            margin-right: 10px;
        }

        .square50 {
            width: 50px;
            height: 50px;
        }

        .bold {
            font-weight: 700;
        }

        .top2px {
            position: relative;
            top: 2px;
        }

        .progress {
            margin-bottom: 3px !important
        }
    </style>
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/plugins/bootstrap-editable/inputs-ext/address/address.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/custom/profile.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="/assets/css/custom/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link id="style_color" href="/assets/layout2/css/themes/grey.css" rel="stylesheet" type="text/css"/>
    <link id="style_color" href="/assets/layout2/css/layout.css" rel="stylesheet" type="text/css"/>


@endsection
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content" style="margin-left:5px !important">
            <?php if (isset($ErrorMsg)) { ?>
            <div class="portlet light bordered">
                <div style="padding: 200px 260px">
                    <lable style="font-size: 30px;color: red"><?php echo $ErrorMsg; ?></lable>
                </div>
            </div>
            <?php } else { ?>
            {{--<h3 class="page-title">Manage Stores</h3>--}}
            <div class="row">
                <div class="col-md-12">

                    <div class="portlet light bordered">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row" align="center">
                                    <a style="font-size: 40px" data-placement="right" id="store_name" data-type="text"
                                       data-pk="<?php if (isset($shopData)) echo $shopData['SupplierShopDetails']->shop_id; ?>"
                                       data-original-title="Enter Store name" data-placeholder="Required">
                                        <?php if (isset($shopData)) echo $shopData['SupplierShopDetails']->shop_name; ?>
                                    </a>
                                </div>
                                <?php if (isset($reviewData)) { ?>
                                <div class="row m-top-md">
                                    <div class="col-sm-4">
                                        <div align="center">
                                            <img src="../../../assets/images/star.png" style="width: 120px;">
                                            <span class="font-20"
                                                  style="position: absolute; left: 40%; top: 31%; font-size: 22px;"><?php if (isset($reviewData)) echo $reviewData['overAllRating']; ?></span>

                                            <div></div>
                                            <span><i class="fa fa-user"></i> <?php if (isset($reviewData)) echo $reviewData['total']; ?>
                                                Total</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div>
                                            <ul class="list-unstyled">
                                                <?php
                                                $ratingClass = array(
                                                        0 => 'success',
                                                        1 => 'primary',
                                                        2 => 'info',
                                                        3 => 'warning',
                                                        4 => 'danger',
                                                );
                                                foreach ($reviewData['rating'] as $key => $value) {
                                                ?>
                                                <li class="flex">
                                                    <span class="paddingLR-xs"><i class="fa fa-star"></i></span>
                                                    <span class="paddingLR-xs m-right-xs"> <?php echo(5 - $key); ?></span>

                                                    <div class="full-width">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-<?php echo $ratingClass[$key]; ?> p-left-sm"
                                                                 role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                 aria-valuemax="100"
                                                                 style="width: '<?php if ($reviewData['total'] != 0) echo round(($value / $reviewData['total']) * 100); ?>%'; text-align:left;padding-left:10px;">
                                                                <?php echo $value; ?>
                                                                <span class="sr-only"><?php echo $value; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                        <!--<div class="row" style="margin-top: 2%">
                                            <span><b>Total Followers:</b> <?php // echo number_format($this->followersCount);               ?> </span>
                                 </div>-->
                            </div>
                            <div class="col-md-4" align="center">
                                <form method="post" enctype="multipart/form-data" id="update-banner-form">
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 335px; height: 190px;">

                                                <img id="store-banner" height="190px" width="335px"
                                                     src="<?php if (isset($shopData)) echo $shopData['SupplierShopDetails']->shop_banner; ?>"
                                                     alt="<?php if (isset($shopData)) echo $shopData['SupplierShopDetails']->shop_name; ?>"/>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                 style="max-width: 335px; max-height: 190px;">
                                            </div>
                                            <div style="margin-top: -12%">
                                                <span class="btn-file"
                                                      style="position: absolute; right: 13%; top: 85%; display: none;">
                                                    <span class="fileinput-new">
                                                        <i class="fa fa-camera btn btn-circle default "></i></span>
                                                    <span class="fileinput-exists fa fa-camera btn btn-circle default "></span>
                                                    <input type="file" name="shop_banner" accept="image/*">
                                                </span>
                                                <span id="banner-action">
                                                    <a class="btn btn-circle btn-sm green fileinput-exists"
                                                       id="banner-submit">Save</a>
                                                    <a class="btn btn-circle btn-sm red fileinput-exists"
                                                       data-dismiss="fileinput">Remove</a>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                                <br><div>Shop Banner</div>
                            </div>


                            <div class="col-md-4" align="center">
                                <form method="post" enctype="multipart/form-data" id="update-logo-form">
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 335px; height: 190px;">

                                                <img id="store-logo" height="190px" width="335px"
                                                     src="<?php if (isset($shopData)) echo $shopData['SupplierShopDetails']->shop_logo; ?>"
                                                     alt="<?php if (isset($shopData)) echo $shopData['SupplierShopDetails']->shop_name; ?>"/>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                 style="max-width: 335px; max-height: 190px;">
                                            </div>
                                            <div style="margin-top: -12%">
                                                <span class="btn-file"
                                                      style="position: absolute; right: 13%; top: 85%; display: none;">
                                                    <span class="fileinput-new">
                                                        <i class="fa fa-camera btn btn-circle default "></i></span>
                                                    <span class="fileinput-exists fa fa-camera btn btn-circle default "></span>
                                                    <input type="file" name="shop_logo" accept="image/*">
                                                </span>
                                                <span id="logo-action">
                                                    <a class="btn btn-circle btn-sm green fileinput-exists"
                                                       id="logo-submit">Save</a>
                                                    <a class="btn btn-circle btn-sm red fileinput-exists"
                                                       data-dismiss="fileinput">Remove</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <br><div>Shop Logo</div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4" style="float: right">
                                <!--  <label class="control-label col-md-7"><strong style="float: right">COD Availability:</strong></label>
                                <?php // if (isset($merchantStoreDetails)) if( $merchantStoreDetails['cod_availability'] == 1) { ?>
                                        <button type="button" class="btn green col-md-2 btn-xs" id="cod_availability"><i class="fa fa-check"></i><span>Yes</span></button>
                                        <?php //} else { ?>
                                        <button type="button" class="btn red col-md-2 btn-xs" id="cod_availability"><i class="fa fa-times"></i><span>No</span></button>
                                        <?php// } ?> -->
                            </div>
                        </div>
                    </div>
                    {{--<a href="" type="button" class="btn btn-primary pull-right btn-circle btn-sm">Add new Shop</a><br><br>--}}

                    <div class="clearfix"></div>
                    <div class="portlet light bordered">
                        <div class="portlet light">

                            <div class="portlet-body">

                                <div class="row">
                                    <!--<div class="col-md-12">-->
                                    <div id="user">

                                        <?php
                                        if (isset($shopData['ShopMetaData'])) {
                                        //                                        print_r($this->storeMetaData);die("ADF");
                                        $count = 0;
                                        foreach ($shopData['ShopMetaData'] as $key => $value) {
                                        if ($value->shop_metadata_status != 3 && $value->shop_metadata_status != 4) {
                                        $count += 1;
                                        ?>
                                        <div class="col-md-6 store" id="store_<?php echo $value->shop_metadata_id; ?>">
                                            <div class="action" style="display: none;">
                                                <?php
                                                //                                                        if ($value['store_metadata_status'] != 0) {
                                                if ($value->shop_metadata_status == 1) {
                                                ?>
                                                <button class="tooltips btn btn-circle btn-sm btn-warning change-shop-status store-status make-inactive"
                                                        data-toggle="tooltip"
                                                        title="change Status to Inactive"
                                                        data-id='<?php echo $value->shop_metadata_id; ?>'>Active
                                                </button>
                                                <?php
                                                } else if ($value->shop_metadata_status == 2) {
                                                ?>
                                                <button class="tooltips btn btn-circle btn-sm btn-success change-shop-status store-status make-active"
                                                        data-toggle="tooltip"
                                                        title="change Status to Active"
                                                        data-id='<?php echo $value->shop_metadata_id; ?>'>Inactive
                                                </button>
                                                <?php
                                                } else if ($value->shop_metadata_status == 0) {
                                                ?>
                                                <span class="btn btn-circle btn-info btn-sm"
                                                      style="position: absolute; right: 59px; top: 4px; cursor: default">Pending </span>
                                                <?php
                                                }
                                                //                                                        }

                                                if ($value->shop_type != 0) {
                                                ?>
                                                <button data-id='<?php echo $value->shop_metadata_id; ?>'
                                                        data-toggle="tooltip"
                                                        title="Delete Shop"
                                                        class="tooltips btn-circle btn btn-danger btn-sm delete-Shop "
                                                        style="position: absolute; right: 20px; top: 4px;"><i
                                                            class="fa fa-trash-o"></i></button>
                                                <?php } ?>
                                            </div>
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                <tr>
                                                    <td style="width:15%">
                                                        Shop No.:
                                                    </td>
                                                    <td style="width:50%">
                                                        <b><?php echo $count; ?></b>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        Shop Type
                                                    </td>
                                                    <td>
                                                        <a class="store-type"
                                                           id="store_type_<?php echo $value->shop_metadata_id; ?>"
                                                           data-type="select"
                                                           data-pk="<?php echo $value->shop_metadata_id; ?>"
                                                           data-value="<?php echo $value->shop_type; ?>"
                                                           data-original-title="Select Store Type">
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Address Line 1
                                                    </td>
                                                    <td>
                                                        <a id="address_line_1_<?php echo $value->shop_metadata_id; ?>"
                                                           data-type="text"
                                                           data-pk="<?php echo $value->shop_metadata_id; ?>"
                                                           data-original-title="Please, fill Address Line 1"
                                                           data-placeholder="Required">
                                                            <?php echo $value->address_line_1; ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Address Line 2
                                                    </td>
                                                    <td>
                                                        <a id="address_line_2_<?php echo $value->shop_metadata_id; ?>"
                                                           data-type="text"
                                                           data-pk="<?php echo $value->shop_metadata_id; ?>"
                                                           data-original-title="Please, fill Address Line 2">
                                                            <?php echo $value->address_line_2; ?>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Country
                                                    </td>
                                                    <td>
                                                        <a class="country"
                                                           id="country_<?php echo $value->shop_metadata_id; ?>"
                                                           data-type="select"
                                                           data-pk="<?php echo $value->shop_metadata_id; ?>"
                                                           data-value="<?php echo $value->country; ?>"
                                                           data-original-title="Select Country">
                                                        </a>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        State
                                                    </td>
                                                    <td>
                                                        <a class="state"
                                                           id="state_<?php echo $value->shop_metadata_id; ?>"
                                                           data-type="select"
                                                           data-pk="<?php echo $value->shop_metadata_id; ?>"
                                                           data-value="<?php echo $value->state; ?>"
                                                           data-original-title="Select State">
                                                        </a>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        City
                                                    </td>
                                                    <td>
                                                        <a class="city"
                                                           id="city_<?php echo $value->shop_metadata_id; ?>"
                                                           data-type="select"
                                                           data-pk="<?php echo $value->shop_metadata_id; ?>"
                                                           data-value="<?php echo $value->city; ?>"
                                                           data-original-title="Select City">
                                                        </a>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Zip Code
                                                    </td>
                                                    <td>
                                                        <a id="zip_code_<?php echo $value->shop_metadata_id; ?>"
                                                           data-type="text"
                                                           data-pk="<?php echo $value->shop_metadata_id; ?>"
                                                           data-original-title="Please, fill Zip Code"
                                                           data-placeholder="Required">
                                                            <?php echo $value->zipcode; ?>
                                                        </a>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                            <div>

                                                <!--<input type="hidden" id="latitude_<?php //echo $value['store_metadata_id']; ?>" value="<?php //echo $value['latitude']; ?>">
                                                <input type="hidden" id="longitude_<?php //echo $value['store_metadata_id']; ?>" value="<?php// echo $value['longitude']; ?>">
                                                <button class="btn btn-sm" data-target="#us6-dialog" data-toggle="modal"  onclick="setMapDetails(<?php// echo $value['store_metadata_id']; ?>);">Show in map</button>-->
                                            </div>
                                            <br>
                                        </div>
                                        <?php
                                        }
                                        }
                                        }
                                        ?>

                                    </div>
                                    <!--                                </div>-->
                                </div>
                                <a href="/admin/available-shop" class="btn btn-circle default">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>


    <!--  <div id="us6-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="us6DialogLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" style="text-align: center">Store Location in Map</h4>
                  </div>
                  <div class="modal-body">
                      <div class="form-horizontal" >
                          <div id="us3" style="width: 100%; height: 300px;"></div>
                          <div class="clearfix">&nbsp;</div>
                          <div class="m-t-small">
                              <input class="hidden" id="locationForStoreId" value="">
                              <label class="p-r-small col-sm-1 control-label">Lat.:</label>

                              <div class="col-sm-3"><input type="text" class="form-control" style="width: 110px" id="us3-lat"/></div>
                              <label class="p-r-small col-sm-2 control-label">Long.:</label>

                              <div class="col-sm-3"><input type="text" class="form-control" style="width: 110px" id="us3-lon"/></div>
                          </div>
                          <div class="clearfix"></div></div>
                  </div>
                  <div class="modal-footer">
                      <input type="hidden" id="storeIdForLocation" value="" >
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="updateMap">Save changes</button>
                  </div>
              </div>
          </div>
      </div>-->
@endsection

@section('pagejavascripts')

    <script>
        $(".store").hover(function () {
            $(this).find('.action').show();
        }, function () {
            $(this).find('.action').hide();
        });

        var FormEditable = function () {
            var initEditables = function () {
                //global settings
                $.fn.editable.defaults.inputclass = 'form-control';
                $.fn.editable.defaults.url = '/admin/shop-ajax-handler';
                $("#store_name").editable({
                    validate: function (value) {
                        if ($.trim(value) == '')
                            return 'This field is required';
                    },
                    url: '/admin/shop-ajax-handler',
                    type: 'text',
                    pk: '<?php if(isset($shopData['SupplierShopDetails'])) echo $shopData['SupplierShopDetails']->shop_id; ?>',
                    name: 'updateSellerShop/shop_name',
                    title: 'Enter Shop name'
                });

                <?php
                if(isset($shopData['ShopMetaData']))
                if ($shopData['ShopMetaData']) {

                    foreach ($shopData['ShopMetaData'] as $key => $value) {
                        if ($value->shop_metadata_status != 3 && $value->shop_metadata_status != 4) {
                            ?>
                                        $('#store_type_<?php echo $value->shop_metadata_id; ?>').editable({
                            inputclass: 'form-control',
                            source: [{
                                value: 0,
                                text: 'Main'
                            }, {
                                value: 1,
                                text: 'Secondary'
                            }
                            ],
                            display: function (value, sourceData) {
                                var colors = {
                                            "": "gray",
                                            0: "green",
                                            1: "blue"
                                        },
                                        elem = $.grep(sourceData, function (o) {
                                            return o.value == value;
                                        });
                                if (elem.length) {
                                    $(this).text(elem[0].text).css("color", colors[value]);
                                } else {
                                    $(this).empty();
                                }
                            },
                            name: 'updateStoreDetails/shop_type/<?php echo $shopData['supplierId']; ?>/<?php echo $shopData['SupplierShopDetails']->shop_id; ?>',
                            success: function (response, newValue) {
                                if (response != 1) {
                                    bootbox.alert(response);
                                }
                                location.reload();
                            }
                        });

                $("#address_line_1_<?php echo $value->shop_metadata_id; ?>").editable({
                    url: '/admin/shop-ajax-handler',
                    type: 'text',
                    pk: '<?php echo $value->shop_metadata_id; ?>',
                    name: 'updateStoreDetails/address_line_1',
                    title: 'Enter Address Line 1'
                });

                $("#address_line_2_<?php echo $value->shop_metadata_id; ?>").editable({
                    url: '/admin/shop-ajax-handler',
                    type: 'text',
                    pk: '<?php echo $value->shop_metadata_id; ?>',
                    name: 'updateStoreDetails/address_line_2',
                    title: 'Enter Address Line 2'
                });


                $('#city_<?php echo $value->shop_metadata_id; ?>').editable({
                    inputclass: 'form-control',
                    source: [
                            <?php foreach ($shopData['city'] as $key1 => $value1){ ?>
                            {
                            value: '<?php echo $value1->location_id; ?>',
                            text: '<?php echo $value1->name; ?>'
                        },
                        <?php } ?>
                ],
                    name: 'updateStoreDetails/city',
                    success: function (response, newValue) {
                        location.reload();
                    }
                });

                $('#state_<?php echo $value->shop_metadata_id; ?>').editable({
                    inputclass: 'form-control',
                    source: [
                            <?php foreach ($shopData['state'] as $key2 => $value2){ ?>
                            {
                            value: '<?php echo $value2->location_id; ?>',
                            text: '<?php echo $value2->name; ?>'
                        },
                        <?php } ?>
                ],
                    name: 'updateStoreDetails/state',
                    success: function (response, newValue) {
                        location.reload();
                    }
                });

                $('#country_<?php echo $value->shop_metadata_id; ?>').editable({
                    inputclass: 'form-control',
                    source: [
                            <?php foreach ($shopData['country'] as $key3 => $value3){ ?>
                            {
                            value: '<?php echo $value3->location_id; ?>',
                            text: '<?php echo $value3->name; ?>'
                        },
                        <?php } ?>
                ],
                    name: 'updateStoreDetails/country',
                    success: function (response, newValue) {
                        location.reload();
                    }
                });
                $("#zip_code_<?php echo $value->shop_metadata_id; ?>").editable({
                    url: '/admin/shop-ajax-handler',
                    type: 'text',
                    pk: '<?php echo $value->shop_metadata_id; ?>',
                    name: 'updateStoreDetails/zipcode',
                    title: 'Enter Zip Code'
                });
                <?php
            }
        }
    }
    ?>


            }

            return {
                //main function to initiate the module
                init: function () {

                    // init editable elements
                    initEditables();
                    // init editable toggler
                    $('#enable').click(function () {
                        $('#user .editable').editable('toggleDisabled');
                    });

                    $('#user .editable').on('hidden', function (e, reason) {
                        if (reason === 'save' || reason === 'nochange') {
                            var $next = $(this).closest('tr').next().find('.editable');
                            if ($('#autoopen').is(':checked')) {
                                setTimeout(function () {
                                    $next.editable('show');
                                }, 300);
                            } else {
                                $next.focus();
                            }
                        }
                    });
                }

            };
        }();

    </script>
    <script>
        jQuery(document).ready(function () {

            $(".fileinput").hover(function () {
                $(this).find('.btn-file').show('slow');
            }, function () {
                $(this).find('.btn-file').hide('slow');
            });

            $("#update-banner-form").find("input").change(function (e) {
                $("#banner-action").show();
            });

            $('#banner-submit').click(function (e) {
                e.preventDefault();
                var formData = new FormData();
                formData.append('method', 'updateShopBanner');
                formData.append('shop_id', '<?php if(isset($shopData['SupplierShopDetails']->shop_id)) echo $shopData['SupplierShopDetails']->shop_id; ?>');
                formData.append('shop_banner', $('input[type=file]')[0].files[0]);
                Metronic.blockUI({
                    boxed: true,
                    message: 'Updating your Shop banner...'
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/shop-ajax-handler",
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        Metronic.unblockUI();
                        if (response == 1) {
                            $("#banner-action").hide();
                            window.location.reload();
                            //                        bootbox.alert("Successfully changed your store banner");
                        } else {
                            bootbox.alert("Something went wrong, please try again.");
                        }
                    },
                });
            });

            $('#logo-submit').click(function (e) {
                e.preventDefault();
                var formData = new FormData();
                formData.append('method', 'updateShopLogo');
                formData.append('shop_id', '<?php if(isset($shopData['SupplierShopDetails']->shop_id)) echo $shopData['SupplierShopDetails']->shop_id; ?>');
                formData.append('shop_logo', $('input[type=file]')[1].files[0]);
                Metronic.blockUI({
                    boxed: true,
                    message: 'Updating your Shop Logo...'
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/shop-ajax-handler",
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        Metronic.unblockUI();
                        if (response == 1) {
                            $("#logo-action").hide();
                            window.location.reload();
                            //                        bootbox.alert("Successfully changed your store banner");
                        } else {
                            bootbox.alert("Something went wrong, please try again.");
                        }
                    },
                });
            });

            $(document.body).on("click", ".change-shop-status", function () {
                var obj = $(this);
                var id = $(this).attr('data-id');
                if (obj.hasClass('make-active')) {
                    var value = 1;
                } else if (obj.hasClass('make-inactive')) {
                    var value = 2;
                }
                Metronic.blockUI({
                    boxed: true,
                    message: 'Changing the Shop status...'
                });
                $.ajax({
                    url: "/admin/shop-ajax-handler",
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'updateShopStatus',
                        shopMetaId: id,
                        value: value,
                        supplierId: '<?php if(isset($shopData['supplierId'])) echo $shopData['supplierId']; ?>'
                    }, success: function (response) {
                        Metronic.unblockUI();
                        if (response == 1) {
                            if (obj.hasClass('btn-warning')) {
                                obj.removeClass('btn-warning make-inactive');
                                obj.addClass('btn-success make-active');
                                obj.text('Inactive');
                                obj.attr('data-original-title', 'Change status to Active.');
                            } else {
                                obj.removeClass('btn-success make-active');
                                obj.addClass('btn-warning make-inactive');
                                obj.text('Active');
                                obj.attr('data-original-title', 'Change status to Inactive.');
                            }
                        } else {
                            bootbox.alert("The operation could not be performed. Something might have gone wrong. Please reload the page and try again.");
                        }
                    }
                });
            });

            $(document.body).on("click", ".delete-Shop", function () {
                var obj = $(this);
                var id = $(this).attr('data-id');
                bootbox.confirm("Are you sure you want to delete this Shop?", function (result) {
                    if (result) {
                        Metronic.blockUI({
                            boxed: true,
                            message: 'Deleting Shop details from database...'
                        });
                        $.ajax({
                            url: "/admin/shop-ajax-handler",
                            type: 'POST',
                            datatype: 'json',
                            data: {
                                method: 'updateShopStatus',
                                shopMetaId: id,
                                value: 4,//ToDo now only changing status, later can delete sub-shop
                                supplierId: '<?php if(isset($shopData['supplierId'])) echo $shopData['supplierId']; ?>'
                            },
                            success: function (response) {
                                Metronic.unblockUI();
                                if (response == 1) {
                                    $('#store_' + id).remove();
                                    $("div.store").each(function (i) {
                                        $(this).find("tbody tr:nth-child(1) td:nth-child(2) b").html(i + 1);
                                    });
                                } else {
                                    bootbox.alert("The operation could not be performed. Something might have gone wrong. Please reload the page and try again.");
                                }
                            }
                        });
                    }

                });
            });

            FormEditable.init();
        });


    </script>
    <script src="/assets/plugins/3d-bold-navigation/js/main.js"></script>
    <script src="/assets/plugins/waypoints/jquery.waypoints.min.js"></script>
    <script src="/assets/plugins/jquery-counterup/jquery.counterup.min.js"></script>
    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script src="/assets/plugins/flot/jquery.flot.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.time.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.symbol.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.resize.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="/assets/plugins/curvedlines/curvedLines.js"></script>
    <script src="/assets/plugins/metrojs/MetroJs.min.js"></script>


    {{--<script src="/assets/plugins/jquery-validation/jquery.validate.min.js"></script>--}}
    {{--<script src="/assets/js/pages/dashboard.js"></script>--}}

    <script src="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js"
            type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-editable/inputs-ext/address/address.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js" type="text/javascript"></script>
    <script src="/assets/plugins/metronic.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootbox.min.js" type="text/javascript"></script>



@endsection
