<?php
function showCards()
{
    include "config.php";

    $wordFilter = "";
    $explanationFilter = "";
    $userFilter = "";
    $IDFilter = "";
    $SortMode = "";

    // Create connection
    $conn = new mysqli($db_host, $db_user, $db_pw, $db_db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['word']))
        $wordFilter = mysqli_escape_string($conn, $_GET['word']);
    if (isset($_GET['explanation']))
        $explanationFilter = mysqli_escape_string($conn, $_GET['explanation']);
    if (isset($_GET['user']))
        $userFilter = mysqli_escape_string($conn, $_GET['user']);
    if (isset($_GET['id']))
        $IDFilter = mysqli_escape_string($conn, $_GET['id']);
    if (isset($_GET['sort']))
        $SortMode = mysqli_escape_string($conn, $_GET['sort']);

    if($IDFilter != "")
        $query = "SELECT * from glossar where word like '%$wordFilter%' and explanation like '%$explanationFilter%' and discord_name like '%$userFilter%' and id like '$IDFilter'";
    else
        $query = "SELECT * from glossar where word like '%$wordFilter%' and explanation like '%$explanationFilter%' and discord_name like '%$userFilter%' and id like '%$IDFilter%'";

    if($SortMode!=""){
        if($SortMode =="old")
            $query .= " order by added_at asc";
        else if($SortMode == "new")
            $query .= " order by added_at desc";
        else{
            $query .= " order by $SortMode";
        }
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<div class="col s12 m6 l4">
        <div class="card blue-grey darken-3">
            <div class="card-content">
                <span class="card-title">' . $row["word"] . '</span>
                <p class="">' . $row["explanation"] . '</p>
            </div>
            <div class="card-action">
                <span>Added by: ' . $row["discord_name"] . '</span>
                <span class="right idDisplay tooltipped" data-position="bottom" data-tooltip="Click to Share" onclick="copy('.$row["id"].')">ID: ' . $row["id"] . '</span>
            </div>
        </div>
    </div>';
    }
    $conn->close();
}

function generateMeta()
{
    include "config.php";
    $IDFilter = "";

    // Create connection
    $conn = new mysqli($db_host, $db_user, $db_pw, $db_db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['ID']))
        $IDFilter = mysqli_escape_string($conn, $_GET['ID']);

    if($IDFilter != "")
        $query = "SELECT * from glossar where id like '$IDFilter'";
    else
        $query = "SELECT * from glossar order by rand() limit 1";

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<meta property="og:title" content="' . $row['word'] . '"/>
                <meta property="og:url" content="'.$this_site.'"/>
                <meta property="og:type" content="website"/>
                <meta property="og:description" content="' . $row['explanation'] . '"/>';
    }
    $conn->close();
}