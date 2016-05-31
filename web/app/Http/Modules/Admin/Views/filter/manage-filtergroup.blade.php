@extends('Admin/Layouts/adminlayout')

@section('title', 'Manage FilterGroup') {{--TITLE GOES HERE--}}

@section('headcontent')
    <link rel="stylesheet" type="text/css" href="/assets/plugins/datatables/css/jquery.datatables.min.css"/>
@endsection


@section('content')
    {{--PAGE CONTENT GOES HERE--}}
    {{--DISPLAY ALL CATEGORIES, USING SERVER SIDE DATATABLES--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="panel-title">All Filters</h4>

                    <div class="panel-control">
                        <a href="/admin/add-new-filtergroup"><i class="fa fa-plus"></i>&nbsp;Add New Filter</a>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" style="width: 100%"
                           id='datatable_filter'>
                        <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Product Filter Group Name</th>
                            <th class="text-center">Display On</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                            <th class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $rowCount = 1; ?>
                        @foreach($filtergroupdetail as $filtergroupkey => $filtergroupvalue)
                            @foreach($filtergroupvalue->filtergroup as $filtercatkey => $filtercatval)
                                <tr id="filter<?php echo $filtergroupvalue->product_filter_option_id?>">
                                    <td class="text-center"><?php echo $rowCount++; ?></td>
                                    <td class="text-center">{{$filtergroupvalue->product_filter_option_name}}</td>
                                    <td class="text-center">{{$filtercatval}}</td>
                                    <td class="text-center"><a
                                                href="/admin/edit-filtergroup/{{$filtergroupvalue->product_filter_option_id}}"
                                                class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td style="text-align: center">
                                        <div role="group" class="btn-group ">
                                            <button aria-expanded="false" data-toggle="dropdown"
                                                    class="btn btn-default dropdown-toggle" type="button">
                                                <i class="fa fa-cog"></i>&nbsp;
                                                <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li>
                                                    <a href="/admin/edit-filtergroup/{{$filtergroupvalue->product_filter_option_id}}""><i
                                                            class="fa fa-pencil"></i>&nbsp;Edit</a>
                                                </li>
                                                <li><a href="javascript:void(0);" class="delete-feature"
                                                       data-cid="{{$filtergroupvalue->product_filter_option_id}}"><i
                                                                class="fa fa-trash"></i>&nbsp;Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="center" style="text-align: center;">
                                        @if($filtergroupvalue->product_filter_option_status == 1)
                                            <button class="btn btn-success changestatus"
                                                    data-id="<?php echo $filtergroupvalue->product_filter_option_id ?>">
                                                Active
                                            </button>
                                        @elseif($filtergroupvalue->product_filter_option_status == 0)
                                            <button class="btn btn-danger changestatus"
                                                    data-id="<?php echo $filtergroupvalue->product_filter_option_id ?>">
                                                Inactive
                                            </button>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                    {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejavascripts')
    <script>
        {{--PAGE SCRIPTS GO HERE--}}

        $(document).ready(function () {
            var table = $('#datatable_filter');
            var oTable = table.dataTable({
                "lengthMenu": [
                    [10, 20, 100, -1],
                    [10, 20, 100, "All"]
                ], "bAutoWidth": false,
                "bSort": false
//                "searching":false
//                "info":     false
            });
            $(document.body).on("click", ".changestatus", function () {
                var featureId = $(this).attr('data-id');
                var featuretatus = $(this).val();
                var obj = $(this);
                var featureId = $(this).attr('data-id');
                var status = 0;
                if (obj.hasClass('btn-success')) {
                    status = 0;
                } else if (obj.hasClass('btn-danger')) {
                    status = 1;
                }
                if (status == 0 || status == 1) {
                    $(document).ajaxStart($.blockUI);
                    $.ajax({
                        url: '/admin/filter-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changefeatureStatus',
                            featureId: featureId,
                            featuretatus: status
                        },
                        success: function (response) {
                            $(document).ajaxStop($.unblockUI);
                            var res = $.parseJSON(response);
                            toastr[res['status']](res['msg']);
                            if (res['status'] == 'success') {
                                if (obj.hasClass('btn-success')) {
                                    obj.removeClass('btn-success');
                                    obj.addClass('btn-danger');
                                    obj.text('Inactive');
                                } else {
                                    obj.removeClass('btn-danger');
                                    obj.addClass('btn-success');
                                    obj.text('Active');
                                }
                            }
                        }
                    });
                }
            });

            $(document.body).on('click', '.delete-feature', function () {
                var w = $(this);
                var filterId = w.attr('data-cid');
                var del = confirm("Are you sure you want to proceed?");
                if (del) {
                    $(document).ajaxStart($.blockUI);
                    $.ajax({
                        url: '/admin/filter-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'deletefilteroption',
                            filterId: filterId,

                        },
                        success: function (response) {
                            $(document).ajaxStop($.unblockUI);
                            response = $.parseJSON(response);
                            toastr[response['status']](response['msg']);
                            if (response['status'] == 'success') {
                                var oTable = $('#datatable_filter').dataTable();
                                oTable.fnDeleteRow(document.getElementById('filter-' + filterId));
                            }

                        }

                    });
                }
            });

        });

    </script>
    <script src="/assets/plugins/datatables/js/jquery.datatables.min.js"></script>
@endsection
