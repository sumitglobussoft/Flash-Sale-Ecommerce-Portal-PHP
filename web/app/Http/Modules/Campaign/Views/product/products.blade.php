<?php


?>

<script type="text/javascript">

    $(document).ready(function () {

        var pageurl = window.location.href;
        var urlparams = (pageurl.split("/"));


        var pagenumber = 1;

//        $("#slider-range").slider({
//            range: true,
//            values: [1, 1000000],
//            min: 1,
//            max: 1000000,
//            step: 100,
//            slide: function (event, ui) {
//                $("#amount").val("Rs." + ui.values[0] + " - Rs." + ui.values[1]);
//            },
//            stop: function (e) {
//                pagenumber = 1;
//                window.setTimeout(function () {
//                    filter();
//                }, 200);
//            }
//        });

        $(document.body).on('click', '.subcategories', function () {
            pagenumber = 1;
            var subcats = $('.subcategories');
            $.each(subcats, function (i, a) {
                $(a).removeClass('subcategoryselected');
            });
            $(this).addClass('subcategoryselected');
            window.setTimeout(function () {
                filter();
            }, 200);
            var subcategoryname = $(this).html();
        });


        $(document.body).on('click', '.suboption', function () {
            pagenumber = 1;
            var subcats = $('.subcategories');
            $.each(subcats, function (i, a) {
                $(a).removeClass('subcategoryselected');
            });
            $(this).parent().parent().parent().find('.subcategories').addClass('subcategoryselected');
            pagenumber = 1;
            var suboption = $('.suboption');
            $.each(suboption, function (i, a) {
                $(a).removeClass('suboptionselected');
            });
            $(this).addClass('suboptionselected');
            window.setTimeout(function () {
                filter();
            }, 200);
            var suboptionname = $(this).html();

        });

    });

    $(document.body).on('click', '.filtercolor', function () {
        $(this).toggleClass('active');
        pagenumber = 1;
        window.setTimeout(function () {
            filter();
        }, 200);
    });

    $(document.body).on('click', '.filterbrandinput', function () {
        $(this).toggleClass('active');
        pagenumber = 1;
        window.setTimeout(function () {
            filter();
        }, 200);
    });


    $(document.body).on('click', '.filtersizing', function () {
        $(this).toggleClass('active');
        pagenumber = 1;
        window.setTimeout(function () {
            filter();
        }, 200);
    });

    $(document.body).on('click', '.filtermaterial', function () {
        $(this).toggleClass('active');
        pagenumber = 1;
        window.setTimeout(function () {
            filter();
        }, 200);
    });

    $(document.body).on('click', '.filterpattern', function () {
        $(this).toggleClass('active');
        pagenumber = 1;
        window.setTimeout(function () {
            filter();
        }, 200);
    });

    $(document.body).on('change', '#selectsortby', function (e) {
        pagenumber = 1;
        window.setTimeout(function () {
            filter();
        }, 200);
    });

    //* Function for product filter *//
    function filter() {

//        if ($('.categoryselected').html()) {
//            categoryname = $('.categoryselected').html();
        if ($('.subcategoryselected').html()) {
            subcategoryname = $('.subcategoryselected').html();
            if ($('.suboption').html()) {
                suboptionname - $('.suboptionselected').html();
            }
        }
//        }
//        var tags = $('.filtertagsinput:checked');
//        var selectedtags = [];
//        $.each(tags, function (i, a) {
//            var temptagId = $(a).attr('id').split('-');
//            selectedtags.push(temptagId[1]);
//        });

        var sortby = $('#selectsortby > option:selected').val();

        var colors = $('.filtercolor');
        var selectedcolors = [];
        $.each(colors, function (i, a) {
            if ($(a).hasClass('active')) {
                var tempColorId = $(a).attr('id').split('-');
                selectedcolors.push(tempColorId[1]);
            }
        });

        var brand = $('.filterbrandinput:checked');
        var selectedbrand = [];
        $.each(brand, function (i, a) {
            var tempBrandId = $(a).attr('id').split('-');
            selectedbrand.push(tempBrandId[1]);
        });

        var size = $('.filtersizing');
        var selectedsize = [];
        $.each(selectedsize, function (i, a) {
            var tempSizeId = $(a).attr('id').split('-');
            selectedsize.push(tempSizeId[1]);
        });

        var material = $('.filtermaterial');
        var selectedmaterial = [];
        $.each(selectedmaterial, function (i, a) {
            var tempMaterialId = $(a).attr('id').split('-');
            selectedmaterial.push(tempMaterialId[1]);
        });

        var pattern = $('.filterpattern');
        var selectedpattern = [];
        $.each(selectedpattern, function (i, a) {
            var tempPatternId = $(a).attr('id').split('-');
            selectedpattern.push(tempPatternId)[1];
        });


        var pricerange = $('#amount').val();
        var pricerangearr = pricerange.split(" - ");
        var pricerangefrom = (pricerangearr[0].split("."))[1];
        var pricerangeto = (pricerangearr[1].split("."))[1];
        url = "?subcat=subcats&subop=suboption&color=selectedcolors"
        redirect(url);
    }


</script>