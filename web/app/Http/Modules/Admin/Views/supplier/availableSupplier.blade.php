@extends('Admin/Layouts/adminlayout')

@section('title', 'Available Supplier') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}


    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link href="/assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>

@endsection

@section('content')

    {{--PAGE CONTENT GOES HERE--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <a href="/admin/add-new-supplier" class="btn btn-success"><i class="fa fa-plus "></i>&nbsp;Add New
                        Supplier
                    </a>
                    <table id="available_supplier" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>SupplierName</th>
                            <th>Email</th>
                            <th>Register Date</th>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Supplier Details</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('pagejavascripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/3d-bold-navigation/js/main.js"></script>
    <script src="/assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
    {{--<script src="/assets/js/modern.min.js"></script>--}}

    <script>
        $(document).ready(function () {
            $('#available_supplier').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "/admin/supplier-ajax-handler",
                    data: {
                        method: 'availableSupplier'
                    },
                },
//                columns:  { data: 'id', name: 'id' },
//            { data: 'name', name: 'name' },
//            { data: 'email', name: 'email' },
//            { data: 'created_at', name: 'created_at' },
//            { data: 'updated_at', name: 'updated_at' }
//            ]


            });

            $(document.body).on("click", ".modaldescription", function () {
                var desc = $(this).attr('data-desc');
                $('#description').val(desc);

            });


            $(document.body).on('click', '.supplier-status', function () {

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
                        url: '/admin/supplier-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changeSupplierStatus',
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

                $(document.body).on('click', '.delete-supplier', function () {
                    //   alert("cfh");
                    var obj = $(this);
                    var UserId = $(this).attr('data-cid');
                    alert(UserId);

                    $.ajax({
                        url: '/admin/supplier-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'deleteSupplierStatus',
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

            });
        });
    </script>
@endsection
