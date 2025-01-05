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
    <!-- REQUIRED meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EcoVibe</title>
    <!-- PLUGINS:css -->
    <link rel="stylesheet" href="../Assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../Assets/vendors/css/vendor.bundle.base.css">
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
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">
                        <h3 class="card-title text-left mb-3">Username</h3>
                            <form method="POST" action="register.php" id="registrationForm">
                                <div class="form-group">
                                    <label>What's your username?&nbsp<span class="text-danger">*</span></label>
                                    <input type="text" id="txtUserName" name="txtUserName" maxlength="15" class="form-control p_input">
                                    <span style="font-size: 13px;">This username appear on your profile.</span>
                                    <span id="txtErrorUserName" style="font-size: smaller;font-style:italic"></span>
                                </div>
                                <div class="text-center">
                                    <input type="submit" name="userNameBtn" class="btn btn-primary btn-block enter-btn" disabled>Create Account</button>
                                </div>
                            </form>
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

    <script>
        const form = document.getElementById("registrationForm");

        let txtUserName = form.txtUserName;

        let txtErrorUserName = document.getElementById("txtErrorUserName");

        let validUserName = false;

        function userNameBtnStatus() {
            if (validUserName) {
                form.userNameBtn.disabled = false;
            } else {
                form.userNameBtn.disabled = true;
            }
        }

        txtUserName.addEventListener('input', function() {
            if (checkUserName(txtUserName.value)) {
                txtErrorUserName.innerHTML = "UserName is valid";
                txtErrorUserName.style.color = "green";
                validUserName = true; 
            } else {
                txtErrorUserName.innerHTML = "UserName is invalid";
                txtErrorUserName.style.color = "red";
                validUserName = false;
            }
            userNameBtnStatus();
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