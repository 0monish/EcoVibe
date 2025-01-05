<?php
session_start();
include "../dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['dashboardContent'])) {

    $userId = $_SESSION['user_id'];
    $artistsData = $database->getReference('users')->getValue();

    $userKey = array();
    if ($artistsData) {
        $artistscount = 0;
        foreach ($artistsData as $key => $artists) {
            $artistsclaims = $auth->getUser($key)->customClaims;
            if (isset($artistsclaims['artist']) == true) {
                $artistscount++;
            } else {
            }
        }
    }


    $normalUser = $database->getReference('users')->getValue();

    if ($normalUser) {
        $usercount = 0;
        foreach ($normalUser as $key => $user) {
            $userclaims = $auth->getUser($key)->customClaims;
            if ($userclaims == null) {
                $usercount++;
            }
        }
    }

    $totalSongCount = 0;

    $users = $database->getReference('users')->getValue();

    foreach ($users as $userData) {
        if (isset($userData['songs'])) {
            $userSongCount = count($userData['songs']);
            $totalSongCount += $userSongCount;
        }
    }

    // TOTAL PLAYLIST
    $totalPlaylistCount = 0;
    foreach ($users as $userData) {
        if (isset($userData['playlist'])) {
            $userPlaylistCount = count($userData['playlist']);
            $totalPlaylistCount += $userPlaylistCount;
        }
    }

    $userData = $database->getReference("users/$userId")->getValue();
    if (isset($userData['songs'])) {
        $mySongCount = count($userData['songs']);
    }

    if (isset($userData['playlist'])) {
        $myPlaylistCount = count($userData['playlist']);
    }


    // Initialize an array to store the count of each song
    $songCount = [];

    // Iterate over each user's favorite songs
    foreach ($users as $userId => $userData) {
        // Check if the user has favorites
        if (isset($userData['favourites'])) {
            $favorites = $userData['favourites'];

            // Iterate over each favorite song of the current user
            foreach ($favorites as $songId => $count) {
                // Increment the count for the current songId
                if (!isset($songCount[$songId])) {
                    $songCount[$songId] = 0;
                }
                $songCount[$songId] += $count;
            }
        }
    }

    // Find the song with the highest count
    $mostFavoriteSongId = null;
    $mostFavoriteCount = 0;
    foreach ($songCount as $songId => $count) {
        if ($count > $mostFavoriteCount) {
            $mostFavoriteCount = $count;
            $mostFavoriteSongId = $songId;
        }
    }

    // Retrieve the details of the most favorite song
    if ($mostFavoriteSongId) {
        // Retrieve the song details from the 'songs' node
        foreach ($users as $userId => $userData) {
            // Output the most favorite song name

            if (isset($userData['songs'])) {
                $songs = $userData['songs'];
                foreach ($songs as $songId => $favSongData) {
                    if ($songId == $mostFavoriteSongId) {
                        if (isset($favSongData['song_title'])) {
                            $favSongName = $favSongData['song_title'];
                            $albumCover = $favSongData['album_cover_url'];
                        } else {
                            $favSongName = "Unknown";
                        }
                    }
                }
            }
        }
    } else {
        echo "No favorite songs found in the database.";
    }


?>
    <div class="row pt-3">
        <!-- TOTAL SONG COUNT CARD -->
        <div class="col-xxl-4 col-md-4 pt-2">
            <div class="card info-card sales-card bg-success text-dark">
                <div class="card-body">
                    <h5 class="card-title">TOTAL SONGS</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="bookingCount">
                                <?= $totalSongCount ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- USER SONG COUNT CARD -->
        <div class="col-xxl-4 col-md-4 pt-2">
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

        <!-- TOTAL ARTIST COUNT CARD -->
        <div class="col-xxl-4 col-md-4 pt-2">
            <div class="card info-card bg-warning sales-card text-dark">
                <div class="card-body">
                    <h5 class="card-title">ARTISTS</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="artistsCount">
                                <?= $artistscount ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL ECOVIBER COUNT CARD -->
        <div class="col-xxl-4 col-md-4 pt-2">
            <div class="card info-card bg-warning sales-card text-dark">
                <div class="card-body">
                    <h5 class="card-title">ECOVIBERS</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="artistsCount">
                                <?= $usercount ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL PLAYLIST COUNT CARD -->
        <div class="col-xxl-4 col-md-4 pt-2">
            <div class="card info-card bg-primary sales-card text-dark">
                <div class="card-body">
                    <h5 class="card-title">TOTAL PLAYLIST</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="artistsCount">
                                <?= $totalPlaylistCount ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MY PLAYLIST COUNT CARD -->
        <div class="col-xxl-4 col-md-4 pt-2">
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

        <!-- MOST FAVOURITE SONG CARD -->
        <div class="col-xxl-4 col-md-4 pt-2">
            <div class="card info-card sales-card">
                <img src="<?= $albumCover ?>" style="object-fit: cover; width: 70%; height: 70%; border-radius: 30px; opacity: 0.4; " class="card-img" alt="...">
                <div class="card-img-overlay">
                    <h5 class="card-title">MOST FAVOURITE SONG</h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h5 id="fav_song_name">
                                <?= $favSongName ?>
                            </h5>
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