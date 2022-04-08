<?php
// Require DB settings with connection variable
require_once "includes/database.php";

// If user isn't logged in, redirect to index.php
if (!isset($_SESSION['user'])) {
    header('Location: /' . explode('/', $_SERVER['REQUEST_URI'])[1] . '/');
}

// Check if form has been submitted
if (isset($_POST['submit'])) {
    session_destroy();
    header('Location: /' . explode('/', $_SERVER['REQUEST_URI'])[1] . '/');
}

//Close connection
mysqli_close($db);
?>