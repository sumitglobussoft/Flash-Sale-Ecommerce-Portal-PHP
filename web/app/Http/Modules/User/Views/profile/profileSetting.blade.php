@extends('Home/Layouts/home_layout')
@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <link rel="stylesheet"
          href="http://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <style>
        /*Box sizing stuff*/

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .control-label {
            font-size: 12px;
            text-transform: uppercase;
        }

        .form-control:focus {
            border-color: #66afe9;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
            outline: 0 none;
        }

        /*Generic styles*/

        #wrapper {
            width: 100%;
            margin: 0 auto;
        }

        #generic-tabs {
            width: 100%;
            padding: 20px;
        }

        /*Tab styles*/

        #generic-tabs ul {
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        #generic-tabs ul li {
            float: left;
            display: inline-block;
            width: 25%;
            background: #EDEDED;
            border-top: 4px solid #CCCCCC;
            border-right: 1px solid #CCCCCC;
        }

        #generic-tabs ul li:last-child {
            border-right: none;
        }

        #generic-tabs ul li:first-child {
            padding-left: 0;
        }

        /*Tab link styles*/

        #generic-tabs ul li a {
            text-align: center;
            display: block;
            font-size: 1.2em;
            text-decoration: none;
            padding: 1.2em 1em;
            line-height: 16px;
            color: #BBBBBB;
        }

        /*Active tab styles*/

        #generic-tabs ul li.active {
            background: #FFFFFF;
            border-top: 4px solid #222222;
        }

        #generic-tabs ul li.active a {
            color: #333333;
        }

        #generic-tabs ul li.active a i {
            color: #222222;
        }

        /*Tab content styles*/

        #generic-tabs .tab-content {
            background: #FFFFFF;
            padding: 3em 2em;
        }

        #generic-tabs .tab-content h1 {
            margin-top: 0;
        }

        .fileinput-new div span {
            width: 100%;
        }

        .fileinput-exists div span {
            margin-top: -4px;
        }

        .fileinput-new.thumbnail {
            width: 284px !important;
        }

        .fileinput-exists.thumbnail {
            max-width: 292px !important;
        }

        @media only screen and (min-width: 650px) {
            #generic-tabs ul li a {
                font-size: 1em;
                padding: 1.2em 2em;
                line-height: 16px;
            }
        }
    </style>
    @endsection


    @section('content')
            <!--Collection-->
    <section class="container">
        <?php // if(isset($profiledata['profilepic']) && !empty($profiledata['profilepic'])) { echo "<pre>";print_r($profiledata);die;} ?>
        <div class="row m-top-md">
            <h2 style="margin-left: 15px;">PROFILE SETTINGS</h2>

            <div class="col-md-12">
                <div id="wrapper">
                    <section id="generic-tabs">
                        <ul id="tabs">
                            <li>
                                <a title="General Info" href="#first-tab"><i class="fa fa-home"></i> GENERAL INFO </a>
                            </li>
                            <li>
                                <a title="Shipping Info" href="#second-tab"><i class="fa fa-ship"></i> SHIPPING ADDRESS </a>
                            </li>
                            <li>
                                <a title="Password Change" href="#third-tab"><i class="fa fa-key"></i> CHANGE PASSWORD </a>
                            </li>
                            <li>
                                <a title="Change Profile Pic" href="#fourth-tab"><i class="fa fa-picture-o"></i> CHANGE AVATAR </a>
                            </li>
                        </ul>

                        <section id="first-tab" class="tab-content">
                            <h2 style="margin-left:2%"> GENERAL INFO </h2>

                            <div class="row" style="margin-top:3%;">
                                <div class="col-md-12">
                                    <form class="form-hotizontal" role="form" action="" id="generalinfo">
                                        <div class="form-group col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">First Name <span
                                                            class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="firstname" id="firstname"
                                                       @if(isset($profiledata)) value="{{$profiledata['name']}}" @endif />
                                            </div>
                                            <div class="firstname_err"></div>
                                            <div class="form-group ">
                                                <label class="control-label">Username <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="username" id="username"
                                                       @if(isset($profiledata)) value="{{$profiledata['username']}}" @endif />
                                            </div>
                                            <div class="username_err"></div>
                                            <div class="form-group ">
                                                <label class="control-label">Email <span
                                                            class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="email" id="email"
                                                       @if(isset($profiledata)) value="{{$profiledata['email']}}" @endif />
                                            </div>
                                            <div class="email_error"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">Last Name <span
                                                            class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="lastname" id="lastname"
                                                       @if(isset($profiledata)) value="{{$profiledata['last_name']}}" @endif />
                                            </div>
                                            <div class="lastname_err"></div>
                                            <div class="form-group ">
                                                <label class="control-label">Mobile No. </label>
                                                <input type="text" class="form-control" name="contact" id="contact"
                                                       @if(isset($profiledata)) value="{{$profiledata['phone']}}" @endif />
                                            </div>
                                            <div class="mobileno_err"></div>
                                        </div>
                                        {{--<div class="form-group col-md-6">--}}
                                        {{--<label class="control-label">Secondary email </label>--}}
                                        {{--<input type="email" class="form-control" name="mail2" />--}}
                                        {{--</div>--}}
                                        <div class="form-group col-md-12">
                                            <p>All fields marked with (<span class="text-danger">*</span>) are required
                                            </p>
                                        </div>
                                        <div class="general_info_succ col-md-12"></div>
                                        <div class="form-group col-md-6 pull-right">
                                            <button class="boton-dark text-uppercase pull-right" value="Submit"
                                                    type="submit">SAVE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>

                        <section id="second-tab" class="tab-content">
                            <h2 style="margin-left:2%"> SHIPPING ADDRESS </h2>

                            <div class="row" style="margin-top:3%;">
                                <div class="col-md-12">
                                    <form class="form-hotizontal" role="form" action="" id="shippinginfo">
                                        {{--<div class="form-group col-md-6">--}}
                                        {{--<label class="control-label">Country <span--}}
                                        {{--class="text-danger">*</span></label>--}}
                                        {{--<input type="text" class="form-control" name="country" id="country"--}}
                                        {{--@if(isset($profiledata)) value="{{$profiledata['country']}}" @endif/>--}}
                                        {{--</div>--}}
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">State <span
                                                            class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="state" id="state"
                                                       @if(isset($profiledata)) value="{{$profiledata['state']}}" @endif/>
                                            </div>
                                            <div class="state_err"></div>
                                            <div class="form-group ">
                                                <label class="control-label">City <span
                                                            class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="city" id="city"
                                                       @if(isset($profiledata)) value="{{$profiledata['city']}}" @endif/>
                                            </div>
                                            <div class="city_err"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">Zipcode <span
                                                            class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="zip_code" id="zip_code"
                                                       @if(isset($profiledata)) value="{{$profiledata['zipcode']}}" @endif/>
                                            </div>
                                            <div class="zip_code_err"></div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="control-label">Street Address 1 <span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="address1" id="address1"
                                                   @if(isset($profiledata)) value="{{$profiledata['addressline1']}}" @endif/>
                                        </div>
                                        <div class="address1_err col-md-12"></div>
                                        <div class="form-group col-md-12">
                                            <label class="control-label">Street Address 2 </label>
                                            <input type="text" class="form-control" name="address2" id="address2"
                                                   @if(isset($profiledata)) value="{{$profiledata['addressline2']}}" @endif/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <p>All fields marked with (<span class="text-danger">*</span>) are required
                                            </p>
                                        </div>
                                        <div class="shipping_info_succ col-md-12"></div>
                                        <div class="form-group col-md-6 pull-right">
                                            <button class="boton-dark text-uppercase pull-right" value="Submit"
                                                    type="submit">SAVE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>

                        <section id="third-tab" class="tab-content">
                            <h2 style="margin-left:2%"> CHANGE PASSWORD </h2>

                            <div class="row" style="margin-top:3%;">
                                <div class="col-md-12">
                                    <form class="form-hotizontal" role="form" action="" id="passwordchange">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">Current Password <span
                                                            class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="opassword"
                                                       id="opassword"/>
                                            </div>
                                            <div class="opassword_err"></div>
                                            <div class="form-group ">
                                                <label class="control-label">Confirm Password <span
                                                            class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="rnpassword"
                                                       id="rnpassword"/>
                                            </div>
                                            <div class="rnpassword_err"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">New Password <span
                                                            class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="npassword"
                                                       id="npassword"/>
                                            </div>
                                            <div class="npassword_err"></div>
                                            <br>

                                            <div class="form-group ">
                                                <p>All fields marked with (<span class="text-danger">*</span>) are
                                                    required
                                                </p>
                                            </div>
                                            <div class="password-suc-err"></div>
                                        </div>
                                        <div class="form-group col-md-12 pull-right">
                                            <button class="boton-dark text-uppercase pull-right" value="Submit"
                                                    type="submit">SAVE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>

                        <section id="fourth-tab" class="tab-content">
                            <h2 style="margin-left:2%"> CHANGE AVATAR </h2>

                            <div class="row" style="margin-top:3%;">
                                <div class="col-md-12">
                                    <form class="form-hotizontal" role="form" action="" id="imageload"
                                          enctype="multipart/form-data">
                                        <div class="form-group col-md-12">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"
                                                     style="max-width: 292px; max-height: 288px;height:auto;">
                                                    <img <?php if(isset($profiledata['profilepic']) && !empty($profiledata['profilepic'])){ echo "src=".$profiledata['profilepic']; }else{ ?> src="http://placehold.it/292x200" <?php } ?> alt="">

                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                     style="max-width: 292px; max-height: 288px;height:auto;"></div>
                                                <div>
														<span class="boton-dark text-uppercase btn-file">
                       										<span class="fileinput-new">Select Image</span>
															<span class="fileinput-exists">Replace</span>
															<input type="file" name="file">
														</span>
                                                    <a href="#" class="boton-dark text-uppercase fileinput-exists"
                                                       data-dismiss="fileinput" style="background:#D54E64;"> Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="error_placement"></div>
                                        <div class="form-group col-md-6 pull-right" >
                                            <button class="boton-dark text-uppercase pull-right" value="Submit"
                                                    type="submit"> SAVE
                                            </button>
                                        </div>
                                    </form>
                                    <div class="image-suc-err"></div>
                                    <input type="text" class="hidden"
                                           @if(isset($profiledata)) value="{{$profiledata['id']}}" @endif id="userId"/>
                                    <input type="text" class="hidden"
                                           @if(isset($api_data)) value="{{$api_data['api_url']}}" @endif id="apiurl"/>
                                    <input type="text" class="hidden"
                                           @if(isset($api_data)) value="{{$api_data['api_token']}}"
                                           @endif id="api_token"/>
                                </div>
                            </div>
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pagejavascripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script>
        (function ($) {
            /* trigger when page is ready */
            $(document).ready(function () {

                //Tabs functionality
                //Firstly hide all content divs
                $('#generic-tabs section').hide();
                //Then show the first content div
                $('#generic-tabs section:first').show();
                //Add active class to the first tab link
                $('#generic-tabs ul#tabs li:first').addClass('active');
                //Functionality when a tab is clicked
                $('#generic-tabs ul#tabs li a').click(function () {
                    //Firstly remove the current active class
                    $('#generic-tabs ul#tabs li').removeClass('active');
                    //Apply active class to the parent(li) of the link tag
                    $(this).parent().addClass('active');
                    //Set currentTab to this link
                    var currentTab = $(this).attr('href');
                    //Hide away all tabs
                    $('#generic-tabs section').hide();
                    //show the current tab
                    $(currentTab).show();
                    //Stop default link action from happening
                    return false;
                });
            });
        })(window.jQuery);

        $(document).ready(function () {
            $.validator.addMethod("nameregex", function (value, element) {
                return this.optional(element) || /^[A-Za-z.\s]+$/.test(value);
            }, "Name cannot contain special characters.");

            $.validator.addMethod("usernameregex", function (value, element) {
                return this.optional(element) || /^[A-Za-z0-9._\s]+$/.test(value);
            }, "Username cannot contain special characters.");

            $.validator.addMethod("emailregex", function (value, element) {
                return this.optional(element) || /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/.test(value);
            }, "Invalid email address.");

            $.validator.addMethod("passwordregex", function (value, element) {
                return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{7,14}$/.test(value);
            }, "Min 7 and Max 14 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character (@$!%*?&):");

            $.validator.addMethod("notequalTo", function (value, element) {
                return $('#opassword').val() != $('#npassword').val()
            }, "* Current and New Password should not be same");

            $('#generalinfo').validate({
                rules: {
                    firstname: {
                        required: true,
                        nameregex: true
                    },
                    lastname: {
                        required: true,
                        nameregex: true
                    },
                    email: {
                        required: true,
                        emailregex: true
                    },
                    username: {
                        required: true,
                        usernameregex: true
                    },
                    contact: {
                        number: true,
                        minlength: 10,
                        maxlength: 10

                    }
                },
                messages: {
                    firstname: {
                        required: "First name is required"
                    },
                    lastname: {
                        required: "Last name is required"
                    },
                    email: {
                        required: "Email is required"
                    },
                    username: {
                        required: "Username is required"
                    }
                }
            });
            $('#shippinginfo').validate({
                rules: {
                    city: {
                        required: true,
                        nameregex: true
                    },
                    state: {
                        required: true,
                        nameregex: true
                    },
                    zip_code: {
                        required: true

                    },
                    address1: {
                        required: true
                    }
                },
                messages: {// custom messages for radio buttons and checkboxes
                    city: {
                        required: "City name required"
                    },
                    state: {
                        required: "State name required"
                    },
                    zip_code: {
                        required: "Zipcode required"
                    },
                    address1: {
                        required: "Address required"
                    }
                }
            });
            $('#passwordchange').validate({
                rules: {
                    opassword: {
                        required: true
                    },
                    npassword: {
                        required: true,
                        passwordregex: true,
                        notequalTo: true
                    },
                    rnpassword: {
                        required: true,
                        equalTo: "#npassword"
                    }
                },
                messages: {
                    opassword: {
                        required: "Old password required"
                    },
                    npassword: {
                        required: "New Password required"
                    },
                    rnpassword: {
                        required: "Re-type Password"
                    }
                }
            });
            $('#imageload').validate({
                rules: {
                    file: {
                        required: true
                    }
                },
                messages: {
                    file: {
                        required: "Please Select image file."
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertBefore('#error_placement');
                }
            });

            $("#generalinfo").submit(function (e) {
                e.preventDefault();
                var firstname = $('#firstname').val();
                var lastname = $('#lastname').val();
                var contact = $('#contact').val();
                var username = $('#username').val();
                var email = $('#email').val();

                if ($("#generalinfo").valid()) {

                    $.ajax({
                        url: '/profile-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'changegeneralinfo',
                            fname: firstname,
                            lname: lastname,
                            contact: contact,
                            uname: username,
                            email: email
                        },
                        success: function (response) {
                            if (response) {
                                if (response['code'] == 200) {
                                    $('.general_info_succ').show();
                                    $('.general_info_succ').html(response['message']);
                                    $('.general_info_succ').css('color', 'green');
                                    $('.general_info_succ').delay(4000).hide('slow');
                                } else if (response['code'] == 100) {
                                    var message = response['message'];
                                    $.each(message, function (key, value) {
//                                    console.log(key);firstname_err lastname_err email_error lastname_err mobileno_err
                                        if (key == "firstname") {
                                            $('.firstname_err').show();
                                            $('.firstname_err').html(message[key]);
                                            $('.firstname_err').css('color', 'red');
                                            $('.firstname_err').delay(6000).hide('slow');
                                        }
                                        if (key == "lastname") {
                                            $('.lastname_err').show();
                                            $('.lastname_err').html(message[key]);
                                            $('.lastname_err').css('color', 'red');
                                            $('.lastname_err').delay(6000).hide('slow');
                                        }
                                        if (key == "username") {
                                            $('.username_err').show();
                                            $('.username_err').html(message[key]);
                                            $('.username_err').css('color', 'red');
                                            $('.username_err').delay(6000).hide('slow');
                                        }
                                        if (key == "email") {
                                            $('.email_error').show();
                                            $('.email_error').html(message[key]);
                                            $('.email_error').css('color', 'red');
                                            $('.email_error').delay(6000).hide('slow');
                                        }
                                    })
                                } else {
                                    $('.general_info_succ').show();
                                    $('.general_info_succ').html(response['message']);
                                    $('.general_info_succ').css('color', 'red');
                                    $('.general_info_succ').delay(4000).hide('slow');
                                }
//                            console.log(response);
//                            alert(response);
                            }
                        }
                    });
                }
            });

            $("#shippinginfo").submit(function (e) {
                e.preventDefault();
                var city = $('#city').val();
                var state = $('#state').val();
                var zip_code = $('#zip_code').val();
                var address1 = $('#address1').val();
                var address2 = $('#address2').val();

                if ($("#shippinginfo").valid()) {
                    $.ajax({
                        url: '/profile-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'changeshippinginfo',
                            City: city,
                            State: state,
                            Zipcode: zip_code,
                            Address1: address1,
                            Address2: address2
                        },
                        success: function (response) {
                            if (response) {
                                if (response['code'] == 200) {
                                    $('.shipping_info_succ').show();
                                    $('.shipping_info_succ').html(response['message']);
                                    $('.shipping_info_succ').css('color', 'green');
                                    $('.shipping_info_succ').delay(4000).hide('slow');
                                } else if (response['code'] == 100) {
                                    var message = response['message'];
                                    $.each(message, function (key, value) {
//                                    console.log(key);firstname_err lastname_err email_error lastname_err mobileno_err
                                        if (key == "city") {
                                            $('.city_err').show();
                                            $('.city_err').html(message[key]);
                                            $('.city_err').css('color', 'red');
                                            $('.city_err').delay(6000).hide('slow');
                                        }
                                        if (key == "state") {
                                            $('.state_err').show();
                                            $('.state_err').html(message[key]);
                                            $('.state_err').css('color', 'red');
                                            $('.state_err').delay(6000).hide('slow');
                                        }
                                        if (key == "zipcode") {
                                            $('.zip_code_err').show();
                                            $('.zip_code_err').html(message[key]);
                                            $('.zip_code_err').css('color', 'red');
                                            $('.zip_code_err').delay(6000).hide('slow');
                                        }
                                        if (key == "address_line_1") {
                                            $('.address1_err').show();
                                            $('.address1_err').html(message[key]);
                                            $('.address1_err').css('color', 'red');
                                            $('.address1_err').delay(6000).hide('slow');
                                        }
                                    })
                                } else {
                                    $('.shipping_info_succ').show();
                                    $('.shipping_info_succ').html(response['message']);
                                    $('.shipping_info_succ').css('color', 'red');
                                    $('.shipping_info_succ').delay(4000).hide('slow');
                                }
                            }
                        }
                    });
                }
            });

            $("#passwordchange").submit(function (e) {
                e.preventDefault();
                var oldpassword = $('#opassword').val();
                var newpassword = $('#npassword').val();
                var renewpassword = $('#rnpassword').val();

                if ($("#passwordchange").valid()) {
//                alert(oldpassword);alert(newpassword);alert(renewpassword);
                    $.ajax({
                        url: '/profile-ajax-handler',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            method: 'changepassword',
                            oldpassword: oldpassword,
                            newpassword: newpassword,
                            renewpassword: renewpassword
                        },
                        success: function (response) {
                            if (response) {
                                if (response['code'] == 200) {
                                    $('.password-suc-err').show();
                                    $('.password-suc-err').html(response['message']);
                                    $('.password-suc-err').css('color', 'green');
                                    $('.password-suc-err').delay(4000).hide('slow');
                                    $('#opassword').val("");
                                    $('#npassword').val("");
                                    $('#rnpassword').val("");
                                } else if (response['code'] == 100) {
                                    var message = response['message'];
                                    $.each(message, function (key, value) {
//                                    console.log(key);firstname_err lastname_err email_error lastname_err mobileno_err
                                        if (key == "oldPassword") {
                                            $('.opassword_err').show();
                                            $('.opassword_err').html(message[key]);
                                            $('.opassword_err').css('color', 'red');
                                            $('.opassword_err').delay(6000).hide('slow');
                                        }
                                        if (key == "newPassword") {
                                            $('.npassword_err').show();
                                            $('.npassword_err').html(message[key]);
                                            $('.npassword_err').css('color', 'red');
                                            $('.npassword_err').delay(6000).hide('slow');
                                        }
                                        if (key == "reNewPassword") {
                                            $('.rnpassword_err').show();
                                            $('.rnpassword_err').html(message[key]);
                                            $('.rnpassword_err').css('color', 'red');
                                            $('.rnpassword_err').delay(6000).hide('slow');
                                        }
                                    })
                                } else {
                                    $('.password-suc-err').show();
                                    $('.password-suc-err').html(response['message']);
                                    $('.password-suc-err').css('color', 'red');
                                    $('.password-suc-err').delay(4000).hide('slow');
                                }

                            }
                        }
                    });
                }
            });

            $("#imageload").submit(function (e) {
                e.preventDefault();
                var userId = $('#userId').val();
                var apiurl = $('#apiurl').val();
                var apitoken = $('#api_token').val();
                if ($("#imageload").valid()) {
                    var formData = new FormData($('#imageload')[0]);
                    formData.append("user_id", userId);
                    formData.append("method", "changeavtar");
                    formData.append("api_token", apitoken);
                    $.ajax({
                        url: apiurl,
                        type: 'POST',
                        dataType: 'json',
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        crossDomain: true,

                        success: function (response) {
                            if (response) {
                                if (response['code'] == 200) {
                                    var profile_pic_url = response['data'];
                                    var d = new Date();
                                    d.setTime(d.getTime() + (60*1000));
                                    var expires = "expires="+d.toUTCString();
                                    document.cookie = "profile_pic_url=" + profile_pic_url+';'+expires;
                                    <?php
                                    if (isset($_COOKIE['profile_pic_url'])) {
                                       Session::put('fs_user.profilepic' , $_COOKIE['profile_pic_url']);
                                    }
                                    ?>
                                    $('.image-suc-err').show();
                                    $('.image-suc-err').html(response['message']);
                                    $('.image-suc-err').css('color', 'green');
                                    $('.image-suc-err').delay(8000).hide('slow');
                                    $('#user_profile_pic_id').attr('src',profile_pic_url);
                                    window.location.reload();
                                } else {
                                    $('.image-suc-err').show();
                                    $('.image-suc-err').html(response['message']);
                                    $('.image-suc-err').css('color', 'red');
                                    $('.image-suc-err').delay(8000).hide('slow');
                                }
                            }
                        }
                    });
                }
            });

        });
    </script>
@endsection
