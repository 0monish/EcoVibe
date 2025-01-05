<?php
session_start();

if (isset($_SESSION['user_admin'])) {
    header('Location: ../Admin/dashboard.php');
    die();
} else if ( (isset($_SESSION['user_artist']) && $_SESSION['user_artist']== true) && $_SESSION['status'] == true ) {
    header('Location: ../Artists/dashboard.php');
    die();
}