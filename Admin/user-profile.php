<?php
// TO DO BOTH SIDE VALIDATIONS 
session_start();
include "../dbconnect.php";
require_once ('../Assets/validations/Validations.php');

if (!isset($_SESSION['user_admin'])) {
    header('Location: ../UserAuthentication/login.php');
    die();
} else {
    $response = array();

    // VIEWING USER PROFILE
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['userProfile'])) {
        header('Content-Type: text/html; charset=UTF-8');

        // Check if the user ID is set in the session
        if (isset($_SESSION['user_id'])) {
            // Get the user ID from the session
            $userId = $_SESSION['user_id'];

            $userData = $database->getReference("users/$userId")->getValue();
            $user = $auth->getUser($userId);
            $userEmail = $user->email;
            // CHECK IF USER DATA IS FETCHED SUCCESSFULLY
            if ($userData) {
                // PRE-FILL FORM FIELDS WITH USER DATA
                $txtUsername = $userData['user_name']; // PRE-FILL USERNAME FIELD
                $dateOfBirth = $userData['date_of_birth']; // PRE-FILL DATE OF BIRTH FIELD
                $profileImg = $userData['profile_image_url'];
            }

        }
        ?>
        <!-- CONTENT WRAPPER START HERE -->
        <div class="content-wrapper">
            <!-- HEADING -->
            <h2>User Profile</h2>
            <!-- FORM START -->
            <form class="editProfileForm" enctype="multipart/form-data">
                <br>
                <div class="row">
                    <!-- DIVISION 1 START HERE -->
                    <div class="form-group col-12 col-md-3">
                        <div id="profile-container">
                            <div id="profile-picture">
                                <img src="<?= isset($profileImg) ? $profileImg : ''; ?>" alt="User Image"
                                    style="max-height: 100p%; max-width:100%">
                            </div>
                            <button type="button" id="upload-button">
                                <label for="userProfile" style="cursor:pointer;">+</label>
                                <input type="file" name="updateimg" id="userProfile">
                            </button>
                        </div>
                        <span id="userProfileError" style="font-size: 13px; margin-left: 30px;"></span>
                    </div>
                    <!-- DIVISION 1 END HERE -->

                    <!-- DIVISION 2 START HERE -->
                    <div class="form-group col-12 col-md-9">
                        <!-- USERNAME -->
                        <label for="Username">Username&nbsp;<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" name="txtUsername" id="txtUsername" class="form-control" placeholder="Username"
                                aria-label="Username" aria-describedby="basic-addon1" maxlength="15"
                                value="<?= isset($txtUsername) ? $txtUsername : ''; ?>">
                        </div>
                        <span id="usernameError" style="font-size: 13px;"></span>
                        <br />
                        <!-- EMAIL -->
                        <label for="Email">Email&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-dark" name="txtEmail" id="txtEmail"
                            value="<?= isset($userEmail) ? $userEmail : ''; ?>" disabled>
                        <span id="emailError" style="font-size: 13px;"></span>
                        <br />
                        <!-- DATE OF BIRTH -->
                        <label for="DateOfBirth">Date of Birth&nbsp;<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="dateOfBirth" id="dateOfBirth"
                            value="<?= isset($dateOfBirth) ? $dateOfBirth : ''; ?>">
                        <span id="dateOfBirthError" style="font-size: 13px;"></span>
                        <br />
                        <!-- PASSWORD
                        <label for="Password">Password&nbsp;<span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="txtPassword" id="txtPassword">
                        <span id="passwordError" style="font-size: 13px;"></span>
                        <br /> -->

                    </div>
                    <!-- DIVISION 2 ENDS HERE -->
                </div>
                <!-- BUTTONS -->
                <div class="d-flex justify-content-center">
                    <button type="button" id="editButton" name="updateProfile" class="btn btn-outline-secondary btn-icon-text">
                        Edit
                        <i class="mdi mdi-file-check btn-icon-append"></i></button>&nbsp;&nbsp;
                    <button type="submit" id="btnUpdate" name="btnUpdate" class="btn btn-outline-primary" disabled
                        hidden>Update</button>
                    &nbsp;&nbsp;
                </div>
            </form>
        </div>
        <?php
    }

    // UPDATING USER PROFILE
    else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProfile'])) {
        header('Content-Type: application/json; charset=UTF-8');

        extract($_POST);

        if (isset($_SESSION['user_id'])) {
            try {
                $uid = $_SESSION['user_id'];

                $existingProfileImage = $database->getReference("users/$uid/profile_image_name")->getValue();
                $imageFilePath = "user_profile_image/$uid/$existingProfileImage";

                // CHECKING FILE EXISTS OR NOT BEFORE DELETION
                if ($storage->getBucket()->object($imageFilePath)->exists()) {
                    $imageFile = $storage->getBucket()->object($imageFilePath);
                    $imageFile->delete();
                }

                if (isset($_FILES['updateimg'])) {
                    $imgFileName = $_FILES['updateimg']['name'];
                    $imgFileTmpName = $_FILES['updateimg']['tmp_name'];

                    // DEFINE A UNIQUE NAME FOR THE FILE IN FIREBASE STORAGE
                    $userProfileImg = 'user_profile_image/' . $uid . '/' . $imgFileName;

                    // UPLOAD THE FILE TO FIREBASE STORAGE
                    $storage->getBucket()->upload(fopen($imgFileTmpName, 'r'), [
                        'name' => $userProfileImg
                    ]);

                    // GET THE DOWNLOAD URL OF THE UPLOADED IMAGE
                    $downloadUrl = $storage->getBucket()->object($userProfileImg)->signedUrl(new DateTime('2025-12-31'));

                    // UPDATE USER DETAILS IN THE REAL-TIME DATABASE
                    $userDetails = [
                        'user_name' => $txtUsername,
                        'date_of_birth' => $dateOfBirth,
                        'profile_image_name' => $imgFileName,
                        'profile_image_url' => $downloadUrl
                    ];

                    $updated = $database->getReference('users/' . $uid)->update($userDetails);

                    // $properties = [
                    //     'email' => $txtEmail
                    // ];
                    // $updatedUser = $auth->updateUser($uid, $properties);

                    if ($updated) {
                        $response['success'] = "User profile updated successfully";
                    } else {
                        $response['error'] = "User not profile updated successfully";
                    }
                } else {
                    $response['error'] = "No image file uploaded";
                }
            } catch (\Exception $e) {
                $response['error'] = $e->getMessage();
            }
        } else {
            $response['error'] = "User ID not set";
        }
        echo json_encode($response);
    } else {
        header('Location: dashboard.php');
        die();
    }
}
?>