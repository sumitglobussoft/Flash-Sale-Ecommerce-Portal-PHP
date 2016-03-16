@extends('Admin/Layouts/adminlayout')

@section('title', trans('message.manage_taxes')) {{--TITLE GOES HERE--}}

@section('headcontent')
    <link rel="stylesheet" type="text/css" href="/assets/plugins/datatables/css/jquery.datatables.min.css"/>
    <style>
        table.sorting-table {
            cursor: move;
        }

        table tr.sorting-row td {
            background-color: #8b8;
        }

        table td.sorter {
            background-color: #c4c4c4;
            width: 10px;
            cursor: move;
        }

        /*table td, th{*/
        /*text-align: center;*/
        /*}*/

        table tr.nodrag td.sorter {
            cursor: default;
            background-color: #ddd;
        }

        .sort-handler {
            float: right;
            background-color: #f80;
            width: 14px;
            height: 14px;
            margin: 2px 0 0 6px;
            cursor: move;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(empty($allTaxDetails))
                <div style="text-align: center">
                    <span class="">{{trans('message.no_tax_detail_found')}}</span><br>
                    <a href="/admin/add-tax">
                        <button class="btn btn-xs btn-success">{{trans('message.add_new_tax')}}</button>
                    </a>
                </div>
            @else
                <div class="panel panel-white">
                    <div class="panel-heading">
                        {{--<h4 class="panel-title">Currencies</h4>--}}

                        <div class="panel-control">
                            <a href="/admin/add-tax"><i class="fa fa-plus"></i>&nbsp;{{trans('message.add_new_tax')}}
                            </a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-hover" id="taxTable">
                            <thead>
                            <tr>
                                <th></th>
                                <th width="30%">{{trans('message.name')}}</th>
                                <th width="30%">{{trans('message.registration_number')}}</th>
                                <th width="20%">{{trans('message.action')}}</th>
                                <th width="20%">{{trans('message.status')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allTaxDetails as $tax)
                                <tr data-id="{{$tax->tax_id}}">
                                    <td class="sorter"></td>
                                    <td><a href="/admin/edit-tax/{{$tax->tax_id}}" style="text-decoration: none;">{{$tax->tax_name}}</a></td>
                                    <td>{{$tax->regnumber}}</td>
                                    <td>
                                        <div role="group" class="btn-group ">
                                            <button aria-expanded="false" data-toggle="dropdown"
                                                    class="btn btn-default dropdown-toggle" type="button">
                                                <i class="fa fa-cog"></i>&nbsp;
                                                <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="/admin/edit-tax/{{$tax->tax_id}}">
                                                        <i class="fa fa-pencil"></i>&nbsp;{{trans('message.edit')}} </a>
                                                </li>
                                                <li><a href="javascript:void(0);" class="delete-tax"
                                                       data-id="{{$tax->tax_id}}">
                                                        <i class="fa fa-trash"></i>&nbsp;{{trans('message.delete')}}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        @if($tax->status=='A')
                                            <button class="btn btn-success tax-status"
                                                    data-id="{{$tax->tax_id}}">{{trans('message.active')}}
                                            </button>
                                        @else
                                            <button class="btn btn-danger tax-status"
                                                    data-id="{{$tax->tax_id}}">
                                                {{trans('message.inactive')}}
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('pagejavascripts')
    <script>
        $(document).ready(function () {

            $("#taxTable").rowSorter({
                handler: "td.sorter",
                tbody: true,
                tableClass: 'sorting-table',
                dragClass: 'sorting-row',
                stickTopRows: 0,
                stickBottomRows: 0,
                onDragStart: null,
                onDrop: function (tbody, row, index, oldIndex) {
                    var position = [];
                    $.each($('tbody tr'), function (i, a) {
                        position[i] = $(this).attr('data-id');
                    });
                    $(document).ajaxStart($.blockUI);
                    $.ajax({
                        url: '/admin/tax-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changePosition',
                            position: position,
                        },
                        success: function (response) {
                            $(document).ajaxStop($.unblockUI);
                            response = $.parseJSON(response);
                            toastr[response['status']](response['msg']);
                        },
                        error: function (response) {
                            $(document).ajaxStop($.unblockUI);
//                            toastr["error"]("Sorry an exception occurred, please reload the page try again.");
                        }
                    });
                }
            });


            $(document.body).on("click", ".tax-status", function () {
                var obj = $(this);
                var tax_id = $(this).attr('data-id');
                var status = 0;
                if (obj.hasClass('btn-success')) {
                    status = 'D';
                } else if (obj.hasClass('btn-danger')) {
                    status = 'A';
                }
                if (status == 'A' || status == 'D') {
                    $(document).ajaxStart($.blockUI);
                    $.ajax({
                        url: '/admin/tax-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changeTaxStatus',
                            tax_id: tax_id,
                            status: status
                        },
                        success: function (response) {
                            $(document).ajaxStop($.unblockUI);
                            response = $.parseJSON(response);
                            toastr[response['status']](response['msg']);
                            if (response['status'] == "success") {
                                if (obj.hasClass('btn-success')) {
                                    obj.removeClass('btn-success');
                                    obj.addClass('btn-danger');
                                    obj.text('{{trans('message.inactive')}}');
                                } else {
                                    obj.removeClass('btn-danger');
                                    obj.addClass('btn-success');
                                    obj.text('{{trans('message.active')}}');
                                }
                            }
                        },
                        error: function (response) {
                            $(document).ajaxStop($.unblockUI);
//                            toastr["error"]("Sorry an exception occurred, please reload the page try again.");
                        }
                    });
                }
            });

            $(document.body).on("click", ".delete-tax", function () {
                var obj = $(this);
                var tax_id = $(this).attr('data-id');
                var x = confirm("Are you sure you want to proceed?");
                if (x) {
                    $(document).ajaxStart($.blockUI);
                    $.ajax({
                        url: '/admin/tax-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'deleteTax',
                            tax_id: tax_id
                        },
                        success: function (response) {
                            $(document).ajaxStop($.unblockUI);
                            response = $.parseJSON(response);
                            toastr[response['status']](response['msg']);
                            if (response['status'] == 'success') {
                                obj.parents('tr').remove();
                            }
                        },
                        error: function (response) {
                            $(document).ajaxStop($.unblockUI);
//                            toastr["error"]("Sorry an exception occurred, please reload the page try again.");
                        }
                    });
                }
            });
        });

    </script>
    <script src="/assets/plugins/row-sorter/RowSorter.js"></script>
@endsection
