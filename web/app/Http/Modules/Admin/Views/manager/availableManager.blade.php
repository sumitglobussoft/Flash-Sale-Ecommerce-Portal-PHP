@extends('Admin/Layouts/adminlayout')

@section('title', 'Available Manager') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}


    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link href="/assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/jquery-nestable/jquery.nestable.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    {{--PAGE CONTENT GOES HERE--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <a href="/admin/add-new-manager" class="btn btn-success"><i class="fa fa-plus "></i>&nbsp;Add New
                        Manager
                    </a>
                    <table id="available_manager" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>ManagerName</th>
                            <th>Email</th>
                            <th>Register Date</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Permission</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="permissionmodal" class="modal fade" tabindex="-1" data-width="400">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Permission</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <li class="dd-item" data-id="">
                                <div class="dd-handle" id="permitid"></div>
                            </li>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn">Close</button>

                </div>
            </div>
        </div>
    </div>

@endsection


@section('pagejavascripts')

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/3d-bold-navigation/js/main.js"></script>
    <script src="/assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
    <script src="/assets/js/pages/ui-nestable.js"></script>


    <script>
        $(document).ready(function () {
            $('#available_manager').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "/admin/manager-ajax-handler",
                    data: {
                        method: 'availableManager'
                    },
                },
//                columns:  { data: 'id', name: 'id' },
//            { data: 'name', name: 'name' },
//            { data: 'email', name: 'email' },
//            { data: 'created_at', name: 'created_at' },
//            { data: 'updated_at', name: 'updated_at' }
//            ]

            });


//            $(document.body).on("click", ".modaldescription", function () {
//                var desc = $(this).attr('data-desc');
//                $('#description').val(desc);
//
//            });


            $(document.body).on('click', '.manager-status', function () {

                var obj = $(this);
                var UserId = $(this).attr('data-id');
                var status = 0;
                if (obj.hasClass('btn-success')) {
                    status = 2;
                } else if (obj.hasClass('btn-danger')) {
                    status = 1;
                }
                if (status == 1 || status == 2) {
                    $.ajax({
                        url: '/admin/manager-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changePermissionStatus',
                            UserId: UserId,
                            status: status
                        },
                        success: function (response) {
                            response = $.parseJSON(response);
                            toastr[response['status']](response['msg']);
                            if (response['status'] == "success") {
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

            $(document.body).on('click', '.delete-manager', function () {
                var obj = $(this);
                var UserId = $(this).attr('data-cid');

                $.ajax({
                    url: '/admin/manager-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'deleteStatus',
                        UserId: UserId,
                    },
                    success: function (response) {
                        response = $.parseJSON(response);
                        toastr[response['status']](response['msg']);
                        if (response['status'] == "success") {
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
            });

            var permission_detail = new Array();
            $(document.body).on('click', '.permission', function () {
                var obj = $(this);
                var UserId = $(this).attr('data-id');
                $.ajax({
                    url: '/admin/manager-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'getPermissionDetails',
                        UserId: UserId,
                    },
                    success: function (response) {
                        response = $.parseJSON(response);
                        var res = response;
//                        var fold = res.split("");
//                        $.each(res, function (index, val) {
                            // permission_details =  val['permission_details'];
//                            $.each(val, function (pindex, pval) {
//                                permission_detail =  pval;
//                            });
                           // var permit = JSON.stringify(permission_detail);
//                            var permit =  permission_detail.split(",");
//                            console.log(permit);
                            $('#permitid').html(res);
//                            console.log(permission_detail);
//                        });

//                        alert(permission_detail);
//                        console.log(permission_detail);
                    }

//                        alert(permission_details);
//                        var permit =  res.split("");
//                        $('#permitid').html(res);

                    // alert(permit);
                });

            });
        });

    </script>


@endsection
