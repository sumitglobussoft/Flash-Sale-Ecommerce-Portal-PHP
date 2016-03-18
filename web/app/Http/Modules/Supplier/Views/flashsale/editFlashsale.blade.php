@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Edit FlashSale')


@section('pageheadcontent')
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" media="screen" rel="stylesheet"
          type="text/css">

    <link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>
    {{--<link href="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" media="screen" rel="stylesheet"--}}
    {{--type="text/css">--}}
    {{--<link rel="stylesheet" type="text/css" href="/assets/plugins/bootstrap-datepicker/css/datepicker.css">--}}
    {{--<link rel="stylesheet" type="text/css"--}}
    {{--href="/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>--}}
    {{--<link rel="stylesheet" type="text/css"--}}
    {{--href="/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>--}}



    <link rel="stylesheet" type="text/css" href=" /assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
    <link rel="stylesheet" type="text/css"
          href=" /assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link rel="stylesheet" type="text/css"
          href=" /assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>


    <link href=" /assets/css/custom/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" media="screen"
          href="/assets/plugins/input-autocomplete-without-addnew/dist/tokens.css">
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{--<div class="portlet light bordered">--}}
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        {{--<i class="fa fa-plus font-blue-hoki"></i>--}}
                        {{--<span class="caption-subject font-blue-hoki bold">Add new Coupon</span>--}}
                        <span class="caption-helper"></span>
                    </div>
                    @if(empty($flashsaleDetails)||!isset($flashsaleDetails) && (empty($activeflashsale)||!isset($activeflashsale)))
                        <div style="text-align: center">
                            <span class="">Sorry, no such flashsale found.</span><br>
                            <a href="/supplier/manage-flashsale" class="btn btn-default btn-circle"><i
                                        class="fa fa-angle-left"></i> Back To List</a>
                        </div>
                    @else
                    <div class="actions">
                        <a href="/supplier/manage-flashsale" class="btn btn-default btn-circle"><i
                                    class="fa fa-angle-left"></i> Back To List</a>
                    </div>

                </div>
                <div class="portlet-body form">
                    <!-- BEGIN ADD NEW COUPON FORM -->
                    <form class="form-horizontal form-bordered" id="addnewcouponform" enctype="multipart/form-data"
                          method="post">
                        <div class="form-body">

                            <div class="form-group">
                                <label class="control-label col-md-2 col-lg-2 col-sm-2 col-xs-12">Campaign Name:</label>

                                <div class="input-group">
                                    <div class=" form-horizontal">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="campaignname"
                                                   value="{{ $flashsaleDetails->campaign_name }}"
                                                   name="campaign_name" placeholder="campaign name">
                                        </div>
                                        {!!  $errors->first('campaign_name', '<font color="red">:message</font>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <!-- CHANGE AVATAR TAB -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Upload Banner</label>

                                <div class="col-sm-8">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">

                                        <div class="fileinput-new thumbnail"
                                             style="width: 200px; height: 150px;">
                                            @if($flashsaleDetails->campaign_banner!='')
                                                <img src="{{$flashsaleDetails->campaign_banner}}" alt=""/>
                                                <input type="hidden" name="oldImage"
                                                       value="{{$flashsaleDetails->campaign_banner}}">
                                            @else
                                                <img src="/assets/images/no-image.png" alt=""/>
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 200px; max-height: 150px;">
                                        </div>
                                        <div>
                                                            <span class="btn btn-circle default btn-file">
                                                                <span class="fileinput-new">
                                                                    Select image </span>
                                                                <span class="fileinput-exists">
                                                                    Change </span>
                                                                <input type="file" name="flashsale_image"
                                                                       accept="image/*">
                                                            </span>
                                            <a href="#" class="btn btn-circle default fileinput-exists"
                                               data-dismiss="fileinput">
                                                Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- END CHANGE AVATAR TAB -->
                            <div class="form-group">
                                <label class="control-label col-md-2">Discount Type:</label>

                                <div class="col-md-2">
                                    <div class="margin-bottom-10">
                                        <select class="bs-select form-control input-small" data-style="btn-info"
                                                id="discounttype" name="discounttype">
                                            <option value="">select</option>
                                            <option value="1" <?php if (1 == $flashsaleDetails->discount_type) echo ' selected="selected"'?>>
                                                Flat
                                            </option>
                                            <option value="2" <?php if (2 == $flashsaleDetails->discount_type) echo ' selected="selected"'?>>
                                                Percentage
                                            </option>

                                        </select>
                                        {!!  $errors->first('discounttype', '<font color="red">:message</font>') !!}
                                    </div>
                                </div>

                                <label class="control-label col-md-2">Value:</label>

                                <div class="col-md-3" id="flatdiscount">
                                    <div class="input-inline input-medium input-icon right">
                                        <i class="fa fa-rupee" id="iconrupee" style="display:none;"></i>
                                        <input id="flatdiscountval" type="text"
                                               value="{{ $flashsaleDetails->discount_value }}"
                                               name="flatdiscount" class="form-control integer-only"
                                               style="cursor: text">

                                    </div>

                                </div>
                                <div class="display-none col-md-3" id="percentagediscount">
                                    <div class="input-inline input-medium input-icon right">
                                        <i class="icon-percent"></i>
                                        <input id="percentagediscountval" type="text"
                                               value="{{ $flashsaleDetails->discount_value }}"
                                               name="percentagediscount" class="form-control integer-only">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Available from:</label>

                                <div class="col-md-5">
                                    <div data-date-start-date="+0d"
                                         class="input-group date form_meridian_datetime input-icon">
                                        <input id="availablefromdate" name="availablefromdate" type="text"
                                               <?php if ($flashsaleDetails->available_from != '') { ?> value="<?php echo date('d F Y - h:i A', $flashsaleDetails->available_from); ?>"
                                               <?php } ?>
                                               class="form-control" size="16">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn default date-reset"><i
                                                            class="fa fa-times"></i></button>
                                                <button type="button" class="btn default date-set"><i
                                                            class="fa fa-calendar"></i></button>
                                            </span>
                                    </div>
                                    {!!  $errors->first('availablefromdate', '<font color="red">:message</font>') !!}
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Available upto:</label>

                                <div class="col-md-5">
                                    <div data-date-start-date="+0d"
                                         class="input-group date form_meridian_datetime input-icon">
                                        <input id="availableuptodate" name="availableuptodate" type="text"
                                               class="form-control" size="16"
                                               <?php if ($flashsaleDetails->available_upto != '') { ?> value="<?php echo date('d F Y - h:i A', $flashsaleDetails->available_upto); ?>" <?php } ?>>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn default date-reset"><i
                                                            class="fa fa-times"></i></button>
                                                <button type="button" class="btn default date-set"><i
                                                            class="fa fa-calendar"></i></button>
                                            </span>

                                    </div>
                                    {!!  $errors->first('availableuptodate', '<font color="red">:message</font>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Shop:</label>

                                <div class="margin-bottom-10">
                                    <select class="bs-select form-control input-small" data-style="btn-info"
                                            id="suppliershop" name="suppliershop">
                                        <option value="">select</option>
                                        <option value="0">Abevo</option>
                                    </select>
                                </div>
                            </div>

                            {{--<div class="form-group" id="validonvaluesdivcat">--}}
                            {{--<div class="form-group">--}}
                            {{--<label class="control-label col-md-2 col-lg-2 col-sm-2 col-xs-12">Choose Categories:</label>--}}
                            {{--<div class="input-group">--}}
                            {{--<div class=" form-horizontal">--}}
                            {{--<div class="form-group">--}}
                            {{--<input type="text" class="form-control" id="validonvaluesprod1" name="productcat[]" placeholder="start typing to choose products">--}}
                            {{--<input type="hidden" name="productcategories[]" id="prods-id" value="" />--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--{!!  $errors->first('productcategories', '<font color="red">:message</font>') !!}--}}
                            {{--<a href="/admin/add-category" class="btn btn-success" value="Add Category"--}}
                            {{--style="float:right">Add Your Own Category</a>--}}

                            {{--</div>--}}
                            {{--</div>--}}


                            <div class="form-group">
                                <label class="control-label col-md-2">Choose Category:</label>

                                <div class="col-md-6">
                                    <select id="select2_tags" class="form-control select2" multiple
                                            data-placeholder="Choose Category..." name="productcategories[]">
                                        <?php
                                        $selectedCategory = explode(',', $flashsaleDetails->for_category_ids);
                                        foreach ($activeflashsale as $keyTCsWithTs => $valueTCsWithTs) {
                                        $categoryName = explode(",", $valueTCsWithTs->category_name);
                                        $category_ids = explode(",", $valueTCsWithTs->category_id);
                                        ?>
                                        <?php foreach ($categoryName as $keyCategory => $valueCategory) { ?>
                                        <option value="<?php echo $category_ids[$keyCategory]; ?>"
                                                <?php if (in_array($category_ids[$keyCategory], $selectedCategory)) { ?> selected=""<?php } ?>><?php echo $valueCategory; ?></option>
                                        <?php } ?>
                                        <?php
                                        $categoryName = '';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            {{--</div>--}}
                            <!-- SUBMIT BUTTON-->
                            <div class="form-actions">
                                <div align="center">
                                    <button type="submit" class="btn blue" type="submit">Edit Flashsale</button>
                                </div>
                            </div>
                    </form>
                </div>
                @endif
                <!-- END ADD NEW COUPON FORM -->
            </div>
        </div>
    </div>
    </div>
    <!-- Row -->

@endsection

@section('pagejavascripts')
    <script src="/assets/plugins/select2/js/select2.min.js"></script>
    <script src="/assets/js/pages/form-select2.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

    <script src="/assets/js/pages/components-pickers.js"></script>
    {{--<script src="/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>--}}
    <script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script type="text/javascript"
            src=" /assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript"
            src=" /assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script type="text/javascript"
            src=" /assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/assets/plugins/input-autocomplete-without-addnew/dist/tokens.js" type="text/javascript"></script>

    <script>


        $(document).ready(function () {

            $(document).on('change', '#discounttype', function (e) {
                if ($('#discounttype').val() == "2") {
                    alert("cvh");
                    $('#percentagediscount').removeClass("display-none");
                    $('#flatdiscount').addClass("display-none");
                    $('#flatdiscountval').prop("disabled", true);
                    $('#percentagediscount').prop("disabled", false);
                } else if ($('#discounttype').val() == "1") {
                    alert("cfh");
                    $('#flatdiscount').removeClass("display-none");
                    $('#flatdiscountval').prop("disabled", false);
                    $('#percentagediscount').prop("disabled", true);
                    $('#flatdiscountval').val('0');
                    $('#percentagediscount').addClass("display-none");
                    $('#iconrupee').show();
                } else if ($('#discounttype').val() == "") {
                    $('#availablefromdate').val('')
                    $('#availableuptodate').val('')
                    $('#percentagediscount').addClass("display-none");
                    $('#flatdiscount').removeClass("display-none");
                    $('#flatdiscountval').val('Choose discount type first.');
                    $('#flatdiscountval').prop("disabled", true);
                    $('#percentagediscount').prop("disabled", true);
                    $('#iconrupee').hide();
                }
            });


            var autocompleteList1 = new Array();
            var srcindex1 = new Array();
            var data = new Array();
            var data1 = new Array();
            $.ajax({
                url: '/supplier/flashsale-ajax-handler',
                type: 'POST',
                datatype: 'json',
                data: {
                    method: 'getActiveCategories'
                },
                success: function (resposne) {
                    data1 = $.parseJSON(resposne);
                    $.each(data1, function (i, v) {
                        autocompleteList1.push(v.category_name);
                        srcindex1.push(v.category_id);
                    });
                }
            });
            jQuery('#validonvaluesprod1').tokens({
                source: autocompleteList1,
            });

            $('.tokens-token-list').find('tokens-list-token-holder').parent('div');
            $(document.body).on('change', '#validonvaluesprod1', function () {
//                $('#validonvaluesprod1').on('change',function(){
                console.log(data1);
                var text = $(this).val().toLowerCase();
                var categoryId;
                $.each(data1.data, function (id, aVal) {
                    if (aVal.category_name.toLowerCase() == text) {
                        categoryId = aVal.category_id;
                    }
                });
                if (categoryId) {
                    $('#prods-id').attr('value', categoryId);
                }
            });

        });
        jQuery(document).ready(function () {
            Metronic.init();
            ComponentsPickers.init();
        });

    </script>
    {{--<script src="/assets/js/pages/dashboard.js"></script>--}}
@endsection
