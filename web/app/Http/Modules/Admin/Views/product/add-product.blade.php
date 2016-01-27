@extends('Admin/Layouts/adminlayout')

@section('title', 'Add Product') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection

@section('content')

    <div class="row">
        <!-- panel preview -->
        <div class="col-sm-12">

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif

            <?php //echo"<pre>";print_r($candidateinfo);die("cfh"); ?>
            <form method="post" id="employeeform" name="employeeform" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label for="concept"
                       class="col-sm-6 control-label dark_greyrad pull-left labeleft">Information </label>
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                            <div class="control-group">
                                <label class="control-label cm-required" for="product_description_product">Name</label>
                                <div class="controls">
                                    <input id="product_description_product" class="input-large" type="text" value="" size="55" name="" form="form">
                                </div>
                            </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            </br>
                            <label class="col-md-12">Choose Vendor</label>
                            <div class="col-md-12">
                                <select class="form-control select2_store" data-placeholder="Select a store..." name="selectstore" id="selectstore">
                                    <option value=""></option>

                                </select>
                                </br></br>
                                <span class="help font-red-thunderbird" id="storeerror"></span>
                                </br>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection


@endsection