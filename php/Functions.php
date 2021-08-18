<?php
function showCards()
{
    global $servername;
    global $port;
    global $username;
    global $password;
    global $dbname;

    $textFilter = "";
    $authorFilter = "";
    $IDFilter = "";
    $SortMode = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['text']))
        $textFilter = mysqli_escape_string($conn, $_GET['text']);
    if (isset($_GET['author']))
        $authorFilter = mysqli_escape_string($conn, $_GET['author']);
    if (isset($_GET['ID']))
        $IDFilter = mysqli_escape_string($conn, $_GET['ID']);
    if (isset($_GET['sort']))
        $SortMode = mysqli_escape_string($conn, $_GET['sort']);

    if($IDFilter != "")
        $query = "SELECT * from quotes where Text like '%$textFilter%' and Author like '%$authorFilter%' and ID like '$IDFilter'";
    else
        $query = "SELECT * from quotes where Text like '%$textFilter%' and Author like '%$authorFilter%' and ID like '%$IDFilter%'";

    if($SortMode!=""){
        if($SortMode =="old")
            $query .= " order by addedAt asc";
        else if($SortMode == "new")
            $query .= " order by addedAt desc";
        else{
            $query .= " order by $SortMode";
        }
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        echo "<div class='col s12 m6 l4'>
        <div class='card'>
            <div class='card-content'>
                <span class='card-title'>" . $row['Text'] . "</span>
            </div>
            <div class='card-action'>
                <span>" . $row['Author'] . "</span>
                <span class='right idDisplay tooltipped' data-position='bottom' data-tooltip='Click to Share' onclick='copy(".$row['ID'].")'>ID: " . $row['ID'] . "</span>
            </div>
        </div>
    </div>";
    }
    $conn->close();
}

function generateMeta()
{
    global $servername;
    global $port;
    global $username;
    global $password;
    global $dbname;

    $IDFilter = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['ID']))
        $IDFilter = mysqli_escape_string($conn, $_GET['ID']);

    if($IDFilter != "")
        $query = "SELECT * from quotes where ID like '$IDFilter'";
    else
        $query = "SELECT * from quotes order by rand() limit 1";

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<meta property="og:title" content="' . $row['Text'] . '"/>
                <meta property="og:url" content="https://reisminer.xyz/quotes"/>
                <meta property="og:type" content="website"/>
                <meta property="og:description" content="' . $row['Author'] . '"/>';
    }
    $conn->close();
}