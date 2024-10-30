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

$raw_url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$url = htmlspecialchars($raw_url, ENT_QUOTES, 'UTF-8');
$root_url = explode("?", $url)[0];

$queryStr = $_SERVER['QUERY_STRING'];
$offsetMultiplier = 50;

$pageOffset = 0;

$root_query = "SELECT id,title, eyes, message_date FROM xfiles";

if (empty($queryStr)) {
    $query = $root_query . " ORDER BY message_date DESC LIMIT 50 OFFSET " . $pageOffset * $offsetMultiplier . ";";

    $offSetSelectorHref = $root_url . "?offset=";
    $totalBinQuery = "SELECT COUNT(*) as total FROM xfiles";
} else if (strpos($queryStr, "search=") !== false && strpos($queryStr, "offset=") === false) {
    $searchQuery = explode('=', explode("&", $queryStr)[0])[1];
    $query = $root_query . " WHERE title LIKE '%" . $searchQuery . "%' " . "ORDER BY message_date DESC LIMIT 50 OFFSET " . $pageOffset * $offsetMultiplier . ";";

    $offSetSelectorHref = $root_url . "?search=" . $searchQuery . "&offset=";
    $totalBinQuery = "SELECT COUNT(*) as total FROM xfiles WHERE title LIKE '%" . $searchQuery . "%'";
    //$query = $root_query . $likeFilter . $orderByFilter;
} else if (strpos($queryStr, "offset=") !== false && strpos($queryStr, "search=") !== false) {
    $searchQuery = explode('=', explode("&", $queryStr)[0])[1];
    $pageOffset = explode('=', explode("&", $queryStr)[1])[1];
    $query = $root_query . " WHERE title LIKE '%" . $searchQuery . "%' " . "ORDER BY message_date DESC LIMIT 50 OFFSET " . (int)$pageOffset * (int)$offsetMultiplier . ";";

    $offSetSelectorHref = $root_url . "?search=" . $searchQuery . "&offset=";
    $totalBinQuery = "SELECT COUNT(*) as total FROM xfiles WHERE title LIKE '%" . $searchQuery . "%'";
} else if (strpos($queryStr, "offset=") !== false && strpos($queryStr, "search=") === false) {
    $pageOffset = explode('=', explode("&", $queryStr)[0])[1];
    $query = $root_query . " ORDER BY message_date DESC LIMIT 50 OFFSET " . (int)$pageOffset * (int)$offsetMultiplier . ";";

    $offSetSelectorHref = $root_url . "?offset=";
    $totalBinQuery = "SELECT COUNT(*) as total FROM xfiles";
} else {
    $pageOffset = 0;
    $query = $root_query . " ORDER BY message_date DESC LIMIT 50 OFFSET " . $pageOffset * $offsetMultiplier . ";";

    $offSetSelectorHref = $root_url . "?offset=";
    $totalBinQuery = "SELECT COUNT(*) as total FROM xfiles";
}

$resArray = [];
$res = $rchive->query($query);

$totalBins = $rchive->query($totalBinQuery)->fetch_assoc()['total'];
while ($row = $res->fetch_assoc()) {
    $resArray[] = $row;
}
$currentResTotal = count($resArray);


$totalPages = floor($totalBins / $offsetMultiplier);
?>

This is a production by a certain company that creates problems instead of solving them.
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style.css" />
    <title>hatebin :(</title>
</head>

<body>
    <header>
        <menu>

            <li><a href="./hate.php">spread hate</a></li>
            <h2>Hatebin</h2>
            <li><a href="">hall of hate</a></li>

        </menu>
        <pre id="ascii_art">
       ,---.
       ,'_   _`.
     {{ |o| |o| }}
    {{{ '-'O'-' }}}
      {`'~._.~'`}
         `---'    The gods are bound to slip...
        </pre>
        <h2><a href="">The official hatebin discord</a></h2>

        <div class="advert">
            <img src="./resources/small1.gif" alt="advertisement">
        </div>

        <div class="Posts">
            <div class="topWrapper">
                <div class="top">
                    <p>Showing <?php echo $currentResTotal . ' of ' . $totalBins . ' ' ?>total bins</p>
                    <span id="searchBar">
                        <input id="searchbarInput" type="text" /><button onclick="search()">Search</button>
                    </span>
                </div>
            </div>
            </top>

            <div class="resultSplit">
                <resPageButtons>
                    <?php
                    echo '<a href="' . $offSetSelectorHref . '0">0</a>';
                    ?>
                    <p>...</p>
                    <?php
                    for ($i = 6; $i >= 1; $i--) {
                        $back = (int)$pageOffset - $i;
                        if ($back > 0) {

                            if ((int)$back === (int)$pageOffset && $back < (int)$pageOffset / 2) {
                                echo '<a class="currentOffset" href="' . $offSetSelectorHref  . $back . '">' . $back . '</a>';
                            } else {
                                echo '<a href="' . $offSetSelectorHref . $back . '">' . $back . '</a>';
                            }
                        }
                    }
                    for ($f = 0; $f <= 6; $f++) {
                        $pos = (int)$pageOffset + $f;
                        if ($pos < $totalPages) {

                            if ($pos === (int)$pageOffset && $pos > (int)$pageOffset / 2) {
                                echo '<a class="currentOffset" href="' . $offSetSelectorHref . $pos . '">' . $pos . '</a>';
                            } else {

                                echo '<a href="' . $offSetSelectorHref . $pos . '">' . $pos . '</a>';
                            }
                        }
                    }

                    ?>
                    <p>...</p>
                    <?php
                    echo '<a href="' . $offSetSelectorHref . $totalPages . '">' . $totalPages . '</a>';
                    ?>
                </resPageButtons>
            </div>

            <content>
                <!-- <h3>Bins</h3> -->
                <span id="tableContent">
                    <li>Title</li>
                    <li>Eyes</li>
                    <li>Date</li>
                </span>
                <table>

                    <?php
                    //$res = $rchive->query("SELECT id,title, eyes, message_date FROM xfiles ORDER BY message_date DESC;");
                    foreach ($resArray as $row) {
                        $cDate = new DateTime($row["message_date"]);
                        echo '
                                <tr>
                                  <th><a href="hateMsg.php?id=' . $row['id'] . '">' . $row["title"] . '</a></th>
                                  <th>' . $row["eyes"] . '</th>
                                  <th>' . $cDate->format('d/m/Y') . '</th>
                                </tr>
                                ';
                    }
                    ?>
                </table>
            </content>

            <div class="advert bottomadvert">
                <img src="./resources/small3.gif" alt="advertisement">
            </div>

        </div>
</body>

</html>

<script>
    const searchBar = document.querySelector('#searchbarInput');

    function search() {
        if (search !== "") {
            window.location.href = "<?php echo $root_url . '?search=' ?>" + searchBar.value;
        }
    }

    searchBar.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            search();
        }
    });
</script>