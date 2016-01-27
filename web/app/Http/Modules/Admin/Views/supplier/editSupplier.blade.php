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
            @if(Session::has('msg'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('msg') }}</p>
            @endif
            <div class="col-lg-12">
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
                        <input type="text" class="form-control" id="email" name="email" placeholder="email" value="{{$userinfo['email']}}">

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

@endsection