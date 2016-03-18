<html>
<head>
    @include('Home/Layouts/home_header_scripts')
    @yield('pageheadcontent')
</head>
<body>

<div class="wrapper"><!--body wrapper-->
    <header>
        <div class="container-fluid  bg-color-login"><!--Login-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="inline text-white">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                               data-toggle="dropdown">
                                    <span class="user-name" style="padding-bottom: 6px;">{{ trans('message.changelanguage') }}<i
                                                class="fa fa-angle-down"></i></span>
                            </a>
                            {{--<ul class="dropdown-menu">--}}
                            {{--<li>fcb</li>--}}
                            {{--</ul>--}}
                            <ul class="dropdown-menu"><?php $langinfo = \FlashSale\Http\Modules\Home\Controllers\HomeController::getTranslatedLanguage();?>

                                <?php if(isset($langinfo) && !(empty($langinfo))){ ?>

                                @foreach($langinfo as  $val)

                                    <li><a href="/user/lang/{{$val['lang_code']}}">{{$val['name']}}</a></li>
                                    {{--<li><a href="/user/lang/en">English</a></li>--}}
                                    {{--<li> <a href="/lang/{{$val->lang_code}}">{{$val->name}}</a></li>--}}
                                    {{--<option value="/lang/pt">Portuguese</option>--}}
                                @endforeach
                                <?php } ?>

                            </ul>
                        </li>
                        {{--<i class="fa fa-eur"> </i>  <span class="caret cart-caret-blue"> </span></p>--}}
                        {{--<p class="inline text-white">EN <span class="caret cart-caret-blue"></span></p>--}}
                    </div>
                    <div class="col-sm-2 pull-right inline top_5">


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                               data-toggle="dropdown">
                                <p class="text-white inline">(<span class='cart-items-count'>0</span>) CART</p>
                                <img src="/assets/images/shopping-cart-wht.png" class="cart-img-header inline"
                                     alt="shopping cart">
                            </a>
                            {{--<ul class="dropdown-menu">--}}
                            {{--<li>fcb</li>--}}
                            {{--</ul>--}}
                            <ul class="dropdown-menu" style="margin:0;z-index: 999999;">
                               <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                             </ul>
                        </li>

                    </div>
                    <!--Login-->

            </div>
        </div>


        <div class="container-fluid  bg-color-1d padd-top-2"><!--navbar search-->
            <div class="container">
                <div class="row">

                    <div class="col-sm-3  t-a-r">
                        <a class="navbar-brand" href="#"><span class="f-ts">Fashion</span></a>
                    </div>

                    <div class="col-sm-4  js-navbar-collapse hidden-xs">
                        <form class="">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search-box" placeholder="">

                                    <div class="input-group-addon input-addon">
                                        <i class="fa fa-search glyph-color"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3 col-sm-5 col-xs-6 pull-right">
                        <ul class="login list-inline text-uppercase" style="text-align: right;">
                            <?php if (Session::has('fs_user')){
                            $value = Session::get('fs_user')['profilepic'];
                            ?>
                            <li  style="text-align: left;">
                                <a href="javascript:void(0)" id="showdetails" class="white_color"><img src="<?php if ($value != '') {
                                        echo $value;
                                    } else {
                                        echo "http://placehold.it/350x150";
                                    }?>" style="height:30px; width:30px;" class="img-circle" id="user_profile_pic_id"/>Hello
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

                                <button type="button" class="btn btn-bg-clr-grey text-white b-rad-0 open_login_model pull-left"  data-toggle="modal"
                                        data-target=".modal-login">{{ trans('message.login') }}</button>
                                {{--<li><a href="#" class="open_login_model" data-toggle="modal"--}}
                                {{--data-target=".modal-login"--}}
                                {{--class="btn btn-bg-clr-grey text-white b-rad-0 mar-min-btm">{{ trans('message.login') }}</a>--}}
                                {{--</li>--}}
                                <button type="button" class="btn btn-bg-clr-dblue text-white b-rad-0 open_signup_model pull-left" data-toggle="modal"
                                        data-target=".modal-login">{{ trans('message.register') }}</button>
                                {{--<li><a href="#" class="open_signup_model" data-toggle="modal"--}}
                                {{--data-target=".modal-login"--}}
                                {{--class="btn btn-bg-clr-dblue text-white b-rad-0 mar-min-btm">{{ trans('message.register') }}</a>--}}
                                {{--</li>--}}

                            </div>
                            <?php } ?>
                            {{--<li style="float:left ">--}}
                            {{--<a href="#" id="showbag">bag (1) <span id="triangle_down">&#9660;</span>--}}
                            {{--<span id="triangle_up" style="display:none;">&#9650;</span> </a>--}}

                            {{--<div id="bagpanel" class="left-panel">--}}
                            {{--<!--Header panel-->--}}
                            {{--<div class="header-bag"><p>1 item (s) added to your bag</p></div>--}}
                            {{--<!--Header panel-->--}}

                            {{--<!--body panel-->--}}
                            {{--<div class="body-bag">--}}
                            {{--<img src="/assets/home/img/featured-products/product-01.jpg" alt="">--}}

                            {{--<div class="content-body-bag text-overflow">--}}
                            {{--<h4 class="product-bag">YX Black T-Shirt</h4>--}}

                            {{--<p><span class="amount">1</span>x<span class="price">$36.00</span></p>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<!--body panel-->--}}

                            {{--<!--Footer panel-->--}}
                            {{--<div class="footer-bag">--}}
                            {{--<div class="total-bag"><p>total<span>$36.00</span></p></div>--}}
                            {{--<div class="view-bag">view bag</div>--}}
                            {{--</div>--}}
                            {{--<!--Footer panel-->--}}
                            {{--</div>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                    <!--Login-->
                    {{--<div class="col-md-4 pull-right">--}}
                    {{--<div class="pull-right">--}}
                    {{--<button type="button" class="btn btn-bg-clr-grey text-white b-rad-0 mar-min-btm">Login</button>--}}
                    {{--<button type="button" class="btn btn-bg-clr-dblue text-white b-rad-0 mar-min-btm">Register</button>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                </div>


                </div>
            </div>

        </div>
        <!--/navbar search-->

        <div class="nav-bar-container bg-color-1d"><!--container1-->
            <div class="container">
                <nav class="navbar navbar-inverse navbar-rad-0 row m-btm-7  bg-color-1d nav-padd-mar-0">
                    <!--navbar start -->
                    <div class="navbar-header col-sm-3 col-md-2 t-a-r">
                        <a class="navbar-brand padding-0" href="#"><span class="bridge">BRIDGE</span></a>
                    </div>

                    <!--only for mobile-->
                    <div class="col-xs-12 visible-xs margin-top-10">
                        <ul class="remove-list-style">
                            <li><a href="">{{ trans('message.home') }}</a></li>
                            <li><a href="">{{ trans('message.flashsale') }}</a></li>
                            <li><a href="">{{ trans('message.shop') }}</a></li>
                            <li><a href="">{{ trans('message.dailyspecial') }}</a></li>
                            <li><a href="">BABY &amp; KIDS</a></li>
                        </ul>
                    </div>
                    <!--/only for mobile-->
                    <div class='col-sm-8 col-md-7'>
                        <div class="collapse navbar-collapse js-navbar-collapse">
                            <ul class="nav navbar-nav ">
                                <li><a href="#">{{ trans('message.home') }}</a></li>
                                <li class="dropdown mega-dropdown">

                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">WOMEN <span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu mega-dropdown-menu dropdown-styles">

                                        <li class='col-sm-1 p-m-0 width-auto hidden-xs'>
                                            <img src="/assets/images/drop-down-txt.png" class='img-responsive'
                                                 alt="text-image">
                                        </li>

                                        <li class="col-sm-4 p-m-0">
                                            <ul class="display-img">
                                                <li><a href="javascript:;"><img src="/assets/images/dd-img-3.png"
                                                                                alt="img-1"/></a></li>
                                                <li><a href="javascript:;"><img src="/assets/images/dd-img-2.png"
                                                                                alt="img-2"/></a></li>
                                                <li><a href="javascript:;"><img src="/assets/images/dd-img-1.png"
                                                                                alt="img-3"/></a></li>
                                            </ul>
                                        </li>

                                        <li class="col-sm-3 p-m-0">
                                            <ul class="padd-10-a bg-color-dark">
                                                <li><a href="#">Tops</a></li>
                                                <li><a href="#">Dresses</a></li>
                                                <li><a href="#">Shoes</a></li>
                                                <li><a href="#">Bags</a></li>
                                                <li><a href="#">Glasses</a></li>
                                                <li><a href="#"><img src="/assets/images/dots.png" alt="more"></a></li>
                                            </ul>
                                        </li>

                                        <li class="col-sm-4 p-m-0 dd-bg">
                                            <h1>SALE</h1>
                                        </li>
                                        <li class='col-xs-12 s-a'><a href="#" class="s-a-a">SHOW ALL</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown mega-dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">MEN <span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu mega-dropdown-menu dropdown-styles">

                                        <li class='col-sm-1 p-m-0 width-auto hidden-xs'>
                                            <img src="/assets/images/drop-down-txt.png" class='img-responsive'
                                                 alt="text-image">
                                        </li>

                                        <li class="col-sm-3 p-m-0">
                                            <ul class="padd-10-a bg-color-dark">
                                                <li><a href="#">Tops</a></li>
                                                <li><a href="#">Dresses</a></li>
                                                <li><a href="#">Shoes</a></li>
                                                <li><a href="#">Bags</a></li>
                                                <li><a href="#">Glasses</a></li>
                                                <li><a href="#"><img src="/assets/images/dots.png" alt="more"></a></li>
                                            </ul>
                                        </li>

                                        <li class="col-sm-4 p-m-0">
                                            <ul class="display-img">
                                                <li><a href="javascript:;"><img src="/assets/images/dd-img-3.png"
                                                                                alt="img-1"/></a></li>
                                                <li><a href="javascript:;"><img src="/assets/images/dd-img-2.png"
                                                                                alt="img-2"/></a></li>
                                                <li><a href="javascript:;"><img src="/assets/images/dd-img-1.png"
                                                                                alt="img-3"/></a></li>
                                            </ul>
                                        </li>

                                        <li class="col-sm-4 p-m-0 dd-bg">
                                            <h1>SALE</h1>
                                        </li>
                                        <li class='col-xs-12 s-a'><a href="#" class="s-a-a">SHOW ALL</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">BABY &amp; KIDS</a></li>
                                <li><a href="#">ABOUT US</a></li>
                                <li><a href="#">{{ trans('message.contact') }}</a></li>
                            </ul>

                        </div>
                        <!-- /.nav-collapse -->

                    </div>
                </nav>
                <!--navbar end -->

            </div>
        </div>
        <!--/container1-->
    </header>
    {{------------------------------------------PAGE CONTENT STARTS HERE-----------------------------------------}}
    @yield('content')
    {{------------------------------------------PAGE CONTENT ENDS HERE-----------------------------------------}}


    <footer class="bg-color-1d footer-float">
        <div class="container">
            <div class="row">
                <img src="/assets/images/footer-img.png" alt="" class="img-responsive footer-img">
            </div>
        </div>
        <div class="container margin-top-1 footer-font-style">
            <div class="row ">
                <div class="col-md-12">
                    <div class="col-md-2">
                        <a href="#"><span class="f-ts">Fashion</span></a>
                        <a href="#"><span class="bridge">BRIDGE</span></a>
                    </div>
                    <div class="col-md-2">
                        <h5 class="col-fff">COMPANY</h5>
                        <ul class="no-list-style">
                            <li><a href="">About</a></li>
                            <li><a href="">Press</a></li>
                            <li><a href="">Careers</a></li>
                            <li><a href="">Tech</a></li>
                            <li><a href="">Style Directory</a></li>
                            <li><a href="">Brand Directory</a></li>
                            <li><a href="">Category Directory</a></li>
                            <li><a href="">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h5 class="col-fff">Customer Service</h5>
                        <ul class="no-list-style">
                            <li><a href="">FAQ / Contact Us</a></li>
                            <li><a href="">Return Policy</a></li>
                            <li><a href="">Shipping & Tax</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h5 class="col-fff">Policies</h5>
                        <ul class="no-list-style">
                            <li><a href="">Terms of Membership</a></li>
                            <li><a href="">Privacy</a></li>
                            <li><a href="">Security</a></li>
                            <li><a href="">Terms of Use</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h5 class="col-fff">Social Media</h5>
                        <ul class="no-list-style social-col">
                            <li>
                                <a href=""><i class="fa fa-rss social-icons"></i></a>
                                <a href=""><i class="fa fa-twitter social-icons"></i></a>
                                <a href=""><i class="fa fa-twitter social-icons"></i></a>
                            </li>

                            <li>
                                <a href=""><i class="fa fa-twitter social-icons"></i></a>
                                <a href=""><i class="fa fa-twitter social-icons"></i></a>
                                <a href=""><i class="fa fa-twitter social-icons"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Modal Contact -->
    <div class="modal fade modal-login">
        <div class="modal-dialog" id="dialog_modal" style="width: 90rem;">
            <div class="modal-content modal_bgdark_grey">
                <div class="modal-body row">
                    <div class="loginmodel col-lg-12  hidden">
                        <div class="col-lg-6">
                            <h4 class="text-uppercase white_color">{{ trans('message.login') }}</h4>

                            <form class="signin_form" method="post" id="userloginform">
                                <div class="form-group">
                                    <label for="login_email" class="white_color">{{ trans('message.username') }}
                                        or {{ trans('message.email') }}</label>
                                    <input type="text" class="form-control white_color" id="login_email" name="login_email"
                                           placeholder="Username or email">
                                    <span id="login_email_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="login_password" class="white_color">{{ trans('message.password') }}</label>
                                    <input type="password" class="form-control white_color" id="login_password"
                                           name="login_password" placeholder="Password">
                                    <span id="login_password_err"></span>
                                </div>
                                <input type="submit" value="{{ trans('message.login')}}"
                                       class="boton-color text-uppercase">
                                <a class="pss" onClick="forgotpd()">Lost password?</a>

                                <div id="login-suc-err"></div>
                            </form>
                        </div>

                        <div class="col-lg-6">
                            <h4 class="text-uppercase white_color">{{ trans('message.register') }}</h4>

                            <p class="top white_color">{{ trans('message.By creating an account with our Site, you will be able to move through the checkout process faster, view and track your orders in your account and more.') }}
                                .</p>

                            <a class="boton-color text-uppercase open_signup_model"
                               style="color: #f0f0f0;cursor: pointer">{{ trans('message.signup') }}</a>
                        </div>
                    </div>

                    <div class="signupmodel col-lg-12 hidden" style="width: 100%">
                        <div class="col-lg-12">
                            <h4 class="text-uppercase white_color">{{ trans('message.signup') }}</h4>

                            <form class="regsiter_form" method="post" id="usersignupform">
                                <div class="form-group">
                                    <label for="firstname" class="white_color">{{ trans('message.firstname') }}</label>
                                    <input type="text" class="form-control white_color" id="firstname" name="firstname"
                                           placeholder="First Name">
                                    <span id="first_name_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="white_color">{{ trans('message.lastname') }}</label>
                                    <input type="text" class="form-control white_color" id="lastname" name="lastname"
                                           placeholder="Last Name">
                                    <span id="last_name_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="white_color">{{ trans('message.username') }}</label>
                                    <input type="text" class="form-control white_color" id="username" name="username"
                                           placeholder="Username">
                                    <span id="username_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="white_color">{{ trans('message.email') }}</label>
                                    <input type="text" class="form-control white_color" id="email" name="email" placeholder="email">
                                    <span id="email_err"></span>
                                </div>

                                <input type="submit" value="{{ trans('message.signup') }}"
                                       class="boton-color text-uppercase">
                                <span style="float: right;" class="white_color">Already Registered

                                <a class="boton-color text-uppercase open_login_model"
                                   style="color: #f0f0f0;cursor: pointer">{{ trans('message.login') }}</a></span><br>

                                <div id="pw-suc-err"></div>
                            </form>
                            {{--</div>--}}

                            {{--<div class="col-lg-6">--}}

                        </div>
                    </div>

                    <div class="forgotpd col-lg-12 hidden" style="width: 100%">
                        <div class="col-lg-12">
                            <h4 class="text-uppercase white_color">Forgot Password</h4>

                            <form class="regsiter_form" method="post" id="forgotpasswordform">
                                <div class="form-group">
                                    <label for="fp_email" class="white_color">{{ trans('message.email') }}</label>
                                    <input type="email" class="form-control white_color" id="fp_email" name="fp_email"
                                           placeholder="Email">
                                    <span id="fp_email_err"></span>
                                </div>
                                <div class="resetcode hidden" id="resetcodediv">
                                    <p>
                                        Check Mail and Enter your reset code below to Reset password
                                    </p>

                                    <div class="form-group">
                                        <label for="fp_email" class="white_color">Reset code</label>
                                        <input type="text" class="form-control white_color" id="resetcode" name="resetcode"
                                               placeholder="Reset Code">
                                        <span id="resetcode_err"></span>
                                    </div>

                                </div>
                                <input type="button" class="boton-color" onClick="login()" value="Back">
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
                                    <input type="password" class="form-control white_color" id="password1" name="password1"
                                           placeholder="New Password">
                                    <span id="password1_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password2" class="white_color">Re-enter Password</label>
                                    <input type="password" class="form-control white_color" id="password2" name="password2"
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
        </div>
    </div>
    <!-- Modal Contact -->


</div>
<!--/bodywrapper -->

@include('Home/Layouts/home_footer_scripts')
@yield('pagejavascripts')
<script type="text/javascript">

    $(document).ready(function () {
        $('.main-grid').isotope({
            percentPosition: true,
            itemSelector: '.grid-item',
            masonry: {
                columnWidth: '.grid-item'
            }
        });


        /* $('.grid').masonry({
         // options
         itemSelector: '.g-item',
         columnWidth: 499
         });*/

    });


    $(document).ready(function () {
        $(".dropdown").hover(
                function () {
                    $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("fast");
                    $(this).toggleClass('open');
                },
                function () {
                    $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("fast");
                    $(this).toggleClass('open');
                }
        );
    });
</script>
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
        $("#dialog_modal").css("width", "60rem");
        $('.forgotpd').removeClass('hidden');
        $('.loginmodel').addClass('hidden');
        $('.enternewpw').addClass('hidden');//emailID resetcode password1 password2
        $('#fp_email').prop('disabled', false);
        $('#resetcodediv').addClass('hidden');
    }
    function login() {
        $("#dialog_modal").css("width", "90rem");
        $('.loginmodel').removeClass('hidden');
        $('.forgotpd').addClass('hidden');
        $('.enternewpw').addClass('hidden');
        $('#fp_email').val('');
        $('#resetcode').val('');
        $('#password1').val('');
        $('#password2').val('');
        $('#fp_email').prop('disabled', false);
    }
    function enternewpw() {
        $("#dialog_modal").css("width", "60rem");
        $('.enternewpw').removeClass('hidden');
        $('.forgotpd').addClass('hidden');
        $('.loginmodel').addClass('hidden');
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
                        email: Email
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

</body>
</html>
