@extends('Admin/Layouts/adminlayout')

@section('title', 'Manage Currencies') {{--TITLE GOES HERE--}}

@section('headcontent')
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
            @if(empty($allCurrencies))
                <div style="text-align: center">
                    <span class="">Sorry, no currency detail found.</span><br>
                    <a href="/admin/add-currency" class="btn btn-info">Add currency</a>
                </div>
            @else
                <div class="panel panel-white">
                    <div class="panel-heading">
                        {{--<h4 class="panel-title">Currencies</h4>--}}

                        <div class="panel-control">
                            <a href="/admin/add-currency" class="btn btn-info">Add currency</a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped" id="currencyTable">
                            <tbody>
                            @foreach($allCurrencies as $currency)
                                <tr data-id="{{$currency->currency_id}}">
                                    <td class="sorter"></td>
                                    <td>{{$currency->currency_name}}</td>
                                    <td>
                                        {{$currency->currency_code.
                                        ', Rate: '.number_format(
                                        $currency->coefficient,
                                        $currency->decimals,
                                        $currency->decimals_separator,
                                        $currency->thousands_separator
                                        ).', Sign: '.$currency->symbol}}
                                    </td>
                                    <td style="text-align: center">
                                        <div role="group" class="btn-group ">
                                            <button aria-expanded="false" data-toggle="dropdown"
                                                    class="btn btn-default dropdown-toggle" type="button">
                                                <i class="fa fa-cog"></i>&nbsp;
                                                <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="/admin/edit-currency/{{$currency->currency_id}}"><i
                                                                class="fa fa-pencil"
                                                                data-id="{{$currency->currency_id}}"></i>&nbsp;Edit</a>
                                                </li>
                                                @if($currency->is_primary!='Y')
                                                    <li><a href="javascript:void(0);" class="delete-currency"
                                                           data-id="{{$currency->currency_id}}"><i
                                                                    class="fa fa-trash"></i>&nbsp;Delete</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        @if($currency->status=='1')
                                            <button class="btn btn-success currency-status"
                                                    data-id="{{$currency->currency_id}}">Active
                                            </button>
                                        @elseif($currency->status=='2')
                                            <button class="btn btn-danger currency-status"
                                                    data-id="{{$currency->currency_id}}">
                                                Inactive
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

            $("#currencyTable").rowSorter({
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
                        url: '/admin/currency-ajax-handler',
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


            $(document.body).on("click", ".currency-status", function () {
                var obj = $(this);
                var currencyId = $(this).attr('data-id');
                var status = 0;
                if (obj.hasClass('btn-success')) {
                    status = 2;
                } else if (obj.hasClass('btn-danger')) {
                    status = 1;
                }
                if (status == 1 || status == 2) {
                    $(document).ajaxStart($.blockUI);
                    $.ajax({
                        url: '/admin/currency-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'changeCurrencyStatus',
                            currencyId: currencyId,
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
                                    obj.text('Inactive');
                                } else {
                                    obj.removeClass('btn-danger');
                                    obj.addClass('btn-success');
                                    obj.text('Active');
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

            $(document.body).on("click", ".delete-currency", function () {
                var obj = $(this);
                var currencyId = $(this).attr('data-id');
                var x = confirm("Are you sure you want to proceed?");
                if (x) {
                    $(document).ajaxStart($.blockUI);
                    $.ajax({
                        url: '/admin/currency-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'deleteCurrency',
                            currencyId: currencyId
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
