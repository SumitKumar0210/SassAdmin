<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('backend/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ url('backend/assets/images/favicon.png') }}" type="image/x-icon">
    <title>{{$hotlr[0]->name}} - Admin</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Secular+One&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/custom.css') }}">
    <link id="color" rel="stylesheet" href="{{ url('backend/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/responsive.css') }}">
    <style>
        .invalid-feedback {
            color: #dc3545 !important;
        }

        .alert-icons svg {
            top: 12px !important;
        }
        .alert-success {
            color:#0f5132;
        }
    </style>
</head>

<body>
    <!-- loader starts  -->
    <div class="loader">
        <div class="jumpy-bars">
            <div class="bar" id="bar1"></div>
            <div class="bar" id="bar2"></div>
            <div class="bar" id="bar3"></div>
            <div class="bar" id="bar4"></div>
            <div class="bar" id="bar5"></div>
            <div class="bar" id="bar6"></div>
            <div class="bar" id="bar7"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="login-card login-dark">
                        <div>
                            <div>
                                <a class="logo mb-2" href="/">
                                    <img class="img-fluid for-light"src="{{ asset('backend/'.$hotlr[0]->logo.'')}}" alt="looginpage">
                                    <img class="img-fluid for-dark mx-auto" src="{{ asset('backend/'.$hotlr[0]->logo.'')}}" alt="looginpage">
                                </a>
                            </div>
                            <div class="login-main">
                                <div class="alert alert-success otp_success d-none" role="alert">
                                    OTP Sent Successfully.
                                  </div>
                                <div class="resetPass_class">
                                    {{-- --------Email ID submit for password reset----------- --}}
                                    <h3>Reset Your Password</h3>
                                    <form class="theme-form needs-validation" action="" id="form1"
                                        novalidate>
                                       
                                        <div class="form-group">
                                            <label class="col-form-label">Enter Registered Email</label>
                                            <div class="row">
                                                <div class="col-12 col-sm-12">
                                                    <input class="form-control" type="email" id="email"
                                                        placeholder="Enter Email ID"
                                                        style="background-image:none;"required="">
                                                    <div class="invalid-feedback email_feedback">
                                                        Enter Valid Email ID
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="text-end">
                                                        <button
                                                            class="btn btn-primary btn-block m-t-10 w-100 submit1_btn"
                                                            type="submit">Send OTP</button>
                                                        <button
                                                            class="btn btn-primary btn-block m-t-10 w-100 spinn1_btn"
                                                            style="display:none;" type="button" disabled>
                                                            <span class="spinner-border spinner-border-sm"
                                                                aria-hidden="true"></span>
                                                            <span role="status">Please wait...</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2 mb-0 text-center already_cls">Already have an password?<a
                                                class="ms-2" href="/">Sign in</a></p>
                                    </form>
                                    {{-- -------------- Input OTP and verify------------------ --}}
                                    <div class="mt-4 mb-4"><span class="reset-password-link">If don't receive OTP?  <a
                                                class="btn-link text-danger" href="#"><span
                                                    class="resend_class" onclick="resendotp()">Resend</span></a><span>
                                                <div class="spinner-border spinner-border-sm resend_spinn d-none"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="resendotp_error d-none"></div>

                                            </span></span></div>
                                    <form class="theme-form d-none otp_form" id="otp_submit">
                                        <div class="form-group">
                                            <label class="col-form-label pt-0">Submit OTP</label>
                                            <div class="row">
                                                <div class="col">
                                                    <input class="form-control text-center opt-text" type="text"
                                                        id="otp1" placeholder="00" maxlength="2" required>
                                                </div>
                                                <div class="col">
                                                    <input class="form-control text-center opt-text" type="text"
                                                        id="otp2" placeholder="00" maxlength="2" required>
                                                </div>
                                                <div class="col">
                                                    <input class="form-control text-center opt-text" type="text"
                                                        id="otp3" placeholder="00" maxlength="2" required>
                                                </div>
                                                <div class="otpError_msg d-none"></div>
                                                <div class="col-12">
                                                    <div class="text-end">
                                                        <button class="btn btn-primary btn-block m-t-10 w-100 verify_btn"
                                                            type="submit">Verify</button>
                                                            <button
                                                            class="btn btn-primary btn-block m-t-10 w-100 verify_spinn"
                                                            style="display:none;" type="button" disabled>
                                                            <span class="spinner-border spinner-border-sm"
                                                                aria-hidden="true"></span>
                                                            <span role="status">Please wait...</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                {{-- ------------------ New Password Input--------------------- --}}
                                <div class="newPass_class d-none">
                                    <div class="alert alert-success pass_success_alert d-none" role="alert">
                                        Password Changed Successfully.
                                      </div>
                                    <h4 class="mt-4 f-w-700">Create Your Password</h4>
                                    <form class="theme-form needs-validation" action="" id="form3"
                                        novalidate>
                                        <div class="form-group">
                                            <label class="col-form-label">New Password</label>
                                            <div class="form-input position-relative">
                                                <input class="form-control" type="password" name="login[password]"
                                                    id="pass" required="" placeholder="Enter New Password"
                                                    style="background-image: none;">
                                                <div class="invalid-feedback feed_class">
                                                    Enter New Password
                                                </div>
                                                <div class="show-hide"><span class="show"></span></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Retype Password</label>
                                            <input class="form-control" type="text" name="login[password]"
                                                id="cpass" required="" placeholder="Enter Confirm Password"
                                                style="background-image: none;">
                                            <div class="invalid-feedback">
                                                Confirm New Password
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <button class="btn btn-primary btn-block w-100 submit_btn"
                                                type="submit">Submit
                                            </button>
                                            <button class="btn btn-primary btn-block m-t-10 w-100 submit_spinn"
                                                style="display:none;" type="button" disabled>
                                                <span class="spinner-border spinner-border-sm"
                                                    aria-hidden="true"></span>
                                                <span role="status">Please wait...</span>
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- latest jquery-->
    <script src="{{ url('backend/assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ url('backend/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ url('backend/assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ url('backend/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <!-- Sidebar jquery-->
    <script src="{{ url('backend/assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ url('backend/assets/js/script.js') }}"></script>
    <!-- Plugin used-->
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    <script>
        $('.reset-password-link').hide(); //hide otp resend on email input page.
        $('#form1').on("submit", function(e) {
            e.preventDefault();
            let email = $('#email').val();
            if(email==''){
                ('#email').focus();
            }
            else if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                $('.submit1_btn').hide(); //hide email submit button.
                $('.spinn1_btn').show(); //show spinner on palce of email submit button.
                $.ajax({
                    url: "{{ route('admin.backend.sendOtp') }}",
                    method: "POST",
                    data: {
                        email: email
                    },
                    success: function(data) {
                        if (data.success) {
                            setTimeout(function() {
                                $('.spinn1_btn').hide(); //hide spinner on success response.
                                $('.submit1_btn').hide(); //hide email submit button on success.
                                $('.otp_form').removeClass('d-none'); //show OTP input form.
                                $('.reset-password-link').show(); //show otp resend button.
                                $('.invalid-feedback').css("display", "none"); //hide this class
                                $('#email').css("border-color",
                                "#ccc").addClass('disabled'); //change border color of email box
                                $('.already_cls').hide();
                                 $('.magic_link_alert').addClass('d-none');
                                 $('.magic_btn').hide();
                            }, 700);
                        } else if (data.error_validation) {
                            setTimeout(function() {
                            $('.spinn1_btn').hide();
                            $('.submit1_btn').show();
                            $('.invalid-feedback').html(
                                data.error_validation); //change html text of this class
                            }, 500);
                        } else if(data.errors_success){
                            setTimeout(function() {
                            $('.spinn1_btn').hide();
                            $('.submit1_btn').show();
                            $('.invalid-feedback').html(data.errors_success);
                            $('.invalid-feedback').css("display", "block");
                            $('#email').css("border-color", "#dc3545");
                        }, 500);
                        }
                        else{
                            alert("something went wrong");
                        }
                    }
                });
            }
           
        });

        function resendotp() {
            let email = $('#email').val();
            if (email == '') {
                $('#email').focus();
            } else {
                $('.resend_class').addClass('d-none');
                $('.resend_spinn').removeClass('d-none');
                $.ajax({
                    url: "{{ route('admin.backend.sendOtp') }}",
                    method: "POST",
                    data: {
                        email: email
                    },
                    success: function(data) {
                        if (data.success) {
                            setTimeout(function() {
                                $('.resend_spinn').addClass('d-none');
                                $('.resend_class').removeClass('d-none');
                                $('.already_cls').hide();
                            }, 500);
                            $('.resendotp_error').addClass('d-none');
                            $('.otp_form').removeClass('d-none');
                        } else if (data.errors_validation) {
                            alert("error");
                        } else {
                            $('.resend_spinn').addClass('d-none');
                            $('.resend_class').removeClass('d-none');
                            $('.resendotp_error').html(data.errors_success).css("color", "#dc3545").removeClass(
                                'd-none');
                        }
                    }
                });
            }
        }

        const inputs = document.querySelectorAll('.opt-text');
        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length == 2 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });

        $('#otp_submit').on("submit", function(event) {
            let email = $('#email').val();
            let otp1 = $('#otp1').val();
            let otp2 = $('#otp2').val();
            let otp3 = $('#otp3').val();
            let otp = otp1 + otp2 + otp3;
            $('.verify_btn').hide();
            $('.verify_spinn').show();
            $.ajax({
                url: "{{ route('admin.backend.verify_otp') }}",
                method: "POST",
                data: {
                    email: email,
                    otp: otp
                },
                success: function(data) {
                    setTimeout(function(){
                        $('.verify_spinn').hide();
                        $('.verify_btn').show();
                    },200);
                    
                    if (data.success) {
                        $('.resetPass_class').addClass('d-none');
                        $('.newPass_class').removeClass('d-none');
                    } else {
                        $('.otpError_msg').html("Invalid OTP!").css("color", "#dc3545").removeClass(
                            'd-none');
                        $('#otp1, #otp2, #otp3').css("border-color", "#dc3545");
                    }
                }
            });
            event.preventDefault();
        });

        $('#form3').on("submit", function(event) {
            let email = $('#email').val();
            let pass = $('#pass').val();
            let cpass = $('#cpass').val();
            if (pass != cpass || pass.length <= 0 || pass <= 0 || cpass.length <= 0 || cpass <= 0) {
                $('.invalid-feedback').html("Password Not Matched").css("display", "block");
                $('.feed_class').css("display", "none");
                $('#pass').css("border-color", "#dc3545");
                $('#cpass').css("border-color", "#dc3545");
            } else {
                $('.submit_btn').hide();
                $('.submit_spinn').show();
                $.ajax({
                    url: "{{ route('admin.backend.update_pass') }}",
                    method: "POST",
                    data: {
                        email: email,
                        pass: pass,
                        cpass: cpass
                    },
                    success: function(data) {
                        $('.submit_spinn').hide();
                        $('.submit_btn').show();
                        if (data.success) {
                            $('.pass_success_alert').removeClass('d-none');
                            $('.invalid-feedback').css("display", "none");
                            $('#pass').css("border-color", "#ccc");
                            $('#cpass').css("border-color", "#ccc");
                            setTimeout(function() {
                                window.location.href = "{{ route('index') }}";
                            }, 2000);
                        } else {
                            alert("error");
                        }
                    }
                });
            }
            event.preventDefault();
        })
    </script>
</body>

</html>
