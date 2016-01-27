<?php $weightSymbol = getSetting('weight_symbol'); $weightSymbol = $weightSymbol ? $weightSymbol : 'lbs';
$priceSymbol = getSetting('price_symbol'); $priceSymbol = $priceSymbol ? $priceSymbol : '$';
?>
@extends('Admin/Layouts/adminlayout')

@section('title', 'New Option') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}

    <style>
        table tr th {
            text-align: center;
        }

        .separator {
            font-size: 25px;
        }
    </style>
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-white">
                <div class="panel-body">

                    <div class="portlet-title tabbable-line">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1_1" data-toggle="tab">General</a></li>
                            <li><a href="#tab_1_2" data-toggle="tab">Variants</a></li>
                        </ul>
                    </div>
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="tab-content">
                            {{--GENERAL DETAILS TAB--}}
                            <div class="tab-pane active" id="tab_1_1">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="option_name"
                                               name="option_data[option_name]"
                                               value="{{old('option_data')['option_name']}}">
                                        <span class="error">{!! $errors->first('option_name') !!}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Supplier</label>

                                    <div class="col-sm-4">
                                        <select name="option_data[shop_id]" class="form-control m-b-sm">
                                            <option value="0">None</option>
                                            @if(isset($allShop))
                                                @foreach($allShop as $key=>$value)
                                                    <option value="{{$value->id}}"
                                                            @if(isset(old('option_data')['shop_id'])&&$value->id==old('option_data')['shop_id']) selected @endif>{{$value->shop_name}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Type</label>

                                    <div class="col-sm-4">
                                        <select name="option_data[option_type]" class="form-control m-b-sm"
                                                id="option_type">
                                            <?php $optionType = array('1' => 'Select box', '2' => 'Radio group', '3' => 'Check box'); ?>
                                            @foreach($optionType as $key=>$value)
                                                <option value="{{$key}}"
                                                        @if(isset(old('option_data')['option_type'])&&$key==old('option_data')['option_type']) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Description</label>

                                    <div class="col-sm-4">
                                        <textarea name="option_data[description]"
                                                  class="form-control">{{old('option_data')['description']}}</textarea>
                                        <span class="error">{!! $errors->first('description') !!}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Comment</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="comment"
                                               name="option_data[comment]"
                                               value="{{old('option_data')['comment']}}">
                                        <small>Enter your comment to appear below the option</small>
                                        <br>
                                        <span class="error">{!! $errors->first('comment') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Required</label>

                                    <div class="col-sm-4">
                                        <input type="checkbox" class="form-control" name="option_data[required]"
                                               @if(isset(old('option_data')['required'])) checked @endif>
                                    </div>
                                </div>
                            </div>
                            {{--//GENERAL DETAILS TAB--}}
                            {{--VARIANT DETAILS TAB--}}
                            <div class="tab-pane" id="tab_1_2">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price modifier / Type</th>
                                            <th>Weight modifier / Type</th>
                                            <th>Status</th>
                                            <th>Extra</th>
                                        </tr>
                                        </thead>
                                        <tbody id="variantTBody">
                                        @if(isset(old('option_data')['variants'])
                                        && (current(old('option_data')['variants'])['variant_name']!=''
                                        || current(old('option_data')['variants'])['price_modifier']!=''
                                        || current(old('option_data')['variants'])['weight_modifier']!=''))
                                            @foreach(old('option_data')['variants'] as $variantKey=>$variantValue)
                                                @if($variantValue['variant_name']!=''||$variantValue['price_modifier']!=''||$variantValue['weight_modifier']!='')
                                                    <tr>
                                                        <td><input type="text" class="form-control"
                                                                   name="option_data[variants][{{$variantKey}}][variant_name]"
                                                                   value="{{$variantValue['variant_name']}}">
                                                            <span class="error">{!! $errors->first('variants.'.$variantKey.'.variant_name') !!}</span>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-6">
                                                                    <input type="text" class="form-control"
                                                                           name="option_data[variants][{{$variantKey}}][price_modifier]"
                                                                           value="{{$variantValue['price_modifier']}}">
                                                                    <span class="error">{!! $errors->first('variants.'.$variantKey.'.price_modifier') !!}</span>
                                                                </div>
                                                                <span class="col-sm-1 separator">/</span>

                                                                <div class="col-sm-4">
                                                                    <select name="option_data[variants][{{$variantKey}}][price_modifier_type]"
                                                                            class="form-control">
                                                                        <?php $priceModifierType = array('1' => $priceSymbol, '2' => '%'); ?>
                                                                        @foreach($priceModifierType as $key=>$value)
                                                                            <option value="{{$key}}"
                                                                                    @if(isset(old('option_data')['variants'])&&$key==old('option_data')['variants'][$variantKey]['price_modifier_type']) selected @endif>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-6">
                                                                    <input type="text" class="form-control"
                                                                           name="option_data[variants][{{$variantKey}}][weight_modifier]"
                                                                           value="{{$variantValue['weight_modifier']}}">
                                                                    <span class="error">{!! $errors->first('variants.'.$variantKey.'.weight_modifier') !!}</span>
                                                                </div>
                                                                <span class="col-sm-1 separator">/</span>

                                                                <div class="col-sm-4">
                                                                    <select name="option_data[variants][{{$variantKey}}][weight_modifier_type]"
                                                                            class="form-control">
                                                                        <?php $weightModifierType = array('1' => $weightSymbol, '2' => '%'); ?>
                                                                        @foreach($priceModifierType as $key=>$value)
                                                                            <option value="{{$key}}"
                                                                                    @if(isset(old('option_data')['variants'])&&$key==old('option_data')['variants'][$variantKey]['weight_modifier_type']) selected @endif>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div class="col-sm-12">
                                                                <select name="option_data[variants][{{$variantKey}}][status]"
                                                                        class="form-control">
                                                                    <?php $status = array('1' => 'Active', '2' => 'Inactive'); ?>
                                                                    @foreach($status as $key=>$value)
                                                                        <option value="{{$key}}"
                                                                                @if(isset(old('option_data')['variants'])&&$key==old('option_data')['variants'][$variantKey]['status']) selected @endif>{{$value}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0);" class="col-sm-1 add-more"><i
                                                                        class="fa fa-plus"></i></a>
                                                            <a href="javascript:void(0);" class="col-sm-1 remove"><i
                                                                        class="fa fa-remove"></i></a>
                                                        </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td><input type="text" class="form-control"
                                                           name="option_data[variants][0][variant_name]"></td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control"
                                                                   name="option_data[variants][0][price_modifier]">
                                                        </div>
                                                        <span class="col-sm-1 separator">/</span>

                                                        <div class="col-sm-4">
                                                            <select name="option_data[variants][0][price_modifier_type]"
                                                                    class="form-control">
                                                                <option value="1">{{$priceSymbol}}</option>
                                                                <option value="2">%</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control"
                                                                   name="option_data[variants][0][weight_modifier]">
                                                        </div>
                                                        <span class="col-sm-1 separator">/</span>

                                                        <div class="col-sm-4">
                                                            <select name="option_data[variants][0][weight_modifier_type]"
                                                                    class="form-control">
                                                                <option value="1">{{$weightSymbol}}</option>
                                                                <option value="2">%</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>
                                                    <div class="col-sm-12">
                                                        <select name="option_data[variants][0][status]"
                                                                class="form-control">
                                                            <option value="1">Active</option>
                                                            <option value="2">Inactive</option>
                                                        </select>
                                                    </div>

                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" class="col-sm-1 add-more"><i
                                                                class="fa fa-plus"></i></a>
                                                    <a href="javascript:void(0);" class="col-sm-1 remove"><i
                                                                class="fa fa-remove"></i></a>
                                                </td>

                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{--//VARIANT DETAILS TAB--}}

                        </div>
                        <div class="form-actions" align="center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('pagejavascripts')
    <script>
        $(document).ready(function () {

            var variantCounter = 1;
            $(document.body).on('click', '.add-more', function () {
                var toAppendNewTableRow = '<tr>';
                toAppendNewTableRow += '<td><input type="text" class="form-control" name="option_data[variants][' + variantCounter + '][variant_name]"></td>';
                toAppendNewTableRow += '<td>';
                toAppendNewTableRow += '<div class="form-group">';
                toAppendNewTableRow += '<div class="col-sm-6">';
                toAppendNewTableRow += '<input type="text" class="form-control" name="option_data[variants][' + variantCounter + '][price_modifier]">';
                toAppendNewTableRow += '</div>';
                toAppendNewTableRow += '<span class="col-sm-1 separator">/</span>';

                toAppendNewTableRow += '<div class="col-sm-4">';
                toAppendNewTableRow += '<select name="option_data[variants][' + variantCounter + '][price_modifier_type]" class="form-control">';
                toAppendNewTableRow += '<option value="1">{{$priceSymbol}}</option>';
                toAppendNewTableRow += '<option value="2">%</option>';
                toAppendNewTableRow += '</select>';
                toAppendNewTableRow += '</div>';
                toAppendNewTableRow += '</div>';
                toAppendNewTableRow += '</td>';
                toAppendNewTableRow += '<td>';
                toAppendNewTableRow += '<div class="form-group">';
                toAppendNewTableRow += '<div class="col-sm-6">';
                toAppendNewTableRow += '<input type="text" class="form-control" name="option_data[variants][' + variantCounter + '][weight_modifier]">';
                toAppendNewTableRow += '</div>';
                toAppendNewTableRow += '<span class="col-sm-1 separator">/</span>';

                toAppendNewTableRow += '<div class="col-sm-4">';
                toAppendNewTableRow += '<select name="option_data[variants][' + variantCounter + '][weight_modifier_type]" class="form-control">';
                toAppendNewTableRow += '<option value="1">{{$weightSymbol}}</option>';
                toAppendNewTableRow += '<option value="2">%</option>';
                toAppendNewTableRow += '</select>';
                toAppendNewTableRow += '</div>';
                toAppendNewTableRow += '</div>';

                toAppendNewTableRow += '</td>';
                toAppendNewTableRow += '<td>';
                toAppendNewTableRow += '<div class="col-sm-12">';
                toAppendNewTableRow += '<select name="option_data[variants][' + variantCounter + '][status]" class="form-control">';
                toAppendNewTableRow += '<option value="1">Active</option>';
                toAppendNewTableRow += '<option value="2">Inactive</option>';
                toAppendNewTableRow += '</select>';
                toAppendNewTableRow += '</div>';

                toAppendNewTableRow += '</td>';
                toAppendNewTableRow += '<td>';
                toAppendNewTableRow += ' <a href="javascript:void(0);" class="col-sm-1 add-more"><i class="fa fa-plus"></i></a>';
                toAppendNewTableRow += ' <a href="javascript:void(0);" class="col-sm-1 remove"><i class="fa fa-remove"></i></a>';
                toAppendNewTableRow += '</td>';

                toAppendNewTableRow += ' </tr>';

                $("#variantTBody").append(toAppendNewTableRow);
                variantCounter++;
            });

            $(document.body).on('click', '.remove', function () {
                var count = $('#variantTBody').children('tr').length;
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
                        if (id == 'tab_1_1') {
                            $(".nav-tabs").children('li').first().addClass('active');
                        } else {
                            $(".nav-tabs").children('li').last().addClass('active');
                        }
                        return false;
                    }
                });
            }
        });
    </script>
@endsection
