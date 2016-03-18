@extends('Admin/Layouts/adminlayout')

@section('title', trans('message.add_new_supplier')) {{--TITLE GOES HERE--}}

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
                    <div class="portlet-body form">
                        <form class="customer" method="post" id="usersignupform">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                       placeholder="First Name">
                                {!! $errors->first('firstname' ,'<font color="red">:message</font>') !!}
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                       placeholder="Last Name">
                                {!! $errors->first('lastname' ,'<font color="red">:message</font>') !!}
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                       placeholder="Username">
                                {!! $errors->first('username' ,'<font color="red">:message</font>') !!}
                            </div>
                            <div class="form-group">
                                <label for="email">email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="email">
                                {!! $errors->first('email' ,'<font color="red">:message</font>') !!}
                            </div>

                            <div class="form-group">
                                <label>Choose Campaign Type</label>

                                <div class="input-group">
                                    <div class="icheck-inline">
                                        <label>
                                            <input type="checkbox" class="icheck" name="flashsale[]"
                                                   data-checkbox="icheckbox_square-grey" id="flashsale" value="0">
                                            Flashsale Campaign </label>
                                        <label>
                                            <input type="checkbox" class="icheck"
                                                   data-checkbox="icheckbox_square-grey" name="flashsale[]"
                                                   id="dailyspecial" value="1"> Dailyspecial Campaign </label>
                                        <label>
                                            <input type="checkbox" class="icheck" name="flashsale[]"
                                                   data-checkbox="icheckbox_square-grey" id="wholesale" value="2">
                                            Wholesale Campaign </label>
                                        <label>
                                            <input type="checkbox" class="icheck" name="flashsale[]"
                                                   data-checkbox="icheckbox_square-grey" id="shop" value="3">
                                            Shop Campaign </label>
                                    </div>
                                </div>
                            </div>

                            <input type="submit" value="Save" class="btn btn-info text-uppercase">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="/admin/available-supplier">Back</a>

                            {{--<div id="pw-suc-err"></div>--}}
                        </form>
                        {{--</div>--}}

                        {{--<div class="col-lg-6">--}}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection



@section('pagejavascripts')

    <script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="/assets/global/scripts/layout.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/icheck/icheck.min.js"></script>
    <script src="/assets/admin/layout/scripts/form-icheck.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $(document.body).on('click', '#flashsale', function () {

                var checkId = $(this).val();
//                alert(checkId);
            });


        });

    </script>


@endsection