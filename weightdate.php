<?php

$conn=new mysqli("www.db4free.net","infits_free_test","EH6.mqRb9QBdY.U","infits_db");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$userID = $_POST['userID'];

$mon = $_POST['month'];

// $userID = 'Azarudeen';

// $mon = 'Jun';

$from = date("Y-m-d", strtotime("first day of $mon"));
$to = date("Y-m-d", strtotime("last day of $mon"));

$sql = "select date,weight from weighttracker where clientID='$userID' and date between '$from' and '$to'";

$result = mysqli_query($conn, $sql);

$emparray = array();

while ($row = mysqli_fetch_assoc($result)) {
    $emparray['date'] = $row['date'];
    $emparray['weight'] = $row['weight'];
    $full[] = $emparray;
}
echo json_encode(['weight' => $full]);
?>