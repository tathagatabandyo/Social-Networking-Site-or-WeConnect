<?php
if (!isset($_SESSION)) {
  session_start();
}
if (isset($_SESSION['user_email'])) {
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

  <link rel="shortcut icon" href="img/icon/icon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/animation.css">
  <link rel="stylesheet" href="css/floating_style.css">

  <title>Forgot Password</title>
  <style>
    #main {
      box-shadow: 0px 0px 8px 2px #000;
      padding: 20px;
      border-radius: 10px;
    }


    #reset_password {
      width: 100%;
      border: 2px solid #0d6efd;
      background-color: #0d6efd;
      padding: 5px 10px;
      font-size: 20px;
      font-weight: 600;
      cursor: pointer;
      border-radius: 10px;
      color: #fff;
      margin-top: 15px;
    }

    .error-r {
      margin-left: 10px;
      color: #dc3545;
      user-select: none;
      font-weight: 500;
      display: none;
    }

    .floating_b_div>div {
      border-width: 4px !important;
    }

    .floating_item_active {
      transform: scale(0.8) translate(-13%, -55%) !important;
      font-weight: bold !important;
    }

    label[for="email"]+.floating_b_div .floating_b_div2 {
      width: 120px !important;
    }

    label[for="otp_input"]+.floating_b_div .floating_b_div2 {
      width: 102px !important;
    }

    label[for="password"]+.floating_b_div .floating_b_div2 {
      width: 153px !important;
    }

    #show_password {
      cursor: pointer;
      margin-right: 8px;
    }

    label[for="show_password"] {
      cursor: pointer;
      user-select: none;
    }

    #email_otp_error {
      font-size: 14px;
      font-weight: 500;
      color: #0d6efd;
      user-select: none;
      /* margin-left: 8px; */
    }

    #verify_otp_btn,
    #change_password,#back_to_login {
      padding: 5px 10px;
      font-size: 20px;
      font-weight: 600;
      color: #fff;
      background-color: #0d6efd;
      border: 2px solid #0d6efd;
      border-radius: 10px;
    }
    #back_to_login {
      text-decoration: none;
      background-color: #42b72a;
      border: 2px solid #42b72a;
    }
    .m_hr_line {
      width: calc(100% - 50% - 20.19px);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .hr_line {
      width: 92%;
      height: 1px;
      background-color: #7878788f;
    }
    .transform-a,.transform-a2 {
      transition: transform 0.1s linear 0s;
    }

    .transform-a:active {
        transform: scale(1.1);
    }

    .transform-a2:active {
        transform: scale(1.04);
    }

    @media screen and (max-width:576px) {
      #p_main {
        margin: 0px 10px !important;
      }
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
    <div class="row justify-content-center align-items-center" style="height: 100vh;" id="p_main">
      <div class="col-md-5 bg-white p-3" id="main">
        <div class="row">
          <div class="col">
            <h2 class="text-center text-decoration-underline">Forgot password</h2>
          </div>
        </div>
        <div class="row mt-2">
          <form class="col" id="reset_password_form">
            <div class="row">
              <div class="col-12">
                <div class="floating_ele">
                  <input type="email" name="email" class="floating_items" id="email">
                  <label for="email" class="floating_label">Enter The E-mail ID</label>
                </div>
                <span class="error-r" id="error1">Error text</span>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <button type="submit" class="transform-a2" id="reset_password" name="reset_password">Reset Password</button>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col d-flex justify-content-center align-items-center">
                <div class="m_hr_line"><div class="hr_line"></div></div>
                <div class="fw-bold fs-5">or</div>
                <div class="m_hr_line"><div class="hr_line"></div></div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col d-flex justify-content-center">
                <a href="index" id="back_to_login" class="transform-a">Back to Login</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
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
          <form class="container" id="otp_form">
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


  <!-- Password set Modal -->
  <div class="modal fade" id="modal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div class="container">
            <div class="row">
              <div class="col d-flex justify-content-end p-0 mb-2">
                <button type="button" id="close_modal2" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
            <div class="row">
              <div class="col d-flex justify-content-center">
                <h5 class="modal-title text-decoration-underline" id="modal2Label">Choose a new password</h5>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <form class="container" id="new_password_form">
            <div class="row">
              <div class="col-12 d-flex flex-column">
                <div class="floating_ele">
                  <input type="password" name="password" class="floating_items" id="password" autocomplete="off">
                  <label for="password" class="floating_label">Enter The New Password</label>
                </div>
                <span class="error-r" id="error2">Error text</span>
              </div>
            </div>
            <div class="row mt-1">
              <div class="col d-flex justify-content-end align-items-center">
                <input type="checkbox" class="form-check-input" name="show_password" id="show_password">
                <label for="show_password">Show password</label>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col d-flex justify-content-center" id="item">
                <button type="submit" class="transform-a" id="change_password" name="change_password">Change Password</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle with Popper -->
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
      $("#reset_password_form").on("submit", function(event) {
        event.preventDefault();
        $(".error-r").fadeOut();
        var email = $("#email").val().trim();

        $.ajax({
          url: "ajax_request/forgot_password_otp",
          type: "POST",
          beforeSend: function() {
            document.getElementById("reset_password").disabled = true;
            $("#reset_password").prepend("<span id='sp1' class='spinner-border spinner-border-sm me-2' role='status' aria-hidden='true'></span>");
          },
          data: {
            email: email
          },
          dataType: "json",
          success: function(data) {
            $("#reset_password #sp1").remove();
            if (data.error == 0) {
              Swal.fire({
                icon: 'error',
                title: 'something went wrong'
              });
            } 
            else {
              if (data.email_e != true) {
                $("#error1").fadeIn();
                $("#error1").html(data.email_e);
              }
              if (data.success == 1) {
                $(".error-r").fadeOut();
                $("#email").val("");
                $("#modal1").modal("show");
                $("#email_content").html(data.email_content);
              }
            }
            document.getElementById("reset_password").disabled = false;
          }
        });
      });

      $("#otp_form").on("submit", function(event) {
        event.preventDefault();
        var otp_input = $("#otp_input").val().trim();
        $("#email_otp_error").fadeOut();

        $.ajax({
          url: "ajax_request/reset_otp_verify",
          type: "POST",
          dataType: "json",
          data: {
            otp: otp_input
          },
          beforeSend: function() {
            document.getElementById("verify_otp_btn").disabled = true;
            $("#verify_otp_btn").prepend("<span id='sp2' class='spinner-border spinner-border-sm me-2' role='status' aria-hidden='true'></span>");
          },
          success: function(data) {
            $("#verify_otp_btn #sp2").remove();
            if (data.error == 0) {
              console.log("something went wrong");
            } 
            else {
              if (data.otp_info != true) {
                $("#email_otp_error").fadeIn();
                $("#email_otp_error").text(data.otp_info);
                $("#email_otp_error").css("color", "red");
              } else {
                $("#otp_input").val("");
                $("#email_otp_error").fadeIn();
                $("#email_otp_error").css("color", "#0d6efd");
                $("#email_otp_error").html("OTP has been sent to Your E-mail ID(Check the email in the Inbox or Spam category)");
                $("#modal1").modal("hide");
                $("#modal2").modal("show");
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

      $("#new_password_form").on("submit", function(event) {
        event.preventDefault();
        $(".error-r").fadeOut();
        var password = $("#password").val().trim();

        $.ajax({
          url: "ajax_request/new_password_ajax",
          type: "POST",
          beforeSend: function() {
            document.getElementById("change_password").disabled = true;
            $("#change_password").prepend("<span id='sp3' class='spinner-border spinner-border-sm me-2' role='status' aria-hidden='true'></span>");
          },
          data: {
            password: password
          },
          dataType: "json",
          success: function(data) {
            $("#change_password #sp3").remove();
            if (data.error == 0) {
              Swal.fire({
                icon: 'error',
                title: 'something went wrong'
              });
            } 
            else {
              if (data.password_e != true) {
                $("#error2").fadeIn();
                $("#error2").html(data.password_e);
              } 
              else {
                if (data.success == 1) {
                  $("#password").val("");
                  $("#modal2").modal("hide");
                  Swal.fire({
                    icon: 'success',
                    title: 'Password Change Successfully',
                    showConfirmButton: false,
                    timer: 1500
                  });
                }
                else {
                  Swal.fire({
                    icon: 'success',
                    title: 'Password Not Change,something went wrong',
                    showConfirmButton: false,
                    timer: 1500
                  });
                }
              }
            }
            document.getElementById("change_password").disabled = false;
          }
        });
      });

      $("#close_modal2").click(function() {
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