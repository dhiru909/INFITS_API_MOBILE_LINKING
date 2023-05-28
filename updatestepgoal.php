<?php

$conn = new mysqli("www.db4free.net", "infits_free_test", "EH6.mqRb9QBdY.U", "infits_db");


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$userID = $_POST['clientuserID'];
$goal = $_POST['goal'];
$dateandtime = $_POST['dateandtime'];
echo $dateandtime;
$stmt =  $conn->prepare("update steptracker set goal = $goal where dateandtime = date('$dateandtime') and clientuserID = '$userID';");
$stmt->execute();
$stmt->store_result();

if ($stmt->affected_rows) {
  echo " success";
} else {
  echo "error";
}

?>