<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    if(isset($_SESSION['user_email'])) {
        header("Location:user");
    }
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <link rel="shortcut icon" href="img/icon/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/animation.css">
    <link rel="stylesheet" href="css/floating_style.css">
    <link rel="stylesheet" href="css/date_picker.css">

    <title>WeConnect Sign Up</title>

    <style>
        .floating_label {
            font-weight: 600;
        }

        .floating_b_div>div {
            border-width: 4px !important;
        }

        .floating_item_active {
            transform: scale(0.8) translate(-12%, -56%) !important;
            font-weight: bold !important;
        }

        #show_password {
            cursor: pointer;
            margin-right: 8px;
        }

        label[for="show_password"] {
            cursor: pointer;
            user-select: none;
        }
        label[for="otp_input"]+.floating_b_div .floating_b_div2 {
            width: 104px !important;
        }
    </style>
</head>

<body>
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>


    <!-- OTP Modal -->
    <div class="modal fade" id="modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col d-flex justify-content-end p-0 mb-2">
                                <button type="button" id="close_modal1" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <h5 class="modal-title text-decoration-underline" id="modal1Label">Enter the code from your email</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="container" id="otp_form_g">
                        <div class="row">
                            <div class="col">
                                <p id="email_content"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex flex-column">
                                <!-- <input type="text" name="" id="otp_input" placeholder="Verification OTP"> -->
                                <div class="floating_ele">
                                    <input type="text" name="" class="floating_items" id="otp_input">
                                    <label for="otp_input" class="floating_label">Verification OTP</label>
                                </div>
                                <span id="email_otp_error">OTP has been sent to Your E-mail ID(Check the email in the Inbox or Spam category)</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col d-flex justify-content-center">
                                <button id="verify_otp_btn" class="transform-a">Verify OTP</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row header_row1 justify-content-around align-items-center">
            <div class="col-lg-5 mb-2">
                <p class="text-primary m-0" id="title_h">WeConnect</p>
                <p class="m-0" id="title____p">Share what's new and life moments with your friends.</p>
            </div>
            <div class="col-lg-4 d-flex flex-column align-items-center">
                <div class="row bg-white d-flex flex-column" id="main">
                    <div class="col">
                        <div class="row">
                            <form class="col" action="#" method="post" id="form_e">
                                <h4 class="text-center text-decoration-underline">Sign Up</h4>
                                <div class="row">
                                    <div class="col-12 items" id="item1">
                                        <!-- <input type="text" name="name" id="name" placeholder="Name"> -->
                                        <div class="floating_ele">
                                            <input type="text" name="name" class="floating_items" id="name">
                                            <label for="name" class="floating_label">Name</label>
                                        </div>
                                        <span class="error-r" id="error1">Error text</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 items" id="item2">
                                        <!-- <input type="email" name="email" id="email" placeholder="E-mail ID"> -->
                                        <div class="floating_ele">
                                            <input type="email" name="email" class="floating_items" id="email">
                                            <label for="email" class="floating_label">E-mail ID</label>
                                        </div>
                                        <span class="error-r" id="error2">Error text</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 items" id="item4">
                                        <!-- <input type="password" name="password" id="password" placeholder="Password"> -->
                                        <div class="floating_ele">
                                            <input type="password" name="password" class="floating_items" id="password" autocomplete="off">
                                            <label for="password" class="floating_label">Password</label>
                                        </div>
                                        <span class="error-r" id="error3">Error text</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-end align-items-center">
                                        <input type="checkbox" class="form-check-input" name="show_password" id="show_password">
                                        <label for="show_password">Show password</label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 items" id="item5">
                                        <!-- <input type="date" name="dob" id="dob" style="user-select: none;"> -->
                                        <div class="floating_ele">
                                            <span class="material-icons position-absolute date_picker_icon">date_range</span>
                                            <input type="text" name="dob" class="floating_items date_picker" id="dob" readonly autocomplete="off">
                                            <label for="dob" class="floating_label">DOB</label>
                                        </div>
                                        <span class="error-r" id="error4">Error text</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 items" id="item6">
                                        <!-- <select name="gender" id="gender">
                                            <option selected value="1">Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select> -->
                                        <div class="floating_ele">
                                            <select class="form-select floating_items floating_select_item" id="gender">
                                                <option selected value="1">Select the Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <label for="gender" class="floating_label">Gender</label>
                                        </div>
                                        <span class="error-r" id="error5">Error text</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col items" id="item7">
                                        <button type="submit" class="transform-a" id="signup" name="submit">Sign Up</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col d-flex justify-content-center items" id="item5">
                                        <span>Already have an account?</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-center items" id="item6">
                                        <a href="index" class="transform-a">Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- date-picker Modal -->
    <div class="modal fade" id="date_picker_modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" id="date_modal_dialog">
            <div class="modal-content border-0">
                <div class="modal-header text-white" style="background-color: var(--date_picket_header_light_bg-color);">
                    <div class="container" style="user-select: none;">
                        <div class="row">
                            <div class="col">
                                <span id="year"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex fw-bold fs-3">
                                <div id="day_name"></div>
                                <div>,</div>
                                <div id="date_name" class="mx-2"></div>
                                <div id="month_name"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body position-relative" id="date_modal_body">
                    <div id="year_list" class="position-absolute">

                    </div>
                    <div id="month_list" class="position-absolute">

                    </div>
                    <div class="container-fluid p-0">
                        <div class="row fw-bold fs-6 align-items-center">
                            <button class="col-2 p_n_date" id="prev_date">
                                <span class="material-icons active_css_icon">
                                    expand_less
                                </span>
                            </button>
                            <div class="col text-center" id="change_m_y"></div>
                            <button class="col-2 p_n_date" id="next_date">
                                <span class="material-icons active_css_icon">
                                    expand_less
                                </span>
                            </button>
                        </div>
                        <div class="week_list mt-3">
                            <div class="week_m">S</div>
                            <div class="week_m">M</div>
                            <div class="week_m">T</div>
                            <div class="week_m">W</div>
                            <div class="week_m">T</div>
                            <div class="week_m">F</div>
                            <div class="week_m">S</div>
                        </div>
                        <div class="data_picker">
                            <span class="data_picker_span"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" id="set_date">SET</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_date_picker_modal">CANCEL</button>
                    <button type="button" class="btn btn-primary" id="clear_date_picker">CLEAR</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- floating_script js -->
    <script src="js/floating_script.js"></script>

    <!-- date-picker js -->
    <script src="js/date_picker.js"></script>

    <!-- sweetalert2 js -->
    <script src="js/sweetalert2.js"></script>


    <script>
        $("#show_password").click(function() {
            var password = document.getElementById("password");
            if (password.type == "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#form_e").on("submit", function(event) {
                event.preventDefault();
                $(".error-r").fadeOut();
                var name = $("#name").val().trim();
                var email = $("#email").val().trim();
                var password = $("#password").val().trim();
                var dob = $("#dob").val().trim();
                var gender = $("#gender").val().trim();

                $.ajax({
                    url: "ajax_request/signup_ajax",
                    type: "POST",
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        dob: dob,
                        gender: gender
                    },
                    beforeSend: function() {
                        document.getElementById("signup").disabled = true;
                        $("#signup").prepend("<span id='sp1' class='spinner-border spinner-border-sm me-2' role='status' aria-hidden='true'></span>");
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#signup #sp1").remove();
                        // console.log(data);
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'something went wrong'
                            });
                        } 
                        else {
                            if (data.name_e != true) {
                                $("#error1").fadeIn();
                                $("#error1").html(data.name_e);
                            }
                            if (data.email_e != true) {
                                $("#error2").fadeIn();
                                $("#error2").html(data.email_e);
                            }
                            if (data.password_e != true) {
                                $("#error3").fadeIn();
                                $("#error3").html(data.password_e);
                            }
                            if (data.age_e != true) {
                                $("#error4").fadeIn();
                                $("#error4").html(data.age_e);
                            }
                            if (data.gender_e != true) {
                                $("#error5").fadeIn();
                                $("#error5").html(data.gender_e);
                            }
                            if (data.success == 1) {
                                $(".error-r").fadeOut();
                                $("#name").val("");
                                $("#email").val("");
                                $("#password").val("");
                                $("#dob").val("");
                                $("#gender").val(1);
                                $("#modal1").modal("show");
                                $("#email_content").html(data.email_content);
                            }
                        }
                        document.getElementById("signup").disabled = false;
                    }
                });
            });
            $("#otp_form_g").on("submit", function(event) {
                event.preventDefault();
                var otp_get = $("#otp_input").val().trim();
                $.ajax({
                    url: "ajax_request/otp_verify",
                    type: "POST",
                    dataType: "json",
                    data: {
                        otp: otp_get
                    },
                    beforeSend: function() {
                        document.getElementById("verify_otp_btn").disabled = true;
                        $("#verify_otp_btn").prepend("<span id='sp2' class='spinner-border spinner-border-sm me-2' role='status' aria-hidden='true'></span>");
                    },
                    success: function(data) {
                        $("#verify_otp_btn #sp2").remove();
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'something went wrong'
                            });
                        } 
                        else {
                            if (data.otp_info != true) {
                                $("#email_otp_error").text(data.otp_info);
                                $("#email_otp_error").css("color", "red");
                            } else {
                                $("#otp_input").val("");
                                $("#email_otp_error").css("color", "#0d6efd");
                                $("#modal1").modal("hide");
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Account Creatrd Successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                        document.getElementById("verify_otp_btn").disabled = false;
                    }
                });
            });
            $("#close_modal1").click(function() {
                $.ajax({
                    url: "session_delete",
                    type: "POST",
                    success: function(data) {
                        // console.log(data);
                    }
                });
            });
        });
    </script>
</body>

</html>