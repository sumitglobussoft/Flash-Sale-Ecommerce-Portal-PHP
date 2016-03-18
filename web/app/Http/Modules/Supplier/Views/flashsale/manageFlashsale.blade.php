@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Manage FlashSale')

@section('pageheadcontent')
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
                    <a href="/supplier/add-flashsale" class="btn btn-success"><i
                                class="fa fa-plus "></i>&nbsp; Add New Flashsale
                    </a>
                    <table id="available_language" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Campaign Name</th>
                            <th>SupplierName</th>
                            <th>Discount Type</th>
                            <th>Discount Value</th>
                            <th>Available From</th>
                            <th>Available Upto</th>
                            <th>For Categories</th>
                            <th>Status</th>
                            <th>Action</th>
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
    <script src="/assets/js/pages/ui-nestable.js"></script>


    <script>
        $(document).ready(function () {
            $('#available_language').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "/supplier/flashsale-ajax-handler",
                    data: {
                        method: 'manageFlashsale'
                    },
                },
//                columns:  { data: 'id', name: 'id' },
//            { data: 'name', name: 'name' },
//            { data: 'email', name: 'email' },
//            { data: 'created_at', name: 'created_at' },
//            { data: 'updated_at', name: 'updated_at' }
//            ]

            });


            $(document.body).on('click', '.flashsale-status', function () {

                var obj = $(this);
                var campaignId = $(this).attr('data-id');
                var userId = $(this).attr('data-set-by');
                var status = 1;
                if (obj.hasClass('btn-success')) {
                    status = 0;
                } else if (obj.hasClass('btn-danger')) {
                    status = 1;
                }
                if (status == 1 || status == 0) {
                    $.ajax({
                        url: '/supplier/flashsale-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changeFlashsaleStatus',
                            campaignId: campaignId,
                            status: status,
                            userId: userId
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


            $(document.body).on('click', '.delete-flashsale', function () {
                var obj = $(this);
                var campaignId = $(this).attr('data-cid');
                if (confirm("Do you want to Delete Your Flashsale!") == true) {
                $.ajax({
                    url: '/supplier/flashsale-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'deleteCampaign',
                        campaignId: campaignId,
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
        });



    </script>


@endsection
