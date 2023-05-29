<?php

$conn = new mysqli("www.db4free.net", "infits_free_test", "EH6.mqRb9QBdY.U", "infits_db");


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$userID = $_POST['clientuserID'];
$calories = $_POST['calories'];
$distance = $_POST['distance'];
$steps = $_POST['steps'];
$avgspeed = $_POST['avgspeed'];
$dateandtime = $_POST['dateandtime'];
$goal = $_POST['goal'];
$stmt = $conn->prepare("select * from steptracker where clientuserID = '$userID' and dateandtime like cast(date('$dateandtime') as DATE );");
$stmt->execute();
if ($stmt->num_rows() > 0) {
  $stmt = $conn->prepare("update steptracker set calories = '$calories',dateandtime = '$dateandtime' , distance = '$distance', steps= $steps,avgspeed = '$avgspeed' where dateandtime like cast(date('$dateandtime') as DATE ) and clientuserID = '$userID';");
  $stmt->execute();
  $stmt->store_result();    

  if ($stmt->affected_rows) {
    echo " success";
  } else {
    echo "error";
  }
}else{
  $stmt = $conn->prepare("select client_id ,dietitian_id, dietitianuserID  from client WHERE clientuserID = '$userID';");
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($clientID, $dietitian_id, $dietitianuserID);
  $stmt->fetch();
  $stmt = $conn->prepare("insert into steptracker values ($clientID,'$userID',$dietitian_id,'$dietitianuserID', $steps, date('$dateandtime'),$goal, '$calories', '$distance','$avgspeed');");
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->affected_rows) {
    echo " success";
  } else {
    echo "error";
  }
}


?>