<?php
// Require DB settings with connection variable
require_once "../includes/database.php";

// Check if id is set
if (isset($_GET['id']) || $_GET['id'] != '') {
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
            <h2>De reservering voor de les van <?= date('l jS F Y \o\n H:i', strtotime($reservation['lesson']['start_datetime'])) . ' - ' . date('H:i', strtotime($reservation['lesson']['end_datetime'])); ?> van <?= $reservation['name']; ?></h2>
            <ul class="list-group">
                <li class="list-group-item"><b>Datum en tijd:</b> <?= date('l jS F Y \o\n H:i', strtotime($reservation['lesson']['start_datetime'])) . ' - ' . date('H:i', strtotime($reservation['lesson']['end_datetime'])); ?></li>
                <li class="list-group-item"><b>Naam:</b> <?= $reservation['name']; ?></li>
                <li class="list-group-item"><b>Telefoonnummer:</b> <?= $reservation['phone']; ?></li>
                <li class="list-group-item"><b>Email:</b> <?= $reservation['email']; ?></li>
            </ul>
        </div>
    </body>
</html>