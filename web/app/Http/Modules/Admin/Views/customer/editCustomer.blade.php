@extends('Admin/Layouts/adminlayout')

@section('title', trans('message.edit_new_customer')) {{--TITLE GOES HERE--}}

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
                        {{--<div class="col-lg-12">--}}
                            <form class="customer" method="post" id="usersignupform">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                           placeholder="First Name" value="{{$userdetail['name']}}">
                                    {!! $errors->first('firstname' ,'<font color="red">:message</font>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                           placeholder="Last Name" value="{{$userdetail['last_name']}}">
                                    {!! $errors->first('lastname' ,'<font color="red">:message</font>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                           placeholder="Username" value="{{$userdetail['username']}}">
                                    {!! $errors->first('username' ,'<font color="red">:message</font>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="email"
                                           value="{{$userdetail['email']}}">
                                    {!! $errors->first('email' ,'<font color="red">:message</font>') !!}
                                </div>

                                <input type="submit" value="Save" class="btn btn-info text-uppercase">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"
                                                                 href="/admin/available-customer">Back</a>

                                {{--<div id="pw-suc-err"></div>--}}
                            </form>
                        {{--</div>--}}
                    </div>
                </div>

                {{--<div class="col-lg-6">--}}
            </div>

        </div>
    </div>

@endsection