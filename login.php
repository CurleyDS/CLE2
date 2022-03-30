<?php
//Require DB settings with connection variable
require_once "includes/database.php";

// If user is logged in, redirect to index.php
if(isset($_SESSION['user'])){
    header('Location: /CLE/');
    exit;
}

// Check if form has been submitted
if (isset($_POST['submit'])) {
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = mysqli_escape_string($db, $_POST['password']);
    
    // Require form-validations
    require_once "includes/form-validation.php";

    if (empty($errors)) {
        // Verify if login-data is valid
        $data = login($db, $email, $password);
        
        if ($data == 'Login failed') {
            $_SESSION['user'] = $data;
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/CLE/schedule/');
            exit;
        } else {
            $errors['login'] = $data;
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
    <div class="container-fluid">
        <div class="row bg-black">
            <!-- Require navigation-bar -->
            <?php require_once "includes/navigation-bar.php"; ?>
        </div>
        <div class="row py-3 d-flex justify-content-center">
            <div class="col-md-10">
                <!-- login form -->
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- Email input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" name="email" class="form-control" id="email" value="<?= isset($email) ? htmlentities($email) : '' ?>">
                        <span class="text-danger"><?= isset($errors['email']) ? $errors['email'] : ''; ?></span>
                    </div>
                    <!-- Password input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" value="<?= isset($password) ? htmlentities($password) : '' ?>">
                        <span class="text-danger"><?= isset($errors['password']) ? $errors['password'] : ''; ?></span>
                    </div>
                    <!-- Submit form -->
                    <div class="mb-3">
                        <input type="submit" name="submit" class="btn btn-primary" value="Login">
                        <span class="text-danger"><?= isset($errors['login']) ? $errors['login'] : ''; ?></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>