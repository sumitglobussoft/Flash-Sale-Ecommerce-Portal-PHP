<!DOCTYPE html>
<html>
<head>
    <!--<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />-->
    @include('Admin/Layouts/adminheadscripts')
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
                        <span class="error">{!! $errors->first('errMsg') !!}</span>
                        <form class="m-t-md" method="post">

                            <div class="form-group">
                                <input class="form-control" placeholder="Email" name="email">
                                <span class="error">{!! $errors->first('email') !!}</span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                                <span class="error">{!! $errors->first('password') !!}</span>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Login</button>
                            {{--<a href="/" class="display-block text-center m-t-md text-sm">Forgot Password?</a>--}}
                        </form>

                    </div>
                </div>
            </div>
            <!-- Row -->
            <div class="row">
                <div class="col-md-3 center">
                    <p class="text-center m-t-xs text-sm" style="color:#fff;">2015 &copy;Flash Sale</p>
                </div>
            </div>
        </div>
        <!-- Main Wrapper -->
    </div>
    <!-- Page Inner -->
</main>
<!-- Page Content -->

@include('Admin/Layouts/admincommonfooterscripts')

</body>
</html>