<?php $priceSymbol = getSetting('price_symbol'); $priceSymbol = $priceSymbol ? $priceSymbol : '$'; ?>

@extends('Admin/Layouts/adminlayout')

@section('title', trans('message.editing_tax').': '.(isset($taxDetails->tax_name) ? $taxDetails->tax_name : '')) {{--TITLE GOES HERE--}}

@section('headcontent')

    <style>
        table tr th {
            text-align: center;
        }
    </style>

@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}

    <div class="row">
        <div class="col-md-12">
            @if(empty($taxDetails)||!isset($taxDetails))
                <div style="text-align: center">
                    <span class="">Sorry, no such tax found.</span><br>
                    <a href="/admin/manage-taxes">
                        <button class="btn btn-xs btn-success">{{trans('message.go_back')}}</button>
                    </a>
                </div>
            @else
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div class="portlet-title tabbable-line">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">{{trans('message.general')}}</a>
                                    </li>
                                    <li><a href="#tab_1_2" data-toggle="tab">{{trans('message.tax_rates')}}</a></li>
                                </ul>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="tab-content">
                                    {{--GENERAL DETAILS TAB--}}
                                    <div class="tab-pane active" id="tab_1_1">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">{{trans('message.name')}}</label>

                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="tax_name"
                                                       name="tax_data[tax_name]"
                                                       value="{{isset(old('tax_data')['tax_name'])  ? old('tax_data')['tax_name'] : $taxDetails->tax_name}}">
                                                <span class="error">{!! $errors->first('tax_name') !!}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">{{trans('message.registration_number')}}
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                   title="Registration number of this tax in the store."></i></label>

                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="regnumber"
                                                       name="tax_data[regnumber]"
                                                       value="{{isset(old('tax_data')['regnumber'])  ? old('tax_data')['regnumber'] : $taxDetails->regnumber}}">
                                                <span class="error">{!! $errors->first('regnumber') !!}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">{{trans('message.priority')}}</label>

                                            <div class="col-sm-4">
                                                <input type="text" class="form-control integer-type" id="priority"
                                                       name="tax_data[priority]"
                                                       value="{{isset(old('tax_data')['priority'])  ? old('tax_data')['priority'] : $taxDetails->priority}}">
                                                <span class="error">{!! $errors->first('priority') !!}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">{{trans('message.rates_depend_on')}}</label>

                                            <div class="col-sm-4">
                                                <select name="tax_data[address_type]" class="form-control m-b-sm"
                                                        id="address_type">
                                                    <?php
                                                    $taxType = array('S' => 'Shipping address', 'B' => 'Billing address');
                                                    $oldTaxAddressType = (isset(old('tax_data')['address_type'])) ? old('tax_data')['address_type'] : $taxDetails->address_type;
                                                    ?>
                                                    @foreach($taxType as $key=>$value)
                                                        <option value="{{$key}}"
                                                                @if($oldTaxAddressType==$key) selected @endif>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">{{trans('message.status')}}</label>

                                            <div class="col-sm-4">
                                                <select name="tax_data[status]" class="form-control m-b-sm" id="status">
                                                    <?php
                                                    $taxStatus = array('A' => 'Active', 'D' => 'Disabled');
                                                    $oldTaxStatus = (isset(old('tax_data')['status'])) ? old('tax_data')['status'] : $taxDetails->status;
                                                    ?>
                                                    @foreach($taxStatus as $key=>$value)
                                                        <option value="{{$key}}"
                                                                @if($key==$oldTaxStatus) selected @endif>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">{{trans('message.price_includes_tax')}}</label>

                                            <div class="col-sm-4">
                                                <?php $oldTaxStatus = !empty(old()) ? (isset(old('tax_data')['price_includes_tax']) ? 'Y' : 'N') : $taxDetails->price_includes_tax; ?>
                                                <input type="checkbox" class="form-control"
                                                       name="tax_data[price_includes_tax]"
                                                       value="Y"
                                                       @if($oldTaxStatus=='Y') checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                    {{--//GENERAL DETAILS TAB--}}
                                    {{--TAX_RATE TAB--}}
                                    <div class="tab-pane" id="tab_1_2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>{{trans('message.location')}}</th>
                                                    <th>{{trans('message.rate_value')}}</th>
                                                    <th>{{trans('message.type')}}</th>
                                                    <th>{{trans('message.extra')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody id="taxRatesTBody">
                                                @if(isset(old('tax_data')['tax_rates'])
                                                    && (current(old('tax_data')['tax_rates'])['country_id']!=''
                                                    || current(old('tax_data')['tax_rates'])['rate_value']!=''))
                                                    @foreach(old('tax_data')['tax_rates'] as $taxRateKey=>$taxRateValue)
                                                        @if($taxRateValue['country_id']!=''||$taxRateValue['rate_value']!='')
                                                            <tr>
                                                                <td>
                                                                    <select name="tax_data[tax_rates][{{$taxRateKey}}][country_id]"
                                                                            class="form-control country_list"
                                                                            data-id="{{$taxRateValue['country_id']}}">
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control float-type"
                                                                           name="tax_data[tax_rates][{{$taxRateKey}}][rate_value]"
                                                                           value="{{$taxRateValue['rate_value']}}">
                                                                    <span class="error">{!! $errors->first('tax_rates . '.$taxRateKey.' . rate_value') !!}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="col-sm-12">
                                                                        <select name="tax_data[tax_rates][{{$taxRateKey}}][type]"
                                                                                class="form-control">
                                                                            <?php $types = array('F' => 'Absolute(' . $priceSymbol . ')', 'P' => 'Percent(%)'); ?>
                                                                            @foreach($types as $key=>$value)
                                                                                <option value="{{$key}}"
                                                                                        @if(isset(old('tax_data')['tax_rates'])&&$key==old('tax_data')['tax_rates'][$taxRateKey]['type']) selected @endif>{{$value}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);"
                                                                       class="col-sm-1 add-more">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                       class="col-sm-1 remove">
                                                                        <i class="fa fa-remove"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @if($taxDetails->tax_rates!='')
                                                        <?php $taxRates = json_decode($taxDetails->tax_rates, true);?>
                                                        @foreach($taxRates as $taxRateKey=>$taxRateValue)
                                                            <tr>
                                                                <td>
                                                                    <select name="tax_data[tax_rates][{{$taxRateKey}}][country_id]"
                                                                            class="form-control country_list"
                                                                            data-id="{{$taxRateValue['country_id']}}">
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control float-type"
                                                                           name="tax_data[tax_rates][{{$taxRateKey}}][rate_value]"
                                                                           value="{{$taxRateValue['rate_value']}}">
                                                                    <span class="error">{!! $errors->first('tax_rates . '.$taxRateKey.' . rate_value') !!}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="col-sm-12">
                                                                        <select name="tax_data[tax_rates][{{$taxRateKey}}][type]"
                                                                                class="form-control">
                                                                            <?php $types = array('F' => 'Absolute(' . $priceSymbol . ')', 'P' => 'Percent(%)'); ?>
                                                                            @foreach($types as $key=>$value)
                                                                                <option value="{{$key}}"
                                                                                        @if($key==$taxRateValue['type']) selected @endif>{{$value}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);"
                                                                       class="col-sm-1 add-more">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                       class="col-sm-1 remove">
                                                                        <i class="fa fa-remove"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>
                                                                <select name="tax_data[tax_rates][0][country_id]"
                                                                        class="form-control country_list" data-id="">
                                                                    <option value="0">
                                                                        Default destination (all countries)
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control float-type"
                                                                       name="tax_data[tax_rates][0][rate_value]">
                                                            </td>
                                                            <td>
                                                                <div class="col-sm-12">
                                                                    <select name="tax_data[tax_rates][0][type]"
                                                                            class="form-control">
                                                                        <option value="F">Absolute ({{$priceSymbol}})
                                                                        </option>
                                                                        <option value="P">Percent (%)</option>
                                                                    </select>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);" class="col-sm-1 add-more">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                                <a href="javascript:void(0);" class="col-sm-1 remove">
                                                                    <i class="fa fa-remove"></i>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                    @endif
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{--//TAX_RATE TAB--}}

                                </div>
                                <div class="form-actions" align="center">
                                    <button type="submit" class="btn btn-primary">{{trans('message.save')}}</button>
                                    <a href="/admin/manage-taxes" class="btn btn-default">{{trans('message.cancel')}}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection


@section('pagejavascripts')
    <script>
        $(document).ready(function () {
            var countryList = new Object();
            $.ajax({
                url: '/admin/settings-ajax-handler',
                type: 'POST',
                datatype: 'json',
                data: {
                    method: 'getLocations',
                    location_type: 0
                },
                success: function (response) {
                    countryList = $.parseJSON(response);
                    if (countryList != '') {
                        $.each($(".country_list"), function (i, v) {
                            var obj = $(this);
                            var appendCountries = '<option value = "0">Default destination(all countries)</option>';
                            $.each(countryList, function (index, value) {
                                appendCountries += '<option value = "' + value['location_id'] + '"' + ((obj.attr('data-id') == value['location_id']) ? 'selected' : '') + '>' + value['name'] + ' </option> ';
                            });
                            $(this).append(appendCountries);
                        });
                    }
                }
            });


            var taxRatesCounter = $("#taxRatesTBody tr").length;
            $(document.body).on('click', '.add-more', function () {
                var obj = $(this);
                var toAppendNewTableRow = '<tr>';
                toAppendNewTableRow += '<td><select name = "tax_data[tax_rates][' + taxRatesCounter + '][country_id]" class="form-control country_list" data-id = "">';
                toAppendNewTableRow += '<option value =""> Select country </option> ';
                toAppendNewTableRow += '<option value ="0">Default destination(all countries)</option> ';

                if (countryList != '') {
                    $.each(countryList, function (index, value) {
                        toAppendNewTableRow += '<option value = "' + value['location_id'] + '">' + value['name'] + '</option>';
                    });
                }

                toAppendNewTableRow += '</select> ';
                toAppendNewTableRow += '</td> ';
                toAppendNewTableRow += '<td> ';
                toAppendNewTableRow += '<input type="text" class="form-control float-type" name="tax_data[tax_rates][' + taxRatesCounter + '][rate_value]">';
                toAppendNewTableRow += '</td>';

                toAppendNewTableRow += '<td> ';
                toAppendNewTableRow += '<div class="col-sm-12"> ';
                toAppendNewTableRow += '<select name="tax_data[tax_rates][' + taxRatesCounter + '][type]" class="form-control">';
                toAppendNewTableRow += '<option value ="F">Absolute({{$priceSymbol}})</option>';
                toAppendNewTableRow += '<option value ="P"> Percent( % )</ option > ';
                toAppendNewTableRow += '</select>';
                toAppendNewTableRow += '</div> ';
                toAppendNewTableRow += '</td>';
                toAppendNewTableRow += '<td> ';
                toAppendNewTableRow += '<a href="javascript:void(0);" class= "col-sm-1 add-more"><i class = "fa fa-plus"></i></a>';
                toAppendNewTableRow += '<a href="javascript:void(0);" class= "col-sm-1 remove"><i class = "fa fa-remove"></i></a>';
                toAppendNewTableRow += '</td> ';

                toAppendNewTableRow += ' </tr>';

                $("#taxRatesTBody").append(toAppendNewTableRow);
                taxRatesCounter++;
            });

            $(document.body).on('click', '.remove', function () {
                var count = $('#taxRatesTBody').children('tr').length;
                if (count > 1) {
                    $(this).closest('tr').remove();
                }
            });

            if ($(".tab-content").find('.error').text()) {
                $.each($(".tab-content").find('.error'), function (index, value) {
                    if ($(this).text()) {
                        $(".tab-content").children('.tab-pane').removeClass('active');
                        $(this).closest('.tab-pane').addClass('active');
                        $(".nav-tabs").children('li').removeClass('active');
                        var id = $(this).closest('.tab-pane').attr('id');
                        $.each($(".nav-tabs").children('li'), function (i, a) {
                            if (('#' + id) == $(this).children('a').attr('href'))
                                $(this).addClass('active');
                        });
                        return false;
                    }
                });
            }

        });
    </script>
@endsection
