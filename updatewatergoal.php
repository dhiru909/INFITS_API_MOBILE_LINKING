<?php

require "connect.php";
// $stmt = $conn->prepare("update steptracker set goal = $goal where  date(dateandtime) like 
// '%$date%' and clientuserID = '$userID';");
$userID = $_POST['clientuserID'];
$goal = $_POST['goal'];
$dateandtime = $_POST['dateandtime'];
$type = $_POST['type'];
$amount = $_POST['amount'];
$date = date("Y-m-d", strtotime($dateandtime));
// echo "$date";
$stmt = $conn->prepare("select row_id from watertracker where date(dateandtime) like '%$date%' and clientuserID = '$userID';");
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows() > 0) {
  $stmt = $conn->prepare("update watertracker set goal = $goal where  date(dateandtime) like 
 '%$date%' and clientuserID = '$userID';");
  $stmt->execute();
  $stmt->store_result();
  echo " success " . " $stmt->affected_rows";
} else {
  echo " success1" . " $stmt->affected_rows";
  $stmt = $conn->prepare("select client_id ,dietitian_id, dietitianuserID  from client WHERE clientuserID = '$userID';");
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($clientID, $dietitian_id, $dietitianuserID);
  $stmt->fetch();
  $stmt = $conn->prepare("insert into watertracker(client_id, clientuserID, dietitian_id, dietitianuserID, goal, dateandtime,type,amount) values($clientID , '$userID',$dietitian_id, '$dietitianuserID', $goal, '$dateandtime','$type',$amount);");
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->affected_rows) {
    echo " success";
  } else {
    echo "error";
  }
}

?>
