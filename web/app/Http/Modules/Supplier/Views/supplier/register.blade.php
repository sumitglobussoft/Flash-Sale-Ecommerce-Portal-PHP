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
                        <form class="m-t-md" method="post">
                            <div class="form-group">
                                <input name="username" type="text" class="form-control" placeholder="Name" required >
                                <span class="error">{!! $errors->first('username') !!}</span>
                            </div>
                            <div class="form-group">
                                <input name="email" type="email" class="form-control" placeholder="Email" required >
                                <span class="error">{!! $errors->first('email') !!}</span>
                            </div>
                            <div class="form-group">
                                <input name="password" type="password" class="form-control" placeholder="Password" required>
                                <span class="error">{!! $errors->first('password') !!}</span>
                            </div>
                            <label>
                                <input type="checkbox"> Agree the terms and policy
                            </label>
                            <button type="submit" class="btn btn-success btn-block m-t-xs">Submit</button>
                            <p class="text-center m-t-xs text-sm">Already have an account?</p>
                            <a href="login" class="btn btn-default btn-block m-t-xs">Login</a>
                        </form>
                        <p class="text-center m-t-xs text-sm">2015 &copy; Flash Sale</p>
                    </div>
                </div>
            </div><!-- Row -->

        </div><!-- Main Wrapper -->
    </div>
    <!-- Page Inner -->
</main>
<!-- Page Content -->

@include('Supplier/layouts/suppliercommonfooterscripts')

</body>
</html>