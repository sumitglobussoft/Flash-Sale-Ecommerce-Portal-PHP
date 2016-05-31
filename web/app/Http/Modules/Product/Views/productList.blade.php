@extends('Home/Layouts/home_layout')
@section('pageheadcontent')
    {{--OPTIONAL--}}
    <link href="/assets/global/css/etalage.css" media="screen" rel="stylesheet" type="text/css">
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <style>
        .etalage_zoom_preview {
            opacity: 1 !important;
        }

        li.etalage_zoom_area div:last-child {
            width: 440px !important;
            /*height: 440px !important;*/
        }
    </style>
@endsection

@section('content')

    {{--<form id="paypalform" name="_xclick" action="https://sandbox.paypal.com/cgi-bin/webscr" method="post">--}}
        {{--<input type="hidden" name="cmd" value="_xclick">--}}
        {{--<input type="hidden" name="upload" value="1">--}}
        {{--<input type="hidden" name="business" value="raushank3-facilitator@gmail.com">--}}
        {{--<input type="hidden" name="currency_code" value="USD">--}}
        {{--<input type="hidden" name="item_name" id="items" value="cloth">--}}
        {{--<input type="hidden" name="amount" id="prices" value="100">--}}
        {{--<input type="hidden" name="rm" id="rm" value="2">--}}
        {{--<input type="hidden" name="return" value="http://localhost.flashsale.com/product-list">--}}
        {{--<input type="image" class="" src="/images/buynowpaypal.png" border="0"--}}
               {{--alt="Make payments with PayPal - it's fast, free and secure!">--}}
    {{--</form>--}}

    <?php if (isset($productList) && !empty($productList)) { ?>
<?php echo '<pre>';
        print_r($productList);
    } else { ?>

    <?php echo "No products Found";
    }?>
@endsection
@section('pagejavascripts')
    <script type="text/javascript"
            src="/assets/scripts/jquery.mThumbnailScroller.js"></script>
    <script src="/assets/scripts/jquery-ui.js" type="text/javascript"></script>

    <script type="text/javascript">

        $(document).ready(function () {

            var pageurl = window.location.href;
            var urlparams = (pageurl.split("?"));
            var categoryname = '';
            var subcategoryname = '';
            var searchterm = '';
            if (urlparams.length > 1) {
                urlparams = urlparams[1].split('&');
                if (urlparams.length > 0) {
                    $.each(urlparams, function (i, a) {
                        a = a.split("=");
                        var key = a[0];
                        if (key == "cat") {
                            categoryname = a[1];
                        }
                        if (key == "subcat") {
                            subcategoryname = a[1];
                        }
                        if (key == "q") {
                            searchterm = a[1];
                        }
                    });
                }
            }


            function filter() {


            }


        });
    </script>

@endsection