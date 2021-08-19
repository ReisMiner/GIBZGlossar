<?php
include "config.php";
session_start();
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
    $dc_user = $_SESSION["username"];
    $dc_id = $_SESSION['user_id'];
    $query = "INSERT INTO glossar(word, explanation, discord_name, discord_id, added_at) VALUES ('$word','$explanation','$dc_user','$dc_id',now())";
    if ($conn->query($query) === TRUE) {
        echo json_encode(array("gud" => "yes"));
    }
    $conn->close();
}