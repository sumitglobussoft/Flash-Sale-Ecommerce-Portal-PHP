@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Profile')

@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}

        <!-- BEGIN PAGE LEVEL STYLES -->
<link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="/assets/css/custom/profile.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="/assets/css/custom/components.css" id="style_components" rel="stylesheet" type="text/css"/>


@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar" style="width:250px;">
                <!-- PORTLET MAIN -->
                <div class="portlet light profile-sidebar-portlet">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
{{--                        <img src="{{url('images'.Session::get('fs_supplier')['profilepic'])}}" class="img-responsive">--}}
{{--                        <img src="{{Storage::path(Session::get('fs_supplier')['profilepic'])}}" class="img-responsive">--}}
                        <img src="{{'/images/'. Session::get('fs_supplier')['profilepic']}}" class="img-responsive" title="{{Session::get('fs_supplier')['profilepic']}}">
{{--                        <img src="{{url('images/ '.Session::get('fs_supplier')['profilepic'].')}}" class="img-responsive">--}}
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            {{Session::get('fs_supplier')['name'].' '.Session::get('fs_supplier')['last_name']}}
                        </div>
                    </div>
                </div>
                <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1_1" data-toggle="tab">Personal Info</a></li>
                                    <li><a href="#tab_1_2" data-toggle="tab">Change Avatar</a></li>
                                    <li><a href="#tab_1_3" data-toggle="tab">Change Password</a></li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                        <form method="post" enctype="multipart/form-data" id="profile-info">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" placeholder="First Name" class="form-control"
                                                           name="first_name" id="first_name"
                                                           @if($uesrDetails->name) value="{{$uesrDetails->name}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="control-label">Email Id</label>
                                                    <input type="text" placeholder="Email Id" class="form-control"
                                                           disabled="" name="email_id" id="email_id"
                                                           @if($uesrDetails->email) value="{{$uesrDetails->email}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="control-label">Address Line 1</label>
                                                    <input type="text" placeholder="Address Line 1" class="form-control"
                                                           name="address_line_1" id="address_line_1"
                                                           @if($uesrDetails->addressline1) value="{{$uesrDetails->addressline1}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="control-label">City</label>
                                                    <input type="text" placeholder="City" class="form-control"
                                                           name="city" id="city"
                                                           @if($uesrDetails->city) value="{{$uesrDetails->city}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="control-label">State</label>
                                                    <input type="text" placeholder="State" class="form-control"
                                                           name="state" id="state"
                                                           @if($uesrDetails->state) value="{{$uesrDetails->state}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" placeholder="Last Name" class="form-control"
                                                           name="last_name" id="last_name"
                                                           @if($uesrDetails->last_name) value="{{$uesrDetails->last_name}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="control-label">Contact Number</label>
                                                    <input type="text" placeholder="Contact Number" class="form-control"
                                                           name="contact_number" id="contact_number"
                                                           @if($uesrDetails->phone) value="{{$uesrDetails->phone}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="control-label">Address Line 2</label>
                                                    <input type="text" placeholder="Address Line 2" class="form-control"
                                                           name="address_line_2" id="address_line_2"
                                                           @if($uesrDetails->addressline2) value="{{$uesrDetails->addressline2}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>

                                                <div class="form-group">
                                                    <label class="control-label">Country</label>
                                                    <input type="text" placeholder="Country" class="form-control"
                                                           name="country"
                                                           @if($uesrDetails->state) value="{{$uesrDetails->state}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="control-label">Zip Code</label>
                                                    <input maxlength="6" type="text" placeholder="Zip Code"
                                                           class="form-control" name="zipcode" id="zipcode"
                                                           @if($uesrDetails->zipcode) value="{{$uesrDetails->zipcode}}" @endif/>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12" align="center">
                                                    <div class="margiv-top-10">
                                                        <a class="btn btn-circle green-haze" id="edit-info"
                                                           style="display: none;">Edit</a>
                                                        <button class="btn btn-circle green-haze hide"
                                                                id="save-info-changes">Save Changes
                                                        </button>
                                                        <a class="btn btn-circle default hide" id="cancel">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                    <!-- CHANGE AVATAR TAB -->
                                    <div class="tab-pane" id="tab_1_2">
                                        <form method="post" enctype="multipart/form-data" id="change-avatar-form">
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail"
                                                         style="width: 200px; height: 150px;">
                                                        <img src="/assets/images/no-image.png" alt=""/>
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                                         style="max-width: 200px; max-height: 150px;">
                                                    </div>
                                                    <div>
                                                            <span class="btn btn-circle default btn-file">
                                                                <span class="fileinput-new">
                                                                    Select image </span>
                                                                <span class="fileinput-exists">
                                                                    Change </span>
                                                                <input type="file" name="..." accept="image/*">
                                                            </span>
                                                        <a href="#" class="btn btn-circle default fileinput-exists"
                                                           data-dismiss="fileinput">
                                                            Remove </a>
                                                    </div>
                                                </div>
                                                <div class="clearfix margin-top-10">
                                                    <span class="label label-danger">NOTE! </span>
                                                    <span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                                </div>
                                            </div>
                                            <div class="margin-top-10">
                                                <a class="btn btn-circle green-haze" id="avatar-submit">
                                                    Submit </a>
                                                <a class="btn btn-circle default">
                                                    Cancel </a>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END CHANGE AVATAR TAB -->
                                    <!-- CHANGE PASSWORD TAB -->
                                    <div class="tab-pane" id="tab_1_3">
                                        <form method="POST" enctype="multipart/form-data" id="password-change">
                                            <div class="form-group">
                                                <label class="control-label">Current Password</label>
                                                <input type="password" class="form-control" name="current_password"
                                                       id="current_password"/>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <label class="control-label">New Password</label>
                                                <input type="password" class="form-control" name="new_password"
                                                       id="new_password"/>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <label class="control-label">Confirm Password</label>
                                                <input type="password" class="form-control" name="confirm_password"
                                                       id="confirm_password"/>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="margin-top-10">
                                                <button class="btn btn-circle green"
                                                        id="submit-change-password"> Change Password
                                                </button>
                                                <button type="button" class="btn btn-circle default"
                                                        onclick="document.getElementById('password-change').reset();">
                                                    Reset
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END CHANGE PASSWORD TAB -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>

@endsection

@section('pagejavascripts')

    <script>
        $(document).ready(function () {

            $("#profile-info").hover(function () {
                $('#edit-info').show('slow');
            }, function () {
                $('#edit-info').hide('slow');
            });

            $("#profile-info :input").attr("disabled", true);
            $("#profile-info :input").attr("style", "cursor: default");
            $("#edit-info").click(function (e) {
                $("#profile-info :input").removeAttr('disabled').attr("style", "cursor: auto");
                $("#email_id, #user_name").attr({disabled: "true", style: "cursor: default"});
                $("#edit-info").addClass("hide");
                $("#save-info-changes, #cancel").removeClass("hide").attr("style", "cursor: hand");
            });

            $("#cancel").click(function (e) {
                $("#profile-info :input").attr({disabled: "true", style: "cursor: default"});
                $("#edit-info").removeClass("hide").attr("style", "cursor: hand");
                $("#save-info-changes, #cancel").addClass("hide");
            });


            $('#profile-info').validate({
                rules: {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    address_line_1: {
                        required: true
                    },
                    contact_number: {
                        required: true,
                        remote: {
                            url: "/supplier/ajaxHandler",
                            type: 'POST',
                            datatype: 'json',
                            data: {
                                method: 'checkContactNumber'
                            }
                        }
                    },
                    city: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    zipcode: {
                        required: true,
                        digits: true,
                    }
                },
                messages: {
                    first_name: {
                        required: "Please enter first name"
                    },
                    last_name: {
                        required: "Please enter last name"
                    },
                    address_line_1: {
                        required: "Please enter an address"
                    },
                    city: {
                        required: "Please enter city"
                    },
                    state: {
                        required: "Please enter state"
                    },
                    zipcode: {
                        required: "Please enter zip code"
                    },
                    contact_number: {
                        required: "Please enter your contact number",
                        remote: "This Contact Number is already in use."
                    }
                }
            });


            $("#save-info-changes").click(function (e) {
                e.preventDefault();
                if ($('#profile-info').valid()) {
                    var profileData = $('#profile-info').serializeArray();
                    profileData.push({name: 'method', value: 'updateProfileInfo'});
                    $.ajax({
                        type: "POST",
                        url: "/supplier/ajaxHandler",
                        dataType: "json",
                        data: profileData,
                        success: function (response) {
                            var alertMsg = '';
                            if ($.isArray(response['message'])) {
                                $.each(response['message'], function (index, value) {
                                    alertMsg += '\u2666\xA0\xA0' + value + '\n';
                                })
                            } else {
                                alertMsg = response['message'];
                            }
                            alert(alertMsg);
                        },
                        error: function (response) {
                        }
                    });
                }
            });

            $.validator.addMethod("password_regex", function (value, element) {
                return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/i.test(value);
            }, "Passwords are 8-16 characters with uppercase letters, lowercase letters and at least one number.");

            $('#password-change').validate({
                rules: {
                    current_password: {
                        required: true
                    },
                    new_password: {
                        required: true,
//                        password_regex: true
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#new_password"
                    }
                },
                messages: {
//                    current_password: "Enter Current Password",
//                new_password: " Enter New Password",
                    confirm_password: " Enter Confirm Password Same as Password"
                }
            });


            $("#submit-change-password").click(function (e) {
                e.preventDefault();
                if ($('#password-change').valid()) {
                    var passwordData = $('#password-change').serializeArray();
                    passwordData.push({name: 'method', value: 'updatePassword'});
                    $.ajax({
                        type: "POST",
                        url: "/supplier/ajaxHandler",
                        dataType: "json",
                        data: passwordData,
                        success: function (response) {
                            var alertMsg = '';
                            if ($.isArray(response['message'])) {
                                $.each(response['message'], function (index, value) {
                                    alertMsg += '\u2666\xA0\xA0' + value + '\n';
                                })
                            } else {
                                alertMsg = response['message'];
                            }
                            alert(alertMsg);
                            $('#password-change').trigger("reset");
                        },
                        error: function (response) {
                            $('#password-change').trigger("reset");
                        }
                    });
                }
            });


            $('#avatar-submit').click(function (e) {
                e.preventDefault();
                var formData = new FormData();
                formData.append('method', 'updateAvatar');

                formData.append('file', $('input[type=file]')[0].files[0]);

                $.ajax({
                    type: "POST",
                    url: "/supplier/ajaxHandler",
                    contentType: false,
                    dataType: "json",
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        var alertMsg = '';
                        if ($.isArray(response['message'])) {
                            $.each(response['message'], function (index, value) {
                                alertMsg += '\u2666\xA0\xA0' + value + '\n';
                            })
                        } else {
                            alertMsg = response['message'];
                        }
                        alert(alertMsg);
                    },
                    error: function (response) {
                    }
                });
            });

        });

    </script>

    <script src="/assets/plugins/3d-bold-navigation/js/main.js"></script>
    <script src="/assets/plugins/waypoints/jquery.waypoints.min.js"></script>
    <script src="/assets/plugins/jquery-counterup/jquery.counterup.min.js"></script>
    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script src="/assets/plugins/flot/jquery.flot.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.time.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.symbol.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.resize.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="/assets/plugins/curvedlines/curvedLines.js"></script>
    <script src="/assets/plugins/metrojs/MetroJs.min.js"></script>
    <script src="/assets/js/modern.js"></script>


    <script src="/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    {{--<script src="/assets/js/pages/dashboard.js"></script>--}}

    <script src="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>



@endsection
