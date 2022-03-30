<?php
require_once "../includes/database.php";

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
            <?php require_once "../includes/navigation-bar.php"; ?>
        </div>
        <div class="row">
            parties
        </div>
    </div>
</body>
</html>