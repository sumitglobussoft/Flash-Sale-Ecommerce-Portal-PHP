@extends('Admin/Layouts/adminlayout')

@section('title', 'Campaign Log') {{--TITLE GOES HERE--}}

@section('headcontent')

    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" media="screen" rel="stylesheet"
          type="text/css">
    <link href=" /assets/global/css/plugins.css" media="screen" rel="stylesheet"
          type="text/css">
    <link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/DT_bootstrap.css" media="screen" rel="stylesheet" type="text/css">
    <link src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" type="text/css">
    <link src="/assets/plugins/bootstrap-datepicker/css/datepicker.css" type="text/css">
    <link rel="stylesheet" type="text/css"
          href=" /assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link rel="stylesheet" type="text/css"
          href=" /assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
    <link src="/assets/global/plugins/datatables/media/css/jquery.dataTables.min.css" type="text/css">
    <link href="/assets/css/custom/components.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>

@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-basket font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Campaign Log</span>
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <div class="table-actions-wrapper">
                            <span style="margin-left: -10px">
                            </span>
                            <select class="table-group-action-input form-control input-inline input-small input-sm"
                                    name="group_action">
                                <option value="">Select...</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                                <option value="3">Rejected</option>
                                <option value="4">Deleted</option>
                                <option value="5">Finished</option>
                            </select>
                            <button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i>
                                Submit
                            </button>
                        </div>
                        <table id="campaign_log"
                               class="table table-striped table-bordered table-hover text-center" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="group-checkable"></th>
                                <th width="5%">Id</th>
                                <th width="5%">Campaign Name</th>
                                <th width="20%">Campaign Type</th>
                                <th width="5%">SupplierName</th>
                                {{--<th>Discount Type</th>--}}
                                <th width="5%">Discount Value</th>
                                <th width="5%">Available From</th>
                                <th width="5%">Available Upto</th>
                                <th width="5%">Extended End Time</th>
                                {{--<th width="10%">For Categories</th>--}}
                                <th width="20%">Status</th>
                                <th width="1%">No Of Products</th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td><input type="text" class="form-control form-filter input-sm"
                                           name="campaign_id" value=""></td>
                                <td><input type="text" class="form-control form-filter input-sm"
                                           name="campaign_name" value=""></td>
                                <td>
                                    {{--<select name="campaign_type" class="form-control form-filter input-sm">--}}
                                        {{--<option value="">Select...</option>--}}
                                        {{--<option value="1">Dailyspecial</option>--}}
                                        {{--<option value="2">Flashsale</option>--}}
                                    {{--</select>--}}

                                </td>
                                <td><input type="text" class="form-control form-filter input-sm"
                                           name="username" value=""></td>
                                <td>
                                    <div class="input-group margin-bottom-5">
                                        <input type="text" class="form-control form-filter input-sm"
                                               name="discount_value_from" placeholder="From">
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-filter input-sm"
                                               name="discount_value_to" value="" placeholder="To">

                                    </div>
                                </td>
                                <td>
                                    {{--<div class="col-md-5">--}}
                                    <div class="input-group date form_datetime input-small">
                                        <input id="availablefromdate" name="available_from_date" type="text"
                                               class="form-control form-filter input-sm">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn default date-reset"><i
                                                            class="fa fa-times"></i></button>
                                                <button type="button" class="btn default date-set"><i
                                                            class="fa fa-calendar"></i></button>
                                            </span>
                                    </div>
                                    {{--</div>--}}
                                    {{--<div class="input-group margin-bottom-5">--}}
                                    {{--<input type="text" class="form-control form-filter input-sm"--}}
                                    {{--name="available_from_date" placeholder="From">--}}
                                    {{--</div>--}}
                                </td>
                                <td>
                                    {{--<div class="col-md-4">--}}
                                    <div class="input-group date form_datetime input-small">
                                        {{--<i class="fa fa-calendar"></i>--}}
                                        <input id="availableuptodate" name="available_upto_date" type="text"
                                               class="form-control form-filter input-sm">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn default date-reset"><i
                                                            class="fa fa-times"></i></button>
                                                <button type="button" class="btn default date-set"><i
                                                            class="fa fa-calendar"></i></button>
                                            </span>

                                    </div>
                                    {{--</div>--}}
                                    {{--<div class="input-group margin-bottom-5">--}}
                                    {{--<input type="text" class="form-control form-filter input-sm"--}}
                                    {{--name="available_upto_date" placeholder="Upto">--}}
                                    {{--</div>--}}
                                </td>
                                <td>
                                    {{--<div class="col-md-4">--}}
                                    <div class="input-group date form_datetime input-small">
                                        {{--<i class="fa fa-calendar"></i>--}}
                                        <input id="extended_date" name="extended_date" type="text"
                                               class="form-control form-filter input-sm">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn default date-reset"><i
                                                            class="fa fa-times"></i></button>
                                                <button type="button" class="btn default date-set"><i
                                                            class="fa fa-calendar"></i></button>
                                            </span>

                                    </div>
                                    {{--</div>--}}
                                    {{--<div class="input-group margin-bottom-5">--}}
                                    {{--<input type="text" class="form-control form-filter input-sm"--}}
                                    {{--name="available_upto_date" placeholder="Upto">--}}
                                    {{--</div>--}}
                                </td>
                                {{--<td></td>--}}
                                {{--<td>--}}
                                    {{--<select id="js-states" class="form-control form-filter input-sm select2" multiple--}}
                                            {{--data-placeholder="Choose Categories..." value=""--}}
                                            {{--name="category_id[]">--}}
                                    {{--</select>--}}
                                {{--</td>--}}
                                {{--<td></td>--}}
                                <td>
                                    <select name="campaign_status" class="form-control form-filter input-sm">
                                        <option value="">Select...</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                        <option value="3">Rejected</option>
                                        <option value="4">Deleted</option>
                                        <option value="5">Finished</option>
                                    </select>

                                </td> {{--<td></td>--}}
                                {{--<td><input type="text" class="form-control form-filter input-sm"--}}
                                {{--name="action"></td>--}}




                                {{--<div class="input-group date date-picker margin-bottom-5"--}}
                                {{--data-date-format="dd-mm-yyyy">--}}
                                {{--<input type="text" class="form-control form-filter input-sm" readonly--}}
                                {{--name="order_date_from" placeholder="From">--}}
                                {{--<span class="input-group-btn">--}}
                                {{--<button class="btn btn-sm default" type="button"><i--}}
                                {{--class="fa fa-calendar"></i></button>--}}
                                {{--</span>--}}
                                {{--</div>--}}
                                {{--<div class="input-group date date-picker" data-date-format="dd-mm-yyyy">--}}
                                {{--<input type="text" class="form-control form-filter input-sm" readonly--}}
                                {{--name="order_date_to" placeholder="To">--}}
                                {{--<span class="input-group-btn">--}}
                                {{--<button class="btn btn-sm default" type="button"><i--}}
                                {{--class="fa fa-calendar"></i></button>--}}
                                {{--</span>--}}
                                {{--</div>--}}
                                {{--</td>--}}
                                {{--<td><input type="text" class="form-control form-filter input-sm"--}}
                                {{--name="order_customer_email"></td>--}}
                                {{--<td><input type="text" class="form-control form-filter input-sm"--}}
                                {{--name="product_name"></td>--}}
                                {{--<td>--}}
                                {{--<div class="margin-bottom-5">--}}
                                {{--<input type="text"--}}
                                {{--class="form-control form-filter input-sm margin-bottom-5 clearfix"--}}
                                {{--name="order_purchase_price_from" placeholder="From"/>--}}
                                {{--</div>--}}
                                {{--<input type="text" class="form-control form-filter input-sm"--}}
                                {{--name="order_purchase_price_to" placeholder="To"/>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                {{--<!--<input type="text" class="form-control form-filter input-sm" name="payment_type">-->--}}
                                {{--<select name="payment_type" class="form-control form-filter input-sm">--}}
                                {{--<option value="">Select...</option>--}}
                                {{--<option value="0">COD</option>--}}
                                {{--<option value="1">PayU Money</option>--}}
                                {{--</select>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                {{--<select name="order_status" class="form-control form-filter input-sm">--}}
                                {{--<option value="">Select...</option>--}}
                                {{--<option value="1">TXN Success</option>--}}
                                {{--<option value="4">TXN Failed</option>--}}
                                {{--<option value="2">Inprocess</option>--}}
                                {{--<option value="3">Cancel Request</option>--}}
                                {{--<option value="11">Cancel Inprocess</option>--}}
                                {{--<option value="12">Cancelled</option>--}}
                                {{--<option value="7">Refund Request</option>--}}
                                {{--<option value="8">Refund Inprocess</option>--}}
                                {{--<option value="9">Refunded</option>--}}
                                {{--<option value="5">Merchant Cancel</option>--}}
                                {{--<option value="10">Shipping</option>--}}
                                {{--<option value="6">Delivered</option>--}}
                                {{--</select>--}}
                                {{--</td>--}}
                                <td>
                                    <div class="margin-bottom-5">
                                        <button class="btn btn-sm yellow filter-submit margin-bottom"><i
                                                    class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                    <button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i>
                                        Reset
                                    </button>
                                </td>
                                {{--<td></td>--}}
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection


@section('pagejavascripts')
    <script src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"
            type="text/javascript"></script>
    <script type="text/javascript" src="/assets/plugins/select2/js/select2.min.js"></script>
    {{--<script type="text/javascript" src="/assets/js/pages/form-select2.js"></script>--}}
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="/assets/js/pages/components-pickers.js"></script>
    {{--<script type="text/javascript" src="/assets/global/plugins/jquery.blockui.min.js"></script>--}}
    <script type="text/javascript" src="/assets/global/scripts/metronic.js"></script>
    <script type="text/javascript" src="/assets/global/scripts/layout.js"></script>
    <script type="text/javascript" src="/assets/global/scripts/demo.js"></script>
    <script src="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script type="text/javascript"
            src=" /assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script type="text/javascript"
            src=" /assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/assets/global/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>

    <script type="text/javascript" src="/assets/admin/layout/scripts/custom.js"></script>
    <script type="text/javascript" src="/assets/global/scripts/datatable.js"></script>


    <script>
        var EcommerceOrders = function () {

            var initPickers = function () {
                //init date pickers
                $('.date-picker').datepicker({
                    rtl: Metronic.isRTL(),
                    autoclose: true
                });
            }

            var handleOrders = function () {

                var grid = new Datatable();

                grid.init({
                    src: $("#campaign_log"),
                    onSuccess: function (grid) {

                        // execute some code after table records loaded
                    },
                    onError: function (grid) {
                        // execute some code on network or other general error
                    },
                    loadingMessage: 'Loading...',
                    dataTable: {// here you can define a typical datatable settings from http://datatables.net/usage/options
                        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
                        // So when dropdowns used the scrollable div should be removed.
                        //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                        "lengthMenu": [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"] // change per page values here
                        ],
                        "pageLength": 10, // default record count per page
                        "ajax": {
                            "url": "/admin/campaign-list-ajax-handler/campaignLog"
                        },
                        "order": [
                            [0, "asc"]
                        ], // set first column as a default sort by asc
                        "columnDefs": [{// define columns sorting options(by default all columns are sortable extept the first checkbox column)
                            'orderable': false,
                            'targets': [0,6,7]
                        }]
                    }
                });

                // handle group actionsubmit button click
                grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
                    e.preventDefault();
                    var action = $(".table-group-action-input", grid.getTableWrapper());
                    if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                        grid.setAjaxParam("customActionType", "group_action");
                        grid.setAjaxParam("customActionValue", action.val());
                        grid.setAjaxParam("orderId", grid.getSelectedRows());
                        grid.getDataTable().ajax.reload();
                        grid.clearAjaxParams();
                    } else if (action.val() == "") {
                        Metronic.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: 'Please select an action',
                            container: grid.getTableWrapper(),
                            place: 'prepend'
                        });
                    } else if (grid.getSelectedRowsCount() === 0) {
                        Metronic.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: 'No record selected',
                            container: grid.getTableWrapper(),
                            place: 'prepend'
                        });
                    }
                });

            }

            return {
                //main function to initiate the module
                init: function () {

                    initPickers();
                    handleOrders();
                }
            };

        }();
        EcommerceOrders.init();
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        ComponentsPickers.init();

        var productData = new Array();
        var autocompleteList1 = new Array();
        var srcindex1 = new Array();
        var data = new Array();
        $.ajax({
            url: '/admin/campaign-ajax-handler',
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

    </script>

@endsection
