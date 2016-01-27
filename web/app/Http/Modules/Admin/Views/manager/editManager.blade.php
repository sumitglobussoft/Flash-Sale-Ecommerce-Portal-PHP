@extends('Admin/Layouts/adminlayout')

@section('title', 'Edit Manager') {{--TITLE GOES HERE--}}

@section('headcontent')
    <link href="/assets/plugins/jquery-nestable/jquery.nestable.css" rel="stylesheet" type="text/css"/>
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            @if(Session::has('msg'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('msg') }}</p>
            @endif
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" name="permissionform">
                            <div class="form-group">
                                <label for="input-Default" class="col-sm-2 control-label">First Name</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input-Default" name="firstname"
                                           value="{{$permissionInfo->name}}">
                                </div>
                                {!! $errors->first('firstname' ,'<font color="red">:message</font>') !!}
                            </div>
                            <div class="form-group">
                                <label for="input-Default" class="col-sm-2 control-label">Last Name</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input-Default" name="lastname"
                                           value="{{$permissionInfo->last_name}}">
                                </div>
                                {!! $errors->first('lastname' ,'<font color="red">:message</font>') !!}
                            </div>
                            <div class="form-group">
                                <label for="input-Default" class="col-sm-2 control-label">User Name</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input-Default" name="username"
                                           value="{{$permissionInfo->username}}">
                                </div>
                                {!! $errors->first('username' ,'<font color="red">:message</font>') !!}
                            </div>
                            <div class="form-group">
                                <label for="input-Default" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input-Default" name="email"
                                           value="{{$permissionInfo->email}}">
                                </div>
                                {!! $errors->first('email' ,'<font color="red">:message</font>') !!}
                            </div>
                            {{--<div id="buttonsDiv">--}}
                            {{--<input type="button" id="button2" class="buttons" value="Permissions"></input>--}}
                            <div id="buttonDiv">
                                <button type="button"
                                        class="btn btn-primary btn-addon m-b-sm btn-rounded btn-lg permission"
                                        value="nestable"><i
                                            class="fa fa-plus"></i> Permission

                                </button> <h4>Click On Icon To Edit Permissions</h4>
                            </div>
                            </br>
                            <div class="dd" id="nestable" style="display:none">
                                <ol class="dd-list">
                                    @foreach($permissionlist as $key => $val)
                                        <li class="dd-item" data-id="{{$val->permission_id}}">
                                            <div class="dd-handle">
                                                <input type="checkbox" name="permitcheck[]"
                                                       id="permitcheckbox{{$val->permission_id}}"
                                                       value="{{$val->permission_id}}"
                                                       @if(in_array($val->permission_id,$info))
                                                       checked="checked "
                                                        @endif
                                                        >{{$val->permission_details}}</div>
                                        </li>
                                    @endforeach
                                </ol>

                            </div>
                            {!! $errors->first('permitcheck' ,'<font color="red">:message</font>') !!}
                            {{--</div>--}}
                            <div class="clearfix"></div>

                            <button class="btn btn-info saverow">Save</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="/admin/available-manager">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('pagejavascripts')
    <script src="/assets/js/pages/ui-nestable.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $(".permission").click(function () {
                var divname = this.value;
                $("#" + divname).toggle();
            });

            //  $(document.body).on("change", 'input:checkbox[name="permitcheck[]"]', function() {
            //  $('.row-detail').attr('disabled',true);
            //  var permission = $(this).val();
            //  alert(permission);
            //   $(this).parent().toggleClass('checked');
            //   alert($(this).parent.toggleClass('checked'));
            // alert($(this).checked);
//                vals = $('input:checkbox[name="permitcheck[]"]').filter(':checked').map(function() {
//                    return this.value;
//                }).get();
//          alert(vals);

            //$('.saverow').html('without saving you cant move to other');
            //   });


        });
    </script>
@endsection