<?php
include ("user-auth.php");

if (isset($_SESSION['error_status'])) {
  echo "<script> alert('" . $_SESSION['error_status'] . "');</script>";
  unset($_SESSION["error_status"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>EcoVibe</title>

  <!-- PLUGINS:CSS -->
  <link rel="stylesheet" href="../Assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../Assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- PLUGIN CSS FOR THIS PAGE -->


  <!-- LAYOUT STYLES -->
  <link rel="stylesheet" href="../Assets/css/style.css">
  <!-- END LAYOUT STYLES -->
  <link rel="shortcut icon" href="../Assets/images/ecovibe_logo.png" />
</head>

<body>
  <!-- CONTAINER-FLUID START -->
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <!-- ROW START -->
    <div class="row w-100 m-0">
      <!-- CONTENT WRAPPER START -->
      <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
          <div class="card-body px-4 py-4">

            <h3 class="card-title text-left mb-3">Login</h3>

            <!-- FORM -->
            <form action="login2.php" method="POST" id="loginForm">
              <div class="form-group">
                <label>Email <span style="color:red">*</span></label>
                <input type="text" id="txtUserEmail" name="txtUserEmail" class="form-control p_input"
                  value="<?= (isset($_COOKIE['user_email'])) ? $_COOKIE['user_email'] : '' ?>">
                <span id="txtErrorEmail" style="font-size: smaller;font-style:italic"></span>
              </div>
              <div class="form-group">
                <label>Password <span style="color:red">*</span></label>
                <div class="input-group">
                  <input type="password" name="txtUserPassword" class="form-control p_input"
                    value="<?= (isset($_COOKIE['user_password'])) ? $_COOKIE['user_password'] : '' ?>" maxlength="10">
                  <div class="input-group-append">
                    <span class="input-group-text toggle-password">
                      <i class="material-icons" style="font-size: 19px;">visibility</i>
                    </span>
                  </div>
                </div>
                <span id="txtErrorPassword" style="font-size: smaller;font-style:italic"></span>
              </div>
              <div class="form-group d-flex align-items-center justify-content-between">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" name="chkRememberMe" class="form-check-input"> Remember me </label>
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex flex-column">
                  <div class="g-recaptcha m-auto" id="captcha"></div>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" name="btnLogin" class="btn btn-primary btn-block enter-btn" disabled>Login</button>
              </div>
              <p class="sign-up">Don't have an Account?<a href="./registration.php"> Sign Up</a></p>
            </form>
            <!-- FORM -->
          </div>
        </div>
      </div>
      <!-- CONTENT-WRAPPER ENDS -->
    </div>
    <!-- ROW ENDS -->
  </div>
  <!-- CONTAINER-FLUID ENDS -->

  <!-- PLUGINS:JS -->
  <script src="../Assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- PLUGIN JS FOR THIS PAGE -->

  <!-- INJECT:JS -->
  <script src="../Assets/js/off-canvas.js"></script>
  <script src="../Assets/js/hoverable-collapse.js"></script>
  <script src="../Assets/js/misc.js"></script>
  <script src="../Assets/js/settings.js"></script>
  <script src="../Assets/js/todolist.js"></script>
  <!-- ENDINJECT -->

  <script src="../Assets/validations/Validations.js"></script>
  <script src="../Assets/js/jquery.js"></script>


  <script>

    $(document).ready(function () {
      $('.toggle-password').click(function () {
        $(this).find('i').text(function (_, text) {
          return text === 'visibility' ? 'visibility_off' : 'visibility';
        });
        var input = $(this).closest('.input-group').find('input');
        var type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
      });
    });

    const form = document.getElementById("loginForm");

    let txtEmail = form.txtUserEmail;
    let txtPassword = form.txtUserPassword;

    let txtErrorEmail = document.getElementById("txtErrorEmail");
    let txtErrorPassword = document.getElementById("txtErrorPassword");

    let validEmail = false;
    let validPassword = false;
    let validCaptcha = false;

    function registerBtnStatus() {
      if (validEmail && validPassword && validCaptcha) {
        form.btnLogin.disabled = false;
      } else {
        form.btnLogin.disabled = true;
      }
    }

    var recaptchaCallback = function () {
      // reCAPTCHA HAS BEEN LOADED AND RENDERED
      // ENABLE FORM SUBMISSION
      validCaptcha = true;
      registerBtnStatus();
      console.log("IN callback");
    };

    var onloadCallback = function () {
      grecaptcha.render('captcha', {
        'sitekey': '6Lcx2CcoAAAAAGVKQ-2yk3aFVy3E3JYb9LBgv1IL',
        'callback': recaptchaCallback, // THIS FOR WHEN CAPTCHA IS RESPONSE IS DONE THEN WHAT SHOULD HAPPEN
        'theme': 'dark' // THIS IS OPTIONAL IT CAN BE light OR dark
      });
    };

    // const recaptchaResponse = grecaptcha.getResponse();

    if (txtEmail.value !== "") {
      if (checkEmail(txtEmail.value)) {
        txtErrorEmail.innerHTML = "Email is valid";
        txtErrorEmail.style.color = "green";
        validEmail = true;
      } else {
        txtErrorEmail.innerHTML = "Email is invalid";
        txtErrorEmail.style.color = "red";
        validEmail = false;
      }
      registerBtnStatus();
    }

    if (txtPassword.value !== "") {
      if (txtPassword.value === "") {
        txtErrorPassword.innerHTML = "Please fill the password field";
        txtErrorPassword.style.color = "red";
      } else if (checkPassword(txtPassword.value)) {
        txtErrorPassword.innerHTML = "Password is valid";
        txtErrorPassword.style.color = "green";
        validPassword = true;
      } else {
        txtErrorPassword.innerHTML = "Password is invalid";
        txtErrorPassword.style.color = "red";
        validPassword = false;
      }
      registerBtnStatus();
    }

    // if (recaptchaResponse === "") { // FOR CAPTCHA
    //   validCaptcha = false;
    //   // PREVENT FORM SUBMISSION
    //   registerBtnStatus();
    // }

    txtEmail.addEventListener('input', function () {
      if (checkEmail(txtEmail.value)) {
        txtErrorEmail.innerHTML = "Email is valid";
        txtErrorEmail.style.color = "green";
        validEmail = true;
      } else {
        txtErrorEmail.innerHTML = "Email is invalid";
        txtErrorEmail.style.color = "red";
        validEmail = false;
      }
      registerBtnStatus();
    });

    txtPassword.addEventListener('input', function () {
      if (txtPassword.value === "") {
        txtErrorPassword.innerHTML = "Please fill the password field";
        txtErrorPassword.style.color = "red";
      } else if (checkPassword(txtPassword.value)) {
        txtErrorPassword.innerHTML = "Password is valid";
        txtErrorPassword.style.color = "green";
        validPassword = true;
      } else {
        txtErrorPassword.innerHTML = "Password is invalid";
        txtErrorPassword.style.color = "red";
        validPassword = false;
      }
      registerBtnStatus();
    });


  </script>

  <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

</body>

</html>