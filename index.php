<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['user_email'])) {
    header("Location:user");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeConnect Login</title>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="shortcut icon" href="img/icon/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/animation.css">
    <link rel="stylesheet" href="css/floating_style.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .floating_b_div>div {
            border-width: 4px !important;
        }

        .floating_item_active {
            transform: scale(0.8) translate(-14.9%, -55%) !important;
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
                            <form class="col" id="form_login">
                                <div class="row">
                                    <div class="col-12 items" id="item1">
                                        <!-- <input type="email" name="email" id="email" placeholder="E-mail ID"> -->
                                        <div class="floating_ele">
                                            <input type="email" name="email" class="floating_items" id="email">
                                            <label for="email" class="floating_label">E-mail ID</label>
                                        </div>
                                        <span class="error-r" id="error1">Error text</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 items" id="item2">
                                        <!-- <input type="password" name="password" id="password" placeholder="Password"> -->
                                        <div class="floating_ele">
                                            <input type="password" name="password" class="floating_items" id="password" autocomplete="off">
                                            <label for="password" class="floating_label">Password</label>
                                        </div>
                                        <span class="error-r" id="error2">Error text</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-end align-items-center">
                                        <input type="checkbox" class="form-check-input" name="show_password" id="show_password">
                                        <label for="show_password">Show password</label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col d-flex justify-content-end items" id="item3">
                                        <a href="forgot_password">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col items" id="item4">
                                        <button type="submit" class="transform-a" id="login" name="submit">Login</button>
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
                                        <span>Don't have an account? </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-center items" id="item6">
                                        <a href="signup" class="transform-a">Create New Account</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- floating_script js -->
    <script src="js/floating_script.js"></script>

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
            $("#form_login").on("submit", function(event) {
                event.preventDefault();
                $(".error-r").fadeOut();
                var email = $("#email").val().trim();
                var password = $("#password").val().trim();

                $.ajax({
                    url: "ajax_request/sign_in_ajax",
                    type: "POST",
                    beforeSend: function() {
                        document.getElementById("login").disabled = true;
                        $("#login").prepend("<span id='sp1' class='spinner-border spinner-border-sm me-2' role='status' aria-hidden='true'></span>");
                    },
                    data: {
                        email: email,
                        password: password
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'something went wrong'
                            });
                        } else {
                            if (data.email_e != true) {
                                $("#error1").fadeIn();
                                $("#error1").html(data.email_e);
                            }
                            if (data.password_e != true) {
                                $("#error2").fadeIn();
                                $("#error2").html(data.password_e);
                            }
                            if (data.success == 1) {
                                $("#email").val("");
                                $("#password").val("");
                                window.location.replace("user");
                            } else if (data.success == 0) {
                                Swal.fire({
                                    icon: 'warning',
                                    html: '<span style="color:red;font-size: 20px;font-weight: 600;">Invalid email id or password<span>'
                                });
                            }
                        }
                        $("#login #sp1").remove();
                        document.getElementById("login").disabled = false;
                    }
                });
            });
        });
    </script>
</body>

</html>