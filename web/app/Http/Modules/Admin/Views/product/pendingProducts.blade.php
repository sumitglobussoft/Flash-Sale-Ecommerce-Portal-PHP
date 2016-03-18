@extends('Admin/Layouts/adminlayout')

@section('title', 'Manage Pending Products') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" media="screen" rel="stylesheet"
          type="text/css">
    <link href=" /assets/global/css/plugins.css" media="screen" rel="stylesheet"
          type="text/css">
    <link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/DT_bootstrap.css" media="screen" rel="stylesheet" type="text/css">
    {{--<script src="/assets/plugins/select2/css/select2.css" type="text/javascript"></script>--}}
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
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="panel-title">All Products</h4>

                    <div class="panel-control">
                        <a href="/admin/add-product"><i class="fa fa-plus"></i>&nbsp;Add new product</a>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-container">
                        <table id="available_products"
                               class="display table table-striped table-bordered table-hover text-center"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">Id</th>
                                {{--<th>Image</th>--}}
                                <th>Image</th>
                                <th width="5%">Added Date</th>
                                <th width="5%">StoreName</th>
                                <th width="5%">ProductName</th>
                                <th width="15%">Price</th>
                                <th width="5%">List Price</th>
                                <th width="2%">Minimum Qunatity</th>
                                <th width="2%">Maximum Qunatity</th>
                                <th width="15%">Category</th>
                                <th width="2%">Instock</th>
                                <th width="5%">Added By</th>
                                <th width="2%">Available Countries</th>
                                <th width="15%">Select Status</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr role="row" class="filter">
                                <!--<td></td>-->
                                <td><input type="text" class="form-control form-filter input-sm" name="product_id"></td>
                                <td></td>
                                <td>
                                    <div class="input-group date form_datetime input-small">
                                        <input id="fromdate" name="date_from" type="text"
                                               class="form-control form-filter input-sm">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn default date-reset"><i
                                                            class="fa fa-times"></i></button>
                                                <button type="button" class="btn default date-set"><i
                                                            class="fa fa-calendar"></i></button>
                                            </span>
                                    </div>
                                    <div class="input-group date form_datetime input-small">
                                        <input id="todate" name="date_to" type="text"
                                               class="form-control form-filter input-sm">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn default date-reset"><i
                                                            class="fa fa-times"></i></button>
                                                <button type="button" class="btn default date-set"><i
                                                            class="fa fa-calendar"></i></button>
                                            </span>
                                    </div>

                                </td>
                                <td><input type="text" class="form-control form-filter input-sm" name="store_name">
                                </td>
                                <td><input type="text" class="form-control form-filter input-sm" name="product_name">
                                </td>
                                <td><input type="text" class="form-control form-filter input-sm"
                                           name="price_from" placeholder="Price From">
                                    <input type="text" class="form-control form-filter input-sm"
                                           name="price_to" placeholder="Price To"></td>
                                <td>
                                    <div class="margin-bottom-5">
                                        <input type="text"
                                               class="form-control form-filter input-sm margin-bottom-5 clearfix"
                                               name="list_price_from" placeholder="List Price From"/>
                                    </div>
                                    <input type="text" class="form-control form-filter input-sm"
                                           name="list_price_to" placeholder="List Price To"/>
                                </td>
                                <td><input type="text" class="form-control form-filter input-sm"
                                           name="minimum_quantity">
                                </td>
                                <td><input type="text" class="form-control form-filter input-sm"
                                           name="maximum_quantity">
                                </td>
                                <td>
                                    {{--<select id="js-states" class="form-control form-filter input-sm select2" multiple--}}
                                    {{--data-placeholder="Choose Categories..." value=""--}}
                                    {{--name="product_categories[]">--}}
                                    {{--</select>--}}
                                    <select id="js-states" class="form-control form-filter input-medium select2"
                                            data-placeholder="Choose Categories..." value=""
                                            name="product_categories">
                                        <option></option>
                                        <?php
                                        function createTree1($array, $curParent, $currLevel = 0, $prevLevel = -1)
                                        {
                                            foreach ($array['category'] as $key => $category) {
                                                if ($curParent == $category->parent_category_id) {
                                                    echo '<option value="' . $category->category_id . '" >';
                                                    if ($currLevel >= $prevLevel) echo str_repeat('&brvbar;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $currLevel);
                                                    echo $category->category_name;
                                                    if ($currLevel > $prevLevel) $prevLevel = $currLevel;
                                                    $currLevel++;
                                                    echo '</option>';
                                                    createTree1($array, $category->category_id, $currLevel, $prevLevel);
                                                    $currLevel--;
                                                }
                                            }
                                        }
                                        $newCategoryArray['category'] = $allCategories;
                                        createTree1($newCategoryArray, 0);
                                        ?>
                                    </select>
                                    {{--<select id="js-states" class="form-control form-filter input-sm select2"--}}
                                    {{--data-placeholder="Choose Categories..." value=""--}}
                                    {{--name="product_categories[]">--}}
                                    {{--</select>--}}
                                </td>

                                <td>

                                </td>
                                <td><input type="text" class="form-control form-filter input-sm"
                                           name="added_by"></td>
                                <td>
                                    {{--<select name="available_countries" class="form-control form-filter input-sm">--}}
                                    {{--<option value="">Select...</option>--}}
                                    {{--<option value="1">TXN Success</option>--}}
                                    {{--<option value="2">Inprocess</option>--}}
                                    {{--</select>--}}
                                </td>
                                <td>
                                    {{--<select name="product_status" class="form-control form-filter input-small">--}}
                                    {{--<option value="">Select...</option>--}}
                                    {{--<option value="1">Active</option>--}}
                                    {{--<option value="2">Inactive</option>--}}
                                    {{--</select>--}}
                                </td>
                                <td>
                                    <div class="margin-bottom-5">
                                        <button class="btn btn-sm yellow filter-submit margin-bottom"><i
                                                    class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                    <button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset
                                    </button>
                                </td>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pagejavascripts')
    {{--<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>--}}
    <script src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"
            type="text/javascript"></script>
    <script type="text/javascript" src="/assets/plugins/select2/js/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/pages/form-select2.js"></script>
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
    <script type="text/javascript" src="/assets/global/scripts/custom_datatable.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
//            $('#available_products').DataTable({
//                "processing": true,
//                "serverSide": true,
//                "ajax": {
//                    url: "/admin/product-ajax-handler",
//                    data: {
//                        method: 'pendingProducts'
//                    },
//                },
//            });

            var ajaxParams = [];
            var grid;

            ajaxParams["method"] = "pendingProducts";
            //        var ajaxParams = new FormData();
            var name = new Array();
            var value = new Array();
            //        ajaxParams.append('method','manageWholesale');

            $(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                ComponentsPickers.init();
                EcommerceOrders.init();
                $(document.body).on('click', '.filter-submit', function (e) {

                    $('textarea.form-filter, input.form-filter,select.form-filter').each(function (i, v) {
//                    console.log($(this));
                        ajaxParams[$(this).attr("name")] = $(this).val();
                    });
                    ajaxParams["action"] = "filter";
                    var oTable = $('#available_products').dataTable();
                    oTable.fnDestroy();
//                e.preventDefault();
                    EcommerceOrders.init();
                });

                $(document.body).on('click', '.filter-cancel', function (e) {
                    e.preventDefault();

                    $('textarea.form-filter, input.form-filter,select.form-filter').each(function (i, v) {
                        $(this).val("");
                    });
//                ajaxParams = [];
                    ajaxParams["action"] = "filter_cancel";
                    var oTable = $('#available_products').dataTable();
                    oTable.fnDestroy();
                    EcommerceOrders.init();
                });

            });

            var EcommerceOrders = function () {

//            var initPickers = function () {
//                //init date pickers
//                $('.date-picker').datepicker({
//                    rtl: Metronic.isRTL(),
//                    autoclose: true
//                });
//            }
                var handleOrders = function () {

                    grid = new Datatable();

                    the = this;
                    // handle filter submit button click


                    grid.init({
                        src: $("#available_products"),
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
                                "url": "/admin/product-ajax-handler",// ajax source
                                "data": ajaxParams
                            },
                            "order": [
                                [0, "asc"]
                            ], // set first column as a default sort by asc
                            "columnDefs": [{// define columns sorting options(by default all columns are sortable extept the first checkbox column)
                                'orderable': false,
                                'targets': [6, 7]
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

//                    initPickers();
                        handleOrders();
                    }

                };


            }();


            $(document.body).on("change", "#statuspending", function () {

                var obj = $(this);
                var productId = $(this).attr('data-id');
                var status = $(this).val();
                if (status == 0 || status == 1 || status == 3) {
                    $.ajax({
                        url: '/admin/product-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changeProductStatus',
                            productId: productId,
                            status: status,
                        },
                        success: function (response) {
                            response = $.parseJSON(response);
                            toastr[response['status']](response['msg']);
                            if (response) {
                                window.location.reload();
                            }
                        }

                    });

                }

            });


        });

    </script>
@endsection
