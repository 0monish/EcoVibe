<?php
session_start();
include "../dbconnect.php";
require_once ('../Assets/validations/Validations.php');

$response = array();

// Function to validate playlist title
// function checkPlaylistTitle($playlistTitle)
// {
//     $playlistTitlePattern = "/^[a-zA-Z0-9.\-+ ()\"\[\]?]{2,}$/";
//     return preg_match($playlistTitlePattern, $playlistTitle);
// }


// if (isset($_POST['btnCreate'])) {
//     if (
//         !empty($_POST['txtPlaylistTitle']) &&
//         !empty($_POST['selLanguage']) &&
//         !empty($_POST['selGenre']) &&
//         !empty($_POST['selMood'])
//     ) {
//         $playlistTitle = $_POST['txtPlaylistTitle'];
//         $language = $_POST['selLanguage'];
//         $genre = $_POST['selGenre'];
//         $mood = $_POST['selMood'];

//         // CHECK SONG TITLE VALIDATION
//         function checkPlaylistTitle($playlistTitle)
//         {
//             $playlistTitlePattern = "/^[a-zA-Z0-9.\-+ ()\"\[\]?]{2,}$/";
//             if (!preg_match($playlistTitlePattern, $playlistTitle)) {
//                 return false;
//             } else {
//                 return true;
//             }
//         }

//         if (!checkPlaylistTitle($playlistTitle)) {
//             // FALSE STATEMENT
//         } else {
//             //TRUE STATEMENT
//         }
//     } else {
//         echo "fill out all fields";
//     }
// }


function fetchSongDetails($songId, $database)
{
    // Get all users' data
    $usersData = $database->getReference("users")->getValue();

    // Iterate over each user's data
    foreach ($usersData as $userId => $userData) {
        // Check if the user has a 'songs' node and if the song ID exists in it
        if (isset($userData['songs']) && isset($userData['songs'][$songId])) {
            // Return the song details if found
            return $userData['songs'][$songId];
        }
    }
    // Return null if the song ID is not found in any user's song data
    return null;
}

// ADDING PLAYLIST FORM
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['add'])) {
    header('Content-Type: text/html; charset=UTF-8');

    ?>
    <div class="content-wrapper">
        <!-- HEADING -->
        <H2>Add Playlist</h2>
        <!-- FORM START -->
        <form id="create_playlist" enctype="multipart/form-data">
            <br>
            <div class="row">
                <!-- DIVISION 1 START HERE -->
                <div class="form-group col-6">
                    <!-- PLAYLIST TITLE-->
                    <label for="txtPlaylistTitle">Playlist Title&nbsp;<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="txtPlaylistTitle" id="txtPlaylistTitle">
                    <span id="playlistTitleError" style="font-size: 13px;"></span>
                    <br />
                    <!-- GENRE -->
                    <LABEL for="inputGenre">Genre&nbsp;<span class="text-danger">*</span></label>
                    <select name="selGenre" class="form-control" id="inputGenre" required>
                        <option hidden>Select Genre</option>
                        <option value="Alternative">Alternative</option>
                        <option value="Bollywood">Bollywood</option>
                        <option value="Folk">Folk</option>
                        <option value="Hip Hop">Hip Hop</option>
                        <option value="Indian Pop">Indian Pop</option>
                        <option value="Kollywood">Kollywood</option>
                        <option value="Pop">Pop</option>
                        <option value="Punjabi">Punjabi</option>
                        <option value="Rock">Rock</option>
                        <option value="Tollywood">Tollywood</option>
                    </select>
                    <span id="genreError" style="font-size: 13px;"></span>
                    <br />
                    <!-- LANGUAGE OF SONG -->
                    <label for="inputLanguage">Language&nbsp;</label>
                    <select name="selLanguage" class="form-control" id="inputLanguage" required>
                        <option hidden>Select Language</option>
                        <option value="Bhojpuri">Bhojpuri</option>
                        <option value="English">English</option>
                        <option value="Gujarati">Gujarati</option>
                        <option value="Hindi">Hindi</option>
                        <option value="Punjabi">Punjabi</option>
                        <option value="Tamil">Tamil</option>
                        <option value="Telugu">Telugu</option>
                    </select>
                    <span id="languageError" style="font-size: 13px;"></span>
                    <br />
                    <!-- PLAYLIST COVER -->
                    <label for="inputPlaylistCover">Playlist Cover&nbsp;<span class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="imgPlaylistCover" id="inputPlaylistCover">
                    <!-- <INPUT type="file" class="form-control file-upload-default" name="imgPlaylistCover"
                        id="inputPlaylistCover">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Playlist Cover">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" name="btnBrowse"
                                type="button">Upload</button>
                        </span>
                    </div> -->
                    <span id="playlistCoverError" style="font-size: 13px;"></span>
                </div>
                <!-- DIVISION 1 END HERE -->

                <!-- DIVISION 2 START HERE -->
                <div class="form-group col-6">
                    <!-- MOOD -->
                    <LABEL for="inputMood">Mood&nbsp;</label>
                    <select name="selMood" class="form-control" id="inputMood" required>
                        <option hidden>Select Mood</option>
                        <option value="Energetic">Energetic</option>
                        <option value="Happy">Happy</option>
                        <option value="Relaxed">Relaxed</option>
                        <option value="Romantic">Romantic</option>
                        <option value="Sad">Sad</option>
                        <option value="Stressed">Stressed</option>
                    </select>
                    <span id="moodError" style="font-size: 13px;"></span>
                    <br />
                </div>
                <!-- DIVISION 2 ENDS HERE -->
            </div>
            <!-- BUTTONS -->
            <INPUT type="submit" name="btnCreate" class="btn btn-outline-danger btn-icon-text" value="Create" disabled>
            <button type="reset" name="btnReset" class="btn btn-outline-warning btn-icon-text" style="margin-left:10px">
                <i class="mdi mdi-reload btn-icon-prepend"></i> Reset </button>
        </form>
    </div>

    <?php
}

// VIEWING PLAYLIST DATA
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['view'])) {
    header('Content-Type: text/html; charset=UTF-8');
    ?>
        <div class="content-wrapper">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Musics to Playlist</h4>

                        <!-- DELETE SONG FROM THE PLAYLIST MODAL -->
                        <div class='modal fade' id='delete_playlist_song'>
                            <div class='modal-dialog modal-dialog-centered'>
                                <div class='modal-content bg-dark'>
                                    <div class='modal-header'>
                                        <h1 class='modal-title text-light fs-5'>
                                            Deleting Record</h1>
                                        <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'
                                            aria-label='Close'></button>
                                    </div>
                                    <form class='delete-playlist-song'>

                                        <div class='modal-body bg-dark'>
                                            <h3>Are you sure to delete the
                                                song ?</h3>
                                            <input type='hidden' name='deleteSongFromPlaylistId'
                                                id="delete_song_from_playlist_id" value=''>
                                            <input type='hidden' name='deletePlaylistSongId' id="delete_playlist_song_id"
                                                value=''>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary'
                                                data-bs-dismiss='modal'>Close</button>
                                            <button type='submit' name='deletePlaylistSong' id="btn_delete_song_from_playlist"
                                                data-bs-target="" data-bs-toggle="modal" class='btn btn-danger'>Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- AVAILABLE SONGS IN THE PLAYLIST MODAL -->
                        <div class='modal fade' id='available_songs'>
                            <div class='modal-dialog modal-lg modal-dialog-centered'>
                                <div class='modal-content bg-dark'>
                                    <div class='modal-header'>
                                        <h1 class='modal-title text-light fs-5'>Add Songs</h1>
                                        <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'
                                            aria-label='Close'></button>
                                    </div>
                                    <form class='add-songs-to-playlist'>
                                        <input type="hidden" name="playlistId" id="playlist_id" value="">
                                        <div class='modal-body bg-dark'
                                            style=" overflow-y: auto; max-height: calc(100vh - 200px);">

                                            <div class="table-responsive">

                                                <table class="table table-striped">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th> No. </th>
                                                            <th> Song Title </th>
                                                            <th> Album </th>
                                                            <th> Artist </th>
                                                            <th> Actions </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        <?php

                                                        if (isset($_SESSION['user_id'])) {
                                                            $userId = $_SESSION['user_id'];

                                                            $usersData = $database->getReference("users")->getValue();
                                                            $count = 1;

                                                            // CHECK IF THERE ARE USERS DATA
                                                            if ($usersData) {
                                                                foreach ($usersData as $userKey => $userData) {
                                                                    // CHECK IF THE USER HAS THE NECESSARY CLAIMS TO ACCESS ADMIN OR ARTIST DATA
                                                                    if (checkUserClaims($userKey, $auth)) {
                                                                        // FETCH SONGS DATA FOR THE CURRENT USER
                                                                        $songsData = isset($userData['songs']) ? $userData['songs'] : [];

                                                                        // LOOP THROUGH SONGS DATA FOR THE CURRENT USER AND DISPLAY IN A TABULAR FORMAT
                                                                        foreach ($songsData as $songKey => $song) {
                                                                            ?>
                                                                            <tr>
                                                                                <td>
                                                                                <?= $count++; ?>
                                                                                </td>
                                                                                <td>
                                                                                <?= $song['song_title']; ?>
                                                                                </td>
                                                                                <td class="ellipsis">
                                                                                <?= $song['album_name']; ?>
                                                                                </td>
                                                                                <td class="ellipsis">
                                                                                <?= $song['artist_name']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="checkbox" value="<?= $songKey; ?>"
                                                                                        name="songIds[]">
                                                                                </td>
                                                                            </tr>
                                                                        <?php
                                                                        }
                                                                    }
                                                                }
                                                            } else {
                                                                echo '<tr><td colspan="4">No songs available</td></tr>';
                                                            }
                                                        } else {
                                                            echo '<tr><td colspan="4">User ID not set</td></tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary'
                                                data-bs-dismiss='modal'>Close</button>
                                            <input type='submit' name='addSongToPlaylist' id="btn_add_song_to_playlist"
                                                data-bs-target="" data-bs-toggle="modal" class='btn btn-danger' value="Add">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            <?php
                            // RETRIEVE PLAYLIST DATA FROM THE DATABASE
                            $artistUID = $_SESSION['user_id'];
                            $artistPlaylist = $database->getReference("users/$artistUID/playlist")->getValue();

                            // CHECK IF THERE ARE PLAYLISTS AVAILABLE
                            if ($artistPlaylist) {

                                // LOOP THROUGH EACH PLAYLIST
                                foreach ($artistPlaylist as $playlistKey => $playlist) {
                                    ?>

                                    <div class="col">

                                        <div class="card" style="height: 14rem; border-radius: 30px 30px 0px 0px; margin-bottom: 60px;">
                                            <a href="#" style="text-decoration:none;" class="text-light" data-bs-toggle="modal"
                                                data-bs-target="#playlist_<?= $playlistKey; ?>">

                                                <!-- PLAYLIST COVER -->
                                                <img src="<?= $playlist['cover_url']; ?>"
                                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: 30px; overflow: hidden;"
                                                    class="card-img-top" alt="...">


                                                <div class="card-body" style="position: relative;">

                                                    <h5 class="card-text text-center"
                                                        style="position: absolute; bottom: 0; left: 0; right: 0;
                                                                    background-color: rgba(0, 0, 0, 0.5); border-radius: 0 0 30px 30px; padding: 10px;">
                                                    <?= $playlist['title']; ?>
                                                    </h5>
                                                    <a href="#"><i class="material-icons"
                                                            style="color:red; position:absolute; margin-left:160px; "
                                                            data-did='<?= $playlistKey; ?>' data-bs-toggle='modal'
                                                            data-bs-target='#delete_<?= $playlistKey; ?>'>remove_circle</i></a>

                                                    <!-- DELETE PLAYLIST MODAL -->
                                                    <div class='modal fade' id='delete_<?= $playlistKey; ?>'>
                                                        <div class='modal-dialog modal-dialog-centered'>
                                                            <div class='modal-content bg-dark'>
                                                                <div class='modal-header'>
                                                                    <h1 class='modal-title text-light fs-5'>Deleting Playlist</h1>
                                                                    <button type='button' class='btn-close btn-close-white'
                                                                        data-bs-dismiss='modal' aria-label='Close'></button>
                                                                </div>
                                                                <form class='delete-playlist'>
                                                                    <input type="hidden" name="deletePlaylistId"
                                                                        value="<?= $playlistKey; ?>">

                                                                    <div class='modal-body bg-dark'>
                                                                        <h3>Are you sure to delete the playlist ?</h3>
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <button type='button' class='btn btn-secondary'
                                                                            data-bs-dismiss='modal'>Close</button>
                                                                        <button type='submit' name='deleteSong'
                                                                            class='btn btn-danger'>Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- VIEW SONGS IN PLAYLIST MODAL -->
                                            <div class='modal fade' id='playlist_<?= $playlistKey; ?>'>
                                                <div class='modal-dialog modal-xl modal-dialog-centered'>
                                                    <div class='modal-content bg-dark'>
                                                        <div class='modal-header'>
                                                            <h3 class='modal-title text-light fs-5'>
                                                            <?= $playlist['title']; ?>
                                                            </h3>

                                                            <button type='button' class='btn-close btn-close-white'
                                                                data-bs-dismiss='modal' aria-label='Close'></button>
                                                        </div>
                                                        <form class='edit-playlist'>
                                                            <div class='modal-body bg-dark' id="<?= $playlistKey; ?>"
                                                                style="overflow-y: auto; max-height: calc(100vh - 200px);">
                                                                <?php

                                                                // FETCH SONG DETAILS FOR THE PLAYLIST
                                                                $commaSeparatedIds = $playlist['song_ids'];
                                                                if (!empty(trim($commaSeparatedIds))) {
                                                                    $songIds = explode(',', $commaSeparatedIds);
                                                                    if (count($songIds) > 0) {
                                                                        ?>
                                                                        <div class="table-responsive">

                                                                            <table class="table table-striped">
                                                                                <thead class="text-center">
                                                                                    <tr>
                                                                                        <th style="width: 0px"> No. </th>
                                                                                        <th> Song Title </th>
                                                                                        <th> Album </th>
                                                                                        <th> Artist </th>
                                                                                        <th> Language </th>
                                                                                        <th> Genre </th>
                                                                                        <th> Mood </th>
                                                                                        <th> Actions </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="text-center">
                                                                                    <?php
                                                                                    $count = 1;
                                                                                    foreach ($songIds as $songId) {
                                                                                        $songDetails = fetchSongDetails($songId, $database);

                                                                                        if ($songDetails) {
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td style="width: 0px">
                                                                                                <?= $count++; ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                <?= $songDetails['song_title']; ?>
                                                                                                </td>
                                                                                                <td class="ellipsis">
                                                                                                <?= $songDetails['album_name']; ?>
                                                                                                </td>
                                                                                                <td class="ellipsis">
                                                                                                <?= $songDetails['artist_name']; ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                <?= $songDetails['language']; ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                <?= $songDetails['genre']; ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                <?= $songDetails['mood']; ?>
                                                                                                </td>


                                                                                                <!-- DELETE MODAL -->
                                                                                                <td>
                                                                                                    <a href="#"><i class="song-id material-icons"
                                                                                                            style="margin-right:0px; color:red;"
                                                                                                            data-song-id='<?= $songId; ?>'
                                                                                                            data-playlist-id='<?= $playlistKey; ?>'
                                                                                                            data-bs-toggle='modal'
                                                                                                            data-bs-target='#delete_playlist_song'>remove_circle</i></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    echo "<p class='text-center text-light'>This playlist is empty.</p>";
                                                                }
                                                                ?>

                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='button' class='playlist-id btn btn-danger'
                                                                    data-bs-toggle='modal' data-bs-target='#available_songs'
                                                                    data-playlist-id='<?= $playlistKey; ?>'>Add
                                                                    Songs</button>
                                                                <button type='submit' name='updatePlaylist'
                                                                    class='btn btn-danger'>Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                            } else {
                                // NO PLAYLISTS AVAILABLE
                                echo '<div class="col-12"><p class="text-center">No playlists available for the artist</p></div>';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

// CREATING PLAYLIST
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnCreate'])) {
    header('Content-Type: application/json; charset=UTF-8');

    $uid = $_SESSION['user_id'];
    extract($_POST);
    // UPLOAD PLAYLIST COVER TO FIREBASE STORAGE
    $imgFileName = $_FILES['imgPlaylistCover']['name'];
    $imgFileTmpName = $_FILES['imgPlaylistCover']['tmp_name'];

    // DEFINE A UNIQUE NAME FOR THE FILE IN FIREBASE STORAGE
    $uniqueImgFileName = 'playlist_covers/' . $uid . "/" . $imgFileName;
    // UPLOAD THE FILE TO FIREBASE STORAGE
    $uploadedFile = fopen($imgFileTmpName, 'r');

    $storageBucket = $storage->getBucket();

    $storageBucket->upload($uploadedFile, [
        'name' => $uniqueImgFileName
    ]);

    $object = $storageBucket->object($uniqueImgFileName); // GET THE URL OF THE UPLOADED FILE
    $url = $object->signedUrl(new \DateTime('2025-12-31')); // SET EXPIRY DATE OF THE IMAGE URL

    // DEFINE PLAYLIST DATA
    $playlistDetails = [
        'title' => $txtPlaylistTitle,
        'genre' => $selGenre,
        'language' => $selLanguage,
        'mood' => $selMood,
        'cover_name' => $imgFileName,
        'cover_url' => $url,
        'song_ids' => ""
    ];
    // $playlistCountRef = $database->getReference('users/' . $uid . '/playlist')->getSnapshot()->numChildren();

    // // GENERATE THE KEY FOR THE NEW PLAYLIST
    // $playlistID = strval($playlistCountRef); // CONVERT THE COUNT TO STRING TO USE IT AS THE KEY

    // INSERT THE PLAYLIST DETAILS UNDER THE USER NODE WITH THE GENERATED KEY
    $executed = $database->getReference('users/' . $uid . '/playlist')->push($playlistDetails);

    if ($executed) {
        $response['success'] = "Playlist added Successfully";
    } else {
        $response['error'] = "Playlist not added Successfully";
    }
    echo json_encode($response);
}

// DELETING THE PLAYLIST 
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['deletePlaylistId'])) {

    header('Content-Type: application/json; charset=UTF-8');

    extract($_GET);
    $userId = $_SESSION['user_id'];

    $playlistRef = $database->getReference("users/$userId/playlist/$deletePlaylistId");
    $playlistDetails = $playlistRef->getValue();

    if ($playlistDetails) {
        // EXTRACT THE FILE NAME FROM THE SONG DETAILS
        $coverName = $playlistDetails['cover_name'];
        // CONSTRUCT THE FILE PATH IN FIREBASE STORAGE
        $coverFilePath = "playlist_covers/$userId/$coverName";

        // RETRIEVE THE FILE OBJECT
        $coverFile = $storage->getBucket()->object($coverFilePath);
        // DELETE THE FILE FROM FIREBASE STORAGE
        $coverFile->delete();

        if ($playlistRef->remove()) {
            $response['success'] = "Playlist Deleted.";
        } else {
            $response['error'] = "Error in deletion";
        }
    }
    echo json_encode($response);
}

// ADDING SONG TO THE PLAYLIST
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addSongToPlaylist'])) {
    header('Content-Type: application/json; charset=UTF-8');
    if (isset($_SESSION['user_id'])) {
        extract($_POST);

        $userId = $_SESSION['user_id'];

        // Fetch existing song IDs from the playlist
        $existingSongIds = $database->getReference("users/$userId/playlist/$playlistId/song_ids")->getValue();

        // If existing song IDs exist, merge them with the new song IDs
        if ($existingSongIds) {
            $existingSongIdsArray = explode(',', $existingSongIds);
            $combinedSongIds = array_unique(array_merge($existingSongIdsArray, $songIds));
            $commaSeparatedSongIds = implode(',', $combinedSongIds);
        } else {
            // If no existing song IDs, simply use the new song IDs
            $commaSeparatedSongIds = implode(',', $songIds);
        }

        // Update the playlist with the combined song IDs
        $database->getReference("users/$userId/playlist/$playlistId/song_ids")->set($commaSeparatedSongIds);

        $response['success'] = "Songs added to playlist.";
    } else {
        $response['error'] = "User ID not set";
    }
    echo json_encode($response);
}

// DELETING SONG FROM THE PLAYLIST
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletePlaylistSong'])) {
    header('Content-Type: application/json; charset=UTF-8');
    if (isset($_SESSION['user_id'])) {
        extract($_POST);

        $userId = $_SESSION['user_id'];

        // CHECK IF PLAYLIST ID IS PROVIDED
        if (isset($deleteSongFromPlaylistId)) {

            $playlistRef = $database->getReference("users/$userId/playlist/$deleteSongFromPlaylistId");
            $playlist = $playlistRef->getValue();

            // CHECK IF THE PLAYLIST EXISTS AND 'song_ids' IS SET
            if ($playlist && isset($playlist['song_ids'])) {

                // FETCH THE EXISTING song_ids STRING FROM YOUR DATABASE
                $commaSeparatedIds = $playlist['song_ids'];

                // SPLIT THE COMMA-SEPARATED STRING INTO AN ARRAY OF SONG IDS
                $songIds = explode(',', $commaSeparatedIds);

                // REMOVE THE SPECIFIC SONG ID FROM THE ARRAY IF IT EXISTS
                $key = array_search($deletePlaylistSongId, $songIds);
                if ($key !== false) {
                    unset($songIds[$key]);
                }

                // JOIN THE REMAINING SONG IDS BACK INTO A COMMA-SEPARATED STRING
                $updatedSongIds = implode(',', $songIds);

                // UPDATE THE song_ids FIELD IN YOUR DATABASE WITH THE MODIFIED STRING
                $playlistRef->update(['song_ids' => $updatedSongIds]);

                $response['success'] = "Song removed from the playlist.";
            } else {
                $response['error'] = "Playlist not found or song_ids not set.";
            }
        } else {
            $response['error'] = "Playlist ID not provided.";
        }
    } else {
        $response['error'] = "User ID not set";
    }
    echo json_encode($response);
}

// AJAX UPDATE PLAYLIST DATA FOR PARTICULAR PLAYLIST 
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['playlistIdAjaxUpdate'])) {
    header('Content-Type: text/html; charset=UTF-8');
    if (isset($_SESSION['user_id'])) {
        extract($_GET);

        $userId = $_SESSION['user_id'];

        $playlistRef = $database->getReference("users/$userId/playlist/$playlistIdAjaxUpdate");
        $playlist = $playlistRef->getValue();
        // CHECK IF THE PLAYLIST EXISTS AND 'song_ids' IS SET
        if ($playlist) {

            $commaSeparatedIds = $playlist['song_ids'];
            if (!empty(trim($commaSeparatedIds))) {
                $songIds = explode(',', $commaSeparatedIds);
                if (count($songIds) > 0) {
                    ?>
                                            <div class="table-responsive">

                                                <table class="table table-striped">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th style="width: 0px"> No. </th>
                                                            <th> Song Title </th>
                                                            <th> Album </th>
                                                            <th> Artist </th>
                                                            <th> Language </th>
                                                            <th> Genre </th>
                                                            <th> Mood </th>
                                                            <th> Actions </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                    <?php
                                    $count = 1;

                                    foreach ($songIds as $songId) {
                                        $songDetails = fetchSongDetails($songId, $database);

                                        if ($songDetails) {
                                            ?>
                                                                <tr>
                                                                    <td style="width: 0px">
                                                <?= $count++; ?>
                                                                    </td>
                                                                    <td>
                                                <?= $songDetails['song_title']; ?>
                                                                    </td>
                                                                    <td class="ellipsis">
                                                <?= $songDetails['album_name']; ?>
                                                                    </td>
                                                                    <td class="ellipsis">
                                                <?= $songDetails['artist_name']; ?>
                                                                    </td>
                                                                    <td>
                                                <?= $songDetails['language']; ?>
                                                                    </td>
                                                                    <td>
                                                <?= $songDetails['genre']; ?>
                                                                    </td>
                                                                    <td>
                                                <?= $songDetails['mood']; ?>
                                                                    </td>


                                                                    <!-- DELETE MODAL -->
                                                                    <td>
                                                                        <a href="#"><i class="song-id material-icons" style="margin-right:0px; color:red;"
                                                                                data-song-id='<?= $songId; ?>' data-playlist-id='<?= $playlistIdAjaxUpdate; ?>'
                                                                                data-bs-toggle='modal' data-bs-target='#delete_playlist_song'>remove_circle</i></a>
                                                                    </td>
                                                                </tr>
                                        <?php
                                        }
                                    }
                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                    <?php
                }
            } else {
                echo "<p class='text-center text-light'>This playlist is empty.</p>";
            }
        } else {
            $response['error'] = "Playlist not found or song_ids not set.";
        }

    } else {
        $response['error'] = "User ID not set";
    }
    // echo json_encode($response);
}

// SOMETHING WENT WRONG
else {
    header('Content-Type: application/json; charset=UTF-8');

    $response['error'] = "Something went wrong";
    echo json_encode($response);
}
?>