<!DOCTYPE html>
<html>
<head>
    @include('Supplier/layouts/supplierheadscripts')
</head>
<body class="page-login">
<main class="page-content">
    <div class="page-inner bg-color">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-3 center">
                    <div class="login-box">
                        <a href="/" class="logo-name text-lg text-center">Flash Sale</a>

                        <p class="text-center m-t-md">Create a Supplier account</p>

                        <form class="m-t-md" method="post" action="">
                            <span class="error">{!! $errors->first('registerErrMsg') !!}</span>
                            <div class="form-group">
                                <input name="first_name" type="text" class="form-control" placeholder="First Name" required
                                       value="{{ old('first_name') }}">
                                <span class="error">{!! $errors->first('first_name') !!}</span>
                            </div>
                            <div class="form-group">
                                <input name="last_name" type="text" class="form-control" placeholder="Last Name" required
                                       value="{{ old('last_name') }}">
                                <span class="error">{!! $errors->first('last_name') !!}</span>
                            </div>
                            <div class="form-group">
                                <input name="email" type="email" class="form-control" placeholder="Email" required
                                       value="{{ old('email') }}">
                                <span class="error">{!! $errors->first('email') !!}</span>
                            </div>
                            <div class="form-group">
                                <input name="password" type="password" class="form-control" placeholder="Password"
                                       required>
                                <span class="error">{!! $errors->first('password') !!}</span>
                            </div>
                            <div class="form-group">
                                <input name="password_confirm" type="password" class="form-control"
                                       placeholder="Confirm Password" required>
                                <span class="error">{!! $errors->first('password_confirm') !!}</span>
                            </div>
                            <label>
                                <input type="checkbox" name="terms_and_policy"> Agree the terms and policy
                                <div class="clearfix"></div>
                                <span class="error">{!! $errors->first('terms_and_policy') !!}</span>
                            </label>
                            <button type="submit" class="btn btn-success btn-block m-t-xs">Submit</button>
                            <p class="text-center m-t-xs text-sm">Already have an account?</p>
                            <a href="login" class="btn btn-default btn-block m-t-xs">Login</a>
                        </form>
                        <p class="text-center m-t-xs text-sm">2015 &copy; Flash Sale</p>
                    </div>
                </div>
            </div>
            <!-- Row -->

        </div>
        <!-- Main Wrapper -->
    </div>
    <!-- Page Inner -->
</main>
<!-- Page Content -->

@include('Supplier/layouts/suppliercommonfooterscripts')

</body>
</html>