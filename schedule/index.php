<?php
// Require DB settings with connection variable
require_once "../includes/database.php";

//Get reservations from the database with an SQL query
$reservations = getReservations($db);

for ($x=0; $x < count($reservations); $x++) {
    // Get lesson from database
    $result = getLesson($db, $reservations[$x]['lesson_id']);
    
    if (mysqli_num_rows($result) == 1) {
        $reservations[$x]['lesson'] = mysqli_fetch_assoc($result);
    } else {
        $reservations[$x]['lesson'] = '';
    }
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
    <div class="container-fluid">
        <div class="row bg-black">
            <!-- Require navigation-bar -->
            <?php require_once "../includes/navigation-bar.php"; ?>
        </div>
        <div class="row py-3">
            <div class="col-md-12">
                <a href="create.php" class="btn btn-maroon rounded-pill">Cursus/Proefles registreren</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <table class="table table-borderless">
                    <thead class="border border-maroon">
                        <tr>
                            <th>#</th>
                            <th>Naam</th>
                            <th>Telefoonnummer</th>
                            <th>Email</th>
                            <th>Lestijden</th>
                            <th <?= isset($_SESSION['user']) ? '' : 'colspan="3"'; ?>></th>
                        </tr>
                    </thead>
                    <tbody class="border border-maroon">
                        <?php foreach ($reservations as $index => $reservation) { ?>
                            <tr>
                                <td><?= $index+1 ?></td>
                                <td><?= $reservation['name']; ?></td>
                                <td><?= $reservation['phone']; ?></td>
                                <td><?= $reservation['email']; ?></td>
                                <td><?= date('H:i', strtotime($reservation['lesson']['start_datetime'])) . ' - ' . date('H:i | j-m-Y', strtotime($reservation['lesson']['end_datetime'])); ?></td>
                                <td><a href="details.php?id=<?= $reservation['id']; ?>">Details</a></td>
                                <?php if (isset($_SESSION['user'])) { ?>
                                    <td><a href="edit.php?id=<?= $reservation['id']; ?>">Bewerken</a></td>
                                    <td><a href="delete.php?id=<?= $reservation['id']; ?>">Annuleren</a></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot class="border border-maroon">
                        <tr>
                            <td colspan="9">&copy; Reservations</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</body>
</html>