<?php
session_start();

include "../dbconnect.php";
require_once ('../Assets/validations/Validations.php');
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);

    if (isset($chkRememberMe)) {
        setcookie("user_email", $txtUserEmail, time() + 60 * 60);
        setcookie("user_password", $txtUserPassword, time() + 60 * 60);
    } else {
        setcookie("user_email", "", time() - 60 * 60);
        setcookie("user_password", "", time() - 60 * 60);
    }

    if (checkEmail($txtUserEmail)) {
        echo "<script> alert('Enter valid email.');</script>";
    } else if (checkPassword($txtUserPassword)) {
        echo "<script> alert('Enter valid password');</script>";
    } else {

        try {
            $user = $auth->getUserByEmail($txtUserEmail);
            $signInResult = $auth->signInWithEmailAndPassword($txtUserEmail, $txtUserPassword);

            $idTokenString = $signInResult->idToken(); // string|null
            try {
                $verifiedIdToken = $auth->verifyIdToken($idTokenString);
                $uid = $verifiedIdToken->claims()->get('sub');

                $claims = $auth->getUser($uid)->customClaims;

                if (isset($claims['admin']) == true) {

                    $_SESSION['user_admin'] = true;
                    $_SESSION['user_id'] = $uid;
                    $_SESSION['id_token_string'] = $idTokenString;
                    header('Location: ../Admin/dashboard.php');
                    die();
                } else if (isset($claims['artist']) == true) {
                   
                    $userRef = $database->getReference("users/$uid");

                    $userData = $userRef->getValue();
                    if ($userData) {
                        $status = $userData['user_status'];
                    }
                    if ($status == true) {
                        $_SESSION['user_artist'] = true;
                        $_SESSION['status'] = true;
                        $_SESSION['user_id'] = $uid;
                        $_SESSION['id_token_string'] = $idTokenString;
                        header('Location: ../Artists/dashboard.php');
                    }
                    else{
                        $_SESSION['user_artist'] = false;
                        $_SESSION['status'] = false;
                        header('Location: ../Assets/html/artist-approval.html');
                    }

                } else if ($claims == null) {
                    header('Location: ../Assets/html/unauthorized.html');
                    die();
                }
            } catch (FailedToVerifyToken $e) {
                echo 'The token is invalid: ' . $e->getMessage();
            }

        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            echo "<script> alert('Get yo urself register first.');</script>";
        } catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e) {
            echo "<script> window.location.href = 'login.php'; </script>";
            echo "<script> console.log('Invalid login credentials.');</script>";
        }
    }
}


// $auth->setCustomUserClaims('ufSA7yLqWaYnPXrCIfSEBXYcxo43', ['admin' => true]);
// $claims = $auth->getUser('ufSA7yLqWaYnPXrCIfSEBXYcxo43')->customClaims;
// if(isset($claims['admin']) == true){
//     echo 'You are admin';
// }
// else{
//     echo 'You are not admin';
// }

// https://www.youtube.com/watch?v=HgxTQIPm9U8
// https://www.youtube.com/watch?v=w896lLQkGeE
// https://firebase.google.com/docs/auth/admin/custom-claims#node.js



//     try {
//         // Implement logic to retrieve user data from the Realtime Database based on the provided email
//         $userData = $database->getUserDataByEmail($txtUserEmail);

//         // Check if the user exists and the password matches the stored password
//         if ($userData && password_verify($txtUserPassword, $userData['password'])) {
//             // Set session variables or perform any necessary actions
//             $_SESSION['uid'] = $userData['uid'];
//             $_SESSION['idTokenString'] = ''; // Modify accordingly based on your requirements

//             header('Location: home1.php');
//             die();
//         } else {
//             echo "<script> alert('Invalid credentials.');</script>";
//         }
//     } catch (Exception $e) {
//         echo "<script> alert('An error occurred: " . $e->getMessage() . "');</script>";
//     }
// }