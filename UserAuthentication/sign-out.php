<?php
session_start();

unset($_SESSION['user_id']);
unset($_SESSION['id_token_string']);

if (isset($_SESSION['user_admin'])) {
    unset($_SESSION['user_admin']);
    header("Location: login.php");
    die();
} else if (isset($_SESSION['user_artist'])) {
    unset($_SESSION['user_artist']);
    header("Location: login.php");
    die();
} else {
    header("Location: login.php");
    die();
}