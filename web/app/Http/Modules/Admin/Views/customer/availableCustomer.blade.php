@extends('Admin/Layouts/adminlayout')

@section('title', trans('message.available_customer')) {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}


    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

@endsection

@section('content')

    {{--PAGE CONTENT GOES HERE--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <a href="/admin/add-new-customer" class="btn btn-success"><i class="fa fa-plus "></i>&nbsp;{{trans('message.add_new_customer')}}
                    </a>
                    <table id="available_customer" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>UserName</th>
                            <th>Email</th>
                            <th>Register Date</th>
                            <th>Action</th>
                            <th>Status</th>
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

    <script>
        $(document).ready(function () {
            $('#available_customer').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "/admin/customer-ajax-handler",
                    data: {
                        method: 'availableCustomer'
                    },
                },
//                columns:  { data: 'id', name: 'id' },
//            { data: 'name', name: 'name' },
//            { data: 'email', name: 'email' },
//            { data: 'created_at', name: 'created_at' },
//            { data: 'updated_at', name: 'updated_at' }
//            ]


            });

            $(document.body).on('click', '.customer-status', function () {

                var obj = $(this);
                var UserId = $(this).attr('data-id');
                var statusSetBy = $(this).attr('data-set-by');
                var status = 0;
                if (obj.hasClass('btn-success')) {
                    status = 1;
                } else if (obj.hasClass('btn-danger')) {
                    status = 2;
                }
                if (status == 1 || status == 2) {
                    $.ajax({
                        url: '/admin/customer-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changeCustomerStatus',
                            UserId: UserId,
                            status: status,
                            statusSetBy:statusSetBy
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

                $(document.body).on('click', '.delete-user', function () {
                    var obj = $(this);
                    var UserId = $(this).attr('data-cid');
                    if (confirm("Do you want to Delete Customer!") == true) {
                        $.ajax({
                            url: '/admin/customer-ajax-handler',
                            type: 'POST',
                            datatype: 'json',
                            data: {
                                method: 'deleteUserStatus',
                                UserId: UserId,
                            },
                            success: function (response) {
                                response = $.parseJSON(response);
                                if (response) {
                                    toastr[response['status']](response['msg']);
                                    window.location.reload();
                                }
                            }
                        });
                    }
                });

            });
        });
    </script>
@endsection
