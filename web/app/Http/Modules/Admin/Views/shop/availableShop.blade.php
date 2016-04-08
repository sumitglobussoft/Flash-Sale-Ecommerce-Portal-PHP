@extends('Admin/Layouts/adminlayout')

@section('title', trans('Available Shop')) {{--TITLE GOES HERE--}}

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
                    <table id="pending_shop" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Shop Name</th>
                            <th>Owned By</th>
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
            $('#pending_shop').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "/admin/shop-ajax-handler",
                    data: {
                        method: 'AvailableShop'
                    },
                },

            });

            $(document.body).on('click', '.supplier-status', function () {

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
                        url: '/admin/shop-ajax-handler',
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

            $(document.body).on('click', '.delete-shop', function () {
                //   alert("cfh");
                var obj = $(this);
                var ShopId = $(this).attr('data-cid');
                //alert(UserId);

                $.ajax({
                    url: '/admin/shop-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'changeShopStatus',
                        ShopId: ShopId,
                        status: 4
                    },
                    success: function (response) {
                        response = $.parseJSON(response);
                        toastr[response['status']]("Shop Deleted Successfully");
                        if (response['status'] == "success") {
                            obj.parents("tr").remove();
                        }
                    }
                });

            });
        });


    </script>
@endsection
