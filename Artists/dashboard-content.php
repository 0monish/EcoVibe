<?php
session_start();
include "../dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['dashboardContent'])) {
 
    $userId = $_SESSION['user_id'];

    $userData = $database->getReference("users/$userId")->getValue();
    if (isset($userData['songs'])) {
        $mySongCount = count($userData['songs']);
    }

    if (isset($userData['playlist'])) {
        $myPlaylistCount = count($userData['playlist']);
    }
    ?>
    <div class="row pt-3">

        <!-- USER SONG COUNT CARD -->
        <div class="col-xxl-4 col-md-4">
            <div class="card info-card sales-card bg-success text-dark">
                <div class="card-body">
                    <h5 class="card-title">MY SONGS</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="bookingCount">
                                <?= $mySongCount ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MY PLAYLIST COUNT CARD -->
        <div class="col-xxl-4 col-md-4">
            <div class="card info-card bg-primary sales-card text-dark">
                <div class="card-body">
                    <h5 class="card-title">MY PLAYLISTS</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="artistsCount">
                                <?= $myPlaylistCount ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['userProfile'])) {
    $userId = $_SESSION['user_id'];

    $userData = $database->getReference("users/$userId")->getValue();
    $user = $auth->getUser($userId);
    $userEmail = $user->email;
    // CHECK IF USER DATA IS FETCHED SUCCESSFULLY
    if ($userData) {
        // PRE-FILL FORM FIELDS WITH USER DATA
        $userName = $userData['user_name']; // PRE-FILL USERNAME FIELD
        $profileImg = $userData['profile_image_url'];
        ?>
            <div class="navbar-profile">
                <img class="img-sm rounded-circle" src="<?= isset($profileImg) ? $profileImg : ''; ?>" alt="logo">
                <p class="mb-0 d-none d-sm-block navbar-profile-name">
                <?= isset($userName) ? $userName : ''; ?>
                </p>
                <i class="mdi mdi-menu-down d-none d-sm-block"></i>
            </div>
    <?php }

}
?>