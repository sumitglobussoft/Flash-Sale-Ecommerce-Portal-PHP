<!DOCTYPE html>
<html>
<head>
    <!-- Title -->
    <title>FlashSale Admin | @yield('title')</title>

    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    <meta name="description" content="FlashSale"/>
    <meta name="keywords" content="flashsale,discount,shopping,online shopping,paypal"/>
    <meta name="author" content="FlashSale Admin"/>

    <!-- Styles -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="/assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
    <link href="/assets/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/weather-icons-master/css/weather-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/metrojs/MetroJs.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css"/>

    {{--{{HTML::style('assets/plugins/pace-master/themes/blue/pace-theme-flash.css')}}--}}

    <!-- Theme Styles -->
    <link href="/assets/css/modern.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
    <!--white.css-->
    <link href="/assets/css/custom.css" rel="stylesheet" type="text/css"/>

    <script src="/assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
    <script src="/assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>

    {{--{{HTML::script('js/example.js')}}--}}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('headcontent')

</head>
<body class="page-header-fixed compact-menu page-sidebar-fixed">
<div class="overlay"></div>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1">
    <h3><span class="pull-left">Chat</span><a href="javascript:void(0);" class="pull-right" id="closeRight"><i
                    class="fa fa-times"></i></a></h3>

    <div class="slimscroll">
        <a href="javascript:void(0);" class="showRight2"><img src="/assets/images/avatar2.png" alt=""><span>Sandra smith<small>
                    Hi! How're you?
                </small></span></a>
    </div>
</nav>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
    <h3><span class="pull-left">Sandra Smith</span> <a href="javascript:void(0);" class="pull-right" id="closeRight2"><i
                    class="fa fa-angle-right"></i></a></h3>

    <div class="slimscroll chat">
        <div class="chat-item chat-item-left">
            <div class="chat-image">
                <img src="/assets/images/avatar2.png" alt="">
            </div>
            <div class="chat-message">
                Hi There!
            </div>
        </div>
        <div class="chat-item chat-item-right">
            <div class="chat-message">
                Hi! How are you?
            </div>
        </div>
    </div>
    <div class="chat-write">
        <form class="form-horizontal" action="javascript:void(0);">
            <input type="text" class="form-control" placeholder="Say something">
        </form>
    </div>
</nav>
<div class="menu-wrap">
    <nav class="profile-menu">
        <div class="profile"><img src="/assets/images/avatar1.png" width="52"
                                  alt="David Green"/><span>David Green</span>
        </div>
        <div class="profile-menu-list">
            <a href="#"><i class="fa fa-star"></i><span>Favorites</span></a>
            <a href="#"><i class="fa fa-bell"></i><span>Alerts</span></a>
            <a href="#"><i class="fa fa-envelope"></i><span>Messages</span></a>
            <a href="#"><i class="fa fa-comment"></i><span>Comments</span></a>
        </div>
    </nav>
    <button class="close-button" id="close-button">Close Menu</button>
</div>
<form class="search-form" action="#" method="GET">
    <div class="input-group">
        <input type="text" name="search" class="form-control search-input" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button">
                        <i class="fa fa-times"></i></button>
                </span>
    </div>
    <!-- Input Group -->
</form>
<!-- Search Form -->
<main class="page-content content-wrap">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="sidebar-pusher">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="logo-box">
                <a href="/" class="logo-text"><span>FlashSale</span></a>
            </div>
            <!-- Logo Box -->
            <div class="search-button">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i
                            class="fa fa-search"></i></a>
            </div>
            <div class="topmenu-outer">
                <div class="top-menu">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="javascript:void(0);"
                               class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                        </li>
                        <!--<li>
                            <a href="#cd-nav" class="waves-effect waves-button waves-classic cd-nav-trigger"><i
                                        class="fa fa-diamond"></i></a>
                        </li>-->
                        <!--<li>
                            <a href="javascript:void(0);"
                               class="waves-effect waves-button waves-classic toggle-fullscreen"><i
                                        class="fa fa-expand"></i></a>
                        </li>-->
                        <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                               data-toggle="dropdown">
                                <i class="fa fa-cogs"></i>
                            </a>
                    </li>-->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li>
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i
                        class="fa fa-search"></i></a>
                        </li>-->
                        <!--USE ONE OF THE BELOW BLOCK COMMENTS FOR NOTIFICATIONS DROPDOWN-->
                        <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                               data-toggle="dropdown"><i class="fa fa-envelope"></i><span
                                        class="badge badge-success pull-right">4</span></a>
                            <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                                <li><p class="drop-title">You have 4 new messages !</p></li>
                                <li class="dropdown-menu-list slimscroll messages">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="#">
                                                <div class="msg-img">
                                                    <div class="online on"></div>
                                                    <img class="img-circle" src="/assets/images/avatar2.png" alt="">
                                                </div>
                                                <p class="msg-name">Sandra Smith</p>
                                                <p class="msg-text">Hey ! I'm working on your project</p>
                                                <p class="msg-time">3 minutes ago</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="drop-all"><a href="#" class="text-center">All Messages</a></li>
                            </ul>
                        </li>-->
                        <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                               data-toggle="dropdown"><i class="fa fa-bell"></i><span
                                        class="badge badge-success pull-right">3</span></a>
                            <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                                <li><p class="drop-title">You have 3 pending tasks !</p></li>
                                <li class="dropdown-menu-list slimscroll tasks">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="#">
                                                <div class="task-icon badge badge-success"><i class="icon-user"></i>
                                                </div>
                                                <span class="badge badge-roundless badge-default pull-right">1min ago</span>
                                                <p class="task-details">New user registered.</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="drop-all"><a href="#" class="text-center">All Tasks</a></li>
                            </ul>
                        </li>-->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                               data-toggle="dropdown">
                                <span class="user-name">David<i class="fa fa-angle-down"></i></span>
                                <img class="img-circle avatar" src="/assets/images/avatar1.png" width="40" height="40"
                                     alt="">
                            </a>
                            <ul class="dropdown-menu dropdown-list" role="menu">
                                <li role="presentation"><a href="/admin/profile"><i class="fa fa-user"></i>Profile</a>
                                </li>
                                {{--<li role="presentation"><a href="/calender"><i class="fa fa-calendar"></i>Calendar</a></li>--}}
                                {{--<li role="presentation"><a href="/inbox"><i class="fa fa-envelope"></i>Inbox<span class="badge badge-success pull-right">4</span></a></li>--}}
                                {{--<li role="presentation" class="divider"></li>--}}
                                {{--<li role="presentation"><a href="/lock-screen"><i class="fa fa-lock"></i>Lock screen</a></li>--}}
                                <li role="presentation"><a href="/logout"><i class="fa fa-sign-out m-r-xs"></i>Log
                                        out</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="/logout" class="log-out waves-effect waves-button waves-classic">
                                <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                            </a>
                        </li>
                        <!--UNCOMMENT THIS BLOCK  WITH SCRIPT IN MODERN.JS TO SHOW CHAT BOX ON RIGHT-->
                        <!--<li>
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic"
                               id="showRight">
                                <i class="fa fa-comments"></i>
                            </a>
                        </li>-->
                    </ul>
                    <!-- Nav -->
                </div>
                <!-- Top Menu -->
            </div>
        </div>
    </div>
    <!-- Navbar -->
    <div class="page-sidebar sidebar">
        <div class="page-sidebar-inner slimscroll">
            <!--<div class="sidebar-header">
                <div class="sidebar-profile">
                    <a href="javascript:void(0);" id="profile-menu-link">
                        <div class="sidebar-profile-image">
                            <img src="/assets/images/avatar1.png" class="img-circle img-responsive" alt="">
                        </div>
                        <div class="sidebar-profile-details">
                            <span>David Green<br><small>Art Director</small></span>
                        </div>
                    </a>
                </div>
            </div>-->
            <ul class="menu accordion-menu">
                <li class="active">
                    <a href="/admin/dashboard" class="waves-effect waves-button">
                        <span class="menu-icon glyphicon glyphicon-home"></span>

                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="droplink">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon glyphicon glyphicon-user"></span>

                        <p>Suppliers</p> <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="/admin/pending-suppliers">Pending requests</a></li>
                        <li><a href="/admin/available-suppliers">Available suppliers</a></li>
                        <li><a href="/admin/rejected-suppliers">Rejected suppliers</a></li>
                        <li><a href="/admin/deleted-suppliers">Deleted suppliers</a></li>
                    </ul>
                </li>

                <li class="droplink">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon glyphicon glyphicon-envelope"></span>

                        <p>Users</p> <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="/admin/pending-users">Pending Users</a></li>
                        <li><a href="/admin/available-users">Available Users</a></li>
                        <li><a href="/admin/deleted-users">Deleted Users</a></li>
                    </ul>
                </li>
                <!-- glyphicon-briefcase    glyphicon-th    glyphicon-list  glyphicon-edit  glyphicon-stats
                glyphicon-log-in    glyphicon-map-marker    glyphicon-gift-->
            </ul>
        </div>
        <!-- Page Sidebar Inner -->
    </div>
    <!-- Page Sidebar -->

    <div class="page-inner">
        <div class="page-title">
            <h3>@yield('title')</h3>
            <!--<div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li>Admin</li>
                    <li class="active"></li>
                </ol>
            </div>-->
        </div>
        <div id="main-wrapper">
            {{------------------------------------------CONTENT GOES HERE-----------------------------------------}}
            @yield('content')
        </div>
        <!-- Main Wrapper -->
        <div class="page-footer">
            <p class="no-s">2015 &copy; FlashSale.</p>
        </div>
    </div>
    <!-- Page Inner -->

</main>
<!-- Page Content -->
<!--RIGHT SIDE SHORTCUTS MENU-->
<!--<nav class="cd-nav-container" id="cd-nav">
    <header>
        <h3>Navigation</h3>
        <a href="#0" class="cd-close-nav">Close</a>
    </header>
    <ul class="cd-nav list-unstyled">
        <li class="cd-selected" data-menu="index">
            <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-home"></i>
                        </span>
                <p>Dashboard</p>
            </a>
        </li>
    </ul>
</nav>-->
<div class="cd-overlay"></div>


<!-- Javascripts -->
<script src="/assets/plugins/jquery/jquery-2.1.3.min.js"></script>
<script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/plugins/pace-master/pace.min.js"></script>
<script src="/assets/plugins/jqury-blockui/jquery.blockui.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets/plugins/switchery/switchery.min.js"></script>
<script src="/assets/plugins/uniform/jquery.uniform.min.js"></script>
<script src="/assets/plugins/offcanvasmenueffects/js/classie.js"></script>
{{--<script src="/assets/plugins/offcanvasmenueffects/js/main.js"></script>--}}
<script src="/assets/plugins/waves/waves.min.js"></script>
<script src="/assets/plugins/3d-bold-navigation/js/main.js"></script>
<script src="/assets/plugins/waypoints/jquery.waypoints.min.js"></script>
<script src="/assets/plugins/jquery-counterup/jquery.counterup.min.js"></script>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
{{--<script src="/assets/plugins/flot/jquery.flot.min.js"></script>--}}
{{--<script src="/assets/plugins/flot/jquery.flot.time.min.js"></script>--}}
{{--<script src="/assets/plugins/flot/jquery.flot.symbol.min.js"></script>--}}
{{--<script src="/assets/plugins/flot/jquery.flot.resize.min.js"></script>--}}
{{--<script src="/assets/plugins/flot/jquery.flot.tooltip.min.js"></script>--}}
{{--<script src="/assets/plugins/curvedlines/curvedLines.js"></script>--}}
<script src="/assets/plugins/metrojs/MetroJs.mein.js"></script>
<script src="/assets/js/modern.js"></script>
{{--<script src="/assets/js/pages/dashboard.js"></script>--}}

@yield('pagejavascripts')

</body>
</html>