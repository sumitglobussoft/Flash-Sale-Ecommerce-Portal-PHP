@extends('Admin/Layouts/adminlayout')

@section('title', 'Settings: '.(isset($allObjectsOfSection[0]->section_name) ? str_replace('_',' ',$allObjectsOfSection[0]->section_name) : '')) {{--TITLE GOES HERE--}}

@section('headcontent')

@endsection

@section('content')
    <div class="row">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="col-md-3 well" id="section-sidebar">
                    @if(isset($allSection)&&!empty($allSection))
                        <div id="section-sidebar-wrapper">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach($allSection as $sectionKey =>$section)
                                    <li role="presentation"
                                        @if(isset($allObjectsOfSection[0]->section_name)&&$allObjectsOfSection[0]->section_id==$section->section_id) class="active" @endif>
                                        <a href="/admin/manage-settings/{{$section->name}}">{{str_replace('_',' ',$section->name)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div style="text-align: center">
                            <b><span>Something went wrong, please go back to
                                    <i><a href="/admin/control-panel">control panel</a></i> and try again.
                                </span></b>
                        </div>
                    @endif
                </div>
                <div class="col-md-9" id="main-content">
                    @if(isset($allObjectsOfSection)&&!empty($allObjectsOfSection))
                        <form class="form-horizontal" method="post">
                            {{--<div class="form-actions" align="center">--}}
                            {{--<button type="submit" class="btn btn-primary">Save</button>--}}
                            {{--</div>--}}
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php
                                $firstHead = 0;
                                ?>
                                @foreach($allObjectsOfSection as $key=>$value)
                                    <?php $varNamesValues = $varNames = $groupValues = ''; ?>
                                    @if($value->type!='H')
                                        <div class="form-group" id="container_{{$value->name.'_'.$value->object_id}}">
                                            <label class="col-sm-4 control-label"
                                                   for="field_{{$value->name.'_'.$value->object_id}}">
                                                {{$value->setting_name}}
                                                @if($value->tooltip!='')
                                                    <i class="fa fa-question-circle" data-toggle="tooltip"
                                                       title="{{$value->tooltip}}!"></i>
                                                @endif
                                            </label>

                                            <div class="col-sm-6 controls">
                                                @if($value->type=='U' ||$value->type=='I')
                                                    <input name="update[{{$value->object_id}}]"
                                                           id="field_{{$value->name.'_'.$value->object_id}}"
                                                           class="form-control" type="text" value="{{$value->value}}">
                                                @elseif($value->type=='S'|| $value->type=='K')
                                                    <?php
                                                    $varNamesValues = explode('____', $value->variant_names);
                                                    $varNames = explode('____', $value->var_names);
                                                    ?>
                                                    <select name="update[{{$value->object_id}}]"
                                                            id="field_{{$value->name.'_'.$value->object_id}}"
                                                            data-key="{{$value->value}}"
                                                            class="form-control">
                                                        @if($value->object_id==49)
                                                            <?php $default_wysiwyg_editor = ['_empty' => 'Do not use', 'ckeditor' => 'CKEditor', 'redactor' => 'Redactor', 'tinymce' => 'TinyMCE']; ?>
                                                            @foreach($default_wysiwyg_editor as $editorKey =>$editorValue)
                                                                <option value="{{$editorKey}}"
                                                                        @if($editorKey==$value->value) selected="selected" @endif>
                                                                    {{$editorValue}}
                                                                </option>
                                                            @endforeach
                                                        @elseif($value->object_id==50)
                                                            <?php $default_image_previewer = ['fancybox' => 'FancyBox', 'lightbox' => 'Lightbox', 'magnific' => 'MagnificPopup', 'prettyphoto' => 'prettyPhoto']; ?>
                                                            @foreach($default_image_previewer as $previewKey =>$previewValue)
                                                                <option value="{{$previewKey}}"
                                                                        @if($previewKey==$value->value) selected="selected" @endif>
                                                                    {{$previewValue}}
                                                                </option>
                                                            @endforeach

                                                        @elseif($value->object_id==180)
                                                            <?php $default_product_details_view = ['bigpicture_template' => 'The big picture', 'default_template' => 'Default template']; ?>
                                                            @foreach($default_product_details_view as $PDKey =>$PDValue)
                                                                <option value="{{$PDKey}}"
                                                                        @if($PDKey==$value->value) selected="selected" @endif>
                                                                    {{$PDValue}}
                                                                </option>
                                                            @endforeach
                                                        @elseif($value->object_id==64)
                                                            <?php $available_product_list_sortings = array(
                                                                    'null-asc' => 'No sorting',
                                                                    'timestamp-asc' => 'Oldest Items First',
                                                                    'timestamp-desc' => 'Newest Items First',
                                                                    'position-asc' => 'Sort by Position: Low to High',
                                                                    'position-desc' => 'Sort by Position: High to Low',
                                                                    'product-asc' => 'Sort Alphabetically: A to Z',
                                                                    'product-desc' => 'Sort Alphabetically: Z to A',
                                                                    'price-asc' => 'Sort by Price: Low to High',
                                                                    'price-desc' => 'Sort by Price: High to Low',
                                                                    'popularity-asc' => 'Sort by Popularity: Low to High',
                                                                    'bestsellers-asc' => 'Sort by Bestselling: Low to High',
                                                                    'bestsellers-desc' => 'Sort by Bestselling',
                                                                    'on_sale-asc' => 'Sort by discount: Low to High',
                                                                    'on_sale-desc' => 'Sort by discount: High to Low'
                                                            ); ?>
                                                            @foreach($available_product_list_sortings as $sortingKey =>$sortingValue)
                                                                <option value="{{$sortingKey}}"
                                                                        @if($sortingKey==$value->value) selected="selected" @endif>
                                                                    {{$sortingValue}}
                                                                </option>
                                                            @endforeach
                                                        @elseif($value->object_id==169)
                                                            <?php $default_products_view = array(
                                                                    'products_multicolumns' => 'Grid',
                                                                    'products_without_options' => 'List without options',
                                                                    'short_list' => 'Compact list'
                                                            ); ?>
                                                            @foreach($default_products_view as $PVKey =>$PVValue)
                                                                <option value="{{$PVKey}}"
                                                                        @if($PVKey==$value->value) selected="selected" @endif>
                                                                    {{$PVValue}}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            @if($value->var_names!='')
                                                                @foreach($varNames as $variantKey=>$variant)
                                                                    <option value="{{$varNamesValues[$variantKey]}}"
                                                                            @if($value->value==$varNamesValues[$variantKey]) selected @endif>{{$variant}}</option>
                                                                @endforeach
                                                            @else
                                                                <option>{{$value->value}}</option>
                                                            @endif
                                                        @endif

                                                    </select>

                                                @elseif($value->type=='C')
                                                    <input id='hidden_field_{{$value->name.'_'.$value->object_id}}'
                                                           type='hidden' value='N' name='update[{{$value->object_id}}]'>
                                                    <input name="update[{{$value->object_id}}]"
                                                           id="field_{{$value->name.'_'.$value->object_id}}"
                                                           class="form-control" type="checkbox"
                                                           @if($value->value=='Y') checked @endif>
                                                @elseif($value->type=='G'||$value->type=='N')
                                                    <div class="checkbox-group-for-select-field"
                                                         id="field_{{$value->name.'_'.$value->object_id}}">
                                                        <?php
                                                        $groupValues = explode('&', isset(explode('#', $value->value)[2]) ? explode('#', $value->value)[2] : '');
                                                        array_walk($groupValues, function (&$value) {
                                                            $value = explode('=', $value)[0];
                                                        });
                                                        ?>
                                                        @if($value->object_id==289)
                                                            <input id='hidden_field_{{$value->name.'_'.$value->object_id}}'
                                                                   type='hidden' value='N'
                                                                   name='update[{{$value->object_id}}][]'>
                                                            <?php $available_product_list_sortings = array(
                                                                    'null-asc' => 'No sorting',
                                                                    'timestamp-asc' => 'Oldest Items First',
                                                                    'timestamp-desc' => 'Newest Items First',
                                                                    'position-asc' => 'Sort by Position: Low to High',
                                                                    'position-desc' => 'Sort by Position: High to Low',
                                                                    'product-asc' => 'Sort Alphabetically: A to Z',
                                                                    'product-desc' => 'Sort Alphabetically: Z to A',
                                                                    'price-asc' => 'Sort by Price: Low to High',
                                                                    'price-desc' => 'Sort by Price: High to Low',
                                                                    'popularity-asc' => 'Sort by Popularity: Low to High',
                                                                    'bestsellers-asc' => 'Sort by Bestselling: Low to High',
                                                                    'bestsellers-desc' => 'Sort by Bestselling',
                                                                    'on_sale-asc' => 'Sort by discount: Low to High',
                                                                    'on_sale-desc' => 'Sort by discount: High to Low'
                                                            );
                                                            ?>
                                                            @foreach($available_product_list_sortings as $sortingKey =>$sortingValue)
                                                                <label>
                                                                    <input name="update[{{$value->object_id}}][{{$sortingKey}}]"
                                                                           id="variant_{{$value->name.'_'.$sortingKey}}"
                                                                           class="form-control group-checkbox"
                                                                           type="checkbox"
                                                                           data-key="{{$sortingKey}}"
                                                                           data-value="{{$sortingValue}}"
                                                                           @if(in_array($sortingKey,$groupValues)) checked @endif>{{$sortingValue}}
                                                                </label>

                                                            @endforeach
                                                        @elseif($value->object_id==171)
                                                            <input id='hidden_field_{{$value->name.'_'.$value->object_id}}'
                                                                   type='hidden' value='N'
                                                                   name='update[{{$value->object_id}}][]'>
                                                            <?php $available_product_list_views = array(
                                                                    'products_multicolumns' => 'Grid',
                                                                    'products_without_options' => 'List without options',
                                                                    'short_list' => 'Compact list'
                                                            );
                                                            ?>
                                                            @foreach($available_product_list_views as $viewKey =>$viewValue)
                                                                <label>
                                                                    <input name="update[{{$value->object_id}}][{{$viewKey}}]"
                                                                           id="variant_{{$value->name.'_'.$viewKey}}"
                                                                           class="form-control group-checkbox"
                                                                           type="checkbox"
                                                                           data-key="{{$viewKey}}"
                                                                           data-value="{{$viewValue}}"
                                                                           @if(in_array($viewKey,$groupValues)) checked @endif>{{$viewValue}}
                                                                </label>

                                                            @endforeach

                                                        @elseif($value->object_id==138)
                                                            <input id='hidden_field_{{$value->name.'_'.$value->object_id}}'
                                                                   type='hidden' value='N'
                                                                   name='update[{{$value->object_id}}][]'>
                                                            <?php $use_for = array(
                                                                    'login' => 'Login form',
                                                                    'register' => 'Create and edit profile form',
                                                                    'checkout' => 'Checkout (user information) form',
                                                                    'track_orders' => 'Track my order form',
                                                                    'apply_for_vendor_account' => 'Apply for a vendor account form',
                                                                    'email_share' => 'Send to friend form',
                                                                    'call_request' => 'Call request and buy now with one click form',
                                                                    'form_builder' => 'Custom forms',
                                                                    'discussion' => 'Comments and reviews forms'
                                                            );
                                                            ?>
                                                            @foreach($use_for as $UFKey =>$UFValue)
                                                                <label>
                                                                    <input name="update[{{$value->object_id}}][{{$UFKey}}]"
                                                                           id="variant_{{$value->name.'_'.$UFKey}}"
                                                                           class="form-control group-checkbox"
                                                                           type="checkbox"
                                                                           data-key="{{$UFKey}}"
                                                                           data-value="{{$UFValue}}"
                                                                           @if(in_array($UFKey,$groupValues)) checked @endif>{{$UFValue}}
                                                                </label>

                                                            @endforeach

                                                        @endif
                                                    </div>
                                                @elseif($value->type=='X')
                                                    <select name="update[{{$value->object_id}}]"
                                                            id="field_{{$value->name.'_'.$value->object_id}}"
                                                            class="form-control country_list"
                                                            data-id="{{$value->value}}">
                                                        <option value="">Select country</option>
                                                    </select>
                                                @elseif($value->type=='W')
                                                    <select name="update[{{$value->object_id}}]"
                                                            id="field_{{$value->name.'_'.$value->object_id}}"
                                                            class="form-control state_list"
                                                            data-id="{{$value->value}}">
                                                        <option value="">Select state</option>
                                                    </select>
                                                @endif

                                            </div>
                                        </div>

                                    @endif

                                    @if($value->type=='H')
                                        @if($firstHead!=0)
                                            <?php echo '</div></div></div>'; ?>
                                        @endif
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab"
                                                 id="head_{{$value->object_id}}">
                                                <h4 class="panel-title">
                                                    <a @if($firstHead!=0||$key!=0)class="collapsed"
                                                       @endif data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapse_{{$value->object_id}}"
                                                       aria-expanded="@if($firstHead==0&&$key==0)true @else false @endif"
                                                       aria-controls="collapse_{{$value->object_id}}">
                                                        {{$value->setting_name}}
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapse_{{$value->object_id}}"
                                                 class="panel-collapse collapse @if($firstHead==0&&$key==0)in @endif"
                                                 role="tabpanel"
                                                 aria-labelledby="head_{{$value->object_id}}">
                                                <div class="panel-body" style="height:300px; overflow-y:auto;">
                                                    <?php $firstHead++; ?>
                                                    @endif
                                                    @if($firstHead!=0&&$key==(count($allObjectsOfSection)-1))
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="form-actions" align="center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    @else
                        <div style="text-align: center">
                            <b><span>Something went wrong, please go back to
                                    <i><a href="/admin/control-panel">control panel</a></i> and try again.
                                </span></b>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pagejavascripts')
    <script>
        //SUBMIT CHANGED VALUE ONLY
        $(function () {
//            $('button[type="submit"]').prop("disabled", "disabled");
            $('input:not([type="checkbox"],[type="hidden"]), select').change(function () {
                $(this).addClass("changed");
//                $('button[type="submit"]').removeAttr("disabled");
            });
            $('form').submit(function () {
                $('form').find('input:not([type="checkbox"],[type="hidden"],.changed)').prop("disabled", "disabled");
                $('form').find('select:not(.changed)').prop("disabled", "disabled");
                return true;
            });
        });


        $(document).ready(function () {
            if ($(".country_list").length > 0) {
                $.ajax({
                    url: '/admin/settings-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'getLocations',
                        location_type: 0
                    },
                    success: function (response) {
                        response = $.parseJSON(response);
                        if (response != '') {
                            var appendCountries = '';
                            $.each(response, function (index, value) {
                                appendCountries += '<option value="' + value['location_id'] + '"' + (($(".country_list").attr('data-id') == value['location_id']) ? 'selected' : '') + '>' + value['name'] + '</option>';
                            });
                            $('.country_list').append(appendCountries);
                        }
                    }
                });
            }
            if ($(".state_list").length > 0) {
                $.ajax({
                    url: '/admin/settings-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'getLocations',
                        location_type: 1,
                        parent_id: $(".country_list").attr('data-id')
                    },
                    success: function (response) {
                        response = $.parseJSON(response);
                        if (response != '') {
                            var appendStates = '';
                            $.each(response, function (index, value) {
                                appendStates += '<option value="' + value['location_id'] + '"' + (($(".state_list").attr('data-id') == value['location_id']) ? 'selected' : '') + '>' + value['name'] + '</option>';
                            });
                            $('.state_list').append(appendStates);
                        }
                    }
                });
            }

            $(".country_list").on('change', function () {
                $.ajax({
                    url: '/admin/settings-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'getLocations',
                        location_type: 1,
                        parent_id: $(this).val()
                    },
                    success: function (response) {
                        $('.state_list').empty();
                        response = $.parseJSON(response);
                        if (response != '') {
                            var appendStates = '<option value="">Select state</option>';
                            $.each(response, function (index, value) {
                                appendStates += '<option value="' + value['location_id'] + '"' + (($(".state_list").attr('data-id') == value['location_id']) ? 'selected' : '') + '>' + value['name'] + '</option>';
                            });
                            $('.state_list').append(appendStates);
                        } else {
                            $('.state_list').append('<option value="">No states found</option>');
                        }
                    }
                });
            });

            $(".group-checkbox").on('change', function () {
                var allCheckedBox = $(this).parents("div .checkbox-group-for-select-field").find('input[type="checkbox"]:checked');
                var nextSelectBox = $(this).parents("div .form-group").next().find("select");
                nextSelectBox.empty();
                var newSelectBox = '';
                $.each(allCheckedBox, function (i, v) {
                    newSelectBox += '<option value="' + $(this).attr("data-key") + '"' + (nextSelectBox.attr("data-key") == $(this).attr("data-key") ? "selected" : "") + '>' + $(this).attr("data-value") + '</option>';
                });
                nextSelectBox.append(newSelectBox);
                if (nextSelectBox.children().length == 0) {
                    nextSelectBox.append('<option>Please select check box first...');
                }
            });

            var allGroupCheckBoxForSelectBox = $(".checkbox-group-for-select-field");
            $.each(allGroupCheckBoxForSelectBox, function (i, a) {
                var allGroupedCheckedBox = $(this).find('input[type="checkbox"]:checked');
                var nextSelectBox = allGroupedCheckedBox.parents("div .form-group").next().find("select");
                nextSelectBox.empty();
                var newSelectBox = '';
                $.each(allGroupedCheckedBox, function (i, v) {
                    newSelectBox += '<option value="' + $(this).attr("data-key") + '"' + (nextSelectBox.attr("data-key") == $(this).attr("data-key") ? "selected" : "") + '>' + $(this).attr("data-value") + '</option>';
                });
                nextSelectBox.append(newSelectBox);
                if (nextSelectBox.children().length == 0) {
                    nextSelectBox.append('<option>Please select check box first...');
                }
            });
        });
    </script>
@endsection
