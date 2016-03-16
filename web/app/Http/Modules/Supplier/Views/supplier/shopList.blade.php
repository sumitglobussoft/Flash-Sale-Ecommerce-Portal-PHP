@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Shop List') {{--TITLE GOES HERE--}}

@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}


    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link href="/assets/css/custom/components.css" id="style_components" rel="stylesheet" type="text/css"/>


@endsection

@section('content')

    {{--PAGE CONTENT GOES HERE--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <a href="/supplier/addNewShop" class="btn btn-success" style="float: right"><i
                                class="fa fa-plus "></i>&nbsp;Add New
                        Shop
                    </a><br><br><br>
                    <table id="available_shop" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Shop Name</th>
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
            $('#available_shop').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "/supplier/ajaxHandler",
                    data: {
                        method: 'available_Shop'
                    },
                },
            });

            $(document.body).on('click', '.customer-status', function () {

                var obj = $(this);
                var ShopId = $(this).attr('data-id');
                var status = 0;
                if (obj.hasClass('btn-success')) {
                    status = 2;
                } else if (obj.hasClass('btn-danger')) {
                    status = 1;
                }
                if (status == 1 || status == 2) {
                    $.ajax({
                        url: '/supplier/ajaxHandler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changeShopStatus',
                            ShopId: ShopId,
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

//            $(document.body).on('click', '.delete-shop', function () {
//                //   alert("cfh");
//                var obj = $(this);
//                var ShopId = $(this).attr('data-cid');
//                //alert(UserId);
//
//                $.ajax({
//                    url: '/supplier/ajaxHandler',
//                    type: 'POST',
//                    datatype: 'json',
//                    data: {
//                        method: 'changeShopStatus',
//                        ShopId: ShopId,
//                        status: 4
//                    },
//                    success: function (response) {
//                        response = $.parseJSON(response);
//                        toastr[response['status']]("Shop Deleted Successfully");
//                        if (response['status'] == "success") {
//                            obj.parents("tr").remove();
//                        }
//                    }
//                });
//
//            });


        });
    </script>



@endsection