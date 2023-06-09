<?php
require "connect.php";

$steps = $_POST['steps'];
echo "$steps";
$distance = $_POST['distance'];
echo "$distance";
$calories = $_POST['calories'];
echo "$calories";
$userID = $_POST['clientuserID'];
$dateandtime = $_POST['dateandtime'];

$date = date("Y-m-d", strtotime($dateandtime));
$goal = "1";
$stmt = $conn->prepare("select steps,distance,calories from walkingtracker where date(date) like '%$date%' and clientuserID = '$userID';");
$stmt->execute();
$stmt->store_result();


if ($stmt->num_rows() > 0) {
    $stmt->bind_result($steps_old, $distance_old, $calories_old);
    $stmt->fetch();
    $steps+=$steps_old;
    $distance+=$distance_old;
    $calories+=$calories_old;
  $stmt = $conn->prepare("update walkingtracker set calories = '$calories', distance = '$distance', steps= $steps where date(date) like '%$date%' and clientuserID = '$userID';");
  $stmt->execute();
  $stmt->store_result();    

  if ($stmt->affected_rows>0) {
    echo " success";
  } else {
    echo "errorSucc";
  }
}else{
  $stmt->free_result();
  $stmt = $conn->prepare("insert into walkingtracker(`clientuserID`, `steps`, `date`, `calories`, `distance`)  values ('$userID', $steps, '$date','$calories', '$distance');");
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->affected_rows) {
    echo " success";
  } else {
    echo "error";
  }
}


?>