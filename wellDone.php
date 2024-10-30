<?php

/* in prod you're gonna have to add a passwd */
$rchive = mysqli_connect(
    "127.0.0.1",
    "root",
    "", // Add your password here
    "hatebinrchive", // Add your database name here
) or die("Could not connect to database");


/* $rchive = mysqli_connect(
    "sql112.infinityfree.com",
    "if0_37531963",
    "FhKF93z9GXg8RW", // Add your password here
    "if0_37531963_hatebinrchive", // Add your database name here
) or die("Could not connect to database"); */

$q = "INSERT INTO xfiles (title, message) VALUES ('" . htmlspecialchars($_POST['title']) . "', '" . htmlspecialchars($_POST['hate']) . "');";

mysqli_query($rchive, $q);

// making sure to redirect.
// PRQ meta
function redirect($url) {
    header('Location: '.$url);
    die();
}
redirect('index.php');