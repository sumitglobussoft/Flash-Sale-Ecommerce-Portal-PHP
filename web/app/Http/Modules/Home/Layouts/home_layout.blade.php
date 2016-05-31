{{--<html>--}}
{{--<head>--}}
    @include('Home/Layouts/home_header_scripts')
    @yield('pageheadcontent')
{{--</head>--}}
<body>

<nav class="navbar navbar-inverse">
    <div class="container nh1">
        <div class="navbar-header nh2">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#">
                <img src="/assets/images/logo.png" alt="logo">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">

            <!--navbar start -->
            <!-- <div class="navbar-header col-sm-3 col-md-2 t-a-r">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

            </div>-->

            <!--only for mobile-->
            <!--<div class="col-xs-12 visible-xs margin-top-10">
                <ul class="remove-list-style">
                    <li><a href="">HOME</a>
                    </li>
                    <li><a href="">WOMEN</a>
                    </li>
                    <li><a href="">MEN</a>
                    </li>
                    <li><a href="">BABY &amp; KIDS</a>
                    </li>
                </ul>
            </div>-->
            <!--/only for mobile-->
            <div class='col-sm-6 col-md-6'>
                <div class="collapse navbar-collapse js-navbar-collapse navbar row">
                    <ul class="nav navbar-nav ">
                        <li><a href="#">HOME</a>
                        </li>
                        <li class="dropdown mega-dropdown">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">WOMEN <span class="caret"></span></a>
                            <ul class="dropdown-menu mega-dropdown-menu dropdown-styles">

                                <li class='col-sm-1 p-m-0 width-auto hidden-xs'>
                                    <img src=".//assets/images/drop-down-txt.png" class='img-responsive'
                                         alt="text-image">
                                </li>

                                <li class="col-sm-4 p-m-0">
                                    <ul class="display-img">
                                        <li>
                                            <a href="javascript:;"><img src="/assets/images/dd-img-3.png" alt="img-1"/>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;"><img src="/assets/images/dd-img-2.png" alt="img-2"/>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;"><img src="/assets/images/dd-img-1.png" alt="img-3"/>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="col-sm-3 p-m-0">
                                    <ul class="padd-10-a bg-color-dark">
                                        <li><a href="#">Tops</a>
                                        </li>
                                        <li><a href="#">Dresses</a>
                                        </li>
                                        <li><a href="#">Shoes</a>
                                        </li>
                                        <li><a href="#">Bags</a>
                                        </li>
                                        <li><a href="#">Glasses</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="/assets/images/dots.png" alt="more">
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="col-sm-4 p-m-0 dd-bg">
                                    <h1>SALE</h1>
                                </li>
                                <li class='col-xs-12 s-a'><a href="#" class="s-a-a">SHOW ALL</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown mega-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">MEN <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu mega-dropdown-menu dropdown-styles">

                                <li class='col-sm-1 p-m-0 width-auto hidden-xs'>
                                    <img src=".//assets/images/drop-down-txt.png" class='img-responsive'
                                         alt="text-image">
                                </li>

                                <li class="col-sm-3 p-m-0">
                                    <ul class="padd-10-a bg-color-dark">
                                        <li><a href="#">Tops</a>
                                        </li>
                                        <li><a href="#">Dresses</a>
                                        </li>
                                        <li><a href="#">Shoes</a>
                                        </li>
                                        <li><a href="#">Bags</a>
                                        </li>
                                        <li><a href="#">Glasses</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="/assets/images/dots.png" alt="more">
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="col-sm-4 p-m-0">
                                    <ul class="display-img">
                                        <li>
                                            <a href="javascript:;"><img src="/assets/images/dd-img-3.png" alt="img-1"/>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;"><img src="/assets/images/dd-img-2.png" alt="img-2"/>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;"><img src="/assets/images/dd-img-1.png" alt="img-3"/>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="col-sm-4 p-m-0 dd-bg">
                                    <h1>SALE</h1>
                                </li>
                                <li class='col-xs-12 s-a'><a href="#" class="s-a-a">SHOW ALL</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#">BABY &amp; KIDS</a>
                        </li>
                        <li><a href="#">ABOUT US</a>
                        </li>
                        <li><a href="#">CONTACT</a>
                        </li>
                    </ul>

                </div>
                <!-- /.nav-collapse -->

            </div>

            <!--navbar end -->


            <!----------------------------->
            <div class="col-md-4 pull-right pr_nav">
                <ul class="login list-inline text-uppercase" style="text-align: right;">
                    <?php if (Session::has('fs_user')){
                    $value = Session::get('fs_user')['profilepic'];
                    ?>
                    <li style="text-align: left;">
                        <a href="javascript:void(0)" id="showdetails" class="white_color"><img
                                    src="<?php if ($value != '') {
                                        echo $value;
                                    } else {
                                        echo "http://placehold.it/350x150";
                                    }?>" style="height:30px; width:30px;" class="img-circle"
                                    id="user_profile_pic_id"/>Hello
                            <?php echo(Session::get('fs_user')['username']); ?><span
                                    id="triangle_down">&#9660;</span>
                            <span id="triangle_up" style="display:none;">&#9650;</span></a>

                        <div id="userpanel" class="left-panel click_panel" style="display: none;">
                            <!--body panel-->
                            <div class="body-user">
                                <div class="content-body-user text-overflow admin-dropdwn">
                                    <ul class="list-unstyled">
                                        <li><a href="/profile-setting" class="white_color"><i
                                                        class="fa fa-user white_color"></i>&nbsp;&nbsp;{{ trans('message.my_account') }}
                                            </a></li>
                                        <li><a href="#" class="white_color"><i
                                                        class="fa fa-heart white_color"></i>&nbsp;&nbsp;{{ trans('my_wishlist') }}
                                            </a>
                                        </li>
                                        <li><a href="#" class="white_color"><i
                                                        class="fa fa-truck white_color"></i>&nbsp;&nbsp;{{ trans('message.my_orders') }}
                                            </a>
                                        </li>
                                        <li><a href="#" class="white_color"><i
                                                        class="fa fa-outdent white_color"></i>&nbsp;&nbsp;{{ trans('message.my_tickets') }}
                                            </a>
                                        </li>
                                        <li><a href="#" class="white_color"><i
                                                        class="fa fa-bullhorn white_color"></i>&nbsp;&nbsp;{{ trans('message.add_new_ticket') }}
                                            </a>
                                        </li>
                                        <li><a href="#" class="white_color"><i
                                                        class="fa fa-envelope white_color"></i>&nbsp;&nbsp;{{ trans('message.newsletter') }}
                                            </a>
                                        </li>
                                        <li><a href="/logout" class="white_color"><i
                                                        class="fa fa-key white_color"></i>&nbsp;&nbsp;{{ trans('message.logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--body panel-->
                        </div>
                    </li>

                    <?php } else { ?>
                    <div class="col-md-8 pull-right">
                        <div id="login" class="col-md-3 _login">
                            <a id="login-trigger" href="#">{{ trans('message.login') }}<i class="fa fa-angle-down"
                                                                                          aria-hidden="true"></i>
                            </a>
                            <div id="login-content">
                                <form class="signin_form" method="post" id="userloginform">
                                    <fieldset id="inputs">
                                        <div class="form-group">
                                            <label class="signemail">{{ trans('message.username') }}
                                                or {{ trans('message.email') }}*</label>
                                            <input type="text" class="form-control white_color" id="login_email"
                                                   name="login_email"
                                                   placeholder="Username or email">
                                            <span id="login_email_err"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="login_password"
                                                   class="login_password">{{ trans('message.password') }}
                                                *</label>
                                            <input type="password" class="form-control white_color" id="login_password"
                                                   name="login_password" placeholder="Password">
                                            <span id="login_password_err"></span>
                                        </div>
                                    </fieldset>
                                    {{--<fieldset id="actions">--}}
                                    {{--<form action="">--}}
                                    <label class="radio metro-radio"><input type="radio" value="test" name="test"><span
                                                class="check"></span>Remember Me
                                    </label>
                                    {{--</form>--}}
                                    <input type="submit" value="{{ trans('message.login')}}"
                                           class="boton-color text-uppercase">
                                    <div class="clearfix"></div>
                                    <a class="pss" onClick="forgotpd()" href="#"> Forgot your password?</a>
                                    <div id="login-suc-err"></div>
                                    {{--</fieldset>--}}
                                </form>
                                <div class="forgotpd col-lg-12 hidden" style="width: 100%">
                                    <div class="col-lg-12">
                                        <h4 class="text-uppercase white_color">Forgot Password</h4>

                                        <form class="regsiter_form" method="post" id="forgotpasswordform">
                                            <div class="form-group">
                                                <label for="fp_email"
                                                       class="white_color">{{ trans('message.email') }}</label>
                                                <input type="email" class="form-control white_color" id="fp_email"
                                                       name="fp_email"
                                                       placeholder="Email">
                                                <span id="fp_email_err"></span>
                                            </div>
                                            <div class="resetcode hidden" id="resetcodediv">
                                                <p>
                                                    Check Mail and Enter your reset code below to Reset password
                                                </p>

                                                <div class="form-group">
                                                    <label for="fp_email" class="white_color">Reset code</label>
                                                    <input type="text" class="form-control white_color" id="resetcode"
                                                           name="resetcode"
                                                           placeholder="Reset Code">
                                                    <span id="resetcode_err"></span>
                                                </div>

                                            </div>
                                            {{--<input type="button" class="boton-color" onClick="login()" value="Back">--}}
                                            <a class="signin" onClick="login()" href="#">Back</a>
                                            {{--<a class="signin" href="#">Send</a>--}}
                                            <input type="submit" value="Send" class="boton-color">

                                            <div id="fp-suc-err"></div>
                                        </form>
                                        {{--</div>--}}

                                        {{--<div class="col-lg-6">--}}

                                    </div>
                                </div>

                                <div class="enternewpw col-lg-12 hidden" style="width: 100%">
                                    <div class="col-lg-12">
                                        <h4>Enter New Password</h4>

                                        <form class="regsiter_form" method="post" id="EnterNewPasswordform">
                                            <div class="form-group">
                                                <label for="password1" class="white_color">New Password</label>
                                                <input type="password" class="form-control white_color" id="password1"
                                                       name="password1"
                                                       placeholder="New Password">
                                                <span id="password1_err"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="password2" class="white_color">Re-enter Password</label>
                                                <input type="password" class="form-control white_color" id="password2"
                                                       name="password2"
                                                       placeholder="Re-enter Password">
                                                <span id="password2_err"></span>
                                            </div>

                                            <input type="button" class="boton-color" onClick="login()" value="Back">
                                            <input type="submit" value="Send" class="boton-color">

                                            <div id="resetpw-suc-err"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="signup" class="col-md-3 _signup ">
                            <a id="signup-trigger" href="#" data-toggle="modal"
                               data-target=".bs-example-modal-lg">{{ trans('message.register') }}</a>
                        </div>
                        <div class="col-md-6  cart">
                            <a class="index" href="#cart">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                <span>0</span>
                                <span id="cart">Cart</span>
                            </a>
                        </div>
                        <div id="custom-search-input">
                            <div class="input-group col-md-12 _search">
                                <input type="text" class="  search-query form-control" placeholder="Search"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="button">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog _mdd">
            <div class="modal-content _account">
                <div class="container-fluid">
                    <div class="row pop_account">
                        <div class="col-md-12 p_a">
                            <div class="col-md-7 pop_shadow">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="gridSystemModalLabel">{{ trans('message.signup') }}</h4>
                                </div>
                                <form class="regsiter_form" method="post" id="usersignupform">
                                    <div class="modal-body">
                                        <div class="col-md-6 first_name">
                                            <label for="firstname">{{ trans('message.firstname') }}*</label>
                                            <input type="text" class="form-control white_color" id="firstname"
                                                   name="firstname"
                                                   placeholder="First Name">
                                            <span id="first_name_err"></span>
                                        </div>
                                        <div class="col-md-6 last_name">
                                            <label for="lastname">{{ trans('message.lastname') }}*</label>
                                            <input type="text" class="form-control white_color" id="lastname"
                                                   name="lastname"
                                                   placeholder="Last Name">
                                            <span id="last_name_err"></span>
                                        </div>
                                        <div class="form-group username">
                                            <label for="username">{{ trans('message.username') }}*</label>
                                            <input type="text" class="form-control white_color" id="username"
                                                   name="username"
                                                   placeholder="Username">
                                            <span id="username_err"></span>
                                        </div>
                                        <div class="form-group email">
                                            <label for="email">{{ trans('message.email') }}*</label>
                                            <input type="text" class="form-control white_color" id="email" name="email"
                                                   placeholder="Enter your Email address">
                                            <span id="email_err"></span>
                                        </div>
                                        <div class="form-group optradio">
                                                <label for="optradio">Gender:</label>
                                                <label class="radio-inline">
                                                    <input type="radio" id="optradio" name="optradio">Female
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" id="optradio" name="optradio">Male
                                                </label>
                                        </div>
                                        <div class="form-group form-inline contact_no">
                                            <label for="contact_no">phoneNumber* : </label>
                                            <input type="telephone number" class="form-control _phone" id="contact_no" name="contact_no"
                                                   placeholder="Enter your ContactNumber" maxlength="10">
                                            <span id="contact_no"></span>
                                        </div>
                                        <div class="form-group form-inline date_of_birth">
                                            <label for="date_of_birth">Birthday:</label>
                                            <select class="form-control date_dd" id="date_dd" name="date_of_birth">
                                                <option>DD</option>
                                                <?php for($d = 1;$d <= 31;$d++){?>
                                                <option value="<?php echo $d; ?>"><?php echo $d; ?></option>
                                                <?php } ?>
                                                <span id="date_dd"></span>
                                            </select>
                                            <select class="form-control month_mm" id="month_mm" name="date_of_birth">
                                                <option>MM</option>
                                                <?php for($m = 1;$m <= 12;$m++){?>
                                                <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                                <?php } ?>
                                                <span id="month_mm"></span>
                                            </select>
                                            <select class="form-control year_yy" id="year_yy" name="date_of_birth">
                                                <option>YYYY</option>
                                                <?php
                                                $year = 1960;
                                                for($i = 1;$i <= 100;$i++){?>
                                                <option value="<?php echo $year + $i; ?>"><?php echo $year + $i; ?></option>
                                                <?php } ?>
                                                <span id="year_yy"></span>
                                            </select>
                                        </div>
                                        <div class="required">
                                            <label>*Required</label>
                                            <div class="register_button">
                                                <input type="submit" value="{{ trans('message.signup') }}"
                                                       class="boton-color text-uppercase">
                                                {{--<a class="register" href="#">Register</a>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pw-suc-err"></div>
                                </form>
                            </div>
                            <div class="col-md-5 acc_about">
                                <div class="botton_account ">
                                    <button type="button" class="close account_close " data-dismiss="modal"
                                            aria-label="Close">
                                        <img src="/assets/images/close.png">
                                    </button>
                                </div>
                                <div class="account Heading _bor_account">
                                    <h4>ABOUT US</h4>
                                </div>
                                <div class="account first_row">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum laoreet, nunc
                                    eget
                                    laoreet sa Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum
                                    laoreet,
                                    nunc eget laoreet sa
                                </div>
                                <div class="account second_row">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum laoreet, nunc
                                    eget
                                    laoreet sa Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum
                                    laoreet,
                                    nunc eget laoreet sa
                                </div>
                                <div class="account third_row">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum laoreet, nunc
                                    eget
                                    laoreet sa Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum
                                    laoreet,
                                    nunc eget laoreet sa
                                </div>
                                <div class="terms">
                                    <p>By Registering You Agree To Our <br>Terms And Condtions</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-------nAVIGATION ENDS HERE---------->
<!--/container1-->

{{------------------------------------------PAGE CONTENT STARTS HERE-----------------------------------------}}
@yield('content')
{{------------------------------------------PAGE CONTENT ENDS HERE-----------------------------------------}}


<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 footer-content">
                <div class="col-md-2 logo_section">
                    <img src="/assets/images/flogo.png" class="img-responsive">

                    <p>@2015</p>

                    <p>ALL RIGHTS RESERVED</p>
                </div>
                <div class="col-md-2 company_section">
                    <h4>company</h4>
                    <a href="#">about</a>
                    <a href="#">press</a>
                    <a href="#">careers</a>
                </div>
                <div class="col-md-2 customer_section">
                    <h4>customer services</h4>
                    <a href="#">FAQ</a>
                    <a href="#">contacts</a>
                    <a href="#">return policy</a>
                    <a href="#">taxes</a>
                </div>
                <div class="col-md-2 policiy_section">
                    <h4>policies</h4>

                    <p><a href="#">terms&amp;conditions</a></p>

                    <p><a href="#">privacy</a></p>

                    <p><a href="#">security</a></p>

                    <p><a href="#">Terms of use</a></p>
                </div>
                <div class="col-md-2 contact_section">
                    <h4>contacts us</h4>
                    <a href="#"> <i class="fa fa-linkedin-square social" aria-hidden="true"></i>Linkedin</a>
                    <a href="#"><i class="fa fa-twitter-square social" aria-hidden="true"></i>Twitter</a>
                    <a href="#"><i class="fa fa-facebook-square social" aria-hidden="true"></i>Facebook</a>
                    <a href="#"> <i class="fa fa-envelope footer_email social" aria-hidden="true"></i>email</a>
                    <a href="#"><i class="fa fa-google-plus-square social" aria-hidden="true"></i>google+</a>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal Contact -->


<!--/bodywrapper -->
@include('Home/Layouts/home_footer_scripts')
@yield('pagejavascripts')
<script type="text/javascript">

    $(".open_login_model").click(function () {
        $(".signupmodel").addClass("hidden");
        $(".loginmodel").removeClass("hidden");
        $("#dialog_modal").css("width", "90rem");
        $('#login_email').val('');
        $('#login_password').val('');
    });
    $(".open_signup_model").click(function () {
        $(".loginmodel").addClass("hidden");
        $(".signupmodel").removeClass("hidden");
        $("#dialog_modal").css("width", "60rem");
        $('#firstname').val('');
        $('#lastname').val('');
        $('#username').val('');
        $('#email').val('');
    });
    function forgotpd() {
        $("#login-content").css("width","20rem");
        $(".signin_form").addClass('hidden');
        $('.forgotpd').removeClass('hidden');
        $('.loginmodel').addClass('hidden');
        $('.enternewpw').addClass('hidden');//emailID resetcode password1 password2
        $('#fp_email').prop('disabled', false);
        $('#resetcodediv').addClass('hidden');
    }
    function login() {
//        $("#login-content").css("width", "90rem");
        $('.signin_form').removeClass('hidden');
        $('.forgotpd').addClass('hidden');
        $('.enternewpw').addClass('hidden');
        $('#fp_email').val('');
        $('#resetcode').val('');
        $('#password1').val('');
        $('#password2').val('');
        $('#fp_email').prop('disabled', false);
    }
    function enternewpw() {
        $("#login-content").css("width","20rem");
        $('.enternewpw').removeClass('hidden');
        $('.forgotpd').addClass('hidden');
        $('.signin_form').addClass('hidden');
        $('#password1').val('');
        $('#password2').val('');
        $('#fp_email').prop('disabled', false);
    }
</script>
<script type="text/javascript">

    $(document).ready(function () {

        $('#showdetails').click(function () {
            $('#userpanel').slideToggle('slow', function () {
                $("#triangle_down").toggle();
                $("#triangle_up").toggle();
            });
        });


        $.validator.addMethod("nameregex", function (value, element) {
            return this.optional(element) || /^[A-Za-z\s]+$/.test(value);
        }, "Name cannot contain special characters.");

        $.validator.addMethod("usernameregex", function (value, element) {
            return this.optional(element) || /^[A-Za-z0-9._\s]+$/.test(value);
        }, "Username cannot contain special characters.");

        $.validator.addMethod("emailregex", function (value, element) {
            return this.optional(element) || /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/.test(value);
        }, "Invalid email address.");

        $.validator.addMethod("passwordregex", function (value, element) {
            return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{7,14}$/.test(value);
        }, "Min 7 and Max 14 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character (@$!%*?&):");

        $('#forgotpasswordform').validate({
            rules: {
                fp_email: {
                    required: true,
                    emailregex: true
                },
                resetcode: {
                    required: true
                }
            },
            messages: {
                fp_email: {
                    required: "Email cannot be empty"
                },
                resetcode: {
                    required: "Reset Code cannot be empty"
                }
            }
        });

        $('#EnterNewPasswordform').validate({
            rules: {
                password1: {
                    required: true,
                    passwordregex: true
                },
                password2: {
                    required: true,
                    equalTo: "#password1"
                }
            },
            messages: {
                password1: {
                    required: "Please Enter Password"
                },
                password2: {
                    required: "Please Re-enter Password"
                }
            }
        });

        $('#usersignupform').validate({
            rules: {
                firstname: {
                    required: true,
                    nameregex: true
                },
                lastname: {
                    required: true,
                    nameregex: true
                },
                username: {
                    required: true,
                    usernameregex: true
                },
                email: {
                    required: true,
                    emailregex: true
                }
            },
            messages: {
                firstname: {
                    required: "First name required"
                },
                lastname: {
                    required: "Last name required"
                },
                username: {
                    required: "User name cannot be empty"
                },
                email: {
                    required: "Email id required"
                }
            }
        });

        $('#userloginform').validate({
            rules: {
                login_email: {
                    required: true
                },
                login_password: {
                    required: true
                }
            },
            messages: {
                login_email: {
                    required: "Username or Email cannot be empty"
                },
                login_password: {
                    required: "Password cannot be empty"
                }
            }
        });

        $("#usersignupform").submit(function (e) {
            e.preventDefault();
            var Firstname = $('#firstname').val();
            var Lastname = $('#lastname').val();
            var Username = $('#username').val();
            var Email = $('#email').val();
            var Gender = $('#optradio').val();
            var Contact = $('#contact_no').val();
            var Date = $('#date_dd').val();
            var Month = $('#month_mm').val();
            var Year = $('#year_yy').val();
            if ($('#usersignupform').valid()) {
                $.ajax({
                    url: '/home-ajax-handler',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        method: 'user_signup',
                        fname: Firstname,
                        lname: Lastname,
                        uname: Username,
                        email: Email,
                        optradio: Gender,
                        contact_no: Contact,
                        date_of_birth: Year+"-"+Month+"-"+Date
                    },
                    success: function (response) {
//                    console.log(response);
                        if (response) {
                            if (response == 200) {
                                $('#pw-suc-err').show();
                                $('#pw-suc-err').html("Signup successful. Please check your email for Password");
                                $('#pw-suc-err').css('color', 'green');
                                $('#pw-suc-err').delay(6000).hide('slow');
                            } else {
                                if (response['code'] == 100) {
                                    var message = response['message'];
                                    $.each(message, function (key, value) {
//                                    console.log(key);
                                        if (key == "first_name") {
                                            $('#first_name_err').show();
                                            $('#first_name_err').html(message[key]);
                                            $('#first_name_err').css('color', 'red');
                                            $('#first_name_err').delay(6000).hide('slow');
                                        }
                                        if (key == "last_name") {
                                            $('#last_name_err').show();
                                            $('#last_name_err').html(message[key]);
                                            $('#last_name_err').css('color', 'red');
                                            $('#last_name_err').delay(6000).hide('slow');
                                        }
                                        if (key == "username") {
                                            $('#username_err').show();
                                            $('#username_err').html(message[key]);
                                            $('#username_err').css('color', 'red');
                                            $('#username_err').delay(6000).hide('slow');
                                        }
                                        if (key == "email") {
                                            $('#email_err').show();
                                            $('#email_err').html(message[key]);
                                            $('#email_err').css('color', 'red');
                                            $('#email_err').delay(6000).hide('slow');
                                        }
                                        if (key == "optradio") {
                                            $('#optradio').show();
                                            $('#optradio').html(message[key]);
                                            $('#optradio').css('color', 'red');
                                            $('#optradio').delay(6000).hide('slow');
                                        }
                                        if (key == "contact_no") {
                                            $('#contact_no').show();
                                            $('#contact_no').html(message[key]);
                                            $('#contact_no').css('color', 'red');
                                            $('#contact_no').delay(6000).hide('slow');
                                        }
                                        if (key == "date_dd") {
                                            $('#date_dd').show();
                                            $('#date_dd').html(message[key]);
                                            $('#date_dd').css('color', 'red');
                                            $('#date_dd').delay(6000).hide('slow');
                                        }
                                        if (key == "month_mm") {
                                            $('#month_mm').show();
                                            $('#month_mm').html(message[key]);
                                            $('#month_mm').css('color', 'red');
                                            $('#month_mm').delay(6000).hide('slow');
                                        }
                                        if (key == "year_yy") {
                                            $('#year_yy').show();
                                            $('#year_yy').html(message[key]);
                                            $('#year_yy').css('color', 'red');
                                            $('#year_yy').delay(6000).hide('slow');
                                        }
                                    })
                                } else {
                                    $('#pw-suc-err').show();
                                    $('#pw-suc-err').html(response['message']);
                                    $('#pw-suc-err').css('color', 'red');
                                    $('#pw-suc-err').delay(6000).hide('slow');
                                }
                            }
                        }
                    }
                });
            }
        });

        $("#userloginform").submit(function (e) {
            e.preventDefault();
            var Username = $('#login_email').val();
            var Password = $('#login_password').val();
            if ($('#userloginform').valid()) {
                $.ajax({
                    url: '/home-ajax-handler',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        method: 'user_login',
                        uname: Username,
                        password: Password
                    },
                    success: function (response) {
//                    console.log(response);
                        if (response) {
                            if (response == 200) {
                                $('#login-suc-err').show();
                                $('#login-suc-err').html("Login successful");
                                $('#login-suc-err').css('color', 'green');
                                $('#login-suc-err').delay(6000).hide('slow');
                                window.location = "/";
                            } else {
                                if (response['code'] == 100) {
                                    var message = response['message'];
                                    $.each(message, function (key, value) {
//                                    console.log(key);
                                        if (key == "username") {
                                            $('#login_email_err').show();
                                            $('#login_email_err').html(message[key]);
                                            $('#login_email_err').css('color', 'red');
                                            $('#login_email_err').delay(6000).hide('slow');
                                        }
                                        if (key == "password") {
                                            $('#login_password_err').show();
                                            $('#login_password_err').html(message[key]);
                                            $('#login_password_err').css('color', 'red');
                                            $('#login_password_err').delay(6000).hide('slow');
                                        }
                                    })
                                } else {
                                    $('#login-suc-err').show();
                                    $('#login-suc-err').html(response['message']);
                                    $('#login-suc-err').css('color', 'red');
                                    $('#login-suc-err').delay(6000).hide('slow');
                                }
                            }
                        }
                    }
                });
            }
        });

        $("#forgotpasswordform").submit(function (e) {
            e.preventDefault();
            var fpdemail = $('#fp_email').val();
            var resetcode = $('#resetcode').val();

            if ($("#forgotpasswordform").valid()) {
                if (resetcode == '' && fpdemail != '') {
                    $.ajax({
                        url: '/home-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'forgotpw',
                            fpwemail: fpdemail
                        },
                        success: function (response) {

                            if (response['code'] == 200) {
                                $('#fp_email_err').show();
                                $('#fp_email_err').html(response['message']);
                                $('#fp_email_err').css('color', 'green');
                                $('#fp_email_err').delay(4000).hide('slow');
                                $('#resetcodediv').removeClass('hidden');
                                $('#fp_email').prop('disabled', true);
                            } else {
                                $('#fp_email_err').show();
                                $('#fp_email_err').html(response['message']);
                                $('#fp_email_err').css('color', 'red');
                                $('#fp_email_err').delay(4000).hide('slow');
                            }
                        }
                    });
                } else {
                    $.ajax({
                        url: '/home-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'verifyResetCode',
                            fpwemail: fpdemail,
                            resetcode: resetcode
                        },
                        success: function (response) {
                            if (response['code'] == 200) {
                                $('#resetcode_err').show();
                                $('#resetcode_err').html(response['message']);
                                $('#resetcode_err').css('color', 'green');
                                $('#resetcode_err').delay(4000).hide('slow');
                                enternewpw();
                            } else {
                                $('#resetcode_err').show();
                                $('#resetcode_err').html(response['message']);
                                $('#resetcode_err').css('color', 'red');
                                $('#resetcode_err').delay(4000).hide('slow');
                            }
                        }
                    });

                }
            }
        });

        $("#EnterNewPasswordform").submit(function (e) {
            e.preventDefault();
            var fpdemail = $('#fp_email').val();
            var resetcode = $('#resetcode').val();
            var password1 = $('#password1').val();
            var password2 = $('#password2').val();
            if ($("#EnterNewPasswordform").valid()) {
                if (resetcode != '' && fpdemail != '' && password1 != '' && password2 != '') {
                    $.ajax({
                        url: '/home-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'resetPassword',
                            fpwemail: fpdemail,
                            password: password1,
                            re_password: password2,
                            reset_code: resetcode
                        },
                        success: function (response) {
                            if (response['code'] == 200) {
                                $('#resetpw-suc-err').show();
                                $('#resetpw-suc-err').html(response['message']);
                                $('#resetpw-suc-err').css('color', 'green');
                                $('#resetpw-suc-err').delay(4000).hide('slow');
                                $('#password1').val('');
                                $('#password2').val('');
                            } else {
                                $('#resetpw-suc-err').show();
                                $('#resetpw-suc-err').html(response['message']);
                                $('#resetpw-suc-err').css('color', 'red');
                                $('#resetpw-suc-err').delay(4000).hide('slow');
                                $('#password1').val('');
                                $('#password2').val('');
                            }
                        }
                    });
                }
            }
        });

    });

</script>
@include('Home/Layouts/home_common_code_script')
</body>
</html>
