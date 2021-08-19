<?php
include __dir__."config.php";

$word = "";
$explanation = "";

if (isset($_POST['word']) and isset($_POST['explanation'])) {
    // Create connection
    $conn = new mysqli($db_host, $db_user, $db_pw, $db_db);

    $word = mysqli_escape_string($conn, $_POST['word']);
    $explanation = mysqli_escape_string($conn, $_POST['explanation']);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = "INSERT INTO glossar(word, explaination, discord_name, discord_id, added_at) VALUES ('$word','$explanation','69','69',now())";
    if ($conn->query($query) === TRUE) {
        echo json_encode(array("gud" => "yes"));
    }
    $conn->close();
}