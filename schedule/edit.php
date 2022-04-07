<?php
// Require DB settings with connection variable
require_once "../includes/database.php";

//Get lessons from the database with an SQL query
$lessons = getLessons($db);

// Check if form has been submitted else check if id is set
if (isset($_POST['submit'])) {
    $id = mysqli_escape_string($db, $_POST['id']);
    $lesson_id = mysqli_escape_string($db, $_POST['lesson_id']);
    $name = mysqli_escape_string($db, $_POST['name']);
    $phone = mysqli_escape_string($db, $_POST['phone']);
    $email = mysqli_escape_string($db, $_POST['email']);
    
    // Require form-validations
    require_once "../includes/form-validation.php";

    if (empty($errors)) {
        // update reservation from database table
        $result = updateReservation($db, $id, $lesson_id, $name, $phone, $email);

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
            <!-- edit form -->
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Lesson list -->
                <div class="mb-3">
                    <label for="lessons" class="form-label">Start van de cursus</label>
                    <select name="lesson_id" class="form-select" id="lessons">
                        <?php foreach ($lessons as $lesson) { ?>
                            <option value="<?= $lesson['id']; ?>" <?= isset($lesson_id) && $lesson['id'] == $lesson_id ? 'selected' : isset($reservation['lesson_id']) && $lesson['id'] == $reservation['lesson_id'] ? 'selected' : '' ?>><?= date('H:i \o\n l jS F Y', strtotime($lesson['start_datetime'])); ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger"><?= isset($errors['lesson_id']) ? $errors['lesson_id'] : ''; ?></span>
                </div>
                <!-- Name input -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="<?= isset($name) ? htmlentities($name) : $reservation['name'] ?>">
                    <span class="text-danger"><?= isset($errors['name']) ? $errors['name'] : ''; ?></span>
                </div>
                <!-- Email input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="text" name="email" class="form-control" id="email" value="<?= isset($email) ? htmlentities($email) : $reservation['email'] ?>">
                    <span class="text-danger"><?= isset($errors['email']) ? $errors['email'] : ''; ?></span>
                </div>
                <!-- Phone input -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="<?= isset($phone) ? htmlentities($phone) : $reservation['phone'] ?>">
                    <span class="text-danger"><?= isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
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