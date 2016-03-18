@extends('Admin/Layouts/adminlayout')

@section('title', 'Add New Flashsale') {{--TITLE GOES HERE--}}

@section('headcontent')

    <link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css"
          href="/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/bootstrap-datepicker/css/datepicker.css">
    <link href=" /assets/css/custom/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" media="screen" href="/assets/plugins/input-autocomplete-without-addnew/dist/tokens.css">


    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}

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
                    <div class="actions">
                        <a href="/admin/manage-coupons" class="btn btn-default btn-circle"><i
                                    class="fa fa-angle-left"></i> Back To List</a>
                    </div>

                </div>

                <div class="alert <?php
                if (isset($this->errorMsg))
                    echo 'alert-danger';
                else if (isset($this->successMsg))
                    echo 'alert-success';
                else
                    echo 'display-hide';
                ?>">
                    <button class="close" data-close="alert"></button>
                        <span>
                            <?php if (isset($this->errorMsg)) echo $this->errorMsg; ?>
                            <?php if (isset($this->successMsg)) echo $this->successMsg; ?>
                        </span>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN ADD NEW COUPON FORM -->
                    <form class="form-horizontal form-bordered" id="addnewcouponform" enctype="multipart/form-data"
                          method="post">
                        <div class="form-body">
                            <div class="clearfix"></div>



                            <div class="form-group">
                                <label class="control-label col-md-2">Discount Type:</label>

                                <div class="col-md-2">
                                    <div class="margin-bottom-10">
                                        <select class="bs-select form-control input-small" data-style="btn-info"
                                                id="discounttype" name="discounttype">
                                            <option value="">select</option>
                                            <option value="0">Percentage</option>
                                            <option value="1">Flat</option>
                                        </select>
                                    </div>
                                </div>

                                <label class="control-label col-md-2">Value:</label>

                                <div class="col-md-3" id="flatdiscount">
                                    <div class="input-inline input-medium input-icon right">
                                        <i class="fa fa-rupee" id="iconrupee" style="display:none;"></i>
                                        <input id="flatdiscountval" type="text" value="Choose discount type first."
                                               name="flatdiscount" class="form-control integer-only" disabled
                                               style="cursor: text">
                                    </div>

                                </div>
                                <div class="display-none col-md-3" id="percentagediscount">
                                    <div class="input-inline input-medium input-icon right">
                                        <i class="icon-percent"></i>
                                        <input id="percentagediscountval" type="text" value="0"
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
                                        <i class="fa fa-calendar"></i>
                                        <input id="availablefromdate" name="availablefromdate" type="text"
                                               class="form-control" size="16">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn default date-reset"><i
                                                            class="fa fa-times"></i></button>
                                                <button type="button" class="btn default date-set"><i
                                                            class="fa fa-calendar"></i></button>
                                            </span>
                                            <span id="availablefromdateError">
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Available upto:</label>

                                <div class="col-md-5">
                                    <div data-date-start-date="+0d"
                                         class="input-group date form_meridian_datetime input-icon">
                                        <i class="fa fa-calendar"></i>
                                        <input id="availableuptodate" name="availableuptodate" type="text"
                                               class="form-control" size="16">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn default date-reset"><i
                                                            class="fa fa-times"></i></button>
                                                <button type="button" class="btn default date-set"><i
                                                            class="fa fa-calendar"></i></button>
                                            </span>
                                            <span id="availableuptodateError">
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Date Picker</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control date-picker">
                                </div>
                            </div>

                            <div class="form-group" id="validonvaluesdivprod">
                                <label class="control-label col-md-2 col-lg-2 col-sm-2 col-xs-12">Choose
                                    Categories:</label>

                                <div class="input-group">
                                    <div class=" form-horizontal">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="validonvaluescategory"
                                                   name="category[]" placeholder="start typing to choose Categories">
                                            <input type="text" name="categs_id[]" id="categs-id" style="display: none;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SUBMIT BUTTON-->
                        <div class="form-actions">
                            <div align="center">
                                <button type="submit" class="btn blue" type="submit">Add Flashsale</button>
                            </div>
                        </div>
                    </form>
                    <!-- END ADD NEW COUPON FORM -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagejavascripts')
    <script src="/assets/plugins/select2/js/select2.min.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="/assets/js/pages/components-pickers.js"></script>
    <script src="/assets/plugins/input-autocomplete-without-addnew/dist/tokens.js" type="text/javascript"></script>

    <script>


        $(document).ready(function () {

            $(document).on('change', '#discounttype', function (e) {
                if ($('#discounttype').val() == "0") {
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
            $.ajax({
                url: '/admin/flashsale-ajax-handler',
                type: 'POST',
                datatype: 'json',
                data: {
                    method: 'getActiveCategories'
                },
                success: function (data) {
                    var data1 = $.parseJSON(data);
                    console.log(data1);
                    productData = data1;
                    $.each(data1, function (i, v) {
                        autocompleteList1.push(v.category_name);
                        srcindex1.push(v.category_id);
                    });
                }
            });
            (function () {
                $('#validonvaluesprod').tokens({
                    source: autocompleteList1,
                    initValue: []
                });
            })();
        });

    </script>
@endsection

