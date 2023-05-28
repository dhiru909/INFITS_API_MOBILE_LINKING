<?php
// Create 4 variables to store these information
$server="www.db4free.net";
$username="infits_free_test";
$passwordd="EH6.mqRb9QBdY.U";
$database = "infits_db";
// Create connection
$conn = new mysqli($server, $username, $passwordd, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>