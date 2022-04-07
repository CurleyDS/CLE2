<?php
// Require DB settings with connection variable
require_once "../includes/database.php";

// Check if form has been submitted else check if id is set
if (isset($_POST['submit'])) {
    $id = mysqli_escape_string($db, $_POST['id']);
    
    // Require form-validations
    require_once "../includes/form-validation.php";

    if (empty($errors)) {
        // delete reservation from database table
        $result = deleteReservation($db, $id);

        if ($result) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/CLE2/schedule/');
            exit;
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

    }
} else if (isset($_GET['id']) || $_GET['id'] != '') {
    // Get id of reservation
    $reservationId = mysqli_escape_string($db, $_GET['id']);

    // Get reservation from database table
    $result = getReservation($db, $reservationId);

    if (mysqli_num_rows($result) == 1) {
        $reservation = mysqli_fetch_assoc($result);
        
        // Get lesson from database
        $lResult = getLesson($db, $reservation['lesson_id']);

        if (mysqli_num_rows($lResult) == 1) {
            $reservation['lesson'] = mysqli_fetch_assoc($lResult);
        } else {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/CLE2/schedule/');
            exit;
        }
    } else {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/CLE2/schedule/');
        exit;
    }
} else {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/CLE2/schedule/');
    exit;
}

//Close connection
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Require head -->
        <?php require_once "../includes/head-info.php"; ?>
    </head>
    <body>
        <div class="row bg-black">
            <!-- Require navigation-bar -->
            <?php require_once "../includes/navigation-bar.php"; ?>
        </div>
        <div class="section">
            <a href="../schedule" class="btn btn-maroon rounded-pill">Terug</a>
        </div>
        <div class="section">
            <h2>Verwijder de reservatie</h2>
            <!-- delete form -->
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <p>Weet u zeker dat u de reservatie voor les van <?= date('l jS F Y \o\n H:i', strtotime($reservation['lesson']['start_datetime'])) . ' - ' . date('H:i', strtotime($reservation['lesson']['end_datetime'])); ?> wilt verwijderen?</p>
                </div>
                <!-- Submit form -->
                <div class="mb-3">
                    <input type="hidden" name="id" value="<?= $reservation['id'] ?>"/>
                    <input type="submit" name="submit" class="btn btn-maroon" value="Submit" aria-describedby="contactHelp">
                    <div id="contactHelp">We'll never share your contact info with anyone else.</div>
                </div>
            </form>
        </div>
    </body>
</html>