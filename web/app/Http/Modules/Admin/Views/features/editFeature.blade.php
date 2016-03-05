@extends('Admin/Layouts/adminlayout')

@section('title', 'Features') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <link href="/assets/plugins/jstree/themes/default/style.min.css" rel="stylesheet" type="text/css"/>

@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="panel info-box panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Edit Feature</h4>
                </div>
                <div class="panel-body">

                    @if($featureDetails['code'] != 200)
                        <div style="text-align: center">
                            <span class="">{{$featureDetails['message']}}</span><br>
                            <a href="/admin/manage-featuregroups">
                                <button class="btn btn-xs btn-success">Go back</button>
                            </a>
                        </div>
                    @else

                        <div class="alert
                    @if(session('code')) @if(session('code') == 400) alert-danger @elseif(session('code') == 200) alert-success @else display-hide @endif
                        @else display-hide @endif">
                            <button class="close" data-close="alert"></button>
                            <span>
                                @if(session('code') == 400 || session('code') == 200)
                                    <?php echo session('message'); ?>
                                @endif
                            </span>
                        </div>

                        <div class="portlet-title tabbable-line">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_editfeature_general" data-toggle="tab">General</a></li>
                                <li><a href="#tab_editfeature_variants" data-toggle="tab">Variants</a></li>
                            </ul>
                        </div>

                        <form class="form-horizontal" method="post">
                            <div class="form-body">
                                <div class="tab-content">

                                    <div class="tab-pane active" id="tab_editfeature_general">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="feature_name" value="{{null != old('feature_name')  ? old('feature_name') : $featureDetails['data']['feature_name']}}">
                                                <span class="error">{!! $errors->first('category_name') !!}</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="full_description" value="{{null != old('full_description')  ? old('full_description') : $featureDetails['data']['full_description']}}">
                                                <span class="error">{!! $errors->first('full_description') !!}</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Feature group</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="parent_id" value="{{null != old('parent_id')  ? old('parent_id') : $featureDetails['data']['parent_id']}}">
                                                    <option value="">--None--</option>
                                                    <?php $fgSelectedFlag = false; ?>
                                                    @foreach($featureGroups['data'] as $keyFG => $valueFG)
                                                        <option value="{{$valueFG['feature_id']}}" @if(old('parent_id') == $valueFG['feature_id']) {{$fgSelectedFlag = true}} selected @elseif($featureDetails['data']['parent_id'] == $valueFG['feature_id'] && !$fgSelectedFlag) selected @endif>{{$valueFG['feature_name']}}</option>
                                                    @endforeach
                                                </select> <span class="error">{!! $errors->first('parent_id') !!}</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Feature type</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="feature_type" value="{{null != old('feature_type')  ? old('feature_type') : $featureDetails['data']['feature_type']}}" id="featuretype">
                                                    <?php $ftSelectedFlag = false; ?>
                                                    <option value="">--Select--</option>
                                                    <optgroup label="Checkbox">
                                                        <option value="0" @if(old('feature_type') != null && (int)old('feature_type') === 0) {{$ftSelectedFlag=true}} selected @elseif($featureDetails['data']['feature_type'] == 0 && !$ftSelectedFlag) selected @endif>
                                                            Single
                                                        </option>
                                                        <option value="1" @if(old('feature_type') == 1) {{$ftSelectedFlag=true}} selected @elseif($featureDetails['data']['feature_type'] == 1 && !$ftSelectedFlag) selected @endif>
                                                            Multiple
                                                        </option>
                                                    </optgroup>
                                                    <optgroup label="Select box">
                                                        <option value="2" @if(old('feature_type') == 2) {{$ftSelectedFlag=true}} selected @elseif($featureDetails['data']['feature_type'] == 2 && !$ftSelectedFlag) selected @endif>
                                                            Text
                                                        </option>
                                                        <option value="3" @if(old('feature_type') == 3) {{$ftSelectedFlag=true}} selected @elseif($featureDetails['data']['feature_type'] == 3 && !$ftSelectedFlag) selected @endif>
                                                            Number
                                                        </option>
                                                        <option value="4" @if(old('feature_type') == 4) {{$ftSelectedFlag=true}} selected @elseif($featureDetails['data']['feature_type'] == 4 && !$ftSelectedFlag) selected @endif>
                                                            Brands/Manufacturer
                                                        </option>
                                                    </optgroup>
                                                </select>
                                                <span class="error">{!! $errors->first('feature_type') !!}</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">For categories</label>
                                            <div class="col-sm-4">

                                                <?php
                                                function treeView($array, $id = 0, $initVals)
                                                {
                                                foreach ($array as $keyArray => $valueArray) {
                                                if ($array[$keyArray]->parent_category_id == $id) { ?>
                                                <ul>
                                                    <li data-jstree='{"opened":true}'>
                                                        <?php echo $array[$keyArray]->category_name;
                                                        $catId = $array[$keyArray]->category_id; ?>
                                                        <span class="catinputdivs" data-id="<?php echo $array[$keyArray]->category_id; ?>" data-checked="{{(isset(old('for_categories')[$catId]) || in_array($array[$keyArray]->category_id, explode(",", $initVals['data']['for_categories']))) ? "checked" : ""}}"> </span>
                                                        <?php treeView($array, $array[$keyArray]->category_id, $initVals); ?>
                                                    </li>
                                                </ul>
                                                <?php }
                                                }
                                                }
                                                ?>

                                                <div id="checkTree">
                                                    <ul>
                                                        <li data-jstree='{"opened":true}'>All categories
                                                            <span class="catinputdivs" data-id="0"></span>
                                                            @if(isset($allCategories))
                                                                <?php treeView($allCategories, 0, $featureDetails); ?>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>

                                                <br> <span class="error">{!! $errors->first('for_categories') !!}</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Display on features tab</label>
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="form-control" name="display_on_product" value="{{null != old('display_on_product')  ? old('display_on_product') : $featureDetails['data']['display_on_product']}}" {{((null != old('display_on_product')) || ($featureDetails['data']['display_on_product'] == 1))  ? "checked" : ""}}>
                                                <span class="error">{!! $errors->first('display_on_product') !!}</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Display on catalog</label>
                                            <div class="col-sm-4">
                                                <input type="checkbox" class="form-control" name="display_on_catalog" value="{{null != old('display_on_catalog')  ? old('display_on_catalog') : $featureDetails['data']['display_on_catalog']}}" {{((null != old('display_on_catalog')) || ($featureDetails['data']['display_on_catalog'] == 1))  ? "checked" : ""}}>
                                                <span class="error">{!! $errors->first('display_on_catalog') !!}</span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                    </div>

                                    <div class="tab-pane" id="tab_editfeature_variants">
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

                                                @if(isset(old('feature_variant')['name']))
                                                    @foreach(old('feature_variant')['name'] as $keyFV => $valueFV)
                                                        @if($valueFV != '')
                                                            <tr>
                                                                <td>
                                                                    <div class="col-sm-12">
                                                                        <input type="hidden"
                                                                                name="feature_variant[variant_id][{{$keyFV}}]"
                                                                                @if(isset(old('feature_variant')['variant_id'][$keyFV])) value="{{old('feature_variant')['variant_id'][$keyFV]}}" @endif>
                                                                        <input type="text" class="form-control" name="feature_variant[name][{{$keyFV}}]" value="{{$valueFV}}" placeholder="Ex: Polka, Dotted">
                                                                        <span class="error">{!! $errors->first('feature_variant.name.'.$keyFV) !!}</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" class="form-control" name="feature_variant[description][{{$keyFV}}]" value="{{old('feature_variant')['description'][$keyFV]}}" placeholder="description">
                                                                        <span class="error">{!! $errors->first('feature_variant.description.'.$keyFV) !!}</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a class="col-sm-1 addvarianttr"><i class="fa fa-plus"></i></a>
                                                                    <a class="col-sm-1 removevarianttr"><i class="fa fa-remove"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @elseif(isset($fvData['data']) && !empty($fvData['data']))
                                                    @foreach($fvData['data'] as $keyFV => $valueFV)
                                                        <tr>
                                                            <td>
                                                                <div class="col-sm-12">
                                                                    <input type="hidden"
                                                                            name="feature_variant[variant_id][{{$keyFV}}]"
                                                                            value="{{$valueFV['variant_id']}}">
                                                                    <input type="text" class="form-control" name="feature_variant[name][{{$keyFV}}]" value="{{$valueFV['variant_name']}}" placeholder="Ex: Polka, Dotted">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="form-control" name="feature_variant[description][{{$keyFV}}]" value="{{$valueFV['description']}}" placeholder="description">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a class="col-sm-1 addvarianttr"><i class="fa fa-plus"></i></a>
                                                                <a class="col-sm-1 removevarianttr"><i class="fa fa-remove"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" name="feature_variant[name][]" placeholder="Ex: Polka, Dotted">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" name="feature_variant[description][]" placeholder="description">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="col-sm-1 addvarianttr"><i class="fa fa-plus"></i></a>
                                                            <a class="col-sm-1 removevarianttr"><i class="fa fa-remove"></i></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn blue btn-info" type="submit">Save changes</button>
                                </div>
                            </div>

                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejavascripts')
    <script src="/assets/plugins/jstree/jstree.min.js"></script>

    <script>
        {{--PAGE SCRIPTS GO HERE--}}
        $(document).ready(function () {

            $('#checkTree').jstree({
                'core': {
                    'themes': {
                        'responsive': false
                    }
                },
                'types': {
                    'default': {
                        'icon': 'fa fa-folder icon-state-info icon-md'
                    },
                    'file': {
                        'icon': 'fa fa-file icon-state-default icon-md'
                    }
                },
                'plugins': ['types', 'checkbox']
            });

            setTimeout(function () {
                var catinputdivs = $('.catinputdivs');
                $.each(catinputdivs, function (i, a) {
                    var catid = $(a).attr('data-id');
                    var checkedstring = '';
                    if ($(a).attr('data-checked') == "checked") {
                        checkedstring = "checked";
                    }
                    $(a).html('<input type="checkbox" name="for_categories[' + catid + ']" class="catinput" hidden ' + $(a).attr('data-checked') + '/>');
                });
                var catinputs = $('.catinput');
                $.each(catinputs, function (i, a) {
                    if ($(a).attr('checked') != undefined) {
                        $(a).parent().parent().click();
                    }
                });
            }, 1000);


            $(document.body).on("click", '.jstree-anchor', function () {
                var thisObj = $(this);
                console.log($(thisObj).find('.catinput'));
                if ($(thisObj).parent().attr('aria-selected') == 'true') {
                    $(thisObj).find('.catinput').attr('checked', true);
//                    $(this).find('.catinput').prop('checked', true);
                } else {
                    $(thisObj).find('.catinput').attr('checked', false);
//                    $(this).find('.catinput').prop('checked', false);
                }
            });

            $(document.body).on('click', '.addvarianttr', function () {
                toAppend = '<tr>';
                toAppend += '<td>';
                toAppend += '<div class="col-sm-12">';
                toAppend += '<input type="text" class="form-control" name="feature_variant[name][]">';
                toAppend += '</div>';
                toAppend += '</td>';
                toAppend += '<td>';
                toAppend += '<div class="col-sm-12">';
                toAppend += '<input type="text" class="form-control" name="feature_variant[description][]">';
                toAppend += '</div>';
                toAppend += '</td>';
                toAppend += '<td>';
                toAppend += '<a class="col-sm-1 addvarianttr"><i class="fa fa-plus"></i></a>';
                toAppend += '<a class="col-sm-1 removevarianttr"><i class="fa fa-remove"></i></a>';
                toAppend += '</td>';
                toAppend += '</tr>';
                $('#variantTBody').append(toAppend);
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
                        if (id == 'tab_editfeature_general') {
                            $(".nav-tabs").children('li').first().addClass('active');
                        } else {
                            $(".nav-tabs").children('li').last().addClass('active');
                        }
                        console.log(id);
                        return false;
                    }
                });
            }

            $(document.body).on('change', '#featuretype', function () {
                if ($(this).val() == 0) {
                    $('.nav-tabs').find('a[href="#tab_editfeature_variants"]').addClass('hidden');
                } else {
                    $('.nav-tabs').find('a[href="#tab_editfeature_variants"]').removeClass('hidden');
                }
            });
            var status = "info";
            @if(session('message')!='')
                @if(session('code') == '200')
                    status = "success";
            @elseif(session('code') == '400')
                status = "error";
            @endif
            toastr[status]("{{session('message')}}");
            @endif













        });
    </script>
@endsection
