<?php

$conn=new mysqli("www.db4free.net","infits_free_test","EH6.mqRb9QBdY.U","infits_db");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$from = date("Y-m-d", strtotime("first day of this month"));
$to = date("Y-m-d", strtotime("last day of this month"));

$clientID = $_POST['clientID'];

$sql = "select steps,dateandtime from steptracker where clientID = '$clientID' and dateandtime between '$from' and '$to';";

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray['date'] = date("d",strtotime($row['dateandtime']));
        $emparray['steps'] = $row['steps'];
        $full[] = $emparray;
    }
    echo json_encode(['steps' => $full]);
?>