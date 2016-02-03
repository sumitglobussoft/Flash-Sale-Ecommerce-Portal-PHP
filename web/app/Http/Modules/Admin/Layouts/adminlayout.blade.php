<!DOCTYPE html>
<html>
<head>
    @include('Admin/Layouts/adminheadscripts')
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
                                <span class="user-name">Administration<i class="fa fa-angle-down"></i></span>
                            </a>
                            <ul class="dropdown-menu dropdown-list" role="menu">
                                <li role="presentation"><a href="/admin/manage-currencies">Currencies</a></li>
                                <li role="presentation"><a href="/admin/cacheClear">Clear cache</a></li>
                            </ul>
                        </li>
                        <?php $allSections = \FlashSale\Http\Modules\Admin\Controllers\AdminController::getSettingsSection(); ?>
                        @if(count($allSections))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                                   data-toggle="dropdown">
                                    <span class="user-name">Settings<i class="fa fa-angle-down"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    <li role="presentation"><a href="/admin/control-panel">Control panel</a></li>
                                    <li role="presentation" class="divider"></li>
                                    @foreach($allSections as $section)
                                        <li role="presentation">
                                            <a href="/admin/manage-settings/{{$section->name}}">{{str_replace('_',' ',$section->name)}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                               data-toggle="dropdown">
                                <span class="user-name">Admin<i class="fa fa-angle-down"></i></span>
                                <img class="img-circle avatar" src="/assets/images/avatar1.png" width="40" height="40"
                                     alt="">
                            </a>
                            <ul class="dropdown-menu dropdown-list" role="menu">
                                {{--<li role="presentation"><a href="/admin/profile"><i class="fa fa-user"></i>Profile</a></li>--}}
                                {{--<li role="presentation"><a href="/calender"><i class="fa fa-calendar"></i>Calendar</a></li>--}}
                                {{--<li role="presentation"><a href="/inbox"><i class="fa fa-envelope"></i>Inbox<span class="badge badge-success pull-right">4</span></a></li>--}}
                                {{--<li role="presentation" class="divider"></li>--}}
                                {{--<li role="presentation"><a href="/admin/control-panel"><i class="fa fa-cogs"></i>Control Panel</a></li>--}}
                                {{--<li role="presentation"><a href="/admin/cacheClear"><i class="fa fa-trash "></i>Clear cache</a></li>--}}
                                {{--<li role="presentation"><a href="/lock-screen"><i class="fa fa-lock"></i>Lock screen</a></li>--}}
                                <li role="presentation"><a href="/admin/add-new-language"><i class="fa fa-cogs"></i>Languages</a>
                                </li>
                                <li role="presentation"><a href="/admin/logout"><i class="fa fa-sign-out m-r-xs"></i>Log
                                        out</a></li>
                            </ul>
                        </li>
                        {{--<li>--}}
                        {{--<a href="/admin/logout" class="log-out waves-effect waves-button waves-classic">--}}
                        {{--<span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>--}}
                        {{--</a>--}}
                        {{--</li>--}}
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
                        <span class="menu-icon fa fa-users"></span>

                        <p>Suppliers</p> <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="/admin/pending-supplier">Pending requests</a></li>
                        <li><a href="/admin/available-supplier">Available suppliers</a></li>
                        <li><a href="/admin/add-new-supplier">Add New suppliers</a></li>
                        {{--<li><a href="/admin/rejected-suppliers">Rejected suppliers</a></li>--}}
                        <li><a href="/admin/deleted-supplier">Deleted suppliers</a></li>
                    </ul>
                </li>

                <li class="droplink">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon fa fa-users"></span>

                        <p>Customers</p> <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="/admin/pending-customer">Pending Customers</a></li>
                        <li><a href="/admin/available-customer">Available Customers</a></li>
                        <li><a href="/admin/deleted-customer">Deleted Customers</a></li>
                    </ul>
                </li>

                <li class="droplink">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon fa fa-users"></span>

                        <p>Buyers</p> <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="/admin/pending-users">Pending Buyers</a></li>
                        <li><a href="/admin/available-users">Available Buyers</a></li>
                        <li><a href="/admin/deleted-users">Deleted Buyers</a></li>
                    </ul>
                </li>

                <li class="droplink">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon fa fa-users"></span>

                        <p>Manager</p> <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="/admin/add-new-manager">Add New Manager</a></li>
                        <li><a href="/admin/pending-manager">Pending Manager</a></li>
                        <li><a href="/admin/available-manager">Available Manager</a></li>
                        <li><a href="/admin/deleted-manager">Deleted Manager</a></li>
                    </ul>
                </li>

                <li class="droplink">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon glyphicon glyphicon-shopping-cart"></span>

                        <p>Products</p> <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="/admin/manage-products">Products</a></li>
                        <li><a href="/admin/manage-categories">Categories</a></li>
                        <li><a href="/admin/manage-features">Features</a></li>
                        <li><a href="/admin/manage-filtergroup">Filters</a></li>
                        <li><a href="/admin/manage-options">Options</a></li>
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
            <h3><b>@yield('title')</b></h3>
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

@include('Admin/Layouts/admincommonfooterscripts')

@yield('pagejavascripts')
<script src="/assets/js/modern.js"></script>

{{--<script>--}}
    {{--//FOR DESKTOP NOTIFICATION--}}
    {{--//request permission on page load--}}
    {{--document.addEventListener('DOMContentLoaded', function () {--}}
        {{--if (Notification.permission !== "granted")--}}
            {{--Notification.requestPermission();--}}
    {{--});--}}

    {{--function notifyMe() {--}}
        {{--if (!Notification) {--}}
            {{--alert('Desktop notifications not available in your browser. Try Chromium.');--}}
            {{--return;--}}
        {{--}--}}
        {{--if (Notification.permission !== "granted")--}}
            {{--Notification.requestPermission();--}}
        {{--else {--}}
            {{--var notification = new Notification('Execution time in sec', {--}}
                {{--icon: '/assets/images/fs.png',--}}
                {{--body: "Your notification",--}}
                {{--body: "{{number_format((microtime(true) - \Illuminate\Support\Facades\Session::get('startTime')),5)}}",--}}

            {{--});--}}
            {{--setTimeout(notification.close.bind(notification), 2000);//Close notification--}}
            {{--notification.onclick = function () {--}}
                {{--return false;--}}
{{--//                window.open(window.location.host);--}}
            {{--};--}}
        {{--}--}}
    {{--}--}}
    {{--window.onload = notifyMe;--}}
    {{--<?php \Illuminate\Support\Facades\Session::forget('startTime'); ?>--}}
{{--</script>--}}
</body>
</html>