<?php \App::setLocale(\Session::get('user_locale')); ?>
        <!-- Title -->
{{--<title>FlashSale User | @yield('title')</title>--}}

{{--<meta content="width=device-width, initial-scale=1" name="viewport"/>--}}
{{--<meta charset="UTF-8">--}}
{{--<meta name="description" content="FlashSale"/>--}}
{{--<meta name="keywords" content="flashsale,discount,shopping,online shopping,paypal"/>--}}
{{--<meta name="author" content="FlashSale User"/>--}}

{{--<!-- Styles -->--}}
{{--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>--}}

{{--<!-- Your styles -->--}}
{{--<link href="/assets/home/css/style.css" rel="stylesheet" media="screen">--}}
{{--<link href="/assets/home/css/responsive-theme.css" rel="stylesheet" media="screen">--}}

{{--<!-- Favicons -->--}}
{{--<!--        <link rel="shortcut icon" href="img/icons/favicon.ico">-->--}}
{{--<link rel="apple-touch-icon" href="/assets/home/img/icons/apple-touch-icon.png">--}}
{{--<link rel="apple-touch-icon" sizes="72x72" href="/assets/home/img/icons/apple-touch-icon-72x72.png">--}}
{{--<link rel="apple-touch-icon" sizes="114x114" href="/assets/home/img/icons/apple-touch-icon-114x114.png">--}}

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
<[endif]-->

<!--[if (gte IE 6)&(lte IE 8)]>
<script type="text/javascript" src="js/css3selectors/selectivizr.js"></script>
<[endif]-->


<!-- New Layout Content Start -->
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flash Sale | @yield('title')</title>

    <!-- bootstrap CDN Links -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
          type='text/css'/>
    <!-- Styles -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

    <!-- Favicons -->
    <!--        <link rel="shortcut icon" href="img/icons/favicon.ico">-->
    <link rel="apple-touch-icon" href="/assets/home/img/icons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/home/img/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/home/img/icons/apple-touch-icon-114x114.png">


    <!-- fonts CDN Links -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700' rel='stylesheet'
          type='text/css'/>
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,700' rel='stylesheet' type='text/css'>
    <link href='http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

    <!-- icons CDN Links -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Custom css  -->
    <link href="/assets/css/styles.css" rel="stylesheet"/>
    <link href="/assets/home/css/responsive-theme.css" rel="stylesheet" media="screen">
</head>
<!-- Skins Changer-->

<!-- New Layout Content Ends Here -->

<script src="/assets/home/js/modernizr/modernizr.js"></script>


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