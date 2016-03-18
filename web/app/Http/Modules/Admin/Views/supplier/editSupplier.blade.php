@extends('Admin/Layouts/adminlayout')

@section('title', 'Edit Supplier') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    @if(Session::has('msg'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('msg') }}</p>
                    @endif
                    {{--<div class="col-lg-12">--}}
                        <div class="portlet-body form">
                            <form class="supplier" method="post" id="usersignupform">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                           placeholder="First Name" value="{{$userinfo['name']}}">
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                           placeholder="Last Name" value="{{$userinfo['last_name']}}">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                           placeholder="Username" value="{{$userinfo['username']}}">

                                </div>
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="email"
                                           value="{{$userinfo['email']}}">

                                </div>
                                <div class="form-group">
                                    <label>Choose Campaign Type</label>

                                    <div class="input-group">
                                        <div class="icheck-inline">
                                            <label>
                                                <input type="checkbox" class="icheck" name="flashsale[]"
                                                       data-checkbox="icheckbox_square-grey" id="flashsale" value="0" <?php if(in_array(0,explode(",",$userinfo['campaign_type']))) { echo 'checked'; }?>>
                                                Flashsale Campaign </label>
                                            <label>
                                                <input type="checkbox" class="icheck"
                                                       data-checkbox="icheckbox_square-grey" name="flashsale[]"
                                                       id="dailyspecial" value="1" <?php if(in_array(1,explode(",",$userinfo['campaign_type']))) { echo 'checked'; }?>> Dailyspecial Campaign </label>
                                            <label>
                                                <input type="checkbox" class="icheck" name="flashsale[]"
                                                       data-checkbox="icheckbox_square-grey" id="wholesale" value="2" <?php if(in_array(2,explode(",",$userinfo['campaign_type']))) { echo 'checked'; }?>>
                                                Wholesale Campaign </label>
                                            <label>
                                                <input type="checkbox" class="icheck" name="flashsale[]"
                                                       data-checkbox="icheckbox_square-grey" id="shop" value="3" <?php if(in_array(3,explode(",",$userinfo['campaign_type']))) { echo 'checked'; }?>>
                                                Shop Campaign </label>
                                        </div>
                                    </div>
                                </div>

                                <input type="submit" value="Save" class="btn btn-info text-uppercase">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"
                                                                 href="/admin/available-supplier">Back</a>

                                {{--<div id="pw-suc-err"></div>--}}
                            </form>
                        </div>
                    {{--</div>--}}
                </div>
                {{--<div class="col-lg-6">--}}
            </div>

        </div>
    </div>

@endsection