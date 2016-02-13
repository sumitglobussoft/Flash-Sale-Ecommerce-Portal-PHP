<html>
<head>
    <title>FlashSale | Supplier Details</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
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
</head>
<body>
<h3>Supplier Details</h3>

<div class="row">
    <div class="col-md-3 center">
        @if(session('error'))
            <span class="error"> {{session('error')}}</span>
        @endif
        <form class="m-t-md" method="post" action="">
            <span class="error">{!! $errors->first('registerErrMsg') !!}</span>

            <div class="form-group">
                <input name="addressline1" type="text" class="form-control" placeholder="Address Line 1"
                       value="{{ old('addressline1') }}">
                <span class="error">{!! $errors->first('addressline1') !!}</span>
            </div>
            <div class="form-group">
                <input name="addressline2" type="text" class="form-control" placeholder="Address Line 2"
                       value="{{ old('addressline2') }}">
                <span class="error">{!! $errors->first('addressline2') !!}</span>
            </div>
            <div class="form-group">
                <input name="city" type="text" class="form-control" placeholder="City" value="{{ old('city') }}">
                <span class="error">{!! $errors->first('city') !!}</span>
            </div>
            <div class="form-group">
                <input name="state" type="text" class="form-control" placeholder="State" value="{{ old('state') }}">
                <span class="error">{!! $errors->first('state') !!}</span>
            </div>
            <div class="form-group">
                <input name="country" type="text" class="form-control" placeholder="Country"
                       value="{{ old('country') }}">
                <span class="error">{!! $errors->first('country') !!}</span>
            </div>
            <div class="form-group">
                <input name="zipcode" type="text" class="form-control" placeholder="Zipcode"
                       value="{{ old('zipcode') }}">
                <span class="error">{!! $errors->first('zipcode') !!}</span>
            </div>

            <div class="form-group">
                <input name="phone" type="text" class="form-control" placeholder="Phone (Ex.:+1234XXXXXX)"
                       value="{{ old('phone') }}">
                <span class="error">{!! $errors->first('phone') !!}</span>
            </div>
            <button type="submit" class="btn btn-success btn-block m-t-xs">Submit</button><br>
            <span style="color: green;"> @if(isset($success_msg)) {{ $success_msg }} @endif</span>
        </form>
    </div>
</div>
</body>
</html>