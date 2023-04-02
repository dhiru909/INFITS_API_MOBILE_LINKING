<?php

// $server = "127.0.0.1:3306";
// $username = "root";
// $password = "";
// $database = "infits_app";

// $conn = mysqli_connect($server, $username, $password, $database);
$conn = new mysqli("www.db4free.net", "infits_free_test", "EH6.mqRb9QBdY.U", "infits_db");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$clientID = $_POST['clientID'];
$date = date('Y-m-d h:i:s', strtotime($_POST['date']));
$type = $_POST['type'];
$text = $_POST['text'];

$sql = "insert into in_app_notifications values('$clientID','$type','$date','$text')";

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

if($result) {
    echo "inserted";
}

?>