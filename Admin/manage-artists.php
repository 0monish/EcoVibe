<?php
session_start();
include "../dbconnect.php";
require_once ('../Assets/validations/Validations.php');

function getUserStatus($userId, $auth)
{
    try {
        $user = $auth->getUser($userId);
        return $user->disabled ? 'Disabled' : 'Enabled';
    } catch (\Exception $e) {
        return 'Error';
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approveUser'])) {
    extract($_POST);
    header('Content-Type: application/json; charset=UTF-8');

    $executed = $database->getReference("users/$userId/user_status")->set(true);
    if ($executed) {
        $response['success'] = "Artist approved.";
    } else {
        $response['error'] = "Facing issue in approving artist";
    }
    echo json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artistStatus'])) {
    extract($_POST);
    header('Content-Type: application/json; charset=UTF-8');
    try {
        // GET THE USER
        $user = $auth->getUser($userId);

        // TOGGLE USER'S STATUS
        $newStatus = !$user->disabled;

        // UPDATE USER'S STATUS IN FIREBASE
        $executed = $auth->updateUser($userId, ['disabled' => $newStatus]);
        if ($executed && $newStatus == true) {
            $response['success'] = 'Artist account is now DISABLED';
        } else if ($executed && $newStatus == false) {
            $response['success'] = 'Artist account is now ENABLED';
        } else {
            $response['error'] = 'Problem updating artist account status';
        }
    } catch (\Exception $e) {
        $response['error'] = $e->getMessage();
    }
    echo json_encode($response);
}

// VIEWING USERS DATA
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['artistData'])) {
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
                                    <th> Image </th>
                                    <th> User Name </th>
                                    <th> Email </th>
                                    <th> Request</th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php


                                $userData = $database->getReference('users')->getValue();

                                if ($userData) {
                                    $count = 1;
                                    foreach ($userData as $key => $user) {
                                        $claims = $auth->getUser($key)->customClaims;
                                        if (isset($claims['artist']) == true) {
                                            $userEmail = $auth->getUser($key)->email;

                                            // Get user status for each user
                                            $status = getUserStatus($key, $auth);
                                            ?>
                                            <tr>
                                                <th scope="row">
                                                    <?= $count++; ?>
                                                </th>
                                                <td>
                                                    <img src="<?= ($user['profile_image_url'] != "") ? $user['profile_image_url'] : "../Assets/images/Profile.jpg"; ?>"
                                                        style="width: 80px; height: 80px;" class="img-sm" alt="User Profile">
                                                </td>
                                                <td>
                                                    <?= $user['user_name']; ?>
                                                </td>
                                                <td>
                                                    <?= $userEmail; ?>
                                                </td>
                                                <td class="text-end">
                                                    <?php if ($user['user_status'] === false) { ?>
                                                        <form class="approve-user">
                                                            <input type="hidden" name="userId" value="<?= $key; ?>">
                                                            <button type="submit" name="approveUser" class="btn btn-sm btn-success">
                                                                Approve
                                                            </button>
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-end">
                                                    <form class="enable-disable-user">
                                                        <input type="hidden" name="userId" value="<?= $key; ?>">
                                                        <button type="submit" name="artistStatus"
                                                            class="btn btn-sm <?= $status === 'Disabled' ? 'btn-success' : 'btn-danger'; ?>">
                                                            <?= $status === 'Disabled' ? 'Enable' : 'Disable'; ?>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                } else {
                                    echo '<tr><td colspan="4">No data available</td></tr>';
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
?>