@extends('Admin/Layouts/adminlayout')

@section('title', 'New Currency') {{--TITLE GOES HERE--}}

@section('headcontent')
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <form class="form-horizontal" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="currency_name">Name</label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="currency_name"
                                           name="currency_data[currency_name]"
                                           value="{{old('option_data')['currency_name']}}">
                                    <span class="error">{!! $errors->first('currency_name') !!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="currency_code">Code</label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="currency_code"
                                           name="currency_data[currency_code]"
                                           value="{{old('option_data')['currency_code']}}"
                                           onkeyup="var matches = this.value.match(/^(\w*)/gi);  if (matches) this.value = matches;">
                                    <span class="error">{!! $errors->first('currency_code') !!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="coefficient">Rate</label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="coefficient"
                                           name="currency_data[coefficient]"
                                           value="{{old('option_data')['coefficient']}}">
                                    <span class="error">{!! $errors->first('coefficient') !!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="symbol">Sign</label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="symbol"
                                           name="currency_data[symbol]"
                                           value="{{old('option_data')['symbol']}}">
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
                                    <label for="status_active" class="col-sm-6">
                                        <input type="radio" class="form-control" id="status_active"
                                               name="currency_data[status]" checked value="1">
                                        Active
                                    </label>
                                    <label for="status_inactive" class="col-sm-6">
                                        <input type="radio" class="form-control" id="status_inactive"
                                               name="currency_data[status]" value="2">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="thousands_separator">Ths sign
                                    <i class="fa fa-question-circle" data-toggle="tooltip"
                                       title="Thousands separator."></i></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="thousands_separator"
                                           name="currency_data[thousands_separator]">
                                    <span class="error">{!! $errors->first('thousands_separator') !!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="decimals_separator">Dec sign
                                    <i class="fa fa-question-circle" data-toggle="tooltip"
                                       title="Decimal separator."></i></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="ths_sign"
                                           name="currency_data[decimals_separator]">
                                    <span class="error">{!! $errors->first('decimals_separator') !!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="decimals">Decimals
                                    <i class="fa fa-question-circle" data-toggle="tooltip"
                                       title="Number of digits after the decimal sign."></i></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="decimals"
                                           name="currency_data[decimals]">
                                    <span class="error">{!! $errors->first('decimals') !!}</span>
                                </div>
                            </div>

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

@endsection
