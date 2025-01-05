<?php
include "../dbconnect.php";

session_start();

require_once ('../Assets/validations/Validations.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerBtn'])) {
    extract($_POST);

    try {
        $existingUser = $auth->getUserByEmail($txtEmail);
        $_SESSION['error_status'] = "Email already registered.";
        header("Location: registration.php");
        die();
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {

        if (checkEmail($txtEmail)) {
            $_SESSION['error_status'] = "Enter valid email.";
            header("Location: registration.php");
            die();
        } else if (checkPassword($txtPassword)) {
            $_SESSION['error_status'] = "Enter valid password.";
            header("Location: registration.php");
            die();
        } else {

            $userProperties = [
                'email' => $txtEmail,
                'password' => $txtPassword,
            ];

            $createdUser = $auth->createUser($userProperties);

            $uid = $createdUser->uid;
            $verified = $auth->sendEmailVerificationLink($txtEmail);

            if ($verified) {

                $auth->setCustomUserClaims($uid, ['artist' => true]);
                $claims = $auth->getUser($uid)->customClaims;

                // $userData = [
                //     'date_of_birth' => $txtDOB,
                //     'profile_image_name' => "",
                //     'profile_image_url' => "",
                //     'user_status' => false
                // ];

                // $newPostKey = $database->getReference('users/' . $uid)->set($userData);

                // if ($createdUser && isset($claims['artist']) == true) {

                //     $_SESSION['user_id'] = $uid;
                //     header("Location: user-name.php");
                //     die();
                // } else {
                //     echo "User not created successfully.";
                // }

                ?>
                    <!DOCTYPE html>
                    <html lang="en">

                    <head>
                        <meta charset="UTF-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Email Verification</title>
                    </head>

                    <body>
                        <h1>Please verify your email...</h1>
                        <script type="module">
                            // Import the functions you need from the SDKs you need
                            import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
                            import { getAuth } from 'https://www.gstatic.com/firebasejs/10.10.0/firebase-auth.js'
                            // TODO: Add SDKs for Firebase products that you want to use
                            // https://firebase.google.com/docs/web/setup#available-libraries

                            // YOUR WEB APP'S FIREBASE CONFIGURATION
                            const firebaseConfig = {
                                apiKey: "AIzaSyDvYvpIG35rF6uBSF1gKG_P3jR1NuGJVw0",
                                authDomain: "ecovibe-e777e.firebaseapp.com",
                                databaseURL: "https://ecovibe-e777e-default-rtdb.firebaseio.com",
                                projectId: "ecovibe-e777e",
                                storageBucket: "ecovibe-e777e.appspot.com",
                                messagingSenderId: "514520571966",
                                appId: "1:514520571966:web:1890f37bf3c81091bb716f"
                            };

                            // INITIALIZE FIREBASE
                            const app = initializeApp(firebaseConfig);
                            const firebase = getAuth(); 
                        </script>
                        <script>
                            // CHECK IF EMAIL IS VERIFIED
                            firebase.auth().onAuthStateChanged(function (user) {
                                if (user && user.emailVerified) {
                                    window.location.href = "register_process.php"; // Redirect to process registration
                                }
                            });
                        </script>
                    </body>

                    </html>
            <?
            }
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userNameBtn'])) {
    extract($_POST);

    if (checkUserName($txtUserName)) {
        $_SESSION['error_status'] = "Enter valid Username.";
        header("Location: registration.php");
        die();
    }

    $query = $database->getReference('users')
        ->orderByChild('user_name')
        ->equalTo($txtUserName)
        ->getSnapshot();

    if ($query->hasChildren()) {
        $_SESSION['error_status'] = "Username already exists: $txtUserName";
        header("Location: user-name.php");
        die();
    } else {
        if (isset($_SESSION['user_id'])) {
            $userData = [
                'user_name' => $txtUserName,
            ];

            $newPostKey = $database->getReference('users/' . $_SESSION['user_id'])->update($userData);
            $_SESSION['user_artist'] = true;
            header('Location: ../Artists/dashboard.php');
            die();
        }
    }
}



// form class="favourite-song" method="get">
//                                                                                                <input type="hidden" name="favouriteSong"
//                                                                                                             value="<?= $songId; ?>">
//                                                                                                         <button><i class="fav-song material-icons"
//                                                                                                                 id="fav_<?= $songId; ?>"
//                                                                                                                 data-song-id='<?= $songId; ?>'
//                                                                                                                 style="margin-right:0px; color:red;">star_border</i></button>
//                                                                                                     </form> 