<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    @include('Supplier/layouts/supplierheadscripts')

</head>
<body class="page-login">
<main class="page-content">
    <div class="page-inner bg-color">
        <div id="main-wrapper">
            <div class="row" style="margin-top: 10%;">
                <div class="col-md-3 center">
                    <div class="login-box">
                        <a href="/" class="logo-name text-lg text-center">Flash Sale</a>

                        <p class="text-center m-t-md">Please login into your account.</p>

                        <form class="m-t-md" method="post" action="login">
                            <div class="form-group">
                                <input class="form-control" placeholder="Email or Username" name="emailOrUsername"
                                       value="{{old('emailOrUsername')}}" required>
                                <span class="error">{!! $errors->first('emailOrUsername') !!}</span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" name="password" required>
                            </div>
                            <span class="error">{!! $errors->first('errMsg') !!}</span>

                            <div class="form-group">
                                <input type="checkbox" name="remember"> Remember me
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Login</button>
                            {{--<a href="forgot.html" class="display-block text-center m-t-md text-sm">Forgot Password?</a>--}}
                            <p class="text-center m-t-xs text-sm">Do not have an account?</p>
                            <a href="register" class="btn btn-default btn-block m-t-md">Create an account</a>
                        </form>
                        <p class="text-center m-t-xs text-sm">2015 &copy; Flash Sale</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Wrapper -->
    </div>
    <!-- Page Inner -->
</main>
<!-- Page Content -->

@include('Supplier/layouts/suppliercommonfooterscripts')

</body>
</html>