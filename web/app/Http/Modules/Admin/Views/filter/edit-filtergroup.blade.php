@extends('Admin/Layouts/adminlayout')

@section('title', 'Edit Filter Group') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--<link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/plugins/summernote-master/summernote.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/assets/plugins/jstree/themes/default/style.min.css" rel="stylesheet" type="text/css"/>
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">

                <div class="portlet-title">

                    <div class="actions">
                        <a class="btn btn-default" href="/admin/manage-filtergroup">Back to list </a>
                    </div>

                </div>

                <div class="alert">
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>

                <form class="form form-horizontal" id="addnewfiltergroupform" method="post"
                      enctype="multipart/form-data">
                    <div class="form-body">

                        <div class="form-group">
                            <label for="productfiltergroupname" class="col-md-3 control-label">Filter
                                name:</label>

                            <div class="col-md-4">
                                <input type="text" class="form-control" id="productfiltergroupname"
                                       placeholder="filter name" name="productfiltergroupname"
                                       value="{{ $editfiltergroup->product_filter_option_name }}">
                            </div>
                            {!!  $errors->first('productfiltergroupname', '<font color="red">:message</font>') !!}
                        </div>

                        <div class="clearfix"></div>
                        {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label">Filter Group Description</label>--}}
                        {{--<div class="col-sm-10">--}}
                        {{--<div class="summernote"></div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="filterdescription" class="col-md-3 control-label">Filter
                                Description</label>

                            <div class="col-md-4">
                                <input type="text" class="form-control" id="filterdescription"
                                       placeholder="filter description" name="filterdescription"
                                       value="<?php echo $editfiltergroup->product_filter_option_description?>">
                            </div>
                            {!!  $errors->first('filterdescription', '<font color="red">:message</font>') !!}
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label for="productfiltergroupnamestatus" class="col-md-3 control-label">Filter By:</label>
                            <?php if (($editfiltergroup->product_filter_feature_id) != 0) {
                                echo $editfiltergroup->feature_name;
                            } else {
                                if ($editfiltergroup->product_filter_parent_product_id == 1) {
                                    echo "Price";
                                } elseif ($editfiltergroup->product_filter_parent_product_id == 2) {
                                    echo "Instock";
                                } else {
                                    echo "Free Shiping";
                                }
                            } ?>
                        </div>
                        <div class="clearfix"></div>
                        {{--<div class="form-group">--}}
                        {{--<label for="productfiltergroupnamestatus" class="col-md-3 control-label">Filter group--}}
                        {{--status:</label>--}}

                        {{--<div class="col-md-2">--}}
                        {{--<select class="form-control" id="productfiltergroupnamestatus"--}}
                        {{--name="productfiltergroupnamestatus">--}}
                        {{--<option value="">set status</option>--}}
                        {{--<option value="0">Inactive</option>--}}
                        {{--<option value="1">Active</option>--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<h4 class="no-m m-b-sm m-t-lg">Multiple Selection</h4>--}}
                        {{--<select class="js-states form-control" multiple="multiple" tabindex="-1" style="display: none; width: 100%">--}}
                        {{--<optgroup label="Alaskan/Hawaiian Time Zone">--}}
                        {{--<option value="AK">Alaska</option>--}}
                        {{--<option value="HI">Hawaii</option>--}}
                        {{--</optgroup>--}}
                        {{--<optgroup label="Pacific Time Zone">--}}
                        {{--<option value="CA">California</option>--}}
                        {{--<option value="NV">Nevada</option>--}}
                        {{--<option value="OR">Oregon</option>--}}
                        {{--<option value="WA">Washington</option>--}}
                        {{--</optgroup>--}}
                        {{--</select>--}}


                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h3 class="panel-title">Choose Categories</h3>
                            </div>
                            <div class="panel-body">
                                <div id="checkTree">
                                    <ul>
                                        <li data-jstree='{"opened":true}'>All Categories
                                            <span class="catinputdiv" data-id="0"></span>

                                            <?php
                                            $selectedcategory;

                                            function treeView($array, $selectedcategory, $id = 0)
                                            {

                                            for ($i = 0; $i < count($array); $i++) {

                                            if ($array[$i]->parent_category_id == $id) {  ?>
                                            <ul>
                                                <li class="catli" data-jstree='{"opened":true}'>
                                                    <?php echo $array[$i]->category_name;
                                                    $catId = $array[$i]->category_id; ?>
                                                    <span class="catinputdivs"
                                                          data-id="<?php echo $array[$i]->category_id; ?>"
                                                          data-checked="{{ (isset(old('productcategories')[$catId]) || in_array($array[$i]->category_id, $selectedcategory)) ? "checked" : ""}}"></span>

                                                    <?php // echo $array[$i]->display_name . $array[$i]->category_name ?>

                                                    {{--<li data-jstree='{"type":"file"}'> --}}
                                                    <?php treeView($array, $selectedcategory, $array[$i]->category_id); ?>
                                                </li>
                                            </ul>
                                            <?php
                                            }
                                            }
                                            } ?>
                                            {{--</li>--}}

                                            @if(isset($categories))
                                                <?php echo treeView($categories, $selectedcategory);  ?>
                                            @endif

                                        </li>
                                    </ul>
                                </div>
                                {!!  $errors->first('productcategories', '<font color="red">:message</font>') !!}
                            </div>
                        </div>

                        {{--<div class="checkbox">--}}
                        {{--<label for="filtercheckproduct" class="col-md-3 control-label" >Display On Product Detail--}}
                        {{--<input type="checkbox" name="filtercheckproduct">--}}
                        {{--</label>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                        {{--<div class="checkbox">--}}
                        {{--<label for="filtercheckcatalog" class="col-md-3 control-label" >Display On Catalog--}}
                        {{--<input type="checkbox" name="filtercheckcatalog">--}}
                        {{--</label>--}}
                        {{--</div>--}}

                    </div>


                    <button type="submit" class="btn btn-info btn-rounded" id="submitadd">Save filter group</button>


                </form>

            </div>
        </div>
    </div>
@endsection


@section('pagejavascripts')
    {{--<script src="/assets/plugins/select2/js/select2.min.js"></script>--}}
    <script src="/assets/plugins/jstree/jstree.min.js"></script>
    <script src="/assets/js/pages/jstree.js"></script>
    {{--<script src="/assets/plugins/summernote-master/summernote.min.js"></script>--}}
    <script type="text/javascript">

        $(document).ready(function () {

            setTimeout(function () {
                var catinputdivs = $('.catinputdivs');
                $.each(catinputdivs, function (i, a) {
                    var catid = $(a).attr('data-id');
                    var datacheck = $(a).attr('data-checked');
                    var checkedstring = '';
                    if ($(a).attr('data-checked') == "checked") {
                        checkedstring = "checked";
                    }
                    $(a).html('<input type="checkbox" name="productcategories[' + catid + ']" class="catinput" hidden ' + $(a).attr('data-checked') + '/>');
                });

                var catinputs = $('.catinput');
                $.each(catinputs, function (i, a) {
                    if ($(a).attr('checked') != undefined) {
                        $(a).parent().parent().click();
                    }
                });
            }, 1000);
//            $("#select2_sample_modal_5").select2({
//                productcategories: ['2', '3', '5']
//            });

            $(document.body).on("change", 'input:checkbox[name="filtercheckproduct"]', function () {
                var checkedflagproduct = $(this).is(':checked');
                alert(checkedflagproduct);
            });

            $(document.body).on("change", 'input:checkbox[name="filtercheckcatalog"]', function () {
                var checkedflagcatalog = $(this).is(':checked');
                alert(checkedflagcatalog);
            });
//            $.validator.addMethod("nameregex", function (value, element) {
//                return this.optional(element) || /^[A-Za-z\-'\s]+$/.test(value);
//            }, "Name can contain only alphabets, white spaces and hyphens.");

            var count = 2;

//            $('#addnewfiltergroupform').validate({
////            ignore: [],
//                rules: {
//                    productfiltergroupname: {
//                        required: true,
//                        nameregex: true,
//                        remote: {
//                            url: "/admin/features-ajax-handler",
//                            type: 'POST',
//                            datatype: 'json',
//                            data: {
//                                method: 'checkForProductcategoryName'
//                            }
//                        }
//                    },
//                    productfiltergroupnamestatus: {
//                        required: true
//                    },
//                    "filter[]": {
//                        nameregex: true
//                    }
//                },
//                messages: {
//                    productfiltergroupname: {
//                        required: "Please enter a name for filter group.",
//                        remote: "Specific filter group already exists."
//                    },
//                    productfiltergroupnamestatus: {
//                        required: "Please set the status."
//                    }
//                }
//            });

            var count = 2;

            $(document.body).on('click', '#addanotherfiltergroupdiv', function (e) {
                e.preventDefault();
                var toAppend = '<div class="form-group">';
                toAppend += '<label for="tag[]" class="col-md-1 control-label">Name:</label>';
                toAppend += '<div class="col-md-2">';
                toAppend += '<input type="text" class="form-control" placeholder="name" name="tag[]" id="taginput' + count + '">';
                toAppend += '</div>';
                toAppend += '<label for="tagdescription[]" class="col-md-1 control-label">Description:</label>';
                toAppend += '<div class="col-md-4">';
                toAppend += '<textarea class="form-control" placeholder="description" name="tagdescription[]" id="tagdescinput' + count + '" style="max-width: 100%; max-height: 150px; min-height: 40px; min-width: 100%;"></textarea>';
                toAppend += '</div>';
                toAppend += '<label for="tagstatus[]" class="col-md-1 control-label">Status:</label>';
                toAppend += '<div class="col-md-2">';
                toAppend += '<select class="form-control" name="tagstatus[]">';
                toAppend += '<option value="0">Inactive</option>';
                toAppend += '<option value="1" selected>Active</option>';
                toAppend += '</select>';
                toAppend += '</div>';
                toAppend += '<div class="col-md-1" id="addanotherfiltergroupdiv">';
                toAppend += '<button class="btn btn-info fa fa-plus" id="addanotherfiltergroupdiv"></button>';
                toAppend += '</div>';
                toAppend += '</div>';
                toAppend += '<div class="clearfix"></div>';

                $('#addanotherfiltergroupdiv').remove();
                $(toAppend).insertBefore($('#appendbeforehere'));

                $("#filterinput1" + count).rules('add', {
                    nameregex: true
                });

                count++;
            });

            $(document.body).on("click", '.jstree-anchor', function () {
                console.log($(this).find('.catinput'));
                if ($(this).parent().attr('aria-selected') == 'true') {
                    $(this).find('.catinput').attr('checked', true);
                    var catid = $(this).find('.catinput').attr('data-catid');
//                    $(this).find('.catinput').prop('checked', true);
//                    alert(catid);
                } else {
                    $(this).find('.catinput').attr('checked', false);
//                    $(this).find('.catinput').prop('checked', false);
                }
//                var checkedflagproduct = $(this).is(':checked');

            });
        });
    </script>
@endsection														   