<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./msg.css" />
    <title>hatebin :(</title>
</head>
<body>
<div class="advert bottomadvert">
                <img src="./resources/small3.gif" alt="advertisement">
            </div>

<?php

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

function redirect($url) {
    header('Location: '.$url);
    die();
}

$url = $_SERVER['QUERY_STRING'];

if (empty($url)) {
    redirect('index.php');
    die("No id provided");
} else if (strpos($url, "id=") === false) {
    redirect('index.php');
    die("No id provided");
} else {
    $id = explode("=", $url)[1];
}

//$id = explode("=", $url)[1];

$q = "SELECT title, message from xfiles WHERE id = $id";
$rchive->query("UPDATE xfiles SET eyes = eyes + 1 WHERE id = $id");
// $query = "SELECT * FROM $table_name WHERE  $field_name  LIKE '".$slug."%'";
$res = $rchive->query($q)->fetch_assoc();

echo "<h1>". $res['title'] ."</h1>";
echo "<pre>". $res['message'] . "</pre>";
?>
</body>

<style>
    .advert {
    width: 40%;
    padding: 1rem;
}
.advert img {
    width: 100%;
}
</style>