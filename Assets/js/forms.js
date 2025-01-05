function managePlaylistForm() {

    const form = document.getElementById("create_playlist");

    //DECLARATION
    let txtPlaylistTitle = form.txtPlaylistTitle;
    let txtGenre = form.selGenre;
    let txtLanguage = form.selLanguage;
    let filePlaylistCover = form.imgPlaylistCover;
    let txtMood = form.selMood;

    //ERROR VARIABLES
    let txtPlaylistTitleError = document.getElementById("playlistTitleError");
    // let txtGenreError = document.getElementById("genreError");
    // let txtLanguageError = document.getElementById("languageError");
    let txtPlaylistCoverError = document.getElementById("playlistCoverError");
    // let txtMoodError = document.getElementById("moodError");

    //VALID VARIABLES
    let validPlaylistTitle = false;
    let validGenre = false;
    let validLanguage = false;
    let validPlaylistCover = false;
    let validMood = false;

    //CREATE BUTTON STATUS
    function createBtnStatus() {
        if (validPlaylistTitle && validGenre && validLanguage && validPlaylistCover && validMood) {
            form.btnCreate.disabled = false;
        } else {
            form.btnCreate.disabled = true;
        }
    }

    // PLAYLIST TITLE VALIDATION
    txtPlaylistTitle.addEventListener('input', function () {
        if (checkPlaylistName(txtPlaylistTitle.value)) {
            txtPlaylistTitleError.innerHTML = "";
            validPlaylistTitle = true;
        } else {
            txtPlaylistTitleError.innerHTML = "Playlist Title is invalid";
            txtPlaylistTitleError.style.color = "red";
            validPlaylistTitle = false;
        }
        createBtnStatus();
    });

    // PLAYLIST COVER VALIDATION
    filePlaylistCover.addEventListener('input', function () {
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (allowedExtensions.exec(filePlaylistCover.value)) {
            txtPlaylistCoverError.innerHTML = "";
            validPlaylistCover = true;
        } else {
            txtPlaylistCoverError.innerHTML = "Invalid file format. Only JPG, JPEG, or PNG files are allowed.";
            txtPlaylistCoverError.style.color = "red";
            validPlaylistCover = false;
        }
        createBtnStatus();
    });

    // GENRE VALIDATION
    txtGenre.addEventListener('input', function () {
        txtGenre.style.color = "white";
        (txtGenre.value === "") ? validGenre = false : validGenre = true;
        createBtnStatus();
    });

    // LANGUAGE VALIDATION
    txtLanguage.addEventListener('input', function () {
        txtLanguage.style.color = "white";
        (txtLanguage.value === "") ? validLanguage = false : validLanguage = true;
        createBtnStatus();
    });

    // MOOD VALIDATION
    txtMood.addEventListener('input', function () {
        txtMood.style.color = "white";
        (txtMood.value === "") ? validMood = false : validMood = true;
        createBtnStatus();
    });

    // FORM SUBMISSION
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const addPlaylistData = new FormData(this);
        addPlaylistData.append('btnCreate', 'btnCreate');

        $.ajax({
            url: "manage-playlist.php",
            type: "POST",
            data: addPlaylistData,
            contentType: false,
            processData: false,
            success: function (data) {
                ("error" in data) ? showAlert(data.error, "alert-danger", "body") : showAlert(data.success, "alert-success", "body")
                form.reset();
            },
            error: function (response) {
                console.log(response);
                showAlert(response.responseText, "alert-danger", "body");
            }
        });
    });

}

function manageMusicForm(elementId) {
    const form = document.getElementById(elementId);
    //DECLARATION
    let txtsongTitle = form.txtSongTitle;
    let txtArtistName = form.txtArtistName;
    let txtGenre = form.selGenre;
    let txtDuration = form.txtDuration;
    let txtLanguage = form.selLanguage;
    let fileAlbumCover = form.albumCover;
    let txtAlbumName = form.txtAlbumName;
    let txtMood = form.selMood;
    let txtReleaseDate = form.dateReleaseDate;
    let songFile = form.songFile;
    let btnUpload = form.btnUpload;

    //ERROR VARIABLES
    let txtSongTitleError = document.getElementById("songTitleError");
    let txtArtistNameError = document.getElementById("artistNameError");
    let txtGenreError = document.getElementById("genreError");
    let txtDurationError = document.getElementById("durationError");
    let txtLanguageError = document.getElementById("languageError");
    let txtAlbumCoverError = document.getElementById("albumCoverError");
    let txtAlbumNameError = document.getElementById("albumNameError");
    let txtMoodError = document.getElementById("moodError");
    let txtReleaseDateError = document.getElementById("releaseDateError");
    let txtSongFileError = document.getElementById("songFileError");

    //VALID VARIABLES
    let validSongTitle = false;
    let validArtistName = false;
    let validGenre = false;
    let validDuration = false;
    let validLanguage = false;
    let validAlbumCover = false;
    let validAlbumName = false;
    let validMood = false;
    let validReleaseDate = false;
    let validSongFile = false;

    //UPLOAD BUTTON STATUS
    function uploadBtnStatus() {
        if (validSongTitle && validArtistName && validGenre && validDuration && validLanguage && validAlbumCover && validAlbumName && validMood && validReleaseDate && validSongFile) {
            form.btnUpload.disabled = false;
        } else {
            form.btnUpload.disabled = true;
        }
    }

    // SONG TITLE VALIDATION
    txtsongTitle.addEventListener('input', function () {
        if (checkSongTitle(txtsongTitle.value)) {
            txtSongTitleError.innerHTML = "";
            validSongTitle = true;
        } else {
            txtSongTitleError.innerHTML = "Song Title is invalid";
            txtSongTitleError.style.color = "red";
            validSongTitle = false;
        }
        uploadBtnStatus();
    });

    // ARTIST NAME VALIDATION
    txtArtistName.addEventListener('input', function () {
        // console.log("sdfs");
        if (checkArtistName(txtArtistName.value)) {
            txtArtistNameError.innerHTML = "";
            validArtistName = true;
        } else {
            txtArtistNameError.innerHTML = "Artist Name is invalid";
            txtArtistNameError.style.color = "red";
            validArtistName = false;
        }
        uploadBtnStatus();
    });

    // GENRE VALIDATION
    txtGenre.addEventListener('input', function () {
        txtGenre.style.color = "white";
        (txtGenre.value === "") ? validGenre = false : validGenre = true;
        uploadBtnStatus();
    });

    // DURATION VALIDATION
    txtDuration.addEventListener('input', function () {
        if (!isValidDurationFormat(txtDuration.value) || isInvalidDurationValue(txtDuration.value)) {
            txtDurationError.innerHTML = "Please enter a valid duration (MM:SS) greater than zero";
            txtDurationError.style.color = "red";
            validDuration = false;
        } else {
            txtDurationError.innerHTML = "";
            validDuration = true;
        }
        uploadBtnStatus();
    });

    // LANGUAGE VALIDATION
    txtLanguage.addEventListener('input', function () {
        txtLanguage.style.color = "white";
        (txtLanguage.value === "") ? validLanguage = false : validLanguage = true;
        uploadBtnStatus();
    });

    // ALBUM COVER VALIDATION
    fileAlbumCover.addEventListener('input', function () {
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(fileAlbumCover.value)) {
            txtAlbumCoverError.innerHTML = "Invalid file format. Only JPG, JPEG, or PNG files are allowed.";
            txtAlbumCoverError.style.color = "red";
            validAlbumCover = false;
        } else {
            txtAlbumCoverError.innerHTML = "";
            validAlbumCover = true;
        }
        uploadBtnStatus();
    });

    // ALBUM NAME VALIDATION
    txtAlbumName.addEventListener('input', function () {
        if (checkAlbumName(txtAlbumName.value)) {
            txtAlbumNameError.innerHTML = "";
            validAlbumName = true;
        } else {
            txtAlbumNameError.innerHTML = "Album Name is invalid";
            txtAlbumNameError.style.color = "red";
            validAlbumName = false;
        }
        uploadBtnStatus();
    });

    // MOOD VALIDATION
    txtMood.addEventListener('input', function () {
        txtMood.style.color = "white";
        (txtMood.value === "") ? validMood = false : validMood = true;
        uploadBtnStatus();
    });

    // RELEASE DATE VALIDATION
    txtReleaseDate.setAttribute('max', formatDate(new Date()));
    txtReleaseDate.addEventListener('input', function () {
        const selectedDate = new Date(txtReleaseDate.value);
        const today = new Date();

        if (selectedDate > today) {
            txtReleaseDate.value = formatDate(today);
            validReleaseDate = false;
        } else {
            validReleaseDate = true;
        }
        uploadBtnStatus();
    });

    // FILE SONG VALIDATION
    songFile.addEventListener('input', function () {
        var allowedExtensions = /(\.mp3|\.m4a)$/i;
        var maxFileSizeMB = 70; // SET THE MAXIMUM FILE SIZE IN MEGABYTES (ADJUST AS NEEDED)

        if (!allowedExtensions.exec(songFile.value)) {
            txtSongFileError.innerHTML = "Invalid file format. Only MP3 & M4A files are allowed.";
            txtSongFileError.style.color = "red";
            validSongFile = false;
        } else {
            var fileSize = songFile.files[0].size / (1024 * 1024); // CONVERT TO MEGABYTES
            if (fileSize > maxFileSizeMB) {
                txtSongFileError.innerHTML = "File size exceeds the allowed limit of " + maxFileSizeMB + " MB.";
                txtSongFileError.style.color = "red";
                validSongFile = false;
            } else {
                txtSongFileError.innerHTML = "";
                validSongFile = true;
            }
        }
        uploadBtnStatus();
    });

    // FORM SUBMISSION
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const addMusicData = new FormData(this);
        addMusicData.append('btnUpload', 'btnUpload');

        $.ajax({
            url: "manage-music.php",
            type: "POST",
            data: addMusicData,
            contentType: false,
            processData: false,
            success: function (data) {

                ("error" in data) ? showAlert(data.error, "alert-danger", "body") : showAlert(data.success, "alert-success", "body");
                form.reset();
            },
            error: function (response) {
                showAlert(response.responseText, "alert-danger", "body");
            }
        });
    });
}


function updateProfile() {

    const btnUpdate = document.getElementById("btnUpdate");
    const userProfile = document.getElementById('userProfile');
    const userProfileError = document.getElementById('userProfileError');
    const userDOB = document.getElementById('dateOfBirth');
    const userDOBError = document.getElementById('dateOfBirthError');
    const txtUsername = document.getElementById("txtUsername");
    const txtUsernameError = document.getElementById("usernameError");

    // VARIABLE TO TRACK THE VALIDITY OF THE USERNAME
    let validUsername = false;
    let validUserProfileImg = false;
    let validUserDOB = false;

    // FUNCTION TO ENABLE EDITING OF USERNAME
    function enableUsernameEditing() {
        document.getElementById('txtUsername').disabled = false;
        userDOB.disabled = false;
        // document.getElementById('txtPassword').disabled = false;
        userProfile.disabled = false;
    }

    // FUNCTION TO DISABLE EDITING OF USERNAME
    function disableEditing() {
        document.getElementById('txtUsername').disabled = true;
        userDOB.disabled = true;
        // document.getElementById('txtPassword').disabled = true;
        userProfile.disabled = true;
    }

    // INITIALLY DISABLE ALL INPUT FIELDS
    disableEditing();

    // GET THE CURRENT DATE
    let currentDate = new Date();

    // CALCULATE THE DATE FIVE YEARS AGO
    let maxDate = new Date(currentDate);
    maxDate.setFullYear(currentDate.getFullYear() - 5);

    // FORMAT THE MAXIMUM DATE FOR THE INPUT
    let maxDateString = maxDate.toISOString().split('T')[0];

    // SET THE MAXIMUM DATE FOR THE INPUT ELEMENT
    userDOB.setAttribute('max', maxDateString);


    // ATTACH CLICK EVENT LISTENER TO THE EDIT BUTTON
    document.getElementById('editButton').addEventListener('click', function () {
        enableUsernameEditing();
        this.disabled = true;
        btnUpdate.hidden = false;


        if (txtUsername.value !== "") {
            if (checkUserName(txtUsername.value)) {
                // USERNAME IS VALID
                txtUsernameError.innerHTML = ""; // CLEAR ERROR MESSAGE
                validUsername = true; // SET VALIDUSERNAME FLAG TO TRUE
            } else {
                // USERNAME IS INVALID
                txtUsernameError.innerHTML = "Username is invalid"; // DISPLAY ERROR MESSAGE
                txtUsernameError.style.color = "red"; // SET ERROR MESSAGE COLOR TO RED
                validUsername = false; // SET VALIDUSERNAME FLAG TO FALSE
            }
        }

        if (userDOB.value === "") {
            userDOBError.innerHTML = "Enter your date of birth";
            userDOBError.style.color = "red";
            validUserDOB = false;
        } else {
            userDOBError.innerHTML = "";
            validUserDOB = true;
        }

        updateBtnStatus();
    });

    // EVENT LISTENER FOR THE USERNAME INPUT FIELD
    txtUsername.addEventListener('input', function () {
        // CHECK IF THE ENTERED USERNAME IS VALID
        if (checkUserName(txtUsername.value)) {
            // USERNAME IS VALID
            txtUsernameError.innerHTML = ""; // CLEAR ERROR MESSAGE
            validUsername = true; // SET VALIDUSERNAME FLAG TO TRUE
        } else {
            // USERNAME IS INVALID
            txtUsernameError.innerHTML = "Username is invalid"; // DISPLAY ERROR MESSAGE
            txtUsernameError.style.color = "red"; // SET ERROR MESSAGE COLOR TO RED
            validUsername = false; // SET VALIDUSERNAME FLAG TO FALSE
        }
        // CALL A FUNCTION TO UPDATE THE STATUS OF THE REGISTER BUTTON BASED ON THE VALIDITY OF ALL FIELDS
        updateBtnStatus();
    });

    userProfile.addEventListener('input', function () {
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (userProfile.value == "") {
            userProfileError.innerHTML = "Choose a profile image.";
            userProfileError.style.color = "red";
            validUserProfileImg = false;
        }
        else if (allowedExtensions.exec(userProfile.value)) {
            userProfileError.innerHTML = "";
            validUserProfileImg = true;
        }
        else {
            userProfileError.innerHTML = "Invalid file format. Only JPG, JPEG, &emsp; &emsp; or PNG files are allowed.";
            userProfileError.style.color = "red";
            validUserProfileImg = false;
        }
        updateBtnStatus();
    });

    userDOB.addEventListener('input', function () {
        if (userDOB.value === "") {
            userDOBError.innerHTML = "Enter your date of birth";
            userDOBError.style.color = "red";
            validUserDOB = false;
        }
        else {
            userDOBError.innerHTML = "";
            validUserDOB = true;
        }

        updateBtnStatus();
    });

    // FUNCTION TO UPDATE THE STATUS OF THE REGISTER BUTTON BASED ON THE VALIDITY OF ALL FIELDS
    function updateBtnStatus() {
        // CHECK IF ALL FIELDS ARE VALID
        if (validUsername && validUserProfileImg && validUserDOB) {
            // ALL FIELDS ARE VALID, ENABLE THE REGISTER BUTTON
            btnUpdate.disabled = false;
        } else {
            // AT LEAST ONE FIELD IS INVALID, DISABLE THE REGISTER BUTTON
            btnUpdate.disabled = true;
        }
    }
}