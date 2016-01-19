@extends('Admin/Layouts/adminlayout')

@section('title', 'Supplier Details') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>
    {{--<link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>--}}
    {{--<link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>--}}
    <style>
        label.error {
            font-weight: normal;
            color: #FF0000 !important;
        }

        span.error {
            font-weight: normal;
            color: #FF0000 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3 center">
                @if(session('error'))
                    <span class="error"> {{session('error')}}</span>
                @endif
                    @if(Session::has('errmsg'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('succmsg') }}</p>
                    @endif
                <form class="m-t-md" method="post" action="">
                    <span class="error">{!! $errors->first('registerErrMsg') !!}</span>

                    <div class="form-group">
                        <h4 class="no-m m-b-sm m-t-lg">Address Line 1</h4>
                        <input name="addressline1" type="text" class="form-control" placeholder="Address Line 1"
                               value="{{ old('addressline1') }}">
                        <span class="error">{!! $errors->first('addressline1') !!}</span>
                    </div>
                    <div class="form-group">
                        <h4 class="no-m m-b-sm m-t-lg">Address Line 2</h4>
                        <input name="addressline2" type="text" class="form-control" placeholder="Address Line 2"
                               value="{{ old('addressline2') }}">
                        <span class="error">{!! $errors->first('addressline2') !!}</span>
                    </div>
                    <div class="form-group">
                        <h4 class="no-m m-b-sm m-t-lg">Country</h4>
                        <select class="js-example-data-array js-states form-control countryjs" id="counryId" name="country"
                                tabindex="-1"
                                style="width: 100%" value="">

                            {{--<option value="AK">Alaska</option>--}}
                            {{--<option value="HI">Hawaii</option>--}}
                        </select>

                        {{--<input name="country" type="text" class="form-control" placeholder="Country"--}}
                        {{--value="{{ old('country') }}">--}}
                        <span class="error">{!! $errors->first('country') !!}</span>
                    </div>
                    <div class="form-group">
                        <h4 class="no-m m-b-sm m-t-lg">State</h4>
                        <select class="js-example-data-array js-states form-control statejs" id="stateId" name="state"
                                tabindex="-1"
                                style="width: 100%" value="" >
                            <option value="0-1">Other</option>
                            {{--<input name="state" type="text" class="form-control" placeholder="State"--}}
                            {{--value="{{ old('state') }}">--}}
                        </select>
                        <span class="error">{!! $errors->first('state') !!}</span>
                    </div>
                    <div class="form-group">
                        <h4 class="no-m m-b-sm m-t-lg">City</h4>
                        <select class="js-example-data-array js-states form-control cityjs" id="cityId" name="city"
                                tabindex="-1"
                                style="width: 100%" value="">
                            <option value="0-1">Other</option>
                            {{----}}
                        </select>
                        <span class="error">{!! $errors->first('city') !!}</span>
                    </div>
                    <div class="form-group">
                        <h4 class="no-m m-b-sm m-t-lg">Zipcode</h4>
                        <input name="zipcode" type="text" class="form-control" placeholder="Zipcode"
                               value="{{ old('zipcode') }}">
                        <span class="error">{!! $errors->first('zipcode') !!}</span>
                    </div>

                    <div class="form-group">
                        <h4 class="no-m m-b-sm m-t-lg">Phone</h4>
                        <input name="phone" type="text" class="form-control" placeholder="Phone (Ex.:+1234XXXXXX)"
                               value="{{ old('phone') }}">
                        <span class="error">{!! $errors->first('phone') !!}</span>
                    </div>
                    <button type="submit" class="btn btn-success btn-block m-t-xs">Submit</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('pagejavascripts')
    {{--<script src="/assets/js/pages/form-select2.js"></script>--}}

    <script src="/assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>


    <script type="text/javascript">
        $(document).ready(function () {
            $('select').select2();

            $(".js-example-basic-multiple-limit").select2({
                maximumSelectionLength: 2
            });

            $(".js-example-tokenizer").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });

            var countryname = new Array();
            var countryid = new Array();
            var countryArray = new Array();
            var data = new Array();
            var id = new Array();
            $.ajax({
                url: '/admin/supplier-ajax-handler',
                type: 'POST',
                datatype: 'json',
                data: {
                    method: 'locationinfo',
                },
                success: function (response) {
                    response = $.parseJSON(response);
//                    var tempdata = "[";
                    var count = 0;
                    $.each(response, function (index, val) {
                        var tempArray = [];
                        tempArray['id'] = val.location_id;
                        tempArray['text'] = val.name;
                        data.push({id:tempArray['id'] , text:tempArray['text']});
                    });
//                    var countryNames = JSON.stringify(data);
                    $(".countryjs").select2({
                        data: data
                    });

                }

            });


            var data1 = new Array();
            $(document.body).on("change", '#counryId', function () {

                var countryId = $(this).val();
                alert(countryId);
                $.ajax({
                    url: '/admin/supplier-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'stateInfoByLocation',
                        countryId: countryId
                    },
                    success: function (response) {
                        response = $.parseJSON(response);
//console.log(response);
                        $.each(response, function (index, val) {
                            var tempArray = [];
                            tempArray['id'] = val.location_id;
                            tempArray['text'] = val.name;
                            data1.push({id:tempArray['id'] , text:tempArray['text']});
                            //data.push({id: +val.location_id + ", ", text: +val.name});

                        });
//                    countryNames = JSON.stringify(data);
                        $(".statejs").select2({
                            data: data1
                        });


                    }


                });
            });

            var data2 = new Array();
            $(document.body).on("change", '#stateId', function () {

                var countryId = $(this).val();
                $.ajax({
                    url: '/admin/supplier-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'cityInfoByLocation',
                        countryId: countryId
                    },
                    success: function (response) {
                        response = $.parseJSON(response);

                        $.each(response, function (index, val) {
                            var tempArray = [];
                            tempArray['id'] = val.location_id;
                            tempArray['text'] = val.name;
                            data2.push({id:tempArray['id'] , text:tempArray['text']});
                          //  data.push({id: +val.location_id + ", ", text: +val.name});

                        });
//                    countryNames = JSON.stringify(data);
                        $(".cityjs").select2({
                            data: data2
                        });


                    }


                });
            });

        });


        //    var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];
        // var data = [];


    </script>

@endsection




