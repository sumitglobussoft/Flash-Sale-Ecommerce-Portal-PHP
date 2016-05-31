<?php
$weightSymbol = getSetting('weight_symbol'); $weightSymbol = $weightSymbol ? $weightSymbol : 'lbs';
$priceSymbol = getSetting('price_symbol'); $priceSymbol = $priceSymbol ? $priceSymbol : '$';
?>

@extends('Admin/Layouts/adminlayout')

@section('title', 'New Product') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css"/>
    {{--<link href="/assets/css/custom/components.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/assets/css/custom/components-rounded.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/datatables/css/jquery.datatables.min.css"/>

    <style>
        /*table tr th {*/
        /*text-align: center;*/
        /*}*/

        .separator {
            font-size: 25px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            padding-right: 2%;
        }

        .panel-collapse .panel-body {
            height: 300px;
            overflow-y: auto;
        }

        hr {
            margin: 7px;
            border-color: #ddd;
        }

        .hrfeaturegroup {
            margin: 7px;
            border-color: #aaa;
        }
    </style>
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-white">
                <div class="panel-body">

                    <div class="portlet-title tabbable-line">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1_1" data-toggle="tab">General</a></li>
                            <li><a href="#tab_1_2" data-toggle="tab">Images</a></li>
                            {{--<li><a href="#tab_1_3" data-toggle="tab">SEO</a></li>--}}
                            <li><a href="#tab_1_4" data-toggle="tab">Options</a></li>
                            <li><a href="#tab_1_5" data-toggle="tab">Shipping properties</a></li>
                            <li><a href="#tab_1_6" data-toggle="tab">Quantity discounts</a></li>
                            <li id="featureTab" class="hidden"><a href="#tab_1_7" data-toggle="tab">Features</a></li>
                            <li><a href="#tab_1_8" data-toggle="tab">Product tabs</a></li>
                            <li><a href="#tab_1_9" data-toggle="tab">Tags</a></li>
                        </ul>
                    </div>
                    <form class="form-horizontal" method="post" enctype="multipart/form-data" autocomplete="on"
                            id="addProductForm">
                        <div class="tab-content">
                            {{--GENERAL DETAILS TAB--}}
                            <div class="tab-pane active" id="tab_1_1">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingInfo">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseInfo"
                                                        aria-expanded="true" aria-controls="collapseInfo">
                                                    Information </a>
                                            </h4>
                                        </div>
                                        <div id="collapseInfo" class="panel-collapse collapse in" role="tabpanel"
                                                aria-labelledby="headingInfo">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Name</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="product_name"
                                                                name="product_data[product_name]"
                                                                value="{{old('product_data')['product_name']}}">
                                                        <span class="error">{!! $errors->first('product_name') !!}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Supplier</label>

                                                    <div class="col-sm-4">
                                                        <select name="product_data[shop_id]"
                                                                class="form-control m-b-sm">
                                                            <option value="0">None</option>
                                                            @if(isset($allShop))
                                                                @foreach($allShop as $key=>$value)
                                                                    <option value="{{$value->id}}"
                                                                            @if(isset(old('product_data')['shop_id'])&&$value->id==old('product_data')['shop_id']) selected @endif>{{$value->shop_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select> <span
                                                                class="error">{!! $errors->first('shop_id') !!}</span>
                                                    </div>
                                                </div>
                                                <!--TODO: SELECT CATEGORY HERE-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Choose category</label>

                                                    <div class="col-md-4">
                                                        <select id="select_category" class="bs-select form-control"
                                                                name="product_data[category_id]">
                                                            <option value="">Select category</option>
                                                            @if(isset($allCategories))
                                                                <?php treeView($allCategories, 0, $allCategories); ?>
                                                            @endif
                                                        </select>
                                                        <?php
                                                        function treeView($array, $id = 0, $allCategories)
                                                        {
                                                        foreach ($array as $keyArray => $valueArray) {
                                                        if ($array[$keyArray]->parent_category_id == $id) {
                                                        $flag = array_search($array[$keyArray]->category_id, array_column(json_decode(json_encode($allCategories), true), 'parent_category_id'));
                                                        if  ($flag) { ?>
                                                        <optgroup
                                                                label="<?php echo $array[$keyArray]->display_name . $array[$keyArray]->category_name; ?>">
                                                            <?php treeView($array, $array[$keyArray]->category_id, $allCategories); ?>
                                                        </optgroup>
                                                        <?php
                                                        } else { ?>
                                                        <option value="{{$array[$keyArray]->category_id }}">
                                                            <?php echo $array[$keyArray]->display_name . $array[$keyArray]->category_name; ?>
                                                        </option>
                                                        <?php }
                                                        }
                                                        }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label"> Price ({{$priceSymbol}}
                                                        )</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control float-type" id="price"
                                                                name="product_data[price]"
                                                                value="{{old('product_data')['price']}}">
                                                        <span class="error">{!! $errors->first('price') !!}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    {{--Todo-use editor here--}}
                                                    <label class="col-sm-3 control-label">Full description</label>

                                                    <div class="col-sm-4">
                                                    <textarea name="product_data[full_description]"
                                                            class="form-control">{{old('product_data')['full_description']}}</textarea>
                                                        <span class="error">{!! $errors->first('full_description') !!}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Status</label>

                                                    <div class="col-sm-4">
                                                        <label for="status_active" class="col-sm-6">
                                                            <input type="radio" class="form-control" id="status_active"
                                                                    name="product_data[status]" checked value="1">
                                                            Active </label>
                                                        <label for="status_inactive" class="col-sm-6">
                                                            <input type="radio" class="form-control"
                                                                    id="status_inactive"
                                                                    name="product_data[status]" value="2"> Inactive
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Only for wholesale</label>

                                                    <div class="col-sm-4">
                                                        <input type="checkbox" name="product_data[product_type]"
                                                                class="form-control m-b-sm"
                                                                id="product_type"
                                                                @if(isset(old('product_data')['product_type'])) checked @endif />
                                                    </div>
                                                </div>

                                                {{--<div class="form-group">--}}
                                                {{--<label class="col-sm-3 control-label">Min quantity</label>--}}
                                                {{--<div class="col-sm-4">--}}
                                                {{--<input type="text" class="form-control" id="quantity_min"--}}
                                                {{--name="product_data[quantity_min]"--}}
                                                {{--value="{{old('product_data')['quantity_min']}}">--}}
                                                {{--<span class="error">{!! $errors->first('quantity_min') !!}</span>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}


                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">For gender</label>

                                                    <div class="col-sm-4">
                                                        <select name="product_data[for_gender]"
                                                                class="form-control m-b-sm"
                                                                id="for_gender">
                                                            <?php $genders = ['0' => 'For all', '1' => 'Male', '2' => 'Female', '3' => 'Unisex'];?>
                                                            @foreach($genders as $key =>$gender)
                                                                <option value="{{$key}}"
                                                                        @if(isset(old('product_data')['for_gender'])&&$key==old('product_data')['for_gender']) selected @endif>{{$gender}}</option>
                                                            @endforeach
                                                        </select> <span
                                                                class="error">{!! $errors->first('for_gender') !!}</span>
                                                    </div>
                                                </div>

                                                {{--<div class="form-group">--}}
                                                {{--<label class="col-sm-3 control-label">--}}
                                                {{--Weight ({{$weightSymbol}})</label>--}}
                                                {{--<div class="col-sm-4">--}}
                                                {{--<input type="text" class="form-control" id="weight"--}}
                                                {{--name="product_data[weight]"--}}
                                                {{--value="{{old('product_data')['weight']}}">--}}
                                                {{--<span class="error">{!! $errors->first('weight') !!}</span>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingPrice">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                        href="#collapsePrice" aria-expanded="false"
                                                        aria-controls="collapsePrice"> Pricing / inventory </a>
                                            </h4>
                                        </div>
                                        <div id="collapsePrice" class="panel-collapse collapse" role="tabpanel"
                                                aria-labelledby="headingPrice">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label"> List price ({{$priceSymbol}})
                                                        <i class="fa fa-question-circle" data-toggle="tooltip"
                                                                title="Manufacturer suggested retail price."></i></label>

                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control float-type"
                                                                id="list_price"
                                                                name="product_data[list_price]"
                                                                value="{{old('product_data')['list_price']}}">
                                                        <span class="error">{!! $errors->first('list_price') !!}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">In stock</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control integer-type"
                                                                id="in_stock"
                                                                name="product_data[in_stock]"
                                                                value="{{old('product_data')['in_stock']}}">
                                                        <span class="error">{!! $errors->first('in_stock') !!}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label"> Minimum order
                                                        quantity</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control integer-type"
                                                                id="minimum_order_quantity"
                                                                name="product_data[minimum_order_quantity]"
                                                                value="{{old('product_data')['minimum_order_quantity']}}">
                                                        <span class="error">{!! $errors->first('minimum_order_quantity') !!}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Maximum order quantity</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control integer-type"
                                                                id="maximum_order_quantity"
                                                                name="product_data[maximum_order_quantity]"
                                                                value="{{old('product_data')['maximum_order_quantity']}}">
                                                        <span class="error">{!! $errors->first('maximum_order_quantity') !!}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Taxes</label>

                                                    <div class="col-sm-4">
                                                        <input type="checkbox" class="form-control" id="taxes"
                                                                name="product_data[taxes]"
                                                                @if(isset(old('product_data')['taxes'])) checked @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingExtra">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                        href="#collapseExtra" aria-expanded="false"
                                                        aria-controls="collapseExtra"> Extra </a>
                                            </h4>
                                        </div>
                                        <div id="collapseExtra" class="panel-collapse collapse" role="tabpanel"
                                                aria-labelledby="headingExtra">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    {{--Todo-Use editor here--}}
                                                    <label class="col-sm-3 control-label"> Short description</label>

                                                    <div class="col-sm-4">
                                                    <textarea name="product_data[short_description]"
                                                            class="form-control">{{old('product_data')['short_description']}}</textarea>
                                                        <span class="error">{!! $errors->first('short_description') !!}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label"> Search words</label>

                                                    <div class="col-sm-4">
                                                    <textarea name="product_data[search_words]"
                                                            class="form-control">{{old('product_data')['search_words']}}</textarea>
                                                        <span class="error">{!! $errors->first('search_words') !!}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    {{--Todo-Use editor here--}}
                                                    <label class="col-sm-3 control-label">Promo text</label>

                                                    <div class="col-sm-4">
                                                        <textarea name="product_data[promo_text]"
                                                                class="form-control">{{old('product_data')['promo_text']}}</textarea>
                                                        <span class="error">{!! $errors->first('promo_text') !!}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--//GENERAL DETAILS TAB--}}
                            {{--VARIANT DETAILS TAB--}}
                            <div class="tab-pane" id="tab_1_2">
                                {{--<div class="portlet-body form">--}}
                                {{--<div class="form-horizontal form-bordered">--}}
                                {{--<div class="form-body">--}}
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingMainImage">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                        href="#collapseMainImage"
                                                        aria-expanded="true" aria-controls="collapseMainImage"> Main
                                                    Image </a>
                                            </h4>
                                        </div>
                                        <div id="collapseMainImage" class="panel-collapse collapse in"
                                                role="tabpanel"
                                                aria-labelledby="headingMainImage">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    {{--<h4 class="note note-info note-bordered"--}}
                                                    {{--style="text-align: center">--}}
                                                    {{--Main Image</h4>--}}
                                                    <div class="text-center col-md-6">

                                                        <div class="fileinput fileinput-new"
                                                                data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail"
                                                                    style="width: 200px; height: 150px;">
                                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                                        alt=""/>
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                                    style="max-width: 200px; max-height: 150px;">
                                                            </div>
                                                            <div>
                                                                <span class="btn default btn-info btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <input id="main-image" type="file"
                                                                            name="product_data[mainimage]"> </span>
                                                                <a href="#"
                                                                        class="btn default btn-danger fileinput-exists"
                                                                        data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                            <span class="error">{!! $errors->first('mainimage') !!}</span>
                                                        </div>


                                                        {{--<div class="clearfix margin-top-10">--}}
                                                        {{--<span class="label label-danger">NOTE! </span> <span>Attached--}}
                                                        {{--image thumbnail is supported in Latest Firefox, Chrome,--}}
                                                        {{--Opera, Safari and Internet Explorer 10 only </span>--}}
                                                        {{--</div>--}}

                                                    </div>
                                                    <div class="col-md-6">
                                                        <br>

                                                        <p class="margin-top-10">
                                                            Counterfeit products are prohibited on FlashSale.
                                                        </p>

                                                        <p class="margin-top-10">Products with multiple high quality
                                                            images get the most sales.</p>

                                                        <p class="margin-top-10">Add images that are at least 800x800
                                                            pixels.</p>

                                                        <p class="margin-top-10">Do not steal images from other
                                                            merchants, or your product will be deleted.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOtherImages">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse"
                                                        data-parent="#accordion"
                                                        href="#collapseOtherImages" aria-expanded="false"
                                                        aria-controls="collapseOtherImages"> Other Images </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOtherImages" class="panel-collapse collapse"
                                                role="tabpanel"
                                                aria-labelledby="headingOtherImages">
                                            <div class="panel-body">
                                                <div class="form-group last">
                                                    {{--<h4 class="note note-info note-bordered"--}}
                                                    {{--style="text-align: center">--}}
                                                    {{--Other Images</h4>--}}
                                                    <div class="col-md-12">
                                                        <div class="fileinput fileinput-new"
                                                                data-provides="fileinput"
                                                                id="otherimagesdiv">
                                                            <div class="fileinput-new thumbnail"
                                                                    style="width: 200px; height: 150px;">
                                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                                        alt=""/>
                                                            </div>
                                                            <!--<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">-->
                                                        </div>
                                                        <div>
                                                            <span class="btn default btn-file btn-info">
                                                                <span class="fileinput-new" id="otherimageselect">
                                                                    Select images </span>
                                                                <span class="fileinput-exists hidden" id="otherimagechange">
                                                                    Change </span>
                                                                <input type="file" name="product_data[otherimages][]"
                                                                        multiple=""
                                                                        accept="image/*" id="otherimages"> </span>
                                                            <a class="btn default fileinput-exists btn-danger hidden"
                                                                    data-dismiss="fileinput"
                                                                    id="otherimagesremove"> Remove All</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                            </div>

                            <div class="tab-pane" id="tab_1_3">

                            </div>

                            <div class="tab-pane" id="tab_1_4">
                                <div class="form-group">
                                    {{--<label class="col-sm-3 control-label">Option</label>--}}
                                    <div class="col-sm-6">
                                        <select class="form-control bs-select"
                                                id="select_option">
                                            @foreach($allOptions as $optionKey=>$optionValue)
                                                <option value="{{$optionValue->option_id}}">
                                                    {{$optionValue->option_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-info" id="add-another-option">Add another
                                            option
                                        </button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-default" id="option-combinations">Option
                                            combinations
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover hidden" id="optionTable">
                                    <thead>
                                    <tr>
                                        <th width="50%">Option</th>
                                        <th width="15%">Action</th>
                                        <th width="35%">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody id="optionTableBody">
                                    {{--APPEND OPTION AND VARIANT DATA HERE--}}
                                    </tbody>
                                </table>

                                {{--<div class="form-group">--}}
                                {{--<div class="col-md-12" id="toAppendOptionDiv">--}}
                                {{--<div class="col-md-6">--}}
                                {{--<div class="portlet box blue-hoki">--}}
                                {{--<div class="portlet-title">--}}
                                {{--<div class="caption">--}}
                                {{--<i class="fa fa-gift"></i>Portlet--}}
                                {{--</div>--}}
                                {{--<div class="tools">--}}
                                {{--<a href="javascript:;" class="collapse"> </a>--}}
                                {{--<a href="javascript:;" class="remove"> </a>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="portlet-body">--}}
                                {{--<div class="scroller" style="height:300px">--}}
                                {{--<p> Duis mollis, est non commodo luctus, nisi erat porttitor--}}
                                {{--ligula, eget lacinia odio sem nec elit. Cras mattis--}}
                                {{--consectetur purus sit amet fermentum. est non commodo--}}
                                {{--luctus, nisi erat porttitor ligula, eget lacinia odio sem--}}
                                {{--nec elit. Cras mattis consectetur purus sit amet fermentum.--}}
                                {{--Duis mollis, est non commodo luctus, nisi erat porttitor--}}
                                {{--ligula, eget lacinia odio sem nec elit. Cras mattis--}}
                                {{--consectetur purus sit amet fermentum. est non commodo--}}
                                {{--luctus, nisi erat porttitor ligula, eget lacinia odio sem--}}
                                {{--nec elit. Cras mattis consectetur purus sit amet--}}
                                {{--fermentum. </p>--}}
                                {{--<p> Duis mollis, est non commodo luctus, nisi erat porttitor--}}
                                {{--ligula, eget lacinia odio sem nec elit. Cras mattis--}}
                                {{--consectetur purus sit amet fermentum. est non commodo--}}
                                {{--luctus, nisi erat porttitor ligula, eget lacinia odio sem--}}
                                {{--nec elit. Cras mattis consectetur purus sit amet fermentum.--}}
                                {{--Duis mollis, est non commodo luctus, nisi erat porttitor--}}
                                {{--ligula, eget lacinia odio sem nec elit. Cras mattis--}}
                                {{--consectetur purus sit amet fermentum. est non commodo--}}
                                {{--luctus, nisi erat porttitor ligula, eget lacinia odio sem--}}
                                {{--nec elit. Cras mattis consectetur purus sit amet--}}
                                {{--fermentum. </p>--}}
                                {{--<p> Duis mollis, est non commodo luctus, nisi erat porttitor--}}
                                {{--ligula, eget lacinia odio sem nec elit. Cras mattis--}}
                                {{--consectetur purus sit amet fermentum. est non commodo--}}
                                {{--luctus, nisi erat porttitor ligula, eget lacinia odio sem--}}
                                {{--nec elit. Cras mattis consectetur purus sit amet fermentum.--}}
                                {{--Duis mollis, est non commodo luctus, nisi erat porttitor--}}
                                {{--ligula, eget lacinia odio sem nec elit. Cras mattis--}}
                                {{--consectetur purus sit amet fermentum. est non commodo--}}
                                {{--luctus, nisi erat porttitor ligula, eget lacinia odio sem--}}
                                {{--nec elit. Cras mattis consectetur purus sit amet--}}
                                {{--fermentum. </p>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}

                            </div>

                            <div class="tab-pane" id="tab_1_5">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Weight ({{$weightSymbol}})</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control float-type" id="weight"
                                                name="product_data[shipping_properties][weight]"
                                                value="{{old('product_data')['shipping_properties']['weight']}}">
                                        <span class="error">{!! $errors->first('weight') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Free shipping</label>

                                    <div class="col-sm-4">
                                        <input type="checkbox" name="product_data[shipping_properties][free_shipping]"
                                                class="form-control m-b-sm"
                                                id="free_shipping"
                                                @if(isset(old('product_data')['shipping_properties']['free_shipping'])) checked @endif />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Shipping freight ({{$priceSymbol}})</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control float-type" id="shipping_freight"
                                                name="product_data[shipping_properties][shipping_freight]"
                                                value="{{old('product_data')['shipping_properties']['shipping_freight']}}">
                                        <span class="error">{!! $errors->first('shipping_freight') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Items in a box
                                        <i class="fa fa-question-circle" data-toggle="tooltip"
                                                title="Use this field to define to minimum and maximum number of product item to be shipped in a separate box. Enter non-zero value and specify the box dimensions below"></i></label>

                                    <div class="col-sm-4">
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control items_in_a_box integer-type"
                                                    id="min_items"
                                                    name="product_data[shipping_properties][min_items]"
                                                    value="{{old('product_data')['shipping_properties']['min_items']}}"
                                                    placeholder="min">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control items_in_a_box integer-type"
                                                    id="max_items"
                                                    name="product_data[shipping_properties][max_items]"
                                                    value="{{old('product_data')['shipping_properties']['max_items']}}"
                                                    placeholder="max">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Box length</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control box_dimension float-type"
                                                id="box_length"
                                                name="product_data[shipping_properties][box_length]"
                                                @if(isset(old('product_data')['shipping_properties']['box_length']))
                                                value="{{old('product_data')['shipping_properties']['box_length']}}"
                                                @endif
                                                disabled>
                                        <span class="error">{!! $errors->first('box_length') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Box width</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control box_dimension float-type"
                                                id="box_width"
                                                name="product_data[shipping_properties][box_width]"
                                                @if(isset(old('product_data')['shipping_properties']['box_width']))
                                                value="{{old('product_data')['shipping_properties']['box_width']}}"
                                                @endif
                                                disabled> <span class="error">{!! $errors->first('box_width') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Box height</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control box_dimension float-type"
                                                id="box_height"
                                                name="product_data[shipping_properties][box_height]"
                                                @if(isset(old('product_data')['shipping_properties']['box_height']))
                                                value="{{old('product_data')['shipping_properties']['box_height']}}"
                                                @endif
                                                disabled>
                                        <span class="error">{!! $errors->first('box_height') !!}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab_1_6">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 25%">Value</th>
                                            <th style="width: 25%">Type
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                        title="Fixed amount/percentage to be taken off the price."></i>
                                            </th>
                                            {{--<th>User group</th>--}}
                                            <th style="width: 15%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="quantityDiscountTBody">
                                        @if(isset(old('product_data')['quantity_discount'])
                                        && (current(old('product_data')['quantity_discount'])['quantity']!=''
                                        || current(old('product_data')['quantity_discount'])['value']!=''))
                                            @foreach(old('product_data')['quantity_discount'] as $quantityDiscountKey=>$quantityDiscountValue)
                                                @if($quantityDiscountValue['quantity']!=''||$quantityDiscountValue['value']!='')
                                                    <tr>
                                                        <td><input type="text" class="form-control integer-type"
                                                                    name="product_data[quantity_discount][{{$quantityDiscountKey}}][quantity]"
                                                                    value="{{$quantityDiscountValue['quantity']}}">
                                                            <span class="error">{!! $errors->first('quantity_discount.'.$quantityDiscountKey.'.quantity') !!}</span>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-6">
                                                                    <input type="text" class="form-control float-type"
                                                                            name="product_data[quantity_discount][{{$quantityDiscountKey}}][value]"
                                                                            value="{{$quantityDiscountValue['value']}}">
                                                                    <span class="error">{!! $errors->first('quantity_discount.'.$quantityDiscountKey.'.value') !!}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-4">
                                                                    <select name="product_data[quantity_discount][{{$quantityDiscountKey}}][type]"
                                                                            class="form-control">
                                                                        <?php $priceModifierType = array('1' => $priceSymbol, '2' => '%'); ?>
                                                                        @foreach($priceModifierType as $key=>$value)
                                                                            <option value="{{$key}}"
                                                                                    @if(isset(old('product_data')['quantity_discount'])&&$key==old('product_data')['quantity_discount'][$quantityDiscountKey]['type']) selected @endif>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        {{--<td>--}}
                                                        {{--<div class="col-sm-12">--}}
                                                        {{--<select name="product_data[quantity_discount][{{$quantityDiscountKey}}][user_group]"--}}
                                                        {{--class="form-control">--}}
                                                        {{--<?php $status = array('1' => 'Active', '2' => 'Inactive'); ?>--}}
                                                        {{--@foreach($status as $key=>$value)--}}
                                                        {{--<option value="{{$key}}"--}}
                                                        {{--@if(isset(old('product_data')['quantity_discount'])&&$key==old('product_data')['quantity_discount'][$quantityDiscountKey]['user_group']) selected @endif>{{$value}}</option>--}}
                                                        {{--@endforeach--}}
                                                        {{--</select>--}}
                                                        {{--</div>--}}

                                                        {{--</td>--}}
                                                        <td>
                                                            <a href="javascript:void(0);" class="col-sm-1 add-more"><i
                                                                        class="fa fa-plus"></i></a>
                                                            <a href="javascript:void(0);" class="col-sm-1 remove"><i
                                                                        class="fa fa-remove"></i></a>
                                                        </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td><input type="text" class="form-control integer-type"
                                                            name="product_data[quantity_discount][0][quantity]"></td>
                                                <td><input type="text" class="form-control float-type"
                                                            name="product_data[quantity_discount][0][value]"></td>
                                                <td>
                                                    <select name="product_data[quantity_discount][0][type]"
                                                            class="form-control">
                                                        <?php $priceModifierType = array('1' => 'Absolute (' . $priceSymbol . ')', '2' => 'Percent (%)'); ?>
                                                        @foreach($priceModifierType as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>

                                                </td>
                                                {{--<td>--}}
                                                {{--<select name="product_data[quantity_discount][0][user_group]"--}}
                                                {{--class="form-control">--}}
                                                {{--<option value="1">Active</option>--}}
                                                {{--<option value="2">Inactive</option>--}}
                                                {{--</select>--}}
                                                {{--</td>--}}
                                                <td>
                                                    <a href="javascript:void(0);" class="col-sm-1 add-more"><i
                                                                class="fa fa-plus"></i></a>
                                                    <a href="javascript:void(0);" class="col-sm-1 remove"><i
                                                                class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_1_7">
                            </div>
                            <div class="tab-pane" id="tab_1_8">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th width="50%">Tabs</th>
                                        <th width="50%">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Description</td>
                                        <td>
                                            <label for="product_tabs_description_active" class="col-sm-3">
                                                <input type="radio"
                                                        name="product_data[product_tabs][description]"
                                                        id="product_tabs_description_active" value="1" checked> Active
                                            </label> <label for="product_tabs_description_disabled" class="col-sm-3">
                                                <input type="radio"
                                                        name="product_data[product_tabs][description]"
                                                        id="product_tabs_description_disabled" value="2"> Disabled
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Features</td>
                                        <td>
                                            <label for="product_tabs_features_active" class="col-sm-3">
                                                <input type="radio"
                                                        name="product_data[product_tabs][features]"
                                                        id="product_tabs_features_active" value="1" checked> Active
                                            </label> <label for="product_tabs_features_disabled" class="col-sm-3">
                                                <input type="radio"
                                                        name="product_data[product_tabs][features]"
                                                        id="product_tabs_features_disabled" value="2"> Disabled </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tags</td>
                                        <td>
                                            <label for="product_tabs_tags_active" class="col-sm-3"> <input type="radio"
                                                        name="product_data[product_tabs][tags]"
                                                        id="product_tabs_tags_active" value="1" checked> Active </label>
                                            <label for="product_tabs_tags_disabled" class="col-sm-3">
                                                <input type="radio"
                                                        name="product_data[product_tabs][tags]"
                                                        id="product_tabs_tags_disabled" value="2"> Disabled </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Reviews</td>
                                        <td>
                                            <label for="product_tabs_reviews_active" class="col-sm-3">
                                                <input type="radio"
                                                        name="product_data[product_tabs][reviews]"
                                                        id="product_tabs_reviews_active" value="1" checked> Active
                                            </label> <label for="product_tabs_reviews_disabled" class="col-sm-3">
                                                <input type="radio"
                                                        name="product_data[product_tabs][reviews]"
                                                        id="product_tabs_reviews_disabled" value="2"> Disabled </label>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab_1_9">

                            </div>
                            {{--//VARIANT DETAILS TAB--}}
                        </div>
                        <div class="form-actions" align="center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>

                        <!-- OPTION COMBINATION MODAL START-->
                        <div class="modal fade bs-modal-lg" id="option_combinations_modal" role="dialog">
                            <div class="modal-dialog  modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><b>Option Combinations</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-horizontal">
                                            <div class="panel-body">
                                                <div class="row" style="  height: 450px; overflow-y: auto;">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="option-combination-table">
                                                            <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Quantity</th>
                                                                <th>Bar code</th>
                                                                <th>Exclude combination</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="variantCombinationTBody">
                                                            <!-- OPTION COMBINATIONS WILL BE ADDED/UPDATED/REMOVED HERE-->
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="text-align: center">
                                        {{--<button data-dismiss="modal" class="btn default" type="button">Close</button>--}}
                                        <button data-dismiss="modal" class="btn blue" type="button" id="save-option-combinations">
                                            Save and close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- OPTION COMBINATION MODAL END-->

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-modal-lg" id="edit_option_modal" role="dialog">
        <div class="modal-dialog  modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Editing option: <span id="modal_title"></span></b></h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="panel panel-white">

                                <div class="panel-body">
                                    <div class="portlet-title tabbable-line">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#option_tab" data-toggle="tab">General</a></li>
                                            <li><a href="#variant_tab" data-toggle="tab">Variants</a></li>
                                        </ul>
                                    </div>
                                    <div class="tab-content" style="  height: 300px; overflow-y: auto;">
                                        {{--GENERAL DETAILS TAB--}}
                                        <div class="tab-pane active" id="option_tab">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="option_id_for_edit"
                                                        for="option_id">
                                                <label class="col-sm-2 control-label">Name</label>

                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="option_name_for_edit"
                                                            for="option_name">
                                                </div>
                                            </div>

                                            {{--<div class="form-group">--}}
                                            {{--<label class="col-sm-2 control-label">Supplier</label>--}}

                                            {{--<div class="col-sm-4">--}}
                                            {{--<select name="option_data[shop_id]" class="form-control m-b-sm"--}}
                                            {{--for="shop_id">--}}
                                            {{--<option value="0">None</option>--}}
                                            {{--@if(isset($allShop))--}}
                                            {{--@foreach($allShop as $key=>$value)--}}
                                            {{--<option value="{{$value->id}}"--}}
                                            {{--@if(isset(old('option_data')['shop_id'])&&$value->id==old('option_data')['shop_id']) selected @endif>{{$value->shop_name}}</option>--}}
                                            {{--@endforeach--}}
                                            {{--@endif--}}

                                            {{--</select>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Type</label>

                                                <div class="col-sm-4">
                                                    <select name="option_data[option_type]" class="form-control m-b-sm"
                                                            id="option_type_for_edit" for="option_type">
                                                        <?php $optionType = array('1' => 'Select box', '2' => 'Radio group', '3' => 'Check box'); ?>
                                                        @foreach($optionType as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Description</label>

                                                <div class="col-sm-4">
                                                    <textarea name="option_data[description]"
                                                            class="form-control"
                                                            id="option_desc_for_edit" for="description"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Comment</label>

                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control"
                                                            name="option_data[comment]"
                                                            id="option_comment_for_edit" for="comment">
                                                    <small>Enter your comment to appear below the option</small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Required</label>

                                                <div class="col-sm-4">
                                                    <input type="checkbox" class="form-control"
                                                            name="option_data[required]"
                                                            @if(isset(old('option_data')['required'])) checked @endif
                                                    id="option_required_for_edit" for="required">
                                                </div>
                                            </div>
                                        </div>
                                        {{--//GENERAL DETAILS TAB--}}
                                        {{--VARIANT DETAILS TAB--}}
                                        <div class="tab-pane" id="variant_tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Price modifier / Type</th>
                                                        <th>Weight modifier / Type</th>
                                                        <th>Status</th>
                                                        <th>Extra</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="variantTBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        {{--//VARIANT DETAILS TAB--}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="text-align: center">
                    <button data-dismiss="modal" class="btn default" type="button">Close</button>
                    <button class="btn blue" type="button" id="save-option-details">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejavascripts')
    {{--<script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>--}}
    <script src="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="/assets/plugins/select2/js/select2.js"></script>
    <script src="/assets/global/scripts/app.min.js"></script>
    <script src="/assets/plugins/datatables/js/jquery.datatables.min.js"></script>
    <script src="/assets/global/plugins/underscore-js/underscore.js"></script>

    <script>
        $(document).ready(function () {
            App.initPortlet();
            App.initSlimScroll(".scroller");
        });

        $(document).ready(function () {

//            TODO UNCOMMENT THIS TO GET STYLED DROPDOWN
            /* $("#select_category").select2({
             allowClear: !0,
             placeholder: "Select a category",
             width: "70%"
             }); */

            var optionAddedRemovedFlag = false;
            $("#select_option").select2({
                allowClear: !0,
                placeholder: "Select an option",
                width: "100%"
            });

            $(document.body).on('click', '#add-another-option', function (e) {
                var optionId = $('#select_option').val();
//                alert(optionId);
                var newOptionFlag = true;
                if ($("#optionTableBody tr").length > 0) {
                    $.each($("#optionTableBody tr"), function (i, v) {
                        if (optionId == $(this).attr('option-id'))
                            newOptionFlag = false;
                    });
                }

                if (optionId != '') {
                    if (newOptionFlag) {
                        $.ajax({
                            url: '/admin/product-ajax-handler',
                            type: 'POST',
                            datatype: 'json',
                            data: {
                                method: 'getOptionVariantsWhere',
                                optionId: optionId
                            },
                            success: function (response) {
                                response = $.parseJSON(response);
                                //toastr[response['status']](response['msg']);
                                console.log(response);
                                if (response['code'] == 200) {
                                    var toAppend = '';
                                    $("#optionTable").removeClass('hidden');
                                    var optionId = response['data']['optionDetails']['option_id'];
                                    var optionName = response['data']['optionDetails']['option_name'];
                                    var optionVariants = response['data']['optionVariants'];
                                    if (optionName != '') {
                                        toAppend += '<tr id="option_id_' + optionId + '" option-id="' + optionId + '"> ';

                                        toAppend += '<td>';
                                        toAppend += '<a total-variant="' + optionVariants.length + '" style="text-decoration: none" href="javascript:void(0);" class="edit-option option-name" data-id="' + optionId + '">' + optionName + '</a>';
                                        toAppend += '<input id="option_name_' + optionId + '" field-name="option_name" type="hidden" name="product_data[options][' + optionId + '][option_name]" value="' + optionName + '">';
                                        toAppend += '<input id="option_id_' + optionId + '" field-name="option_name" type="hidden" name="product_data[options][' + optionId + '][option_id]" value="' + optionId + '">';
                                        toAppend += '<input id="shop_id_' + optionId + '" field-name="shop_id" type="hidden" name="product_data[options][' + optionId + '][shop_id]" value="' + response['data']['optionDetails']['shop_id'] + '">';
                                        toAppend += '<input id="option_type_' + optionId + '" field-name="option_type" type="hidden" name="product_data[options][' + optionId + '][option_type]" value="' + response['data']['optionDetails']['option_type'] + '">';
                                        toAppend += '<input id="description_' + optionId + '" field-name="description" type="hidden" name="product_data[options][' + optionId + '][description]" value="' + response['data']['optionDetails']['description'] + '">';
                                        toAppend += '<input id="comment_' + optionId + '" field-name="comment" type="hidden" name="product_data[options][' + optionId + '][comment]" value="' + response['data']['optionDetails']['comment'] + '">';
                                        toAppend += '<input id="status_' + optionId + '" field-name="status" type="hidden" name="product_data[options][' + optionId + '][status]" value="' + response['data']['optionDetails']['status'] + '">';
                                        toAppend += '<input id="required_' + optionId + '" field-name="required" type="hidden" name="product_data[options][' + optionId + '][required]" value="' + response['data']['optionDetails']['required'] + '">';
                                        toAppend += '</td>';

                                        toAppend += '<td>';
                                        toAppend += '<div role="group" class="btn-group ">';
                                        toAppend += '<button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">';
                                        toAppend += '<i class="fa fa-cog"></i>&nbsp; <span class="caret"></span>';
                                        toAppend += '</button>';
                                        toAppend += '<ul role="menu" class="dropdown-menu">';
                                        toAppend += '<li><a total-variant="' + optionVariants.length + '" href="javascript:void(0);" class="edit-option" data-id="' + optionId + '">';
                                        toAppend += '<i class="fa fa-pencil" data-id="' + optionId + '"></i>&nbsp;Edit</a> </li>';
                                        toAppend += '<li><a href="javascript:void(0);" class="delete-option" data-id="' + optionId + '">';
                                        toAppend += '<i class="fa fa-trash"></i>&nbsp;Delete</a> </li>';
                                        toAppend += '</ul>';
                                        toAppend += '</div>';
                                        toAppend += '</td>';

                                        toAppend += '<td>';
                                        toAppend += '<label for="product_option_status_' + optionId + '_active" class="col-sm-6">';
                                        toAppend += '<input field-name="option_status"  type="radio" name="product_data[options][' + optionId + '][status]" id="product_option_status_' + optionId + '_active" value="1" checked> Active </label>';
                                        toAppend += '<label for="product_option_status_' + optionId + '_disabled" class="col-sm-6">';
                                        toAppend += '<input field-name="option_status" type="radio" name="product_data[options][' + optionId + '][status]" id="product_option_status_' + optionId + '_disabled" value="2"> Disabled </label>';
                                        toAppend += '</td>';


                                        if (optionVariants != '') {
                                            $.each(optionVariants, function (i, a) {
                                                console.log(a['variant_id']);
                                                toAppend += '<input type="hidden" class="all-data-of-a-variant hidden"  variant_id="' + a['variant_id'] + '" variant_name="' + a['variant_name'] + '" price_modifier="' + a['price_modifier'] + '" price_modifier_type="' + a['price_modifier_type'] + '" weight_modifier="' + a['weight_modifier'] + '" weight_modifier_type="' + a['weight_modifier_type'] + '" status="' + a['status'] + '">';
//                                                toAppend += '<input id="variant_name_' + optionId + '_' + a['variant_id'] + '" class="variant-data-' + optionId + ' variant-id-' + a['variant_id'] + '" field-name="variant_name" type="hidden" varaint-id="' + a['variant_id'] + '" name="product_data[options][' + optionId + '][option_variants][variant_name][]" value="' + a['variant_name'] + '">';
//                                                toAppend += '<input id="price_modifier_' + optionId + '_' + a['variant_id'] + '" class="variant-data-' + optionId + ' variant-id-' + a['variant_id'] + '" field-name="price_modifier" type="hidden" varaint-id="' + a['variant_id'] + '" name="product_data[options][' + optionId + '][option_variants][price_modifier][]" value="' + a['price_modifier'] + '">';
//                                                toAppend += '<input id="price_modifier_type_' + optionId + '_' + a['variant_id'] + '" class="variant-data-' + optionId + ' variant-id-' + a['variant_id'] + '" field-name="price_modifier_type" type="hidden" varaint-id="' + a['variant_id'] + '" name="product_data[options][' + optionId + '][option_variants][price_modifier_type][]" value="' + a['price_modifier_type'] + '">';
//                                                toAppend += '<input id="weight_modifier_' + optionId + '_' + a['variant_id'] + '" class="variant-data-' + optionId + ' variant-id-' + a['variant_id'] + '" field-name="weight_modifier" type="hidden" varaint-id="' + a['variant_id'] + '" name="product_data[options][' + optionId + '][option_variants][weight_modifier][]" value="' + a['weight_modifier'] + '">';
//                                                toAppend += '<input id="weight_modifier_type_' + optionId + '_' + a['variant_id'] + '" class="variant-data-' + optionId + ' variant-id-' + a['variant_id'] + '" field-name="weight_modifier_type" type="hidden" varaint-id="' + a['variant_id'] + '" name="product_data[options][' + optionId + '][option_variants][weight_modifier_type][]" value="' + a['weight_modifier_type'] + '">';
                                            });
                                        }
                                        toAppend += '</tr>';
                                        $("#optionTableBody").append(toAppend);
                                    }
                                    $.each(response['data'], function (i, a) {

                                    });
//                                $('#toAppendOptionDiv').html(toAppend);
                                    optionAddedRemovedFlag = true;
                                } else {
                                    toastr['error'](response['message']);
                                }
                            },
                            error: function (response) {
                                toastr['error']("Something went wrong. Please try again");
                                console.log(response);
                            }
                        });
                    } else {
                        toastr['error']("Sorry, you can't add same option twice.");
                    }
                } else {
                    toastr['error']("Please select an option to add.");
                }
            });

            var variantCounter = 1;
            $(document.body).on('click', '.add-more', function () {
                var toAppendNewTableRow = '<tr>';
                toAppendNewTableRow += '<td><input type="text" class="form-control integer-type" name="product_data[quantity_discount][' + variantCounter + '][quantity]"></td>';

                toAppendNewTableRow += '<td><input type="text" class="form-control float-type" name="product_data[quantity_discount][' + variantCounter + '][value]"></td>';
                toAppendNewTableRow += '<td>';
                toAppendNewTableRow += '<select name="product_data[quantity_discount][' + variantCounter + '][type]" class="form-control">';
                toAppendNewTableRow += '<option value="1">Absolute ({{$priceSymbol}})</option>';
                toAppendNewTableRow += '<option value="2">Percent (%)</option>';
                toAppendNewTableRow += '</select>';
                toAppendNewTableRow += '</td>';

                toAppendNewTableRow += '<td>';
                toAppendNewTableRow += '<a class="col-sm-1 add-more"><i class="fa fa-plus"></i></a>';
                toAppendNewTableRow += '<a class="col-sm-1 remove"><i class="fa fa-remove"></i></a>';
                toAppendNewTableRow += '</td>';

                toAppendNewTableRow += ' </tr>';

                $("#quantityDiscountTBody").append(toAppendNewTableRow);
                variantCounter++;
            });

            $(document.body).on('click', '.remove', function () {
                var count = $('#quantityDiscountTBody').children('tr').length;
                if (count > 1) $(this).closest('tr').remove();
            });

            if ($(".tab-content").find('.error').text()) {
                $.each($(".tab-content").find('.error'), function (index, value) {
                    if ($(this).text()) {
                        $(".tab-content").children('.tab-pane').removeClass('active');
                        $(this).closest('.tab-pane').addClass('active');
                        $(".nav-tabs").children('li').removeClass('active');
                        var id = $(this).closest('.tab-pane').attr('id');
                        $.each($(".nav-tabs").children('li'), function (i, a) {
                            if (('#' + id) == $(this).children('a').attr('href'))
                                $(this).addClass('active');
                        });
                        return false;
                    }
                });
            }

            $(document.body).on('change', '#otherimages', function (e) {//NEED TO ADD VALIDATION FOR LIMIT OF FILES TO BE ALLOWED FOR UPLOADING
                e.preventDefault();
                var obj = $(this);
                var imagecount = 0;
                var files1 = e.target.files === undefined ? (e.target && e.target.value ? [{name: e.target.value.replace(/^.+\\/, '')}] : []) : e.target.files;
                if (files1.length > 0) {
                    if (files1.length <= 5) {
                        var el = '';
                        var flag = false;
                        $('#otherimagesdiv').html('');
                        $.each(files1, function (i, a) {
                            var file = a;
                            el = '<div class="fileinput-preview fileinput-exists thumbnail otherimagesdivs" style="width: 200px; height: 150px;" id="otherimagepreviewdiv' + imagecount + '">';
                            el += '</div>';
                            var img = document.createElement("img");
                            if ((typeof file.type !== "undefined" ? file.type.match(/^image\/(gif|png|jpeg)$/) : file.name.match(/\.(gif|png|jpe?g)$/i)) && typeof FileReader !== "undefined") {
                                if (i == 0) {
                                    flag = true;
                                }
                                var reader = new FileReader();
                                $('#otherimagesdiv').append(el);
                                reader.onload = function (re) {
//                                console.log('1' + re.target.result);
                                    img.src = re.target.result;
                                }
                                reader.readAsDataURL(file);
                                $('#otherimagepreviewdiv' + imagecount).html(img);
                                flag = flag && true;
                            }
                            imagecount++;
                        });
                        if (flag) {
                            $('#otherimagesdiv').removeClass('fileinput-new');
                            $('#otherimagesdiv').addClass('fileinput-exists');
                            $('#otherimagesremove').removeClass('hidden');
                            $('#otherimagechange').removeClass('hidden');
                            $('#otherimageselect').addClass('hidden');
                        } else {
                            //CODE TO SHOW ERROR MESSAGE
                        }
                    } else {
                        toastr['error']("You can't upload more than 5 images.");
                    }

                } else {
                    var toAppend = '<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">';
                    toAppend += '<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>';
                    toAppend += '</div>';
                    $('#otherimagesdiv').html(toAppend);
                    $('#otherimagechange').addClass('hidden');
                    $('#otherimageselect').removeClass('hidden');
                    $('#otherimagesdiv').removeClass('fileinput-exists');
                    $('#otherimagesdiv').addClass('fileinput-new');
                    $('#otherimages').val('');
                }
            });

            $(document.body).on('click', '#otherimagesremove', function (e) {
                var toAppend = '<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">';
                toAppend += '<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>';
                toAppend += '</div>';
                $('#otherimagesdiv').html(toAppend);
                $('#otherimagesdiv').removeClass('fileinput-exists');
                $('#otherimagesdiv').addClass('fileinput-new');
                $('#otherimagechange').addClass('hidden');
                $('#otherimageselect').removeClass('hidden');
                $('#otherimagesremove').addClass('hidden');
                $('#otherimages').val('');
            });

            $(".items_in_a_box").on('keyup', function () {
                $(".box_dimension").prop('disabled', (($('#min_items').val() == 0) && ($('#max_items').val() == 0)));
            });

            $(document.body).on('click', '.delete-option', function () {
                $(this).closest('tr').remove();
                if ($("#optionTableBody tr").length == 0) $("#optionTable").addClass('hidden');
                optionAddedRemovedFlag = true;
            });

            var variantCounterForEdit = 1;
            $(document.body).on('click', '.edit-option', function () {
                var obj = $(this);
                var optionName = obj.closest('tr').find('[field-name=option_name]').val();
                var optionId = obj.attr('data-id');
                var totalVariant = variantCounterForEdit = obj.attr('total-variant');
//                console.log(totalVariant);
                $.each($("#option_id_" + optionId), function (i, v) {
                    $("#variantTBody").empty();
                    $("#save-option-details").attr('option_id', optionId);
                    $("#modal_title").html(optionName);
                    $("#option_name_for_edit").val(optionName);
                    $("#option_id_for_edit").val(optionId);
                    $("#option_desc_for_edit").val(obj.closest('tr').find('[field-name=description]').val());
                    $("#option_comment_for_edit").val(obj.closest('tr').find('[field-name=comment]').val());
                    if ($(this).find(".all-data-of-a-variant").length > 0) {
                        $.each($(this).find(".all-data-of-a-variant"), function (i, v) {
//                            console.log(v);
                            var newVarClass = '';
                            if ($(v).hasClass('new-variant')) {
                                newVarClass = 'new-variant';
                            }
                            var toAppendVariantDetail = '';
                            toAppendVariantDetail += '<tr class="variant-data ' + newVarClass + '"  variant-id="' + $(this).attr('variant_id') + '">';
                            toAppendVariantDetail += '<td><input field-name="variant_name" type="text" class="form-control variant_name" value="' + $(this).attr('variant_name') + '"></td>';
                            toAppendVariantDetail += '<td>';
                            toAppendVariantDetail += '<div class="form-group">';
                            toAppendVariantDetail += '<div class="col-sm-5">';
                            toAppendVariantDetail += '<input field-name="price_modifier"  type="text" class="form-control float-type price_modifier " value="' + $(this).attr('price_modifier') + '">';
                            toAppendVariantDetail += '</div>';
                            toAppendVariantDetail += '<span class="col-sm-1 separator">/</span>';
                            toAppendVariantDetail += '<div class="col-sm-5">';
                            toAppendVariantDetail += '<select field-name="price_modifier_type" class="form-control price_modifier_type ">';
                            toAppendVariantDetail += '<option value="1">{{$priceSymbol}}</option>';
                            toAppendVariantDetail += '<option value="2">%</option>';
                            toAppendVariantDetail += '</select>';
                            toAppendVariantDetail += '</div>';
                            toAppendVariantDetail += '</div>';
                            toAppendVariantDetail += '</td>';

                            toAppendVariantDetail += '<td>';
                            toAppendVariantDetail += '<div class="form-group">';
                            toAppendVariantDetail += '<div class="col-sm-5">';
                            toAppendVariantDetail += '<input field-name="weight_modifier" type="text" class="form-control weight_modifier float-type " value="' + $(this).attr('weight_modifier') + '">';
                            toAppendVariantDetail += '</div>';
                            toAppendVariantDetail += '<span class="col-sm-1 separator">/</span>';

                            toAppendVariantDetail += '<div class="col-sm-5">';
                            toAppendVariantDetail += '<select field-name="weight_modifier_type" class="form-control weight_modifier_type ">';
                            toAppendVariantDetail += '<option value="1">{{$weightSymbol}}</option>';
                            toAppendVariantDetail += '<option value="2">%</option>';
                            toAppendVariantDetail += '</select>';
                            toAppendVariantDetail += '</div>';
                            toAppendVariantDetail += '</div>';
                            toAppendVariantDetail += '</td>';

                            toAppendVariantDetail += '<td>';
                            toAppendVariantDetail += '<select field-name="status" class="form-control status ">';
                            toAppendVariantDetail += '<option value="1">Active</option>';
                            toAppendVariantDetail += '<option value="2">Inactive</option>';
                            toAppendVariantDetail += '</select>';
                            toAppendVariantDetail += '</td>';

                            toAppendVariantDetail += '<td>';
                            toAppendVariantDetail += '<a href="javascript:void(0);" class="col-sm-1 for-edit-add-more" option_id="' + optionId + '"><i class="fa fa-plus"></i></a>';
                            toAppendVariantDetail += '<a href="javascript:void(0);" class="col-sm-1 for-edit-remove" option_id="' + optionId + '"><i class="fa fa-remove"></i></a>';
                            toAppendVariantDetail += '</td>';
                            toAppendVariantDetail += '</tr>';
                            $("#variantTBody").append(toAppendVariantDetail);

                        });
                    } else {
                        var toAppendVariantDetail = '';
                        toAppendVariantDetail += '<tr class="variant-data new-variant"  variant-id="' + newVariantCounter + '">';
                        toAppendVariantDetail += '<td><input field-name="variant_name" type="text" class="form-control variant_name "></td>';
                        toAppendVariantDetail += '<td>';
                        toAppendVariantDetail += '<div class="form-group">';
                        toAppendVariantDetail += '<div class="col-sm-5">';
                        toAppendVariantDetail += '<input field-name="price_modifier" type="text" class="form-control price_modifier float-type " >';
                        toAppendVariantDetail += '</div>';
                        toAppendVariantDetail += '<span class="col-sm-1 separator">/</span>';
                        toAppendVariantDetail += '<div class="col-sm-5">';
                        toAppendVariantDetail += '<select field-name="price_modifier_type" class="form-control price_modifier_type ">';
                        toAppendVariantDetail += '<option value="1">{{$priceSymbol}}</option>';
                        toAppendVariantDetail += '<option value="2">%</option>';
                        toAppendVariantDetail += '</select>';
                        toAppendVariantDetail += '</div>';
                        toAppendVariantDetail += '</div>';
                        toAppendVariantDetail += '</td>';

                        toAppendVariantDetail += '<td>';
                        toAppendVariantDetail += '<div class="form-group">';
                        toAppendVariantDetail += '<div class="col-sm-5">';
                        toAppendVariantDetail += '<input field-name="weight_modifier" type="text" class="form-control weight_modifier  float-type ">';
                        toAppendVariantDetail += '</div>';
                        toAppendVariantDetail += '<span class="col-sm-1 separator">/</span>';

                        toAppendVariantDetail += '<div class="col-sm-5">';
                        toAppendVariantDetail += '<select field-name="weight_modifier_type" class="form-control weight_modifier_type">';
                        toAppendVariantDetail += '<option value="1">{{$weightSymbol}}</option>';
                        toAppendVariantDetail += '<option value="2">%</option>';
                        toAppendVariantDetail += '</select>';
                        toAppendVariantDetail += '</div>';
                        toAppendVariantDetail += '</div>';
                        toAppendVariantDetail += '</td>';

                        toAppendVariantDetail += '<td>';
                        toAppendVariantDetail += '<select field-name="status" class="form-control status ">';
                        toAppendVariantDetail += '<option value="1">Active</option>';
                        toAppendVariantDetail += '<option value="2">Inactive</option>';
                        toAppendVariantDetail += '</select>';
                        toAppendVariantDetail += '</td>';

                        toAppendVariantDetail += '<td>';
                        toAppendVariantDetail += '<a href="javascript:void(0);" class="col-sm-1 for-edit-add-more" option_id="' + optionId + '"><i class="fa fa-plus"></i></a>';
                        toAppendVariantDetail += '<a href="javascript:void(0);" class="col-sm-1 for-edit-remove" option_id="' + optionId + '"><i class="fa fa-remove"></i></a>';
                        toAppendVariantDetail += '</td>';
                        toAppendVariantDetail += '</tr>';
                        $("#variantTBody").append(toAppendVariantDetail);
                    }
                });
                $("#edit_option_modal").modal('show');
//                if ($("#optionTableBody tr").length == 0) $("#optionTable").addClass('hidden');
            });

            var newVariantCounter = 1;
            $(document.body).on('click', '.for-edit-add-more', function () {
                var toAppendVariantDetail = '';
                var optionId = $(this).attr('option_id');
                toAppendVariantDetail += '<tr class="variant-data new-variant" variant-id="' + newVariantCounter + '">';
                toAppendVariantDetail += '<td><input field-name="variant_name" type="text" class="form-control variant_name "></td>';
                toAppendVariantDetail += '<td>';
                toAppendVariantDetail += '<div class="form-group">';
                toAppendVariantDetail += '<div class="col-sm-5">';
                toAppendVariantDetail += '<input field-name="price_modifier" type="text" class="form-control price_modifier float-type " >';
                toAppendVariantDetail += '</div>';
                toAppendVariantDetail += '<span class="col-sm-1 separator">/</span>';
                toAppendVariantDetail += '<div class="col-sm-5">';
                toAppendVariantDetail += '<select field-name="price_modifier_type" class="form-control price_modifier_type ">';
                toAppendVariantDetail += '<option value="1">{{$priceSymbol}}</option>';
                toAppendVariantDetail += '<option value="2">%</option>';
                toAppendVariantDetail += '</select>';
                toAppendVariantDetail += '</div>';
                toAppendVariantDetail += '</div>';
                toAppendVariantDetail += '</td>';

                toAppendVariantDetail += '<td>';
                toAppendVariantDetail += '<div class="form-group">';
                toAppendVariantDetail += '<div class="col-sm-5">';
                toAppendVariantDetail += '<input field-name="weight_modifier" type="text" class="form-control weight_modifier  float-type ">';
                toAppendVariantDetail += '</div>';
                toAppendVariantDetail += '<span class="col-sm-1 separator">/</span>';

                toAppendVariantDetail += '<div class="col-sm-5">';
                toAppendVariantDetail += '<select field-name="weight_modifier_type" class="form-control weight_modifier_type ">';
                toAppendVariantDetail += '<option value="1">{{$weightSymbol}}</option>';
                toAppendVariantDetail += '<option value="2">%</option>';
                toAppendVariantDetail += '</select>';
                toAppendVariantDetail += '</div>';
                toAppendVariantDetail += '</div>';
                toAppendVariantDetail += '</td>';

                toAppendVariantDetail += '<td>';
                toAppendVariantDetail += '<select field-name="status" class="form-control status ">';
                toAppendVariantDetail += '<option value="1">Active</option>';
                toAppendVariantDetail += '<option value="2">Inactive</option>';
                toAppendVariantDetail += '</select>';
                toAppendVariantDetail += '</td>';

                toAppendVariantDetail += '<td>';
                toAppendVariantDetail += '<a href="javascript:void(0);" class="col-sm-1 for-edit-add-more"><i class="fa fa-plus"></i></a>';
                toAppendVariantDetail += '<a href="javascript:void(0);" class="col-sm-1 for-edit-remove"><i class="fa fa-remove"></i></a>';
                toAppendVariantDetail += '</td>';
                toAppendVariantDetail += '</tr>';

                $("#variantTBody").append(toAppendVariantDetail);
                variantCounterForEdit++;
                newVariantCounter++;
            });

            $(document.body).on('click', '.for-edit-remove', function () {
                var count = $('#variantTBody').children('tr').length;
                if (count > 1) $(this).closest('tr').remove();
            });


            $(document.body).on('click', '#save-option-details', function () {
                var obj = $(this);
                var optionId = $(this).attr('option_id');

                $("#option_name_" + optionId).val($("#option_name_for_edit").val());
                $("#option_type_" + optionId).val($("#option_type_for_edit").val());
                $("#description_" + optionId).val($("#option_desc_for_edit").val());
                $("#comment_" + optionId).val($("#option_comment_for_edit").val());
                $("#required_" + optionId).val($("#option_required_for_edit").val());
                $("#option_id_" + optionId + " .option-name").text($("#option_name_for_edit").val());

                var modalObj = obj.parents('.modal-content').find(".modal-body");
                $("#option_id_" + optionId + " .all-data-of-a-variant").remove();
                $("#option_id_" + optionId + " .option-variant-data").remove();
                $.each(modalObj.find(".variant-data"), function (i, v) {
                    var newVarClass = '';
                    if ($(v).hasClass('new-variant')) {
                        newVarClass = 'new-variant';
                    }
                    var allDataOfAVariant = '<input class="all-data-of-a-variant  ' + newVarClass + ' hidden" type="hidden" variant_id="' + $(this).attr('variant-id') + '" ';
                    $.each($(this).find(":input"), function (index, value) {
                        allDataOfAVariant += $(this).attr('field-name') + ' = "' + $(this).val() + '" ';
                    });
                    allDataOfAVariant += '>';
                    $("#option_id_" + optionId).append(allDataOfAVariant);
                });
                $("#edit_option_modal").modal('hide');
            });


//            APPEND VARIANT DATA INTO FORM
            $('form').submit(function (event) {
                $.each($("#optionTableBody tr"), function (i, v) {
                    var variantSerialNumber = 0;
                    var optionId = $(this).attr('option-id');
                    var allDataOfAVariantObj = $(this).find('.all-data-of-a-variant');
                    $.each(allDataOfAVariantObj, function (index, value) {
                        if ($(value).hasClass('new-variant')) {
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantDataNew][' + variantSerialNumber + '][variant_id]" value="' + $(this).attr('variant_id') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantDataNew][' + variantSerialNumber + '][variant_name]" value="' + $(this).attr('variant_name') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantDataNew][' + variantSerialNumber + '][price_modifier]" value="' + $(this).attr('price_modifier') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantDataNew][' + variantSerialNumber + '][price_modifier_type]" value="' + $(this).attr('price_modifier_type') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantDataNew][' + variantSerialNumber + '][weight_modifier]" value="' + $(this).attr('weight_modifier') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantDataNew][' + variantSerialNumber + '][weight_modifier_type]" value="' + $(this).attr('weight_modifier_type') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantDataNew][' + variantSerialNumber + '][status]" value="' + $(this).attr('status') + '">');
                        } else {
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantData][' + variantSerialNumber + '][variant_id]" value="' + $(this).attr('variant_id') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantData][' + variantSerialNumber + '][variant_name]" value="' + $(this).attr('variant_name') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantData][' + variantSerialNumber + '][price_modifier]" value="' + $(this).attr('price_modifier') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantData][' + variantSerialNumber + '][price_modifier_type]" value="' + $(this).attr('price_modifier_type') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantData][' + variantSerialNumber + '][weight_modifier]" value="' + $(this).attr('weight_modifier') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantData][' + variantSerialNumber + '][weight_modifier_type]" value="' + $(this).attr('weight_modifier_type') + '">');
                            $("#addProductForm").append('<input class="option-variant-data" type="hidden" name="product_data[options][' + optionId + '][variantData][' + variantSerialNumber + '][status]" value="' + $(this).attr('status') + '">');
                        }
                        variantSerialNumber++;
                    });
                });
//                $('#option-combinations').click();
                return true;
            });

            $(document.body).on('change', '#select_category', function () {
                var catid = $(this).val();
                $("#featuresTableBody").html('');
                $('#select_feature').html('');
                if (catid) {
                    $.ajax({
                        url: '/admin/product-ajax-handler',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            method: 'getFeaturesWhereCatIdLike',
                            catid: catid
                        },
                        success: function (response) {
                            response = $.parseJSON(response);
                            console.log(response);
                            if (response['code'] == 200) {
                                $('#featureTab').removeClass('hidden');
                                var toAppend = '';
                                $.each(response['data']['featureDetails'], function (i, a) {

                                    var toAppendStatus = '<div class="col-md-offset-1 col-md-4"><label for="product_feature_status_' + a['feature_id'] + '_active" class="col-sm-6">';
                                    toAppendStatus += '<input type="radio" name="product_data[features][' + a['feature_id'] + '][status]" id="product_feature_status_' + a['feature_id'] + '_active" value="1" checked> Active </label>';
                                    toAppendStatus += '<label for="product_feature_status_' + a['feature_id'] + '_disabled" class="col-sm-6">';
                                    toAppendStatus += '<input type="radio" name="product_data[features][' + a['feature_id'] + '][status]" id="product_feature_status_' + a['feature_id'] + '_disabled" value="0"> Disabled </label></div>';

                                    toAppend += '<hr><div class="form-group"><label class="col-sm-3 control-label">' + a['feature_name'] + '</label>';
                                    if (a['feature_type'] == 0) {
                                        toAppend += '<div class="col-md-3"><input class="form-control" type="checkbox" name="product_data[features][' + a['feature_id'] + '][single]"/></div>';//value="' + a['feature_id'] + '"//<div class="clearfix"></div>
                                        toAppend += toAppendStatus;
                                        toAppend += '<div class="clearfix"></div>';
                                    } else if (a['feature_type'] == 1) {
                                        if (a['variant_ids'] != null) {
                                            var variantIds = a['variant_ids'].split(",");
                                            var variantNames = a['variant_names'].split(",");
                                            var variantDescs = a['variant_descriptions'].split(",");
                                            $.each(variantIds, function (iVIds, aVIds) {
                                                toAppend += '<div class="col-md-3"><input class="form-control" type="checkbox" name="product_data[features][' + a['feature_id'] + '][multiple][' + aVIds + ']"/>' + variantNames[iVIds] + '</div>';// value="' + a['feature_id'] + '.' + aVIds + '"//<div class="clearfix"></div>
                                                if (iVIds == 0) {
                                                    toAppend += toAppendStatus;
                                                }
                                                toAppend += '<div class="clearfix"></div>';
                                            });
                                        }
                                    } else if (a['feature_type'] == 2 || a['feature_type'] == 3) {
                                        if (a['variant_ids'] != null) {
                                            var variantIds = a['variant_ids'].split(",");
                                            var variantNames = a['variant_names'].split(",");
                                            var variantDescs = a['variant_descriptions'].split(",");
                                            toAppend += '<div class="col-md-3"><select class="form-control" name="product_data[features][' + a['feature_id'] + '][select]">';
                                            $.each(variantIds, function (iVIds, aVIds) {
                                                toAppend += '<option value="' + aVIds + '">' + variantNames[iVIds] + '</option>';//+ a['feature_id'] + '.'
                                            });
                                            toAppend += '</select></div>';//<div class="clearfix"></div>
                                            toAppend += toAppendStatus;
                                            toAppend += '<div class="clearfix"></div>';
                                        }
                                    }
                                    toAppend += '</div>';
                                    toAppend += '<div class="clearfix"></div>';
                                });
                                $.each(response['data']['featureGroupDetails'], function (iFG, aFG) {
                                    toAppend += '<hr class="hrfeaturegroup"><strong>' + aFG['feature_name'] + '</strong><br>';
                                    $.each(aFG['featureDetails'], function (i, a) {

                                        var toAppendStatus = '<div class="col-md-offset-1 col-md-4"><label for="product_feature_status_' + a['feature_id'] + '_active" class="col-sm-6">';
                                        toAppendStatus += '<input type="radio" name="product_data[features][' + a['feature_id'] + '][status]" id="product_feature_status_' + a['feature_id'] + '_active" value="1" checked> Active </label>';
                                        toAppendStatus += '<label for="product_option_status_' + a['feature_id'] + '_disabled" class="col-sm-6">';
                                        toAppendStatus += '<input type="radio" name="product_data[features][' + a['feature_id'] + '][status]" id="product_feature_status_' + a['feature_id'] + '_disabled" value="0"> Disabled </label></div>';

                                        toAppend += '<hr><div class="form-group"><label class="col-sm-3 control-label">' + a['feature_name'] + '</label>';
                                        if (a['feature_type'] == 0) {
                                            toAppend += '<div class="col-md-3"><input class="form-control" type="checkbox" name="product_data[features][' + a['feature_id'] + '][single]"/></div>';//value="' + a['feature_id'] + '"//<div class="clearfix"></div>
                                            toAppend += toAppendStatus;
                                            toAppend += '<div class="clearfix"></div>';
                                        } else if (a['feature_type'] == 1) {
                                            if (a['variant_ids'] != null) {
                                                var variantIds = a['variant_ids'].split(",");
                                                var variantNames = a['variant_names'].split(",");
                                                var variantDescs = a['variant_descriptions'].split(",");
                                                $.each(variantIds, function (iVIds, aVIds) {
                                                    toAppend += '<div class="col-md-3"><input class="form-control" type="checkbox" name="product_data[features][' + a['feature_id'] + '][multiple][' + aVIds + ']"/>' + variantNames[iVIds] + '</div>';// value="' + a['feature_id'] + '.' + aVIds + '"//<div class="clearfix"></div>
                                                    if (iVIds == 0) {
                                                        toAppend += toAppendStatus;
                                                    }
                                                    toAppend += '<div class="clearfix"></div>';
                                                });
                                            }
                                        } else if (a['feature_type'] == 2 || a['feature_type'] == 3) {
                                            if (a['variant_ids'] != null) {
                                                var variantIds = a['variant_ids'].split(",");
                                                var variantNames = a['variant_names'].split(",");
                                                var variantDescs = a['variant_descriptions'].split(",");
                                                toAppend += '<div class="col-md-3"><select class="form-control" name="product_data[features][' + a['feature_id'] + '][select]">';
                                                $.each(variantIds, function (iVIds, aVIds) {
                                                    toAppend += '<option value="' + aVIds + '">' + variantNames[iVIds] + '</option>';//+ a['feature_id'] + '.'
                                                });
                                                toAppend += '</select></div>';//<div class="clearfix"></div>
                                                toAppend += toAppendStatus;
                                                toAppend += '<div class="clearfix"></div>';
                                            }
                                        }
                                        toAppend += '</div><div class="clearfix"></div>';
                                    });
                                });
                                $('#tab_1_7').html(toAppend);
                                App.initAjax();
                            } else {
                                $('#featureTab').addClass('hidden');
                                console.log(response['message']);
                            }
                        },
                        error: function (response) {
                            console.log(response['message']);
                        }
                    });
                }
            });

//            var table = $('#option-combination-table');
//            var oTable = table.dataTable({
//                "lengthMenu": [
//                    [5, 10, 20],
//                    [5, 10, 20]
//                ],
//                "bAutoWidth": false
//            });

            $(document.body).on('click', '#option-combinations', function () {
                if (optionAddedRemovedFlag) {//if options are added or removed clear the table since new set combinations are generated
//                    oTable.fnClearTable();
                    $('#variantCombinationTBody').empty();
                }
                var options = $('#optionTableBody > tr');
                if (options.length > 1) {
                    var optionsData = [];
                    $.each(options, function (i, a) {
                        var optionId = $(a).attr('option-id');
                        var temp = [];
                        temp['variantData'] = $(a).find('.all-data-of-a-variant');
                        temp['optionId'] = optionId;
                        temp['optionName'] = $(a).find('[field-name=option_name]').val();
                        optionsData.push(temp);
                    });
                    var optionCount = options.length;
                    optionsData.sort(function (a, b) {
                        a = a['variantData'].length;
                        b = b['variantData'].length;
                        return a > b ? -1 : (a < b ? 1 : 0);
                    });

                    var combinations = [];
                    var tempcombs = optionCombination(optionsData, 0, '', {});//calling function to generate combination ids

                    //---------------variants exists check and add combiantion start------------------//
//                    var optCombTrs = oTable.fnGetNodes();//getting all the table rows of combinations previously made
                    var optCombTrs = $('#variantCombinationTBody > tr');//getting all the table rows of combinations previously made
                    $(optCombTrs).addClass('to_delete');
                    var combinputs = $(optCombTrs).find('input[type="number"]');//getting inputs to get combination id
                    $.each(tempcombs, function (i, a) {
                        var combinationIds = a['combinationId'].split("_");//get individual variant ids from newly made combination ids
                        console.log(combinationIds);
                        var cIdExistsFlag = false;
                        $.each(combinputs, function (iIp, aIp) {//loop is to check if new made combination ids already exists in previously made combination ids
                            var varIds = $(aIp).attr('dataCid').split("_");//getting combination ids of previously added combination ids
                            if (_.intersection(varIds, combinationIds).length == optionCount) {
                                $(aIp).parent().parent().removeClass('to_delete');
                                cIdExistsFlag = true;
                                return false;
                            }
                        });
                        if (!cIdExistsFlag) {//if doesn't exists add the combiantion to table rows
//                            var toAppend = [];
                            var toAppend = '<tr>';
                            var namesString = '';
                            var varFlagString = '';
                            var optIps = '';
                            var i = 0;
                            while (i < optionCount) {
                                namesString += a['optionName' + i] + ": " + a['variantName' + i] + '<br>';
                                if (i == 0) {
                                    varFlagString += a['newVariantFlag'];
                                } else {
                                    varFlagString += "_" + a['newVariantFlag'];
                                }
                                i++;
                            }
                            /* toAppend.push(namesString + '<input name="product_data[opt_combination][' + a['combinationId'] + '][newflag]" type="hidden" value="' + varFlagString + '"/>');
                             toAppend.push('<input name="product_data[opt_combination][' + a['combinationId'] + '][quantity]" type="number" value="100" dataCid="' + a['combinationId'] + '"/>');
                             toAppend.push('<input name="product_data[opt_combination][' + a['combinationId'] + '][barcode]"/>');
                             toAppend.push('<input name="product_data[opt_combination][' + a['combinationId'] + '][excludeflag]" type="checkbox"/>');
                             oTable.fnAddData(toAppend); */
                            toAppend += '<td>' +namesString + '<input name="product_data[opt_combination][' + a['combinationId'] + '][newflag]" type="hidden" value="' + varFlagString + '"/></td>';
                            toAppend += '<td><input name="product_data[opt_combination][' + a['combinationId'] + '][quantity]" type="number" value="100" dataCid="' + a['combinationId'] + '"/></td>';
                            toAppend += '<td><input name="product_data[opt_combination][' + a['combinationId'] + '][barcode]"/></td>';
                            toAppend += '<td><input name="product_data[opt_combination][' + a['combinationId'] + '][excludeflag]" type="checkbox"/></td>';
                            toAppend += '</tr>';
                            $('#variantCombinationTBody').append(toAppend);
                        }
                    });
                    //---------------variants exists check and add combiantion end------------------//
//                    oTable.fnDeleteRow('.to_delete');//remove other combination ids which are not valid since optoion variants are changed
                    $('.to_delete').remove();
                    optionAddedRemovedFlag = false;
                    $("#option_combinations_modal").modal('show');
                } else {
//                    oTable.fnClearTable();
                    $('#variantCombinationTBody').empty();
                    toastr['error']("Please select atleast 2 options for combining.");
                }

            });

        });

        function optionCombination(array, currentIndex, toAppendString, tempNamesArr) {
            var arrayLength = array.length;
            var tempArray = [];
            $.each(array[currentIndex]['variantData'], function (iVD, aVD) {
                var temp1 = [];
                temp1['combinationId'] = toAppendString + $(aVD).attr('variant_id');
                if (temp1['combinationId'].split("_").length == arrayLength) {
                    temp1['newVariantFlag' + currentIndex] = 0;
                    if ($(aVD).hasClass('new-variant')) {
                        temp1['newVariantFlag' + currentIndex] = 1;
                    }
                    temp1['optionName' + currentIndex] = array[currentIndex]['optionName'];
                    temp1['optionId' + currentIndex] = array[currentIndex]['optionId'];
                    temp1['variantName' + currentIndex] = $(aVD).attr('variant_name');
                    $.each(tempNamesArr, function (iN, aN) {
                        temp1[iN] = aN;
                    });
                    tempArray.push(temp1);
                }
                if (array[currentIndex + 1] != undefined) {
                    console.log('next option exists');
                    var temp2 = [];
                    tempNamesArr['optionName' + currentIndex] = array[currentIndex]['optionName'];
                    tempNamesArr['optionId' + currentIndex] = array[currentIndex]['optionId'];
                    tempNamesArr['variantName' + currentIndex] = $(aVD).attr('variant_name');
                    temp2 = optionCombination(array, currentIndex + 1, toAppendString + $(aVD).attr('variant_id') + '_', tempNamesArr);
                    $.each(temp2, function (iTemp2, aTemp2) {
                        tempArray.push(aTemp2);
                    });
                }
            });
            return tempArray;
        }


    </script>
@endsection
