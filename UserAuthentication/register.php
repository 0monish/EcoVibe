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


            $auth->setCustomUserClaims($uid, ['artist' => true]);
            $claims = $auth->getUser($uid)->customClaims;

            $userData = [
                'date_of_birth' => $txtDOB,
                'profile_image_name' => "",
                'profile_image_url' => "",
                'user_status' => false
            ];

            $newPostKey = $database->getReference('users/' . $uid)->set($userData);

            if ($createdUser && isset($claims['artist']) == true) {

                $_SESSION['user_id'] = $uid;
                header("Location: user-name.php");
                die();
            } else {
                echo "User not created successfully.";
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
            // $_SESSION['user_artist'] = true;
            // $_SESSION['status'] = false;
            header('Location: ../Artists/dashboard.php');
            die();
        }
    }
}