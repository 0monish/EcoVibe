<?php
include("user-auth.php");

if (isset($_SESSION['error_status'])) {
  echo "<script> alert('" . $_SESSION['error_status'] . "');</script>";
  unset($_SESSION["error_status"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- REQUIRED meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>EcoVibe</title>
  <!-- PLUGINS:css -->
  <link rel="stylesheet" href="../Assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../Assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- ENDINJECT -->
  <!-- PLUGIN css for this page -->
  <!-- END plugin css for this page -->
  <!-- INJECT:css -->
  <!-- ENDINJECT -->
  <!-- LAYOUT styles -->
  <link rel="stylesheet" href="../Assets/css/style.css">
  <!-- END layout styles -->
  <link rel="shortcut icon" href="../Assets/images/ecovibe_logo.png" />
  <script src="jquery.js"></script>
  <script src="../Assets/js/main.js" defer type="module"></script>
</head> 

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="row w-100 m-0">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
          <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
              <h3 class="card-title text-left mb-3">Register</h3>
              <form method="POST" action="register.php" id="registrationForm">
                <!-- <div class="form-group">
                  <label>Username</label>
                  <input type="text" id="txtUserName" name="txtUserName" class="form-control p_input">
                  <span id="txtErrorUserName" style="font-size: smaller;"></span>
                </div> -->
                <div class="form-group">
                  <label>Email&nbsp;<span class="text-danger">*</span></label>
                  <input type="email" id="txtEmail" name="txtEmail" class="form-control p_input">
                  <span id="txtErrorEmail" style="font-size: smaller;font-style:italic"></span>
                </div>
                <div class="form-group">
                  <label>Date of Birth &nbsp;<span class="text-danger">*</span></label>
                  <input type="date" id="txtDOB" name="txtDOB" class="form-control p_input">
                  <span id="txtErrorDOB" style="font-size: smaller;font-style:italic" required></span>
                </div>
                <div class="form-group">
                  <label>Password&nbsp;<span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="password" id="txtPassword" name="txtPassword" class="form-control p_input" maxlength="10">
                    <div class="input-group-append">
                      <span class="input-group-text toggle-password">
                        <i class="material-icons" style="font-size: 19px;">visibility</i>
                      </span>
                    </div>
                  </div>
                  <span id="txtErrorPassword" style="font-size: smaller;font-style:italic"></span>
                </div>
                <div class="form-group">
                  <label>Confirm Password&nbsp;<span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="password" id="txtConfirmPassword" name="txtConfirmPassword" class="form-control p_input" maxlength="10">
                    <div class="input-group-append">
                      <span class="input-group-text toggle-password">
                        <i class="material-icons" style="font-size: 19px;">visibility</i>
                      </span>
                    </div>
                  </div>
                  <span id="txtErrorConfirmPassword" style="font-size: smaller;font-style:italic"></span>
                </div>

                <div class="text-center">
                  <input type="submit" name="registerBtn" class="btn btn-primary btn-block enter-btn" value="Register" disabled>
                </div>
                <p class="sign-up text-center mb-2">Already have an Account?<a href="login.php">Log in</a></p>
              </form>
              <!-- <center>
                <button id="google-login-btn" type="button" name="btngoogle" class="btn btn-rounded "><img height="40px" width="40px" src="../Assets/images/google-plus.jpg"></i></button>
              </center> -->
            </div>
          </div>
        </div>
        <!-- CONTENT-wrapper ends -->
      </div>
      <!-- ROW ends -->
    </div>
    <!-- PAGE-body-wrapper ends -->
  </div>
  <!-- CONTAINER-scroller -->

  <script src="../Assets/validations/Validations.js"></script>
  <script src="../Assets/js/jquery.js"></script>

  <script>
    $(document).ready(function() {
      $('.toggle-password').click(function() {
        $(this).find('i').text(function(_, text) {
          return text === 'visibility' ? 'visibility_off' : 'visibility';
        });
        var input = $(this).closest('.input-group').find('input');
        var type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
      });
    });

    const form = document.getElementById("registrationForm");

    // let txtUserName = form.txtUserName;
    let txtEmail = form.txtEmail;
    let txtPassword = form.txtPassword;
    let txtConfirmPassword = form.txtConfirmPassword;

    // let txtErrorUserName = document.getElementById("txtErrorUserName");
    let txtErrorEmail = document.getElementById("txtErrorEmail");
    let txtErrorPassword = document.getElementById("txtErrorPassword");
    let txtErrorConfirmPassword = document.getElementById("txtErrorConfirmPassword");

    // let validUserName = false;
    let validEmail = false;
    let validPassword = false;
    let validCPassword = false;

    function registerBtnStatus() {
      if (validEmail && validPassword && validCPassword) {
        form.registerBtn.disabled = false;
      } else {
        form.registerBtn.disabled = true;
      }
    }

    // GET THE CURRENT DATE
    let currentDate = new Date();

    // CALCULATE THE DATE FIVE YEARS AGO
    let maxDate = new Date(currentDate);
    maxDate.setFullYear(currentDate.getFullYear() - 5);

    // FORMAT THE MAXIMUM DATE FOR THE INPUT
    let maxDateString = maxDate.toISOString().split('T')[0];

    // SET THE MAXIMUM DATE FOR THE INPUT ELEMENT
    document.getElementById('txtDOB').setAttribute('max', maxDateString);


    txtEmail.addEventListener('input', function() {
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

    txtPassword.addEventListener('input', function() {
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

    txtConfirmPassword.addEventListener('input', function() {
      if (txtConfirmPassword.value === "") {
        txtErrorConfirmPassword.innerHTML = "Please fill the password field";
        txtErrorConfirmPassword.style.color = "red";
      } else if (txtConfirmPassword.value === txtPassword.value) {
        txtErrorConfirmPassword.innerHTML = "Confirm Password is valid";
        txtErrorConfirmPassword.style.color = "green";
        validCPassword = true;
      } else {
        txtErrorConfirmPassword.innerHTML = "Confirm Password is invalid";
        txtErrorConfirmPassword.style.color = "red";
        validCPassword = false;
      }
      registerBtnStatus();
    });
  </script>


  <!-- PLUGINS:js -->
  <script src="../Assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- ENDINJECT -->
  <!-- INJECT:js -->
  <script src="../Assets/js/off-canvas.js"></script>
  <script src="../Assets/js/hoverable-collapse.js"></script>
  <script src="../Assets/js/misc.js"></script>
  <script src="../Assets/js/settings.js"></script>
  <script src="../Assets/js/todolist.js"></script>
  <!-- ENDINJECT -->
</body>

</html>