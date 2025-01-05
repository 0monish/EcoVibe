<?php

// 1. Function to check if a username is valid:
function checkUserName($userName)
{
    return !preg_match('/^[a-z]{1}[a-z0-9]{4,14}$/', $userName);
}

// 2. Function to check if an email is valid:
function checkEmail($userEmail)
{
    $indexOfAtSymbol = strpos($userEmail, '@');
    $substringBeforeAtSymbol = substr($userEmail, 0, $indexOfAtSymbol);
    $substringBeforeAtSymbol = str_replace('.', '', $substringBeforeAtSymbol);
    $lengthBeforeAtSymbol = strlen($substringBeforeAtSymbol);
    $pattern = '/^(?=.*[0-9]?)(?=.*[a-zA-Z])(?!.*\.{2,})[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*@(gmail\.com|utu\.ac\.in|outlook\.com|yahoo\.com)$/';

    return !(preg_match($pattern, $userEmail) && ($lengthBeforeAtSymbol >= 6 && $lengthBeforeAtSymbol <= 30));
}

// 3. Function to check if a contact number is valid:
function checkContact($userContact)
{
    return !preg_match('/^\d{10}$/', $userContact);
}

// 4. Function to check if a password is valid:
function checkPassword($userPassword)
{
    return !preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!@#$%^&*_])[a-zA-Z0-9!@#$%^&*_]{6,10}$/', $userPassword);
}

// CHECK SONG TITLE VALIDATION
function checkSongTitle($txtSongTitle)
{
    return !preg_match("/^[a-zA-Z0-9.\-+ ()\"\[\]?]{2,}$/", $txtSongTitle);
}

// CHECK ALBUM NAME VALIDATION
function checkAlbumName($txtAlbumName)
{
    return !preg_match("/^[a-zA-Z0-9.:\-+ ()\"]{2,}/", $txtAlbumName);
}
// CHECK ARTIST VALIDATION
function checkArtistName($txtArtistName)
{
    return !preg_match("/^[a-zA-Z0-9., \-&]{2,}/", $txtArtistName);
}

// CHECK DURATION VALIDATION
function checkDuration($txtDuration)
{
    return !preg_match("/^[0-5]?[0-9]:[0-5][0-9]$/", $txtDuration);
}
