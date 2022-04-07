<?php
//Require DB settings with connection variable
require_once "includes/database.php";

// Check if form has been submitted
if (isset($_POST['submit'])) {
    $name = mysqli_escape_string($db, $_POST['name']);
    $registerPassword = mysqli_escape_string($db, $_POST['register_password']);
    $phone = mysqli_escape_string($db, $_POST['phone']);
    $email = mysqli_escape_string($db, $_POST['email']);
    
    // Require form-validations
    require_once "includes/form-validation.php";

    if (empty($errors)) {
        $result = register($db, $name, $registerPassword, $phone, $email);

        if ($result) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/CLE2/login.php');
            exit;
        } else {
            $errors['register'] = $data['errors'];
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }
    }
}

//Close connection
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Require head -->
        <?php require_once "includes/head-info.php"; ?>
    </head>
    <body>
        <div class="bg-black">
            <!-- Require navigation-bar -->
            <?php require_once "includes/navigation-bar.php"; ?>
        </div>
        <div class="section">
            <!-- login form -->
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Name input -->
                <div>
                    <label for="name" class="form-label">Naam</label>
                    <input type="text" name="name" class="form-control" id="name" value="<?= isset($name) ? htmlentities($name) : '' ?>">
                    <span class="text-error"><?= isset($errors['name']) ? $errors['name'] : ''; ?></span>
                </div>
                <!-- Password input -->
                <div>
                    <label for="password" class="form-label">Wachtwoord</label>
                    <input type="password" name="password" class="form-control" id="password" value="<?= isset($password) ? htmlentities($password) : '' ?>">
                    <span class="text-error"><?= isset($errors['password']) ? $errors['password'] : ''; ?></span>
                </div>
                <!-- Phone input -->
                <div>
                    <label for="phone" class="form-label">Telefoonnummer</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="<?= isset($phone) ? htmlentities($phone) : '' ?>">
                    <span class="text-error"><?= isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
                </div>
                <!-- Email input -->
                <div>
                    <label for="email" class="form-label">Email adres</label>
                    <input type="text" name="email" class="form-control" id="email" value="<?= isset($email) ? htmlentities($email) : '' ?>">
                    <span class="text-error"><?= isset($errors['email']) ? $errors['email'] : ''; ?></span>
                </div>
                <!-- Submit form -->
                <div>
                    <input type="submit" name="submit" class="btn btn-maroon" value="Register">
                    <span class="text-error"><?= isset($errors['register']) ? $errors['register'] : ''; ?></span>
                </div>
            </form>
        </div>
    </body>
</html>