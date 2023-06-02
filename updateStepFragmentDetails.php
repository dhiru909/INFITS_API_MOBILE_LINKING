<?php
require "connect.php";

$steps = $_POST['steps'];
echo "$steps";
$distance = $_POST['distance'];
echo "$distance";
$calories = $_POST['calories'];
echo "$calories";
$avgspeed = $_POST['avgspeed'];
echo "$avgspeed";
$userID = $_POST['clientuserID'];
$dateandtime = $_POST['dateandtime'];

$date = date("Y-m-d", strtotime($dateandtime));
$goal = "1";
$stmt = $conn->prepare("select row_id from steptracker where date(dateandtime) like '%$date%' and clientuserID = '$userID';");
$stmt->execute();
$stmt->store_result();


if ($stmt->num_rows() > 0) {
  $stmt = $conn->prepare("update steptracker set calories = '$calories',dateandtime = '$dateandtime' , distance = '$distance', steps= $steps,avgspeed = '$avgspeed' where date(dateandtime) like '%$date%' and clientuserID = '$userID';");
  $stmt->execute();
  $stmt->store_result();    

  if ($stmt->affected_rows>0) {
    echo " success";
  } else {
    echo "errorSucc";
  }
}else{
  $stmt->free_result();
  $stmt = $conn->prepare("select client_id ,dietitian_id, dietitianuserID  from client WHERE clientuserID = '$userID';");
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($clientID, $dietitian_id, $dietitianuserID);
  $stmt->fetch();
  $stmt = $conn->prepare("insert into steptracker(`client_id`, `clientuserID`, `dietitian_id`, `dietitianuserID`, `steps`, `dateandtime`, `goal`, `calories`, `distance`, `avgspeed`)  values ($clientID,'$userID',$dietitian_id,'$dietitianuserID', $steps, '$dateandtime',$goal, '$calories', '$distance','$avgspeed');");
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->affected_rows) {
    echo " success";
  } else {
    echo "error";
  }
}


?>