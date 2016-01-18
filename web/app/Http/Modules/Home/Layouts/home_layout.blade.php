<html>
<head>
    @include('Home/Layouts/home_header_scripts')
    @yield('pageheadcontent')
</head>
<body>

<!--Layout Theme Options-->
<div id="layout">
    <!--Preloader-->
    <div class="preloader">
        <div class="status">&nbsp;</div>
    </div>
    <!--Preloader-->
    <!--Header-->
    <header>
        <!--Bar Current & Extras-->
        <div class="bar-extras">
            <div class="container">
                <div class="row right">
                    <div class="col-lg-12">
                        <ul class="list-inline">
                            <!--Current-->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    USD $ <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu current right text-uppercase">
                                    <li><a href="#"> AUD $</a></li>
                                    <li><a href="#"> EUR €</a></li>
                                    <li><a href="#"> BOB Bs.</a></li>
                                    <li><a href="#"> COP $</a></li>
                                </ul>
                            </li>

                            <!--Current-->

                            <!--Language-->
                            {{--<li class="dropdown">--}}
                            {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                            {{--ENG <i class="fa fa-angle-down"></i>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu left">--}}
                            {{--<li><a href="#"><img src="/assets/home/img/language/spanish.png" alt=""> Spanish</a></li>--}}
                            {{--<li><a href="#"><img src="/assets/home/img/language/english.png" alt=""> English</a></li>--}}
                            {{--<li><a href="#"><img src="/assets/home/img/language/frances.png" alt=""> French</a></li>--}}
                            {{--<li><a href="#"><img src="/assets/home/img/language/portugues.png" alt=""> Portuguese</a></li>--}}
                            {{--</ul>--}}
                            {{--</li>--}}
                            <!--Language-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--Bar Current & Extras-->

        <!--Logo Menu & Bar Login-->
        <div class="logo-menu">
            <div class="container">
                <div class="row right">
                    <!--Logo-->
                    <div class="col-lg-4 col-md-4 col-sm-3 m-top-minus">
                        <div class="logo center text-uppercase">
                            <a href="/"><h1>Flash Sale</h1></a>
                        </div>
                    </div>
                    <!--Logo-->

                    <!--Search-->
                    <div class="col-lg-5 search col-md-4 col-sm-4 col-xs-6">
                        <form class="search" action="#" method="Post">
                            <div class="input-group">
                                <input class="form-control" placeholder="" name="email" type="email" required="required">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit" name="subscribe"><i
                                                        class="fa fa-search"></i></button>
                                        </span>
                            </div>
                        </form>
                    </div>
                    <!--Search-->

                    <!--Login-->
                    <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                        <ul class="login list-inline text-uppercase">
                            <?php if (Session::has('fs_user')){
                             $value = Session::get('fs_user')['profilepic'];
                            ?>
                            <li>
                                <a href="javascript:void(0)" id="showdetails"><img src="<?php if($value != ''){  echo $value; } else { echo "http://placehold.it/350x150"; }?>" style="height:30px; width:30px;" class="img-circle" id="user_profile_pic_id"/> Username <span id="triangle_down">&#9660;</span>
                                    <span id="triangle_up" style="display:none;">&#9650;</span></a>
                                <div id="userpanel" class="left-panel">
                                    <!--body panel-->
                                    <div class="body-user">
                                        <div class="content-body-user text-overflow">
                                            <ul class="list-unstyled">
                                                <li><a href="/profile-setting"><i class="fa fa-user"></i>&nbsp;&nbsp;My Account</a></li>
                                                <li><a href="#"><i class="fa fa-heart"></i>&nbsp;&nbsp;My Wishlist</a></li>
                                                <li><a href="#"><i class="fa fa-truck"></i>&nbsp;&nbsp;My Orders</a></li>
                                                <li><a href="#"><i class="fa fa-outdent"></i>&nbsp;&nbsp;My Tickets</a></li>
                                                <li><a href="#"><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;Add New Ticket</a></li>
                                                <li><a href="#"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Newsletter</a></li>
                                                <li><a href="/logout"><i class="fa fa-key"></i>&nbsp;&nbsp;Log Out</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--body panel-->
                                </div>
                            </li>
                            <?php } else { ?>
                            <li><a href="#" class="open_login_model" data-toggle="modal" data-target=".modal-login">login</a>
                            </li>
                            <li><a href="#" class="open_signup_model" data-toggle="modal" data-target=".modal-login">Register</a>
                            </li>
                            <?php } ?>
                            <li style="float:left ">
                                <a href="#" id="showbag">bag (1) <span id="triangle_down">&#9660;</span>
                                    <span id="triangle_up" style="display:none;">&#9650;</span> </a>

                                <div id="bagpanel" class="left-panel">
                                    <!--Header panel-->
                                    <div class="header-bag"><p>1 item (s) added to your bag</p></div>
                                    <!--Header panel-->

                                    <!--body panel-->
                                    <div class="body-bag">
                                        <img src="/assets/home/img/featured-products/product-01.jpg" alt="">

                                        <div class="content-body-bag text-overflow">
                                            <h4 class="product-bag">YX Black T-Shirt</h4>

                                            <p><span class="amount">1</span>x<span class="price">$36.00</span></p>
                                        </div>
                                    </div>
                                    <!--body panel-->

                                    <!--Footer panel-->
                                    <div class="footer-bag">
                                        <div class="total-bag"><p>total<span>$36.00</span></p></div>
                                        <div class="view-bag">view bag</div>
                                    </div>
                                    <!--Footer panel-->
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--Login-->

                    <!--Menu-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <nav class="navbar menu yamm top-mini">
                            <div class="navbar-header">
                                <button type="button" data-toggle="collapse" data-target="#navbar-collapse-grid"
                                        class="navbar-toggle"><i class="fa fa-bars"></i></button>
                            </div>
                            <div id="navbar-collapse-grid" class="navbar-collapse collapse left">
                                <ul class="nav navbar-nav">
                                    <!-- home -->
                                    <li class="dropdown yamm-fw"> Home</li>
                                    <!--home -->

                                    <!--shop-->
                                    <li class="dropdown yamm-fw"><a href="#" data-toggle="dropdown"
                                                                    class="dropdown-toggle">Flash Sale <b
                                                    class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li class="grid">
                                                <div class="row" style="margin-left:0px;">
                                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                                        <h4>new arrivals</h4>
                                                        <ul class="list-unstyled">
                                                            <li><a href="shop.html">Shop Site</a></li>
                                                            <li><a href="shop-sidebarleft.html">Shop with Sidebar</a>
                                                            </li>
                                                            <li><a href="#" data-toggle="modal"
                                                                   data-target=".modal-quickview">Quickview</a></li>
                                                            <li><a href="#">Clothes</a></li>
                                                            <li><a href="#">Shoes</a></li>
                                                            <li><a href="#">Accesories</a></li>
                                                            <li><a href="#">Other</a></li>
                                                            <li><a href="#">Cashmere: From $75</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <h4>clothes</h4>
                                                        <ul class="list-unstyled">
                                                            <li><a href="#">Tops</a></li>
                                                            <li><a href="#">Knitwear</a></li>
                                                            <li><a href="#">Dresses</a></li>
                                                            <li><a href="#">Denim</a></li>
                                                            <li><a href="#">Bottoms</a></li>
                                                            <li><a href="#">Jackets</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3">

                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <a href="#"><img
                                                                            src="/assets/home/img/Gilt_GiftCard_Nav_GC_227x442.jpg"
                                                                            class="img-responsive" style="width:404px;">
                                                                </a>
                                                            </li>

                                                        </ul>
                                                    </div>

                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <!--shop-->

                                    <!--pages-->
                                    <li class="dropdown yamm-fw"><a href="#" data-toggle="dropdown"
                                                                    class="dropdown-toggle">Shop <b
                                                    class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li class="grid">
                                                <div class="row" style="margin-left:0px;">
                                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                                        <h4>new arrivals</h4>
                                                        <ul class="list-unstyled">
                                                            <li><a href="shop.html">Shop Site</a></li>
                                                            <li><a href="shop-sidebarleft.html">Shop with Sidebar</a>
                                                            </li>
                                                            <li><a href="#" data-toggle="modal"
                                                                   data-target=".modal-quickview">Quickview</a></li>
                                                            <li><a href="#">Clothes</a></li>
                                                            <li><a href="#">Shoes</a></li>
                                                            <li><a href="#">Accesories</a></li>
                                                            <li><a href="#">Other</a></li>
                                                            <li><a href="#">Cashmere: From $75</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <h4>clothes</h4>
                                                        <ul class="list-unstyled">
                                                            <li><a href="#">Tops</a></li>
                                                            <li><a href="#">Knitwear</a></li>
                                                            <li><a href="#">Dresses</a></li>
                                                            <li><a href="#">Denim</a></li>
                                                            <li><a href="#">Bottoms</a></li>
                                                            <li><a href="#">Jackets</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3">

                                                        <ul class="list-unstyled">
                                                            <li><a href="#"><img
                                                                            src="/assets/home/img/Gilt_GiftCard_Nav_GC_227x442.jpg"
                                                                            class="img-responsive" style="width:404px;"></a>
                                                            </li>

                                                        </ul>
                                                    </div>

                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <!--pages-->
                                    <li class="dropdown yamm-fw"><a href="#" data-toggle="dropdown"
                                                                    class="dropdown-toggle">Daily Specials <b
                                                    class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li class="grid">
                                                <div class="row" style="margin-left:0px;">
                                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                                        <h4>Today's Sales </h4>
                                                        <ul class="list-unstyled">
                                                            <li><a href="#"> Nanos for Baby & Kids</a></li>
                                                            <li><a href="#">Gotta-Have Toys</a></li>
                                                            <li><a href="#">Jaime King for Sapling</a></li>

                                                            <li><a href="#">Shopping Cart</a></li>
                                                            <li><a href="#">CheckOut</a></li>
                                                            <li><a href="#">Shop</a></li>
                                                            <li><a href="#">The Toy Shop </a></li>

                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <h4>Categories</h4>
                                                        <ul class="list-unstyled">
                                                            <li><a href="#">Girls Dresses & Skirts </a></li>
                                                            <li><a href="#">Girls Tops</a></li>
                                                            <li><a href="#">Girls Bottom</a></li>
                                                            <li><a href="#">Boys Bottoms</a></li>
                                                            <li><a href="#">Boys Tops </a></li>
                                                            <li><a href="#">Boys Dresses </a></li>
                                                            <li><a href="#">Shoes and Accessories</a></li>
                                                            <li><a href="#">Maternity</a></li>
                                                            <li><a href="#">Toys, Furnishings & Gear </a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3">

                                                        <ul class="list-unstyled">
                                                            <li><a href="#"><img
                                                                            src="/assets/home/img/Gilt_GiftCard_Nav_GC_227x442.jpg"
                                                                            class="img-responsive" style="width:404px;"></a>
                                                            </li>

                                                        </ul>
                                                    </div>

                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                    <!--Blog-->
                                    <li class="dropdown yamm-fw"><a href="#">About Us</a></li>
                                    <!--Blog-->

                                    <!--Contact-->
                                    <li class="dropdown yamm-fw"><a href="#">Contact</a></li>
                                    <!--Contact-->
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!--Menu-->
                </div>
            </div>
        </div>
        <!--Logo Menu & Bar Login-->
    </header>
    <!--Header-->

    {{------------------------------------------PAGE CONTENT STARTS HERE-----------------------------------------}}
    @yield('content')
    {{------------------------------------------PAGE CONTENT ENDS HERE-----------------------------------------}}

            <!--advertisement-->
    <section class="bg-image">
        <div class="bg-color"></div>
        <div class="paddings title-banner center text-uppercase">
            <div class="container">
                <div class="row">
                    <h2><span>LOOKBOOK</span> 2015/2016</h2>

                    <h3>THE NEW COLLECTION</h3>

                    <div class="boton-border"><a href="#">shop now</a></div>
                </div>
            </div>
        </div>
    </section>
    <!--advertisement-->

    <!--Footer-->
    <footer class="paddings">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-2 col-sm-3 col-xs-6">
                    <h4>company</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Brands</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Our Stores</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Contact us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <h4>help</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">Payment</a></li>
                        <li><a href="#">Shipping & Returns</a></li>
                        <li><a href="#">Size Guide</a></li>
                        <li><a href="#">Track Orders</a></li>
                        <li><a href="#">Gift Card</a></li>
                        <li><a href="#">Faqs</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <h4>from the upcoming</h4>
                    <!--item-->
                    <div class="top-mini">
                        <div class="date center text-uppercase">
                            15 Dec
                        </div>
                        <div class="info-date">
                            <h5><a href="#">What’s trending for 2015? </a></h5>
                            <!--                                <p>&nbsp;&nbsp;&nbsp;</p>-->
                        </div>
                    </div>
                    <!--item-->
                    <div class="clearfix"></div>
                    <!--item-->
                    <div class="top-mini">
                        <div class="date center text-uppercase">
                            15 Dec
                        </div>
                        <div class="info-date">
                            <h5><a href="#">New collection is here! 50 new styles</a></h5>

                        </div>
                    </div>
                    <!--item-->
                    <div class="clearfix"></div>
                    <!--item-->
                    <div class="top-mini">
                        <div class="date center text-uppercase">
                            15 Dec
                        </div>
                        <div class="info-date">
                            <h5><a href="#">NYC The world’s fashion capital</a></h5>

                        </div>
                    </div>
                    <!--item-->
                    <div class="clearfix"></div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-6">
                    <h4>follow us</h4>
                    <!--Social-->
                    <ul class="social-links list-inline">
                        <li><a href="#"><img src="/assets/home/img/social-icons/facebook.png" alt=""></a></li>
                        <li><a href="#"><img src="/assets/home/img/social-icons/twitter.png" alt=""></a></li>
                        <li><a href="#"><img src="/assets/home/img/social-icons/google.png" alt=""></a></li>
                        <li><a href="#"><img src="/assets/home/img/social-icons/skype.png" alt=""></a></li>

                    </ul>
                    <!--Social-->

                    <!--Newsletter-->
                    <h4 class="top newsletter">Newsletter</h4>

                    <form class="newsletterForm top-mini"
                          action="http://html.iwthemes.com/Enter/php/mailchip/newsletter-subscribe.php">
                        <div class="input-group newsletterFormborder">
                            <input class="form-control" placeholder="Enter your email" name="email" type="email"
                                   required="required">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit" name="subscribe">></button>
                                    </span>
                        </div>
                    </form>
                    <div class="result-newsletter"></div>
                    <!--Newsletter-->
                </div>
            </div>
        </div>
    </footer>
    <!--Footer-->

    <!--Copry-->
    <div class="copry center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright 2015 <span>Flash Sale</span> All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
    <!--Copry-->


    <!-- Modal Contact -->
    <div class="modal fade modal-login">
        <div class="modal-dialog" id="dialog_modal">
            <div class="modal-content">
                <div class="modal-body row">
                    <div class="loginmodel col-lg-12  hidden">
                        <div class="col-lg-6">
                            <h4 class="text-uppercase">Login</h4>

                            <form class="signin_form" method="post" id="userloginform">
                                <div class="form-group">
                                    <label for="login_email">Username or email</label>
                                    <input type="text" class="form-control" id="login_email" name="login_email"
                                           placeholder="Username or email">
                                    <span id="login_email_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="login_password">Password</label>
                                    <input type="password" class="form-control" id="login_password"
                                           name="login_password" placeholder="Password">
                                    <span id="login_password_err"></span>
                                </div>
                                <input type="submit" value="Login" class="boton-color text-uppercase">
                                <a class="pss" onClick="forgotpd()">Lost password?</a>

                                <div id="login-suc-err"></div>
                            </form>
                        </div>

                        <div class="col-lg-6">
                            <h4 class="text-uppercase">Register</h4>

                            <p class="top">By creating an account with our Site, you will be able to move through the
                                checkout
                                process faster, view and track your orders in your
                                account
                                and more.</p>

                            <a class="boton-color text-uppercase open_signup_model"
                               style="color: #f0f0f0;cursor: pointer">Sign up</a>
                        </div>
                    </div>

                    <div class="signupmodel col-lg-12 hidden" style="width: 100%">
                        <div class="col-lg-12">
                            <h4 class="text-uppercase">Signup</h4>

                            <form class="regsiter_form" method="post" id="usersignupform">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                           placeholder="First Name">
                                    <span id="first_name_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                           placeholder="Last Name">
                                    <span id="last_name_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                           placeholder="Username">
                                    <span id="username_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="email">
                                    <span id="email_err"></span>
                                </div>

                                <input type="submit" value="Signup" class="boton-color text-uppercase">
                                <span style="float: right;">Already Registered

                                <a class="boton-color text-uppercase open_login_model"
                                   style="color: #f0f0f0;cursor: pointer">Login</a></span><br>

                                <div id="pw-suc-err"></div>
                            </form>
                            {{--</div>--}}

                            {{--<div class="col-lg-6">--}}

                        </div>
                    </div>

                    <div class="forgotpd col-lg-12 hidden" style="width: 100%">
                        <div class="col-lg-12">
                            <h4 class="text-uppercase">Forgot Password</h4>

                            <form class="regsiter_form" method="post" id="forgotpasswordform">
                                <div class="form-group">
                                    <label for="fp_email">Email</label>
                                    <input type="email" class="form-control" id="fp_email" name="fp_email"
                                           placeholder="Email">
                                    <span id="fp_email_err"></span>
                                </div>
                                <div class="resetcode hidden" id="resetcodediv">
                                    <p>
                                        Check Mail and Enter your reset code below to Reset password
                                    </p>
                                    <div class="form-group">
                                        <label for="fp_email">Reset code</label>
                                        <input type="text" class="form-control" id="resetcode" name="resetcode"
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
                                    <label for="password1">New Password</label>
                                    <input type="password" class="form-control" id="password1" name="password1"
                                           placeholder="New Password">
                                    <span id="password1_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password2">Re-enter Password</label>
                                    <input type="password" class="form-control" id="password2" name="password2"
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

    <!-- Modal Lightbox Subscribe-->
    <div class="modal fade modal-subscribe">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body row">

                    <div class="col-lg-6 text-uppercase">
                        <h2>BE THE FIRST TO <span>KNOW ABOUT NEW ARRIVALS</span></h2>
                    </div>

                    <div class="col-lg-6">
                        <!--Newsletter-->
                        <div class="newsletter-top">
                            <h4 class="newsletter">SUBSCRIBE</h4>

                            <form class="newsletterForm"
                                  action="http://html.iwthemes.com/Enter/php/mailchip/newsletter-subscribe.php">
                                <div class="input-group newsletterFormborder">
                                    <input class="form-control" placeholder="Enter your e-mail" name="email"
                                           type="email"
                                           required="required">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="submit" name="subscribe">>
                                                </button>
                                            </span>
                                </div>
                            </form>
                            <div class="result-newsletter"></div>
                        </div>
                        <!--Newsletter-->
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Lightbox Subscribe-->

    <!-- Modal quickview -->
    <div class="modal fade modal-quickview">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body row">
                    <div class="col-lg-4">
                        <img src="/assets/home/img/featured-products/product-01.jpg" alt="">
                    </div>
                    <div class="col-lg-8">
                        <div class="quickview-info">
                            <h3 class="product-bag">YX Black T-Shirt</h3>

                            <p class="price bottom-mini">$36.00</p>
                            <!--Rating-->
                                    <span class="rating-star">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star down"></i>
                                    </span>
                            <!--Rating-->

                            <!--description-->
                            <div class="description top-mini">Style #4102 <br>In stock</div>
                            <!--description-->

                            <!--sizes-->
                            <ul class="sizes list-inline top-mini text-uppercase">
                                <li class="border-box"><a href="#">XS</a></li>
                                <li class="border-box"><a href="#">s</a></li>
                                <li class="border-box"><a href="#">m</a></li>
                                <li class="border-box"><a href="#">l</a></li>
                                <li class="border-box"><a href="#">Xl</a></li>
                            </ul>
                            <!--sizes-->

                            <!--colors-->
                            <ul class="colors list-inline text-uppercase">
                                <li><a href="#"><img src="/assets/home/img/theme-images/color-dark.png"
                                                     alt="colors select dark"></a>
                                </li>
                                <li><a href="#"><img src="/assets/home/img/theme-images/color-gray.png"
                                                     alt="colors select gray"></a>
                                </li>
                            </ul>
                            <!--colors-->

                            <div class="row top">
                                <div class="col-lg-3">
                                    <!--Counter bag-->
                                    <ul class="counter-bag list-inline">
                                        <li><a href="#">-</a></li>
                                        <li>1</li>
                                        <li><a href="#">+</a></li>
                                    </ul>
                                    <!--Counter bag-->
                                </div>
                                <div class="col-lg-5">
                                    <!--Buttom Add to cart-->
                                    <button type="submit" value="Submit" class="boton-dark text-uppercase">add to cart
                                    </button>
                                    <!--Buttom Add to cart-->
                                </div>
                                <div class="col-lg-4">
                                    <!--Add to bag and save to closet-->
                                    <ul class="gotobag text-uppercase list-unstyled">
                                        <li><span><a href="#">add to bag +</a></span></li>
                                        <li><span><a href="#">save to closet +</a></span></li>
                                    </ul>
                                    <!--Add to bag and save to closet-->
                                </div>
                            </div>

                            <ul class="social-simple list-inline top-mini">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-vimeo"></i></a></li>
                                <li><a href="#"><i class="fa fa-google"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal quickview -->

</div>
<!--Layout Theme Options-->

@include('Home/Layouts/home_footer_scripts')
@yield('pagejavascripts')
<script>
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
        $("#dialog_modal").removeAttr('style');
        $('#firstname').val('');
        $('#lastname').val('');
        $('#username').val('');
        $('#email').val('');
    });
    function forgotpd() {
        $("#dialog_modal").removeAttr('style');
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
        $("#dialog_modal").removeAttr('style');
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

        $('#showdetails').click(function() {
            $('#userpanel').slideToggle('slow', function() {
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
                            if (response['code'] == 200) {
                                $('#pw-suc-err').show();
                                $('#pw-suc-err').html(response['message']);
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
                            if (response['code'] == 200) {
                                $('#login-suc-err').show();
                                $('#login-suc-err').html(response['message']);
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