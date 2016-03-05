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
                    <h4 class="panel-title">Add new Feature group</h4>
                </div>
                <div class="panel-body">
                    {{-- @if($errors)-- }}
                    {{-- {!! print_r($errors->all()) !!} @endif --}}
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

                    <form class="form-horizontal" method="post" id="addfeaturegroupform">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Group Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="feature_name" value="{{old('feature_name')}}">
                                    <span class="error">{!! $errors->first('feature_name') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-4">
                                    <textarea type="text" class="form-control" name="full_description" value="{{old('full_description')}}"></textarea>
                                    <span class="error">{!! $errors->first('full_description') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">For categories</label>
                                <div class="col-sm-4">

                                    <div id="checkTree">
                                        <ul>
                                            <li data-jstree='{"opened":true}'>All categories
                                                <span class="catinputdivs" data-id="0"></span>
                                                @if(isset($allCategories))
                                                    <?php treeView($allCategories); ?>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>

                                    <?php
                                    function treeView($array, $id = 0)
                                    {
                                    foreach ($array as $keyArray => $valueArray) {
                                    // for($i = 0; $i < count($array); $i++) {
                                    if ($array[$keyArray]->parent_category_id == $id) { ?>
                                    <ul>
                                        <li data-jstree='{"opened":true}'>
                                            <?php echo $array[$keyArray]->category_name;
                                            $catId = $array[$keyArray]->category_id; ?>
                                            <span class="catinputdivs" data-id="<?php echo $array[$keyArray]->category_id; ?>" data-checked="@if(isset(old('for_categories')[$catId]))
                                                    checked
                                                    @endif">
                                            </span>
                                            <?php treeView($array, $array[$keyArray]->category_id); ?>
                                        </li>
                                    </ul>
                                    <?php }
                                    }
                                    }
                                    ?>

                                    <br>
                                    <span class="error">{!! $errors->first('for_categories') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Display on features tab</label>
                                <div class="col-sm-4">
                                    <input type="checkbox" class="form-control" name="display_on_product" @if(old('display_on_product') == "on") checked @endif/>
                                    <span class="error">{!! $errors->first('display_on_product') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Display on catalog</label>
                                <div class="col-sm-4">
                                    <input type="checkbox" class="form-control" name="display_on_catalog" @if(old('display_on_catalog') == "on") checked @endif/>
                                    <span class="error">{!! $errors->first('display_on_catalog') !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                        </div>

                        <div class="form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn blue btn-info" type="submit">Add feature group</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejavascripts')

    <script src="/assets/plugins/jstree/jstree.min.js"></script>
    <script>
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

        });

    </script>
@endsection
