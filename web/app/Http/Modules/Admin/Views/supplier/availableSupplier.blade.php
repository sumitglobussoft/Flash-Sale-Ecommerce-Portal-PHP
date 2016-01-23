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
    <div class="modal fade" id="mymodel" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Suppliers Details:</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="panel panel-white">

                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th> Address Line 1</th>
                                            <th> Address Line 2</th>
                                            {{--<th> City</th>--}}
                                            {{--<th> State</th>--}}
                                            <th> Country</th>
                                            <th> Zipcode</th>
                                            <th> Phone</th>
                                        </tr>
                                        <tbody>

                                        <tr>
                                            <th scope="row"></th>
                                            <td id="addressline1" rowspan="2" width="300px">picture detail</td>
                                            <td id="addressline2" rowspan="2" width="300px"></td>
                                            {{--<td id="city" rowspan="2" width="300px"></td>--}}
                                            {{--<td id="state" rowspan="2" width="300px"></td>--}}
                                            <td id="country" rowspan="2" width="300px"></td>
                                            <td id="zipcode" rowspan="2" width="300px"></td>
                                            <td id="phone" rowspan="2" width="300px"></td>
                                        </tr>
                                        </tbody>
                                        </thead >
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div align="right">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                    </div>
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

            var name = new Array();
            var addressline1 = new Array();
            var addressline2 = new Array();
            var zipcode = new Array();
            var phone = new Array();
            $(document.body).on("click", ".modaldescription", function () {
                var UserId = $(this).attr('data-id');

                $.ajax({
                    url: '/admin/supplier-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'getUsermetaInfoByUserId',
                        UserId: UserId,
                    },
                    success: function (response) {
                        response = $.parseJSON(response);
                        $.each(response, function (i, v) {

                            name = v['name'];
                            addressline1 = v['addressline1'];
                            addressline2 = v['addressline2'];
                            zipcode = v['zipcode'];
                            phone = v['phone'];
                        });
                        $('#addressline1').html(addressline1);
                        $('#addressline2').html(addressline2);
                        $('#country').html(name);
                        $('#zipcode').html(zipcode);
                        $('#phone').html(phone);
                    }

                });

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
            });

            $(document.body).on('click', '.delete-supplier', function () {
                var obj = $(this);
                var UserId = $(this).attr('data-cid');

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
    </script>
@endsection
