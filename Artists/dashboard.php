<?php
session_start();
include "../dbconnect.php";

if (isset($_SESSION['error_status'])) {
  echo "<script> alert('" . $_SESSION['error_status'] . "');</script>";
  unset($_SESSION["error_status"]);
}

if (!($_SESSION['user_artist'] == true) && !($_SESSION['status'] == true)) {
  header('Location: ../UserAuthentication/login.php');
  die();
} else {

  $userId = $_SESSION['user_id'];

  $userData = $database->getReference("users/$userId")->getValue();
  $user = $auth->getUser($userId);
  $userEmail = $user->email;
  // CHECK IF USER DATA IS FETCHED SUCCESSFULLY
  if ($userData) {
    // PRE-FILL FORM FIELDS WITH USER DATA
    $userName = $userData['user_name']; // PRE-FILL USERNAME FIELD
    $dateOfBirth = $userData['date_of_birth']; // PRE-FILL DATE OF BIRTH FIELD
    $profileImg = $userData['profile_image_url'];
  }

  $totalSongCount = 0;
  $userId = $_SESSION['user_id'];
  $artistSongs = $database->getReference("users/$userId")->getValue();

  if (isset($artistSongs['songs'])) {
    $userSongCount = count($artistSongs['songs']);
    $totalSongCount = $userSongCount;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- REQUIRED META TAGS -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, height=device-height">
  <title>Artist Dashboard</title>
  <!-- PLUGINS:CSS -->
  <link rel="stylesheet" href="../Assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../Assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../Assets/css/style.css">
  <link rel="stylesheet" href="../Assets/vendors/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="../Assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../Assets/vendors/owl-carousel-2/owl.theme.default.min.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
  <!-- END PLUGIN CSS FOR THIS PAGE -->
  <link rel="shortcut icon" href="../Assets/images/ecovibe_logo.png" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <style>
    .alert {
      position: fixed;
      top: 5%;
      left: 50%;
      transform: translateX(-50%);
      z-index: 2000;
    }

    .nav-item {
      cursor: pointer;
    }

    #profile-container {
      margin-left: 20%;
      justify-content: center;
      position: relative;
      display: inline-block;
    }

    #profile-picture {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      overflow: hidden;
      background-color: #ddd;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #upload-button {
      position: absolute;
      bottom: 5px;
      right: 15px;
      background-color: #007bff;
      color: #fff;
      border: none;
      width: 30px;
      height: 30px;
      padding: 8px;
      border-radius: 50%;
      cursor: pointer;
    }

    #upload-button input {
      display: none;
      /* Hide the file input */
    }

    @media (max-width: 576px) {
      #profile-picture {
        width: 120px;
        height: 120px;
      }

      #upload-button {
        bottom: 2px;
        right: 8px;
        width: 25px;
        height: 25px;
        font-size: 12px;
      }
    }

    @media (max-width: 768px) {
      #profile-picture {
        width: 140px;
        height: 140px;
      }

      #upload-button {
        bottom: 3px;
        right: 12px;
        width: 28px;
        height: 28px;
        font-size: 14px;
      }
    }

    .ellipsis {
      white-space: nowrap;
      /* Prevent text from wrapping */
      overflow: hidden;
      /* Hide overflow text */
      text-overflow: ellipsis;
      /* Display ellipsis for overflow text */
      max-width: 150px;
      /* Set maximum width for the content */
    }
  </style>

</head>

<body>
  <!-- CONTAINER-SCROLLER -->
  <div class="container-scroller">
    <!-- SIDEBAR START HERE -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="dashboard.php"><img src="../Assets/images/EcoVibe_Logo_FS.png"
            alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="dashboard.php"><img src="../Assets/images/EcoVibe_Logo_SS.png "
            alt="logo" /></a>
      </div>
      <ul class="nav">
        <li class="nav-item nav-category">
          <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
          <span class="nav-link" data-page="dashboard-content.php?dashboardContent=1">
            <span class="menu-icon">
              <i class="mdi mdi-speedometer"></i>
            </span>
            <span class="menu-title">Dashboard</span>
          </span>
        </li>
        <li class="nav-item menu-items">
          <span class="nav-link" data-page="no-page" data-toggle="collapse" href="#m-music" aria-expanded="false"
            aria-controls="m-music">
            <span class="menu-icon">
              <i class="mdi mdi-music"></i>
            </span>
            <span class="menu-title">Manage Music</span>
            <i class="menu-arrow"></i>
          </span>
          <div class="collapse" id="m-music">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" data-page="manage-music.php?add=1">Add</a></li>
              <li class="nav-item"> <a class="nav-link" data-page="manage-music.php?view=1">View</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link" data-page="no-page" data-toggle="collapse" href="#m-playlist" aria-expanded="false"
            aria-controls="m-playlist">
            <span class="menu-icon">
              <i class="mdi mdi-playlist-play"></i>
            </span>
            <span class="menu-title">Manage Playlist</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="m-playlist">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" data-page="manage-playlist.php?add=1">Add</a></li>
              <li class="nav-item"> <a class="nav-link" data-page="manage-playlist.php?view=1">View</a></li>
            </ul>
          </div>
        </li>
        <!-- <li class="nav-item menu-items">
          <a class="nav-link" href="#">
            <span class="menu-icon">
              <i class="mdi mdi-chart-bar"></i>
            </span>
            <span class="menu-title">Report</span>
          </a>
        </li> -->
        <!-- <li class="nav-item menu-items">
          <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-icon">
              <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Basic UI Elements</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
              <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
              <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
            </ul>
          </div>
        </li> -->
      </ul>
    </nav>
    <!-- SIDEBAR ENDS HERE -->
    <div class="container-fluid page-body-wrapper">
      <!-- NAVBAR START HERE -->
      <nav class="navbar p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src.="Assets/images/logo-mini.svg"
              alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav w-100">
            <li class="nav-item w-50">
              <form class="nav-link mt-1 mt-md-0 d-flex d-lg-flex search">
                <input type="text" class="form-control" placeholder="Search song, artist or album">
              </form>
            </li>
          </ul>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
              <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                <div class="navbar-profile">
                  <img class="img-sm rounded-circle" src="<?= isset($profileImg) ? $profileImg : ''; ?>" alt="logo">
                  <p class="mb-0 d-none d-sm-block navbar-profile-name">
                    <?= isset($userName) ? $userName : ''; ?>
                  </p>
                  <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                aria-labelledby="profileDropdown">
                <span class="dropdown-item preview-item" id="profile">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-account text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Profile</p>
                  </div>
                </span>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item" href="../UserAuthentication/sign-out.php">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-logout text-danger"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Log out</p>
                  </div>
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
          </button>
        </div>
      </nav>
      <!-- NAVBAR ENDS HERE -->
      <script src="../Assets/validations/Validations.js"></script>
      <!-- MAIN PANEL START -->

      <div class="main-panel" id="main-panel">
        <!-- CONTENT WRAPPER START HERE -->
        <div class="row">
          <!-- Total songs count card -->
          <div class="col-xxl-4 col-md-4">
            <div class="card info-card sales-card">
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
        </div>
        <!-- <div class="content-wrapper d-flex align-items-center justify-content-center">
          <div class="container text-center">
            <div class="row">
              <div class="col-md-6 d-flex flex-column align-items-end justify-content-center">
                <div>
                  <video width="300" height="250" autoplay loop muted>
                    <source src="../Assets/videos/music_player_video.mp4" type="video/mp4">
                  </video>
                </div>
              </div>
              <div class="col-md-6 d-flex flex-column align-items-start justify-content-center">
                <div class="mt-3">
                  <p class="display-4">You don't have any playlists</p>
                  <button type="submit" class="btn btn-outline-primary btn-icon-text">
                    <i class="mdi mdi-plus btn-icon-prepend"></i> Create Playlist </button>
                </div>
              </div>
            </div>
          </div>
        </div> -->
        <!-- CONTENT-WRAPPER ENDS HERE -->
      </div>
      <!-- MAIN PANEL ENDS HERE -->
    </div>
    <!-- CONTAINER-FLUID ENDS HERE -->
  </div>
  <!-- CONTAINER SCROLLER ENDS HERE-->

  <script src="../Assets/js/jquery.js"></script>
  <script src="../Assets/js/forms.js"></script>

  <!-- COMMON SCRIPT -->
  <script>
    function showAlert(message, alertType, shownInElement) {
      // REMOVE EXISTING ALERTS
      $(".alert").remove();

      // CREATE A NEW ALERT ELEMENT
      const alertElement = $("<div>").addClass("alert " + alertType).attr("role", "alert").text(message);

      // APPEND THE ALERT TO THE BODY OR ANY SPECIFIC CONTAINER.
      $(shownInElement).append(alertElement);

      // AUTOMATICALLY CLOSE THE ALERT AFTER 4 SECONDS.
      setTimeout(function () {
        alertElement.remove();
      }, 4000);
    }

    function loadContent(page) {

      $.ajax({
        url: page,
        method: "GET",
        success: function (data) {
          // console.log(page);
          $("#main-panel").html(data);
          if (page === "manage-music.php?add=1") {
            manageMusicForm('add-song-details');
          }
          else if (page === "manage-music.php?view=1") {
            manageMusicForm('update-song-details');
          }
          else if (page === "manage-playlist.php?add=1") {
            managePlaylistForm();
          }
          else if (page === "manage-playlist.php?add=1") {
            managePlaylistForm();
          }
        },
        error: function (response) {
          console.log(response.responseText);
          showAlert(response.responseText, "alert-danger", "body");
        }
      });
    }

    // ATTACH CLICK EVENT LISTENERS TO NAVIGATION LINKS
    let navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(function (link) {
      if (link.id !== 'profileDropdown') { // Check if the element's ID is not 'profileDropdown'
        link.addEventListener('click', function (event) {
          event.preventDefault(); // PREVENT DEFAULT LINK BEHAVIOR
          let page = this.getAttribute('data-page');
          if (page == "no-page") {
            // NOTHING TO DO
          } else {
            loadContent(page); // LOAD CONTENT USING AJAX
          }
        });
      }
    });
  </script>

  <!-- SONG MANAGEMENT SCRIPT -->
  <script>

    $(document).on("submit", ".delete", function (e) {
      e.preventDefault();

      $.ajax({
        url: "manage-music.php",
        type: "GET",
        data: $(this).serialize(),
        success: function (data) {

          $(".modal").modal('hide');

          $.ajax({
            url: "manage-music.php",
            method: "GET",
            data: {
              view: 1
            },
            success: function (data) {
              $("#main-panel").html(data);
            },
            error: function (response) {
              showAlert(response.responseText, "alert-danger", "body");
            }
          });

          // console.log(data.success);
          ("error" in data) ? showAlert(data.error, "alert-danger", "body") : showAlert(data.success, "alert-success", "body");

        },
        error: function (response) {
          showAlert(response.responseText, "alert-danger", "body");
        }
      });
    });

    // UPDATING SONGS DATA
    $(document).on("submit", ".update-song-details", function (e) {
      e.preventDefault();

      const updateSong = new FormData(this);
      updateSong.append('updateSong', 'updateSong');

      $.ajax({
        url: "manage-music.php",
        type: "POST",
        data: updateSong,
        contentType: false,
        processData: false,
        success: function (data) {
          $(".modal").modal('hide');

          ("error" in data) ? showAlert(data.error, "alert-danger", "body") : showAlert(data.success, "alert-success", "body")
          $.ajax({
            url: "manage-music.php",
            method: "GET",
            data: {
              view: 1
            },
            success: function (data) {
              $("#main-panel").html(data);
            },
            error: function (response) {
              showAlert(response.responseText, "alert-danger", "body");
            }
          });

        },
        error: function (response) {
          showAlert(response.responseText, "alert-danger", "body");
        }
      });
    });

  </script>

  <!-- PLAYLIST MANAGEMENT SCRIPT -->
  <script>

    function refreshPlaylistSongs(playlistId) {
      $.ajax({
        url: "manage-playlist.php",
        method: "GET",
        data: { playlistIdAjaxUpdate: playlistId },
        success: function (data) {
          $("#" + playlistId).html(data);
        },
        error: function (response) {
          showAlert(response.responseText, "alert-danger", "body");
        }
      });
    }

    // DELETING PLAYLIST
    $(document).on("submit", ".delete-playlist", function (e) {
      e.preventDefault();

      $.ajax({
        url: "manage-playlist.php",
        type: "GET",
        data: $(this).serialize(),
        success: function (data) {

          $(".modal").modal('hide');

          ("error" in data) ? showAlert(data.error, "alert-danger", "body") : showAlert(data.success, "alert-success", "body")
          $.ajax({
            url: "manage-playlist.php",
            method: "GET",
            data: {
              view: 1
            },
            success: function (data) {
              $("#main-panel").html(data);
            },
            error: function (response) {
              showAlert(response.responseText, "alert-danger", "body");
            }
          });
        },
        error: function (response) {
          showAlert(response.responseText, "alert-danger", "body");
        }
      });
    });

    // RETRIEVE THE PLAYLIST ID FROM THE data-playlist-id ATTRIBUTE
    $(document).on('click', '.playlist-id', function () {

      let playlistId = $(this).data('playlist-id');

      // SET THE PLAYLIST ID AS THE VALUE OF THE HIDDEN INPUT FIELD
      document.getElementById('playlist_id').value = playlistId;
      let btnAddSong = document.getElementById('btn_add_song_to_playlist');
      btnAddSong.setAttribute("data-bs-target", "#playlist_" + playlistId);
      let btnDeleteSong = document.getElementById('btn_delete_song_from_playlist');
      btnDeleteSong.setAttribute("data-bs-target", "#playlist_" + playlistId);
    });

    // ADDING SONGS TO THE PLAYLIST
    $(document).on("submit", ".add-songs-to-playlist", function (e) {
      e.preventDefault();
      let checkboxes = document.querySelectorAll('input[name="songIds[]"]:checked');

      // CHECK IF AT LEAST ONE CHECKBOX IS CHECKED
      if (checkboxes.length === 0) {
        showAlert("Please select at least one song.", "alert-danger", "body");
        return false; // PREVENT FORM SUBMISSION
      }
      else {
        let formData = $(this).serialize();
        // APPEND THE 'addSong' PARAMETER TO THE SERIALIZED FORM DATA
        formData += '&addSongToPlaylist=addSongToPlaylist';

        // EXTRACTING FORM DATA BEFORE SUBMISSION
        let playlistId = $(this).find('input[name="playlistId"]').val();

        $.ajax({
          url: "manage-playlist.php",
          method: "POST",
          data: formData,
          success: function (data) {
            // console.log(data);
            ("error" in data) ? showAlert(data.error, "alert-danger", "body") : showAlert(data.success, "alert-success", "body")
            refreshPlaylistSongs(playlistId);

            $(".add-songs-to-playlist")[0].reset(); 0
          },
          error: function (response) {
            showAlert(response.responseText, "alert-danger", "body");
          }
        });
      }
    });

    // RETRIEVE THE SONG ID AND PLAYLIST ID FROM THE data-song-id AND data-playlist-id ATTRIBUTE
    $(document).on('click', '.song-id', function () {

      let songId = $(this).data('song-id');
      let playlistId = $(this).data('playlist-id');

      // SET THE SONG ID AS THE VALUE OF THE HIDDEN INPUT FIELD
      document.getElementById('delete_playlist_song_id').value = songId;

      // SET THE PLAYLIST ID AS THE VALUE OF THE HIDDEN INPUT FIELD
      document.getElementById('delete_song_from_playlist_id').value = playlistId;
    });

    // DELETING SONG FROM THE PLAYLIST
    $(document).on("submit", ".delete-playlist-song", function (e) {
      e.preventDefault();

      let formData = $(this).serialize();
      // APPEND THE 'deletePlaylistSong' PARAMETER TO THE SERIALIZED FORM DATA
      formData += '&deletePlaylistSong=deletePlaylistSong';

      // EXTRACTING FORM DATA BEFORE SUBMISSION
      let playlistId = $(this).find('input[name="deleteSongFromPlaylistId"]').val();

      $.ajax({
        url: "manage-playlist.php",
        method: "POST",
        data: formData,
        success: function (data) {
          // console.log(data);
          ("error" in data) ? showAlert(data.error, "alert-danger", "body") : showAlert(data.success, "alert-success", "body")
          refreshPlaylistSongs(playlistId);
        },
        error: function (response) {
          showAlert(response.responseText, "alert-danger", "body");
        }
      });
    });

  </script>

  <!-- USER MANAGEMENT SCRIPT -->
  <script>

    function refreshUserProfile() {
      $.ajax({
        url: "user-profile.php",
        method: "GET",
        data: { userProfile: "userProfile" },
        success: function (data) {
          $("#main-panel").html(data);
          updateProfile();
        },
        error: function (response) {
          showAlert(response.responseText, "alert-danger", "body");
        }
      });
    }
    // GETTING USER PROFILE 
    $(document).on("click", "#profile", function (e) {
      e.preventDefault();
      refreshUserProfile();
    });

    // UPDATING USER DATA
    $(document).on("submit", ".editProfileForm", function (e) {
      e.preventDefault();

      const updateProfile = new FormData(this);
      updateProfile.append('updateProfile', 'updateProfile');
      // let formData = $(this).serialize();
      // APPEND THE 'addSong' PARAMETER TO THE SERIALIZED FORM DATA
      // formData += '&updateProfile=updateProfile';

      $.ajax({
        url: "user-profile.php",
        type: "POST",
        data: updateProfile,
        contentType: false,
        processData: false,
        success: function (data) {

          ("error" in data) ? showAlert(data.error, "alert-danger", "body") : refreshUserProfile()
          showAlert(data.success, "alert-success", "body")
          $.ajax({
            url: "dashboard-content.php",
            method: "GET",
            data: { userProfile: "userProfile" },
            success: function (data) {
              $("#profileDropdown").html(data);
            },
            error: function (response) {
              console.log(response);
            }
          });

          // $(this).reset();
        },
        error: function (response) {
          showAlert(response.responseText, "alert-danger", "body");
        }
      });
    });

  </script>


  <!-- PLUGINS:JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="../Assets/vendors/progressbar.js/progressbar.min.js"></script>
  <script src="../Assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
  <script src="../Assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <script src="../Assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
  <script src="../Assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../Assets/js/off-canvas.js"></script>
  <script src="../Assets/js/hoverable-collapse.js"></script>
  <script src="../Assets/js/misc.js"></script>
  <script src="../Assets/js/settings.js"></script>
  <script src="../Assets/js/todolist.js"></script>
  <script src="../Assets/js/dashboard.js"></script>
  <script src="../Assets/vendors/select2/select2.min.js"></script>
  <script src="../Assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../Assets/js/file-upload.js"></script>
  <script src="../Assets/js/typeahead.js"></script>
  <script src="../Assets/js/select2.js"></script>
  <!-- END INJECT PLUGINS:JS -->
</body>

</html>