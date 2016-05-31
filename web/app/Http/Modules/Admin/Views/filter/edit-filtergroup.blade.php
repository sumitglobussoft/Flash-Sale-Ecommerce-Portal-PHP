
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
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="panel info-box panel-white">
                <div class="panel-body">
                    <div class="portlet-title">
                        @if(empty($editfiltergroup)||!isset($editfiltergroup))
                            <div style="text-align: center">
                                <span class="">Sorry, no such filtergroup found.</span><br>
                                <a href="/supplier/manage-flashsale" class="btn btn-default btn-circle"><i
                                            class="fa fa-angle-left"></i> Back To List</a>
                            </div>
                        @else

                            <div class="actions">
                                <a class="btn btn-default" href="/admin/manage-filtergroup">Back to list </a>
                            </div>
                            <div class="portlet-title tabbable-line">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_editfilter_general" data-toggle="tab" class="filtersTab" filter-type="G">General</a>
                                    </li>
                                    <li><a href="#tab_editfilter_variants" data-toggle="tab"  class="filtersTab"  filter-type="V">Variants</a></li>
                                </ul>
                            </div>
                    </div>

                    <div class="alert">
                        @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                        @endif
                    </div>

                    <form class="form form-horizontal" id="addnewfiltergroupform" method="post">
                        <div class="form-body">
                            <div class="tab-content">
                                <input type="hidden" class="form-control" id="productfiltertype" name="productfiltertype" value="G">
                                @foreach($editfiltergroup as $filterKey => $filterVal)
                                    {{--<input type="text" class="form-control hidden"  name="productfiltertypexdg" value="cfhfcgh">--}}
                                    @if($filterVal->product_filter_type == 'G')
                                        <div class="tab-pane active" id="tab_editfilter_general">
                                            <div class="form-group">
                                                <label for="productfiltergroupname" class="col-md-3 control-label">Filter
                                                    name:</label>

                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="productfiltergroupname"
                                                           placeholder="filter name" name="productfiltergroupname"
                                                           value="{{ $filterVal->product_filter_option_name }}">
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
                                                           value="<?php echo $filterVal->product_filter_option_description?>">
                                                </div>
                                                {!!  $errors->first('filterdescription', '<font color="red">:message</font>') !!}
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <label for="productfiltergroupnamestatus"
                                                       class="col-md-3 control-label">Filter
                                                    By:</label>
                                                <?php if (($filterVal->product_filter_feature_id) != 0) {
                                                    echo $filterVal->filterFeatures['feature_name'];
                                                } else {
                                                    if ($filterVal->product_filter_parent_product_id == 1) {
                                                        echo "Price";
                                                    } elseif ($filterVal->product_filter_parent_product_id == 2) {
                                                        echo "Instock";
                                                    } else {
                                                        echo "Free Shiping";
                                                    }
                                                } ?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Type</label>

                                                <div class="col-sm-2">
                                                    <select name="filter_variant_type" class="form-control m-b-sm"
                                                            id="filter_variant_type">
                                                        <option value="1" @if($filterVal->product_filter_variant_type == '1') selected @endif>Select box</option>
                                                        <option value="2" @if($filterVal->product_filter_variant_type == '2') selected @endif>Radio group</option>
                                                        <option value="3" @if($filterVal->product_filter_variant_type == '3') selected @endif>Check box</option>
                                                    </select>
                                                    {!!  $errors->first('filter_variant_type', '<font color="red">:message</font>') !!}
                                                </div>
                                            </div>
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
                                                                $selectedcategory = $filterVal->selectedCategories;

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

                                                                        <?php treeView($array, $selectedcategory, $array[$i]->category_id); ?>
                                                                    </li>
                                                                </ul>
                                                                <?php
                                                                }
                                                                }
                                                                } ?>
                                                                {{--</li>--}}

                                                                @if(isset($filterVal->filterCategories))
                                                                    <?php echo treeView($filterVal->filterCategories, $selectedcategory);  ?>
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
                                    @elseif($filterVal->product_filter_type == 'V')
                                        <div class="tab-pane" id="tab_editfilter_variants">
                                            <div class="table-responsive col-md-offset-1 col-md-9">

                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 30%;">Name</th>
                                                        <th style="width: 50%;">Description</th>
                                                        <th style="width: 20%;">Extra</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="variantTBody">

                                                    @if(!empty(old()))
                                                        @foreach(old('filter_variant') as $keyFV => $valueFV)
                                                            @if($valueFV != '')
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-sm-12">
                                                                            <input type="hidden"
                                                                                   name="filter_variant[{{$keyFV}}][product_filter_option_id]"
                                                                                   @if(isset(old('filter_variant')[$keyFV]['product_filter_option_id'])) value="{{old('filter_variant')[$keyFV]['product_filter_option_id']}}" @endif>
                                                                            <input type="text" class="form-control"
                                                                                   name="filter_variant[{{$keyFV}}][name]"
                                                                                   value="{{$valueFV}}"
                                                                                   placeholder="Ex: Polka, Dotted">
                                                                            <span class="error">{!! $errors->first('filter_variant.'.$keyFV.'.name') !!}</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="col-sm-12">
                                                                            <input type="text" class="form-control"
                                                                                   name="filter_variant[{{$keyFV}}][description]"
                                                                                   value="{{old('filter_variant')[$keyFV]['description']}}"
                                                                                   placeholder="description">
                                                                            <span class="error">{!! $errors->first('filter_variant.'.$keyFV.'.description') !!}</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <a class="col-sm-1 addvarianttr"><i
                                                                                    class="fa fa-plus"></i></a>
                                                                        <a class="col-sm-1 removevarianttr"><i
                                                                                    class="fa fa-remove"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @elseif(isset($filterVal) && !empty($filterVal))
                                                        <?php $varNames = explode(",", $filterVal->var_names);
                                                        $varDesc = explode(",", $filterVal->var_description);
                                                        $varIds = explode(",", $filterVal->var_ids);
                                                        ?>
                                                        @foreach($varNames as $key => $val)
                                                            <tr>
                                                                <td>
                                                                    <div class="col-sm-12">
                                                                        <input type="hidden"
                                                                               name="filter_variant[{{$key}}][product_filter_option_id]]"  value="<?php echo $varIds[$key]; ?>">
                                                                      
                                                                        <input type="text" class="form-control"
                                                                               name="filter_variant[{{$key}}][name]"
                                                                               value="<?php echo $val; ?>"
                                                                               placeholder="Ex: Polka, Dotted">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control"
                                                                               name="filter_variant[{{$key}}][description]"
                                                                               value="<?php echo $varDesc[$key]; ?>"
                                                                               placeholder="description">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a class="col-sm-1 addvarianttr"><i
                                                                                class="fa fa-plus"></i></a>
                                                                    <a class="col-sm-1 removevarianttr"><i
                                                                                class="fa fa-remove"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="form-control"
                                                                           name="filter_variant[0][name]"
                                                                           placeholder="Ex: Polka, Dotted">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="form-control"
                                                                           name="filter_variant[0][description]"
                                                                           placeholder="description">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a class="col-sm-1 addvarianttr"><i
                                                                            class="fa fa-plus"></i></a>
                                                                <a class="col-sm-1 removevarianttr"><i
                                                                            class="fa fa-remove"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-info btn-rounded" id="submitadd">Save filter group
                            </button>

                        </div>
                    </form>
                    @endif

                </div>
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

//            $(document.body).on("change", 'input:checkbox[name="filtercheckproduct"]', function () {
//                var checkedflagproduct = $(this).is(':checked');
//                alert(checkedflagproduct);
//            });
//
//            $(document.body).on("change", 'input:checkbox[name="filtercheckcatalog"]', function () {
//                var checkedflagcatalog = $(this).is(':checked');
//                alert(checkedflagcatalog);
//            });
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
            var variantCounter = $("#variantTBody tr").length;
            $(document.body).on('click', '.addvarianttr', function () {
                toAppend = '<tr>';
                toAppend += '<td>';
                toAppend += '<div class="col-sm-12">';
                toAppend += '<input type="text" class="form-control" name="filter_variant[' + variantCounter + '][name]">';
                toAppend += '</div>';
                toAppend += '</td>';
                toAppend += '<td>';
                toAppend += '<div class="col-sm-12">';
                toAppend += '<input type="text" class="form-control" name="filter_variant[' + variantCounter + '][description]">';
                toAppend += '</div>';
                toAppend += '</td>';
                toAppend += '<td>';
                toAppend += '<a class="col-sm-1 addvarianttr"><i class="fa fa-plus"></i></a>';
                toAppend += '<a class="col-sm-1 removevarianttr"><i class="fa fa-remove"></i></a>';
                toAppend += '</td>';
                toAppend += '</tr>';
                $('#variantTBody').append(toAppend);
                variantCounter++;
            });

            $(document.body).on('click', '.removevarianttr', function () {
                var varianttrs = $('.addvarianttr');
                if (varianttrs.length > 1)
                    $(this).parent().parent().remove();
            });

            if ($(".tab-content").find('.error').text()) {
                $.each($(".tab-content").find('.error'), function (index, value) {
                    if ($(this).text()) {
                        $(".tab-content").children('.tab-pane').removeClass('active');
                        $(this).closest('.tab-pane').addClass('active');

                        $(".nav-tabs").children('li').removeClass('active');
                        var id = $(this).closest('.tab-pane').attr('id');
                        if (id == 'tab_editfilter_general') {
                            $(".nav-tabs").children('li').first().addClass('active');
                        } else {
                            $(".nav-tabs").children('li').last().addClass('active');
                        }
                        console.log(id);
                        return false;
                    }
                });
            }

            $(document.body).on("click",".filtersTab",function() {

                var filters = $(this).attr('filter-type');
                var filt = document.getElementById("productfiltertype").setAttribute('value',filters);
            });
        });
    </script>
@endsection