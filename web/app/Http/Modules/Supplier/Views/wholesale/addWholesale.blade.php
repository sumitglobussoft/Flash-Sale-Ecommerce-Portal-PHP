@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Add Wholesale')


@section('pageheadcontent')
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" media="screen" rel="stylesheet"
          type="text/css">
    <link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>
    <link href=" /assets/css/custom/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" media="screen"
          href="/assets/plugins/input-autocomplete-without-addnew/dist/tokens.css">
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
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
                                    {!!  $errors->first('flashsale_image', '<font color="red">:message</font>') !!}
                                </div>
                            </div>
                            <!-- END CHANGE AVATAR TAB -->

                            <!-- END CHANGE AVATAR TAB -->
                            <div class="form-group">
                                <label class="control-label col-md-2">Percentage Discount:</label>

                                <div class="col-md-3" id="percentagediscount">
                                    <div class="input-inline input-medium input-icon right">
                                        <i class="icon-percent"></i>
                                        <input id="percentagediscountval" type="text" value="0"
                                               name="percentagediscount" class="form-control integer-only">
                                        {!!  $errors->first('percentagediscount', '<font color="red">:message</font>') !!}
                                    </div>
                                </div>
                            </div>


                            <div class="form-group" id="validonvaluesdivcat">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Choose Categories:</label>

                                    <div class="col-md-6">
                                        <select id="js-states" class="form-control select2" multiple
                                                data-placeholder="Choose Categories..." value=""
                                                name="productcategories[]">
                                        </select>
                                    </div>
                                    {!!  $errors->first('productcategories', '<font color="red">:message</font>') !!}
                                    <a href="/admin/add-category" class="btn btn-success" value="Add Category"
                                       style="float:right">Add Your Own Category</a>

                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-2">Choose Products:</label>

                                <div class="col-md-6">
                                    <select id="select2_tags" class="form-control select2" multiple
                                            data-placeholder="Choose Products..." name="product[]">
                                        @foreach($Products as $key => $val)
                                            <option value="<?php echo $val->product_id; ?>"
                                                    id="daily"><?php echo $val->product_name; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                                {!!  $errors->first('products', '<font color="red">:message</font>') !!}
                            </div>

                            {{--</div>--}}
                            <!-- SUBMIT BUTTON-->
                            <div class="form-actions">
                                <div align="center">
                                    <button type="submit" class="btn blue" type="submit">Add Wholesale</button>
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

