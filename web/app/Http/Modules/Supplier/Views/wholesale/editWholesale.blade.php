@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Edit Wholesale')

@section('pageheadcontent')
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" media="screen" rel="stylesheet"
          type="text/css">
    <link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>
    <link href=" /assets/css/custom/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" media="screen"
          href="/assets/plugins/input-autocomplete-without-addnew/dist/tokens.css">
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .form-group .select2-selection {
            position: relative;
            z-index: 2;
            float: left;
            width: 100%;
            margin-bottom: 0;
            display: table;
            table-layout: fixed;
        }
        .form-group ul li{
            padding:2px !important;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-helper"></span>
                    </div>
                    <div class="actions">
                        <a href="/supplier/manage-wholesale" class="btn btn-default btn-circle"><i
                                    class="fa fa-angle-left"></i> Back To List</a>
                    </div>

                </div>

                <div class="portlet-body form">
                    <!-- BEGIN ADD NEW COUPON FORM -->
                    <form class="form-horizontal form-bordered" id="addnewwholespecial" enctype="multipart/form-data"
                          method="post">
                        <div class="form-body">

                            <div class="form-group">
                                <label class="control-label col-md-2 col-lg-2 col-sm-2 col-xs-12">Campaign Name:</label>

                                <div class="input-group">
                                    <div class=" form-horizontal">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="campaignname"
                                                   value="{{ $wholesaleDetails->campaign_name }}"
                                                   name="campaign_name" placeholder="campaign name">
                                        </div>
                                        {!!  $errors->first('campaign_name', '<font color="red">:message</font>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <label class="col-sm-2 control-label">Upload Banner</label>

                            <!-- CHANGE AVATAR TAB -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label ">Upload Banner:</label>

                                <div class="col-sm-8">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">

                                        <div class="fileinput-new thumbnail"
                                             style="width: 200px; height: 150px;">
                                            @if($wholesaleDetails->campaign_banner!='')
                                                <img src="{{$wholesaleDetails->campaign_banner}}" alt=""/>
                                                <input type="hidden" name="oldImage"
                                                       value="{{$wholesaleDetails->campaign_banner}}">
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
                                                                <input type="file" name="wholesale_image"
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
                                <label class="control-label col-md-2">Percentage Discount:</label>

                                <div class="col-md-3" id="percentagediscount">
                                    <div class="input-inline input-medium input-icon right">
                                        <i class="icon-percent"></i>
                                        <input id="percentagediscountval" type="text"
                                               value="{{ $wholesaleDetails->discount_value }}"
                                               name="percentagediscount" class="form-control integer-only">
                                        {!!  $errors->first('percentagediscount', '<font color="red">:message</font>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2">Choose Category:</label>
                                <div class="col-md-6">
                                    <select id="js-states" class="form-control select2" multiple
                                            data-placeholder="Choose Category..." name="productcategories[]">
                                        <?php
                                        $selectedCategory = explode(',', $wholesaleDetails->category_ids);
                                        foreach ($activeCategory as $keyTCsWithTs => $valueTCsWithTs) {
                                        $categoryName = explode(",", $valueTCsWithTs->category_name);
                                        $category_ids = explode(",", $valueTCsWithTs->category_id);
                                        ?>
                                        <?php foreach ($categoryName as $keyCategory => $valueCategory) { ?>
                                        <option value="<?php echo $category_ids[$keyCategory]; ?>"
                                                <?php if (in_array($category_ids[$keyCategory], $selectedCategory)) { ?> selected=""<?php } ?>><?php echo $valueCategory; ?></option>
                                        <?php } ?>
                                        <?php
                                        $categoryName = '';
                                        }  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="validonvaluesdivsubcat">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Choose Subcategories</label>
                                    <div class="col-md-6">
                                        <select id="select2_sample2" class="form-control select2" multiple
                                                data-placeholder="Choose Subcategories.." value=""
                                                name="productsubcategories[]">
                                            <?php
                                            $selectedCategory = explode(',', $wholesaleDetails->category_ids);
                                            foreach ($allcategories as $keyTCsWithTs => $valueTCsWithTs) {
                                            $categoryName = explode(",", $valueTCsWithTs->main_category_name);
                                            $category_ids = explode(",", $valueTCsWithTs->main_category_id);
                                            ?>
                                            <optgroup data-id="<?php echo $keyTCsWithTs ?>"
                                                      label="<?php echo $valueTCsWithTs->main_cat_name ?>">
                                                <?php foreach ($categoryName as $keyCategory => $valueCategory) { ?>
                                                <option value="<?php echo $keyTCsWithTs . '_' . $category_ids[$keyCategory]; ?>"
                                                        <?php if (in_array($category_ids[$keyCategory], $selectedCategory)) { ?> selected=""<?php } ?>><?php echo $valueCategory; ?></option>
                                                <?php } ?>
                                            </optgroup>
                                            <?php
                                            $categoryName = '';
                                            }  ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-2">Choose Products:</label>
                                <div class="col-md-6">
                                    <select id="select2_tags" class="form-control select2" multiple
                                            data-placeholder="Choose Products..." name="product[]">
                                        <?php
                                        $selectedCategory = explode(',', $wholesaleDetails->for_product_ids);
                                        foreach ($allProducts as $keyTCsWithTs => $valueTCsWithTs) {
                                        $productName = explode(",", $valueTCsWithTs->product_name);
                                        $product_ids = explode(",", $valueTCsWithTs->product_id);
                                        ?>
                                        <?php foreach ($productName as $keyProduct => $valueProduct) { ?>
                                        <option value="<?php echo $product_ids[$keyProduct]; ?>"
                                                <?php if (in_array($product_ids[$keyProduct], $selectedCategory)) { ?> selected=""<?php } ?>><?php echo $valueProduct; ?></option>
                                        <?php } ?>
                                        <?php
                                        $productName = '';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            {{--</div>--}}
                                    <!-- SUBMIT BUTTON-->
                            <div class="form-actions">
                                <div align="center">
                                    <button type="submit" class="btn blue" type="submit">Edit Wholesale</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
    <script src="/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>

    <script src="/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/assets/global/plugins/fuelux/js/spinner.min.js"></script>
    <script src="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script type="text/javascript"
            src="/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>

    <script src="/assets/js/pages/components-pickers.js"></script>
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
    <script src="/assets/admin/layout/scripts/components-form-tools.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script text="text/javascript">


        $(document).ready(function () {

            $('select').select2();

            $(".js-example-basic-multiple-limit").select2({
                maximumSelectionLength: 2
            });

            $(".js-example-tokenizer").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
            $(document).on('change', '#discounttype', function (e) {
                if ($('#discounttype').val() == "2") {
                    $('#percentagediscount').removeClass("display-none");
                    $('#flatdiscount').addClass("display-none");
                } else if ($('#discounttype').val() == "1") {
                    $('#flatdiscount').removeClass("display-none");
                    $('#flatdiscountval').prop("disabled", false);
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
                    $('#iconrupee').hide();
                }
            });

            var productData = new Array();
            var autocompleteList1 = new Array();
            var srcindex1 = new Array();
            var data = new Array();
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
                        var tempArray = [];
                        tempArray['id'] = v.category_id;
                        tempArray['text'] = v.category_name;
                        data.push({id: tempArray['id'], text: tempArray['text']});
                    });

                    $("#js-states").select2({
                        data: data
                    });

                }

            });

            var maindata = new Array();
            var mainId = new Array();
            $(document.body).on("change", "#js-states", function () {

                var catId = $(this).val();
                $.ajax({
                    url: '/supplier/dailyspecial-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'getProductsByMainCategoryId',
                        catId: catId
                    },
                    success: function (response) {
                        var data = $.parseJSON(response);
                        var temparrayId = [];
                        var temparrayName = [];
                        $.each(data, function (pi, pv) {
                            temparrayId[pi] = pv['product_id'];
                            temparrayName[pi] = pv['product_name'];
                        });

                        $('#select2_tags').html('<option value="' + temparrayId + '">' + temparrayName + '</option>');

                    }
                });

            });
        });
        jQuery(document).ready(function () {
            Metronic.init();
            ComponentsPickers.init();
        });

    </script>
    {{--<script src="/assets/js/pages/dashboard.js"></script>--}}
@endsection

