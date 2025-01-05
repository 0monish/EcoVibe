<?php
session_start();
include "../dbconnect.php";
require_once ('../Assets/validations/Validations.php');

$response = array();

// ADDING SONG FORM
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['add'])) {
    header('Content-Type: text/html; charset=UTF-8');
    ?>
    <div class="content-wrapper">
        <!-- HEADING -->
        <h2>Make your Library Bigger</h2>
        <!-- FORM START -->
        <form id="add-song-details" enctype="multipart/form-data">
            <br>
            <div class="row">
                <!-- DIVISION 1 START HERE -->
                <div class="form-group col-6">

                    <!-- SONG TITLE-->
                    <label for="txtSongTitle">Song Title&nbsp;<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="txtSongTitle" id="txtSongTitle">
                    <span id="songTitleError" style="font-size: 13px;"></span>
                    <br />

                    <!-- ARTIST NAME -->
                    <label for="txtArtistName">Artist Name&nbsp;<span class="text-danger">*</span></label>
                    <input type="text" name="txtArtistName" class="form-control" id="txtArtistName">
                    <span id="artistNameError" style="font-size: 13px;"></span>
                    <br />

                    <!-- GENRE -->
                    <label for="inputGenre">Genre&nbsp;<span class="text-danger">*</span></label>
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

                    <!-- DURATION OF SONG -->
                    <label for="inputDuration">Duration&nbsp;<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="txtDuration" id="inputDuration"
                        oninput="this.value = this.value.replace(/[^0-9:]/g, '')">
                    <span id="durationError" style="font-size: 13px;"></span>
                    <br />

                    <!-- LANGUAGE OF SONG -->
                    <label for="inputLanguage">Language&nbsp;<span class="text-danger">*</span></label>
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

                    <!-- ALBUM COVER -->
                    <label for="inputAlbumCover" class="form-label">Album Cover&nbsp;<span
                            class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="albumCover" id="inputAlbumCover">
                    <!-- <label for="inputAlbumCover">Album Cover&nbsp;<span class="text-danger">*</span></label>
                                <input type="file" class="form-control file-upload-default" name="albumCover"
                                    id="inputAlbumCover">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Album Cover">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" name="btnBrowse"
                                            type="button">Upload</button>
                                    </span>
                                </div> -->
                    <span id="albumCoverError" style="font-size: 13px;"></span>
                </div>
                <!-- DIVISION 1 END HERE -->

                <!-- DIVISION 2 START HERE -->
                <div class="form-group col-6">

                    <!-- ALBUM NAME -->
                    <label for="txtAlbumName">Album Name&nbsp;<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="txtAlbumName" id="txtAlbumName">
                    <span id="albumNameError" style="font-size: 13px;"></span>
                    <br />

                    <!-- MOOD -->
                    <label for="inputMood">Mood&nbsp;<span class="text-danger">*</span></label>
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

                    <!-- RELEASE DATE -->
                    <label for="inputReleaseDate">Release Date&nbsp;<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="dateReleaseDate" id="inputReleaseDate">
                    <span id="releaseDateError" style="font-size: 13px;"></span>
                    <br />

                    <!-- UPLOAD SONG -->
                    <label for="inputSongFile" class="form-label">Upload Song&nbsp;<span
                            class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="songFile" id="inputSongFile">
                    <span id="songFileError" style="font-size: 13px;"></span>
                    <br />

                    <!-- UPLOAD SONG LYRICS -->
                    <label for="inputSongLrc" class="form-label">Upload Song Lyrics&nbsp;<span
                            class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="songLrcFile" id="inputSongLrc">
                    <span id="songLrcFileError" style="font-size: 13px;"></span>
                    <!-- <label for="inputSongFile">Upload Song&nbsp;<span class="text-danger">*</span></label>
                                <input type="file" class="form-control file-upload-default" name="songFile"
                                    id="inputSongFile">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Upload Song">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" name="" type="button">Upload</button>
                                    </span>
                                </div> -->
                </div>
                <!-- DIVISION 2 ENDS HERE -->
            </div>

            <!-- BUTTONS -->
            <input type="submit" name="btnUpload" class="btn btn-outline-danger btn-icon-text" value="Upload" disabled>
            <!-- <i class="mdi mdi-upload btn-icon-prepend"></i> Upload </button> -->
            <button type="reset" name="btnReset" class="btn btn-outline-warning btn-icon-text" style="margin-left:0px">
                <i class="mdi mdi-reload btn-icon-prepend"></i> Reset </button>
        </form>
    </div>
    <?php
}

// VIEWING SONG DATA
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['view'])) {
    header('Content-Type: text/html; charset=UTF-8');
    ?>

        <div class="content-wrapper">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Striped Table</h4>
                    <p class="card-description"> Add class <code>.table-striped</code> -->
                        </p>
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

                                    $adminUid = $_SESSION['user_id'];

                                    $adminSongsData = $database->getReference("users/$adminUid/songs")->getValue();

                                    if ($adminSongsData) {
                                        $count = 1;
                                        foreach ($adminSongsData as $key => $song) {
                                            ?>
                                            <tr>
                                                <td style="width: 0px">
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
                                                <?= $song['language']; ?>
                                                </td>
                                                <td>
                                                <?= $song['genre']; ?>
                                                </td>
                                                <td>
                                                <?= $song['mood']; ?>
                                                </td>


                                                <!-- DELETE MODAL -->
                                                <td>
                                                    <a href="#"><i class="material-icons" style="margin-right:0px; color:red;"
                                                            data-did='<?= $key; ?>' data-bs-toggle='modal'
                                                            data-bs-target='#delete_<?= $key; ?>'>remove_circle</i></a>

                                                    <div class='modal fade' id='delete_<?= $key; ?>'>
                                                        <div class='modal-dialog modal-dialog-centered'>
                                                            <div class='modal-content bg-dark'>
                                                                <div class='modal-header'>
                                                                    <h1 class='modal-title text-light fs-5'>Deleting Record</h1>
                                                                    <button type='button' class='btn-close btn-close-white'
                                                                        data-bs-dismiss='modal' aria-label='Close'></button>
                                                                </div>
                                                                <form class='delete'>
                                                                    <input type='hidden' name='deleteSongId' value='<?= $key; ?>'>

                                                                    <div class='modal-body bg-dark'>
                                                                        <h3 class="text-light">Are you sure to delete the song ?</h3>
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

                                                    <!-- UPDATE MODAL -->
                                                    <a href="#"><i class="material-icons" style="margin-right:0px; color:green;"
                                                            data-eid='<?= $key; ?>' data-bs-toggle='modal'
                                                            data-bs-target='#update_<?= $key; ?>'>create</i></a>

                                                    <div class='modal fade' id='update_<?= $key; ?>'>
                                                        <div class='modal-dialog modal-dialog-centered'>
                                                            <div class='modal-content'>
                                                                <div class='modal-header'>
                                                                    <h3 class='modal-title text-light fs-5 text-center'
                                                                        id='staticBackdropLabel'>Update Song Record</h3>
                                                                    <button type='button' class='btn-close btn-close-white'
                                                                        data-bs-dismiss='modal' aria-label='Close'></button>
                                                                </div>

                                                                <form class='update-song-details' enctype="multipart/form-data">

                                                                    <!-- Hidden input field to store the current filename of the album cover -->
                                                                    <input type="hidden" name="songId" value="<?= $key ?>">

                                                                    <div class='modal-body bg-dark'>
                                                                        <div class="row">
                                                                            <!-- DIVISION 1 START HERE -->
                                                                            <div class="form-group col-6">
                                                                                <!-- SONG TITLE-->
                                                                                <label for="txtSongTitle">Song Title&nbsp;<span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control"
                                                                                    name="txtSongTitle" id="txtSongTitle"
                                                                                    value="<?= $song['song_title']; ?>">
                                                                                <span id="songTitleError"
                                                                                    style="font-size: 13px;"></span>
                                                                                <br />
                                                                                <!-- ARTIST NAME -->
                                                                                <label for="txtArtistName">Artist Name&nbsp;<span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text" name="txtArtistName"
                                                                                    class="form-control" id="txtArtistName"
                                                                                    value="<?= $song['artist_name']; ?>">
                                                                                <span id="artistNameError"
                                                                                    style="font-size: 13px;"></span>
                                                                                <br />
                                                                                <!-- GENRE -->
                                                                                <label for="inputGenre">Genre&nbsp;<span
                                                                                        class="text-danger">*</span></label>
                                                                                <select name="selGenre" class="form-control"
                                                                                    id="inputGenre" value="<?= $song['genre']; ?>"
                                                                                    required>
                                                                                    <option hidden>Select Genre</option>
                                                                                    <option value="Alternative"
                                                                                    <?= ($song['genre'] == 'Alternative') ? 'selected' : '' ?>>Alternative</option>
                                                                                    <option value="Bollywood"
                                                                                    <?= ($song['genre'] == 'Bollywood') ? 'selected' : '' ?>>Bollywood</option>
                                                                                    <option value="Folk" <?= ($song['genre'] == 'Folk') ? 'selected' : '' ?>>Folk</option>
                                                                                    <option value="Hip Hop" <?= ($song['genre'] == 'Hip Hop') ? 'selected' : '' ?>>Hip Hop</option>
                                                                                    <option value="Indian Pop"
                                                                                    <?= ($song['genre'] == 'Indian Pop') ? 'selected' : '' ?>>Indian Pop</option>
                                                                                    <option value="Kollywood"
                                                                                    <?= ($song['genre'] == 'Kollywood') ? 'selected' : '' ?>>Kollywood</option>
                                                                                    <option value="Pop" <?= ($song['genre'] == 'Pop') ? 'selected' : '' ?>>Pop</option>
                                                                                    <option value="Punjabi"
                                                                                    <?= ($song['genre'] == 'Punjabi') ? 'selected' : '' ?>>Punjabi</option>
                                                                                    <option value="Rock" <?= ($song['genre'] == 'Rock') ? 'selected' : '' ?>>Rock</option>
                                                                                    <option value="Tollywood"
                                                                                    <?= ($song['genre'] == 'Tollywood') ? 'selected' : '' ?>>Tollywood</option>
                                                                                </select>
                                                                                <span id="genreError" style="font-size: 13px;"></span>
                                                                                <br />

                                                                                <!-- DURATION OF SONG -->
                                                                                <label for="inputDuration">Duration&nbsp;<span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control"
                                                                                    name="txtDuration" id="inputDuration"
                                                                                    value="<?= $song['duration']; ?>"
                                                                                    oninput="this.value = this.value.replace(/[^0-9:]/g, '')">
                                                                                <span id="durationError"
                                                                                    style="font-size: 13px;"></span>
                                                                                <br />

                                                                                <!-- LANGUAGE OF SONG -->
                                                                                <label for="inputLanguage">Language&nbsp;<span
                                                                                        class="text-danger">*</span></label>
                                                                                <select name="selLanguage" class="form-control"
                                                                                    id="inputLanguage" required>
                                                                                    <option hidden>Select Language</option>
                                                                                    <option value="Bhojpuri"
                                                                                    <?= ($song['language'] == 'Bhojpuri') ? 'selected' : ''; ?>>Bhojpuri</option>
                                                                                    <option value="English"
                                                                                    <?= ($song['language'] == 'English') ? 'selected' : ''; ?>>English</option>
                                                                                    <option value="Gujarati"
                                                                                    <?= ($song['language'] == 'Gujarati') ? 'selected' : ''; ?>>Gujarati</option>
                                                                                    <option value="Hindi"
                                                                                    <?= ($song['language'] == 'Hindi') ? 'selected' : ''; ?>>Hindi</option>
                                                                                    <option value="Punjabi"
                                                                                    <?= ($song['language'] == 'Punjabi') ? 'selected' : ''; ?>>Punjabi</option>
                                                                                    <option value="Tamil"
                                                                                    <?= ($song['language'] == 'Tamil') ? 'selected' : ''; ?>>Tamil</option>
                                                                                    <option value="Telugu"
                                                                                    <?= ($song['language'] == 'Telugu') ? 'selected' : ''; ?>>Telugu</option>
                                                                                </select>
                                                                                <span id="languageError"
                                                                                    style="font-size: 13px;"></span>
                                                                                <br />

                                                                            </div>
                                                                            <!-- DIVISION 1 END HERE -->

                                                                            <!-- DIVISION 2 START HERE -->
                                                                            <div class="form-group col-6">
                                                                                <!-- ALBUM COVER -->

                                                                                <label for="inputAlbumCover" class="form-label">Album
                                                                                    Cover&nbsp;<span class="text-danger">*</span>
                                                                                    <input type="checkbox" name="checkAlbumCover"
                                                                                        value="check"> Update Album Cover
                                                                                </label>

                                                                                <input class="form-control" type="file"
                                                                                    name="albumCover" id="inputAlbumCover">

                                                                                <span id="albumCoverError"
                                                                                    style="font-size: 13px;"></span>
                                                                                <br />
                                                                                <!-- ALBUM NAME -->
                                                                                <label for="txtAlbumName">Album Name&nbsp;<span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control"
                                                                                    name="txtAlbumName" id="txtAlbumName"
                                                                                    value="<?= $song['album_name']; ?>">
                                                                                <span id="albumNameError"
                                                                                    style="font-size: 13px;"></span>
                                                                                <br />
                                                                                <!-- MOOD -->
                                                                                <label for="inputMood">Mood&nbsp;<span
                                                                                        class="text-danger">*</span></label>
                                                                                <select name="selMood" class="form-control"
                                                                                    id="inputMood" required>
                                                                                    <option hidden>Select Mood</option>
                                                                                    <option value="Energetic"
                                                                                    <?= ($song['mood'] == 'Energetic') ? 'selected' : ''; ?>>Energetic</option>
                                                                                    <option value="Happy" <?= ($song['mood'] == 'Happy') ? 'selected' : ''; ?>>Happy</option>
                                                                                    <option value="Relaxed"
                                                                                    <?= ($song['mood'] == 'Relaxed') ? 'selected' : ''; ?>>Relaxed</option>
                                                                                    <option value="Sad" <?= ($song['mood'] == 'Sad') ? 'selected' : '' ?>>Sad</option>
                                                                                    <option value="Romantic"
                                                                                    <?= ($song['mood'] == 'Romantic') ? 'selected' : ''; ?>>Romantic</option>
                                                                                    <option value="Sad" <?= ($song['mood'] == 'Sad') ? 'selected' : ''; ?>>Sad</option>
                                                                                    <option value="Stressed"
                                                                                    <?= ($song['mood'] == 'Stressed') ? 'selected' : ''; ?>>Stressed</option>
                                                                                </select>
                                                                                <span id="moodError" style="font-size: 13px;"></span>
                                                                                <br />
                                                                                <!-- RELEASE DATE -->
                                                                                <label for="inputReleaseDate">Release Date&nbsp;<span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="date" class="form-control"
                                                                                    name="dateReleaseDate" id="inputReleaseDate"
                                                                                    value="<?= $song['release_date']; ?>">
                                                                                <span id="releaseDateError"
                                                                                    style="font-size: 13px;"></span>
                                                                                <br />
                                                                                <!-- UPLOAD SONG -->
                                                                                <label for="inputSongFile" class="form-label">Upload
                                                                                    Song&nbsp;<span class="text-danger">*</span></label>
                                                                                <input class="form-control" type="file" name="songFile"
                                                                                    id="inputSongFile">
                                                                                <span id="songFileError"
                                                                                    style="font-size: 13px;"></span>
                                                                                <br />

                                                                                <!-- UPLOAD SONG LYRICS -->
                                                                                <label for="inputSongLrc" class="form-label">Upload Song
                                                                                    Lyrics&nbsp;<span
                                                                                        class="text-danger">*</span></label>
                                                                                <input class="form-control" type="file"
                                                                                    name="songLrcFile" id="inputSongLrc">
                                                                                <span id="songLrcFileError"
                                                                                    style="font-size: 13px;"></span>
                                                                            </div>
                                                                            <!-- DIVISION 2 END HERE -->
                                                                        </div>
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <button type='button' class='btn btn-secondary'
                                                                            data-bs-dismiss='modal'>Close</button>
                                                                        <button type='submit' name='updateSong'
                                                                            class='btn btn-primary'>Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="9">No songs available for the artist</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

// UPLOADING SONG
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnUpload'])) {
    header('Content-Type: application/json; charset=UTF-8');

    extract($_POST);

    if (checkSongTitle($txtSongTitle)) {
        $response['error'] = "Enter valid song title.";
    } else if (checkAlbumName($txtAlbumName)) {
        $response['error'] = "Enter valid album name.";
    } else if (checkArtistName($txtArtistName)) {
        $response['error'] = "Enter valid artist name.";
    } else if (checkDuration($txtDuration)) {
        $response['error'] = "Enter valid duration.";
    } else {
        try {
            if (isset($_FILES['albumCover']) && isset($_FILES['songFile'])) {
                $uid = $_SESSION['user_id'];

                $albumCoverName = $_FILES['albumCover']['name'];
                $albumCoverType = $_FILES['albumCover']['type'];
                $albumCoverTmpName = $_FILES['albumCover']['tmp_name'];
                $albumCoverSize = $_FILES['albumCover']['size'];

                $songFileName = $_FILES['songFile']['name'];
                $songFileType = $_FILES['songFile']['type'];
                $songFileTmpName = $_FILES['songFile']['tmp_name'];
                $songFileSize = $_FILES['songFile']['size'];

                $songLrcFileName = $_FILES['songLrcFile']['name'];
                $songLrcFileType = $_FILES['songLrcFile']['type'];
                $songLrcFileTmpName = $_FILES['songLrcFile']['tmp_name'];
                $songLrcFileSize = $_FILES['songLrcFile']['size'];

                // DEFINE A UNIQUE NAME FOR THE FILE IN FIREBASE STORAGE
                $albumCoverPath = "album_covers/$uid/$albumCoverName";
                $songFilePath = "songs/$uid/$songFileName";
                $songLrcFilePath = "lyrics/$uid/$songLrcFileName";

                $storageBucket = $storage->getBucket();
                // UPLOAD THE FILE TO FIREBASE STORAGE
                $storageBucket->upload(fopen($albumCoverTmpName, 'r'), [
                    'name' => $albumCoverPath
                ]);

                $storageBucket->upload(fopen($songFileTmpName, 'r'), [
                    'name' => $songFilePath
                ]);

                $storageBucket->upload(fopen($songLrcFileTmpName, 'r'), [
                    'name' => $songLrcFilePath
                ]);

                $imageFile = $storageBucket->object($albumCoverPath); // GET THE URL OF THE UPLOADED FILE
                $imageFileURL = $imageFile->signedUrl(new \DateTime('2025-12-31')); // SET EXPIRY DATE OF THE IMAGE URL

                $songFile = $storageBucket->object($songFilePath); // GET THE URL OF THE UPLOADED FILE
                $songFileURL = $songFile->signedUrl(new \DateTime('2025-12-31')); // SET EXPIRY DATE OF THE IMAGE URL

                $songLrcFile = $storageBucket->object($songLrcFilePath); // GET THE URL OF THE UPLOADED FILE
                $songLrcFileURL = $songLrcFile->signedUrl(new \DateTime('2025-12-31')); // SET EXPIRY DATE OF THE IMAGE URL

                $addSongDetails = [
                    'album_cover_name' => $albumCoverName,
                    'album_cover_url' => $imageFileURL,
                    'artist_name' => $txtArtistName,
                    'album_name' => $txtAlbumName,
                    'duration' => $txtDuration,
                    'genre' => $selGenre,
                    'language' => $selLanguage,
                    'mood' => $selMood,
                    'release_date' => $dateReleaseDate,
                    'song_file_name' => $songFileName,
                    'song_file_url' => $songFileURL,
                    'song_lrc_file_name' => $songLrcFileName,
                    'song_lrc_file_url' => $songLrcFileURL,
                    'song_stream_count' => 0 ,
                    'song_title' => $txtSongTitle
                ];

                $executed = $database->getReference("users/$uid/songs")->push($addSongDetails);
                if ($executed) {
                    $response['success'] = "Music added Successfully";
                } else {
                    $response['error'] = "Music not added Successfully";
                }
            }
        } catch (\Execption $e) {
            $response['error'] = $e->getMessage();
        }
    }
    echo json_encode($response);
}

// UPDATING SONG DETAILS
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateSong'])) {

    header('Content-Type: application/json; charset=UTF-8');

    extract($_POST);

    // Validating form inputs
    if (checkSongTitle($txtSongTitle)) {
        $response['error'] = "Enter valid song title.";
    } else if (checkAlbumName($txtAlbumName)) {
        $response['error'] = "Enter valid album name.";
    } else if (checkArtistName($txtArtistName)) {
        $response['error'] = "Enter valid artist name.";
    } else if (checkDuration($txtDuration)) {
        $response['error'] = "Enter valid duration.";
    } else {
        try {
            if (isset($_FILES['albumCover']) && isset($_FILES['songFile'])) {
                $uid = $_SESSION['user_id'];

                // DELETING OLD SONG FILES AND ALBUM COVER FROM STORAGE 
                $songRef = $database->getReference("users/$uid/songs/$songId");
                $songDetails = $songRef->getValue();

                if ($songDetails) {
                    // EXTRACT THE FILE NAME FROM THE SONG DETAILS
                    $imageFileName = $songDetails['album_cover_name'];
                    $songFileName = $songDetails['song_file_name'];
                    // $songLrcFileName = $songDetails['song_lrc_file_name'];

                    // CONSTRUCT THE FILE PATH IN FIREBASE STORAGE
                    $imageFilePath = "album_covers/$uid/$imageFileName";
                    $songFilePath = "songs/$uid/$songFileName";
                    // $songLrcFilePath = "lyrics/$uid/$songLrcFileName";

                    // RETRIEVE THE FILE OBJECT
                    $imageFile = $storage->getBucket()->object($imageFilePath);
                    $songFile = $storage->getBucket()->object($songFilePath);
                    // $songLrcFile = $storage->getBucket()->object($songLrcFilePath);

                    // DELETE THE FILE FROM FIREBASE STORAGE
                    $imageFile->delete();
                    $songFile->delete();
                    // $songLrcFile->delete();
                }

                $albumCoverName = $_FILES['albumCover']['name'];
                $albumCoverType = $_FILES['albumCover']['type'];
                $albumCoverTmpName = $_FILES['albumCover']['tmp_name'];
                $albumCoverSize = $_FILES['albumCover']['size'];

                $songFileName = $_FILES['songFile']['name'];
                $songFileType = $_FILES['songFile']['type'];
                $songFileTmpName = $_FILES['songFile']['tmp_name'];
                $songFileSize = $_FILES['songFile']['size'];

                $songLrcFileName = $_FILES['songLrcFile']['name'];
                $songLrcFileType = $_FILES['songLrcFile']['type'];
                $songLrcFileTmpName = $_FILES['songLrcFile']['tmp_name'];
                $songLrcFileSize = $_FILES['songLrcFile']['size'];

                // DEFINE A UNIQUE NAME FOR THE FILE IN FIREBASE STORAGE
                $albumCoverPath = "album_covers/$uid/$albumCoverName";
                $songFilePath = "songs/$uid/$songFileName";
                $songLrcFilePath = "lyrics/$uid/$songLrcFileName";

                $storageBucket = $storage->getBucket();
                // UPLOAD THE FILE TO FIREBASE STORAGE
                $storageBucket->upload(fopen($albumCoverTmpName, 'r'), [
                    'name' => $albumCoverPath
                ]);

                $storageBucket->upload(fopen($songFileTmpName, 'r'), [
                    'name' => $songFilePath
                ]);

                $storageBucket->upload(fopen($songLrcFileTmpName, 'r'), [
                    'name' => $songLrcFilePath
                ]);

                $imageFile = $storageBucket->object($albumCoverPath); // GET THE URL OF THE UPLOADED FILE
                $imageFileURL = $imageFile->signedUrl(new \DateTime('2025-12-31')); // SET EXPIRY DATE OF THE IMAGE URL

                $songFile = $storageBucket->object($songFilePath); // GET THE URL OF THE UPLOADED FILE
                $songFileURL = $songFile->signedUrl(new \DateTime('2025-12-31')); // SET EXPIRY DATE OF THE IMAGE URL

                $songLrcFile = $storageBucket->object($songLrcFilePath); // GET THE URL OF THE UPLOADED FILE
                $songLrcFileURL = $songLrcFile->signedUrl(new \DateTime('2025-12-31')); // SET EXPIRY DATE OF THE IMAGE URL

                $updatedSongDetails = [
                    'album_cover_name' => $albumCoverName,
                    'album_cover_url' => $imageFileURL,
                    'artist_name' => $txtArtistName,
                    'album_name' => $txtAlbumName,
                    'duration' => $txtDuration,
                    'genre' => $selGenre,
                    'language' => $selLanguage,
                    'mood' => $selMood,
                    'release_date' => $dateReleaseDate,
                    'song_file_name' => $songFileName,
                    'song_file_url' => $songFileURL,
                    'song_lrc_file_name' => $songLrcFileName,
                    'song_lrc_file_url' => $songLrcFileURL,
                    'song_title' => $txtSongTitle
                ];

                // Update song details in the database
                $executed = $database->getReference("users/$uid/songs/$songId")->update($updatedSongDetails);
                if ($executed) {
                    $response['success'] = "Music updated Successfully";
                } else {
                    $response['error'] = "Music not updated Successfully";
                }
            }
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
        }
    }
    echo json_encode($response);
}

// DELETING SONG
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['deleteSongId'])) {
    header('Content-Type: application/json; charset=UTF-8');

    $songId = $_GET['deleteSongId'];
    $userId = $_SESSION['user_id'];

    try {
        // GET THE SONG DETAILS INCLUDING THE FILE NAME FROM THE REALTIME DATABASE
        $songRef = $database->getReference("users/$userId/songs/$songId");
        $songDetails = $songRef->getValue();

        if ($songDetails) {
            // EXTRACT THE FILE NAME FROM THE SONG DETAILS
            $imageFileName = $songDetails['album_cover_name'];
            $songFileName = $songDetails['song_file_name'];

            // CONSTRUCT THE FILE PATH IN FIREBASE STORAGE
            $imageFilePath = "album_covers/$userId/$imageFileName";
            $songFilePath = "songs/$userId/$songFileName";

            // RETRIEVE THE FILE OBJECT
            $imageFile = $storage->getBucket()->object($imageFilePath);
            $songFile = $storage->getBucket()->object($songFilePath);

            // DELETE THE FILE FROM FIREBASE STORAGE
            $imageFile->delete();
            $songFile->delete();

            // // EXTRACT THE FILE URLS FROM THE SONG DETAILS
            // $imageUrl = $songDetails['album_cover_url'];
            // $songFileUrl = $songDetails['song_file_url'];

            // // // DELETE THE IMAGE FILE FROM FIREBASE STORAGE
            // $imageFile = $storage->getBucket()->object($imageUrl);
            // $imageFile->delete();
            // $songFile = $storage->getBucket()->object($songFileUrl);
            // $songFile->delete();


            // DELETE THE SONG DATA FROM THE REALTIME DATABASE
            if ($songRef->remove()) {
                $response['success'] = "Song Deleted.";
            } else {
                $response['error'] = "Error in song deletion from Realtime Database.";
            }
        } else {
            $response['error'] = "Song not found in Realtime Database.";
        }
    } catch (\Exception $e) {
        $response['error'] = $e->getMessage();
    }

    echo json_encode($response);
}
?>