@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Add Shop')

@section('pageheadcontent')
{{--OPTIONAL--}}
{{--PAGE STYLES OR SCRIPTS LINKS--}}

        <!-- BEGIN PAGE LEVEL STYLES -->
<link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="/assets/css/custom/profile.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="/assets/css/custom/components.css" id="style_components" rel="stylesheet" type="text/css"/>


@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Add New Shop</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php if(isset($multiple_store_err)){ ?>
                                <h1 class="col-md-offset-2" style="color:red;"><?php echo $multiple_store_err; ?></h1>
                                <?php }else { ?>
                                <form method="post" enctype="multipart/form-data" id="add_new_shop">
                                    <div class="col-md-6">
                                        <?php if(isset($flag)) { if($flag['sub_store_flag'] == 1){
                                        if(isset($data['Shop']) && !empty($data['Shop'])){  ?>
                                            <label class="control-label" style="color: green">Select Parent shop for secondary shop</label>
                                        <select name="parent_shop" class="form-control m-b-sm" id="parent_shop">
                                            <option value="">Select Parent Shop</option>
                                            <?php foreach($data['Shop'] as $value){ if($value->shop_status == 1 && $value->shop_flag == 1){ ?>
                                            <option value="<?php echo $value->shop_id; ?>"><?php echo $value->shop_name; ?></option>
                                            <?php } } ?>
                                        </select>
                                        <?php } }   } ?>

                                        <?php if(isset($flag)) { if($flag['parent_category_flag'] == 1){ ?>
                                        <select name="parent_category" class="form-control m-b-sm" id="parent_category">
                                            <option value="">Select Shop Category</option>
                                            <?php
                                            function treeView($array, $id = 0)
                                            {
                                                for ($i = 0; $i < count($array); $i++) {
                                                    if ($array[$i]->parent_category_id == $id) {
                                                        echo '<option value="' . $array[$i]->category_id . '">' . $array[$i]->category_name . '</option>';
                                                        treeView($array, $array[$i]->category_id);
                                                    }
                                                }
                                            }
                                            ?>
                                            @if(isset($data))
                                                <?php treeView($data['allCategories']);  ?>
                                            @endif
                                        </select>
                                        <?php } } ?>
                                        <select name="shop_flag" class="form-control m-b-sm" id="shop_flag">
                                            <option value="1">Actual Shop</option>
                                            <option value="2">Virtual Shop</option>
                                        </select>
                                            <div class="form-group" id="shop_div">
                                                <label class="control-label">Shop Name</label>
                                                <input type="text" placeholder="Shop Name" class="form-control"
                                                       name="shop_name" id="shop_name"/>
                                                <span class="error">{!! $errors->first('shop_name') !!}</span>
                                            </div>
                                            <div class="clearfix"></div>
                                        <div id="shop_address">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="show_shop" value="1"> Select this box
                                                    to show Shop Address details to user side
                                                </label>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="form-group">
                                                <label class="control-label">Address Line 1</label>
                                                <input type="text" placeholder="Address Line 1" class="form-control"
                                                       name="address_line_1" id="address_line_1"/>
                                                <span class="error">{!! $errors->first('address_line_1') !!}</span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <label class="control-label">Address Line 2</label>
                                                <input type="text" placeholder="Address Line 2" class="form-control"
                                                       name="address_line_2" id="address_line_2"/>
                                                <span class="error">{!! $errors->first('address_line_2') !!}</span>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="form-group">
                                                <label class="control-label">Country</label>
                                                <select name="country" class="form-control m-b-sm" id="country">
                                                    <option value="">Select Country</option>
                                                    <?php if(isset($data['Country'])){ foreach($data['Country'] as $value){ ?>
                                                    <option value="<?php echo $value->location_id; ?>"><?php echo $value->name; ?></option>
                                                    <?php } } ?>
                                                </select>
                                                <span class="error">{!! $errors->first('country') !!}</span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group hidden" id="state">
                                                <label class="control-label">State</label>
                                                <select name="state" class="form-control m-b-sm " id="statelist">
                                                </select>
                                                <span class="error">{!! $errors->first('state') !!}</span>
                                            </div>

                                            <div class="clearfix"></div>
                                            <div class="form-group hidden" id="city">
                                                <label class="control-label">City</label>
                                                <select name="city" class="form-control m-b-sm " id="citylist">
                                                </select>
                                                <span class="error">{!! $errors->first('city') !!}</span>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="form-group">
                                                <label class="control-label">Zip Code</label>
                                                <input maxlength="6" type="text" placeholder="Zip Code"
                                                       class="form-control" name="zipcode" id="zipcode"/>
                                                <span class="error">{!! $errors->first('zipcode') !!}</span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="shop_img_div">
                                        <div class="text-center">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    <img src="/assets/images/no-image.png" alt=""/>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                     style="max-width: 200px; max-height: 150px;">
                                                </div>
                                                <div>
                                                            <span class="btn btn-circle default btn-file">
                                                                <span class="fileinput-new">
                                                                    Select Shop Banner </span>
                                                                <span class="fileinput-exists">
                                                                    Change </span>
                                                                <input type="file" name="shop_banner" accept="image/*">
                                                            </span>
                                                    <a href="#" class="btn btn-circle default fileinput-exists"
                                                       data-dismiss="fileinput">
                                                        Remove </a>
                                                </div>
                                            </div>
                                            <br>
                                            <label id="shop_banner-error" class="error col-md-offset-4"
                                                   for="shop_banner"></label><br>
                                            <span class="error">{!! $errors->first('shop_banner') !!}</span>

                                            <div class="clearfix margin-top-10">
                                                <span class="label label-danger">NOTE! </span>
                                                <span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                            </div>
                                        </div>
                                        <br><br>

                                        <div class="text-center">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    <img src="/assets/images/no-image.png" alt=""/>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                     style="max-width: 200px; max-height: 150px;">
                                                </div>
                                                <div>
                                                            <span class="btn btn-circle default btn-file">
                                                                <span class="fileinput-new">
                                                                    Select shop Logo </span>
                                                                <span class="fileinput-exists">
                                                                    Change </span>
                                                                <input type="file" name="shop_logo" accept="image/*">
                                                            </span>
                                                    <a href="#" class="btn btn-circle default fileinput-exists"
                                                       data-dismiss="fileinput">
                                                        Remove </a>
                                                </div>
                                            </div>
                                            <br>
                                            <label id="shop_logo-error" class="error col-md-offset-4"
                                                   for="shop_logo"></label><br>
                                            <span class="error">{!! $errors->first('shop_logo') !!}</span>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12" align="center">
                                            <div class="margiv-top-10">
                                                <button class="btn btn-circle green-haze " type="submit"
                                                        id="save-info-changes">Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="color:green;">@if(session('shop_success_msg')) {{ session('shop_success_msg') }} @endif</div>
                                </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>

@endsection

@section('pagejavascripts')

    <script>
        $(document).ready(function () {

            $('#parent_shop').change(function (e) {
                var shop_id = $('#parent_shop').val();
                if (shop_id != '') {
                    $('#shop_div').addClass('hidden');
                    $('#parent_category').addClass('hidden');
                    $('#shop_img_div').addClass('hidden');
                    $('#shop_flag').addClass('hidden');
                } else {
                    $('#shop_div').removeClass('hidden');
                    $('#parent_category').removeClass('hidden');
                    $('#shop_img_div').removeClass('hidden');
                    $('#shop_flag').removeClass('hidden');
                }
            });

            $('#shop_flag').change(function(e){
                var shop_flag = $('#shop_flag').val();
                if (shop_flag == '1') {
                    $('#shop_address').removeClass('hidden');
                } else {
                    $('#shop_address').addClass('hidden');
                }
            });
            $('#country').change(function (e) {
                var country_id = $('#country').val();
                $.ajax({
                    type: "POST",
                    url: "/supplier/ajaxHandler",
                    dataType: "json",
                    data: {
                        method: 'getState',
                        countryId: country_id
                    },
                    success: function (response) {
                        if (response) {
                            $('#state').removeClass('hidden');
                            var state = response;
                            var toappend = '<option value="">Select State</option>';
                            if (response != '') {
                                $.each(state, function (key, value) {
                                    toappend += ' <option value="' + value["location_id"] + '">' + value["name"] + '</option>';
                                });
                            }
                            $('#statelist').html(toappend);
                        }

                    },
                    error: function (response) {
                    }
                });
            });

            $('#statelist').change(function (e) {
                var state_id = $('#statelist').val();
                $.ajax({
                    type: "POST",
                    url: "/supplier/ajaxHandler",
                    dataType: "json",
                    data: {
                        method: 'getCity',
                        stateId: state_id
                    },
                    success: function (response) {
                        if (response) {
                            $('#city').removeClass('hidden');
                            var state = response;
                            var toappend = '<option value="">Select City</option>';
                            if (response != '') {
                                $.each(state, function (key, value) {
                                    toappend += ' <option value="' + value["location_id"] + '">' + value["name"] + '</option>';
                                });
                            }
                            $('#citylist').html(toappend);
                        }

                    },
                    error: function (response) {
                    }
                });
            });

            $('#add_new_shop').validate({
                rules: {
//                    address_line_1: {
//                        required: true
//                    },
                    shop_name: {
                        required: true
                    },
//                    city: {
//                        required: true
//                    },
//                    country: {
//                        required: true
//                    },
//                    state: {
//                        required: true
//                    },
                    zipcode: {
                       // required: true,
                        digits: true,
                    }
//                    shop_banner: {
//                        required: true
//                    },
                },
                messages: {
                    shop_name: {
                        required: "Please enter shop name"
                    }
//                    address_line_1: {
//                        required: "Please enter an address"
//                    },
//                    city: {
//                        required: "Please select city"
//                    },
//                    country: {
//                        required: "Please select Country"
//                    },
//                    state: {
//                        required: "Please select state"
//                    },
//                    zipcode: {
//                        required: "Please enter zip code"
//                    },
//                    shop_banner: {
//                        required: "Please select banner Image"
//                    }
                }
            });


//            $("#save-info-changes").click(function (e) {
//                e.preventDefault();
//                if ($('#profile-info').valid()) {
//                    var profileData = $('#profile-info').serializeArray();
//                    profileData.push({name: 'method', value: 'updateProfileInfo'});
//                    $.ajax({
//                        type: "POST",
//                        url: "/supplier/ajaxHandler",
//                        dataType: "json",
//                        data: profileData,
//                        success: function (response) {
//                            var alertMsg = '';
//                            if ($.isArray(response['message'])) {
//                                $.each(response['message'], function (index, value) {
//                                    alertMsg += '\u2666\xA0\xA0' + value + '\n';
//                                })
//                            } else {
//                                alertMsg = response['message'];
//                            }
//                            alert(alertMsg);
//                        },
//                        error: function (response) {
//                        }
//                    });
//                }
//            });
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



@endsection
