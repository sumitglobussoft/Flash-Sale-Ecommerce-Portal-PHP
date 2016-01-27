@extends('Admin/Layouts/adminlayout')

@section('title', 'Editing currency: '.(isset($currencyDetails->currency_name) ? $currencyDetails->currency_name : '')) {{--TITLE GOES HERE--}}

@section('headcontent')
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}
    <div class="row">
        <div class="col-md-12">
            @if(empty($currencyDetails)||!isset($currencyDetails))
                <div style="text-align: center">
                    <span class="">Sorry, no such currency detail found.</span><br>
                    <a href="/admin/manage-currencies">
                        <button class="btn btn-xs btn-success">Go back</button>
                    </a>
                </div>
            @else
                <div class="panel panel-white">
                    <div class="panel-body">
                        <form class="form-horizontal" method="post">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="currency_name">Name</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="currency_name"
                                               name="currency_data[currency_name]"
                                               value="{{isset(old('currency_data')['currency_name'])  ? old('currency_data')['currency_name'] : $currencyDetails->currency_name}}">
                                        <span class="error">{!! $errors->first('currency_name') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="currency_code">Code</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="currency_code"
                                               name="currency_data[currency_code]"
                                               value="{{isset(old('currency_data')['currency_code'])  ? old('currency_data')['currency_code'] : $currencyDetails->currency_code}}"
                                               onkeyup="var matches = this.value.match(/^(\w*)/gi);  if (matches) this.value = matches;">
                                        <span class="error">{!! $errors->first('currency_code') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="is_primary">Primary currency:</label>

                                    <div class="col-sm-4">
                                        <input type="checkbox" class="form-control" id="is_primary"
                                               name="currency_data[is_primary]" value="Y"
                                               @if($currencyDetails->is_primary=='Y') checked @endif>
                                        @if($currencyDetails->is_primary=='Y')
                                            <input type="hidden" name="is_primary_old" value="Y">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="coefficient">Rate</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="coefficient"
                                               name="currency_data[coefficient]"
                                               value="{{isset(old('currency_data')['coefficient'])  ? old('currency_data')['coefficient'] : $currencyDetails->coefficient}}"
                                               @if($currencyDetails->is_primary=='Y') disabled @endif>
                                        <span class="error">{!! $errors->first('coefficient') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="symbol">Sign</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="symbol"
                                               name="currency_data[symbol]"
                                               value="{{isset(old('currency_data')['symbol'])  ? old('currency_data')['symbol'] : $currencyDetails->symbol}}">
                                        <span class="error">{!! $errors->first('symbol') !!}</span>
                                    </div>
                                </div>
                                {{--<div class="form-group">--}}
                                {{--<label class="col-sm-2 control-label" for="after">After sum--}}
                                {{--<i class="fa fa-question-circle" data-toggle="tooltip"--}}
                                {{--title="If enabled, the symbol of the currency shown after the sum."></i></label>--}}

                                {{--<div class="col-sm-4">--}}
                                {{--<input type="checkbox" class="form-control" id="after"--}}
                                {{--name="currency_data[after]" value="Y">--}}
                                {{--<span class="error">{!! $errors->first('after') !!}</span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Status</label>

                                    <div class="col-sm-4">
                                        <?php $status = [1 => 'Active', 2 => 'Inactive']; ?>
                                        @foreach($status as $key => $value)
                                            <label for="status_{{strtolower($value)}}" class="col-sm-6">
                                                <input type="radio" class="form-control"
                                                       id="status_{{strtolower($value)}}"
                                                       name="currency_data[status]" value="{{$key}}"
                                                       @if($key==$currencyDetails->status) checked @endif>
                                                {{$value}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="thousands_separator">Ths sign
                                        <i class="fa fa-question-circle" data-toggle="tooltip"
                                           title="Thousands separator."></i></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="thousands_separator"
                                               name="currency_data[thousands_separator]"
                                               value="{{isset(old('currency_data')['thousands_separator'])  ? old('currency_data')['thousands_separator'] : $currencyDetails->thousands_separator}}">
                                        <span class="error">{!! $errors->first('thousands_separator') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="decimals_separator">Dec sign
                                        <i class="fa fa-question-circle" data-toggle="tooltip"
                                           title="Decimal separator."></i></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="ths_sign"
                                               name="currency_data[decimals_separator]"
                                               value="{{isset(old('currency_data')['decimals_separator'])  ? old('currency_data')['decimals_separator'] : $currencyDetails->decimals_separator}}">
                                        <span class="error">{!! $errors->first('decimals_separator') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="decimals">Decimals
                                        <i class="fa fa-question-circle" data-toggle="tooltip"
                                           title="Number of digits after the decimal sign."></i></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="decimals"
                                               name="currency_data[decimals]"
                                               value="{{isset(old('currency_data')['decimals'])  ? old('currency_data')['decimals'] : $currencyDetails->decimals}}">
                                        <span class="error">{!! $errors->first('decimals') !!}</span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions" align="center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="/admin/manage-currencies" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection


@section('pagejavascripts')


    <script>
        $(document).ready(function () {
            $("#is_primary").on('change', function () {
                $(this).parent('span').hasClass('checked') ? $("#coefficient").prop('disabled', true) : $("#coefficient").prop('disabled', false);
            });
        });
    </script>
@endsection
