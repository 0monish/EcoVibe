<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;


$factory = (new Factory)->withServiceAccount('../firebase_credentials.json')
    ->withDatabaseUri('https://ecovibe-e777e-default-rtdb.firebaseio.com/');

// INITIALIZING THE REALTIME DATABASE 
$database = $factory->createDatabase();
$auth = $factory->createAuth();
$storage = $factory->createStorage();

function checkUserClaims($userId,$auth) {
    $claims = $auth->getUser($userId)->customClaims;
    return (isset($claims['admin']) == true || isset($claims['artist']) == true);
}