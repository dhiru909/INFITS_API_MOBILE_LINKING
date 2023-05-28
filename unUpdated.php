<?php

$conn=new mysqli("www.db4free.net","infits_free_test","EH6.mqRb9QBdY.U","infits_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$clientID = $_POST['clientID'];

$i = $_POST['month'];

// $userID = 'Azarudeen';

// $i = 10;

$sql = "select date from weighttracker where clientID='$clientID'";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $full[] = $row['date'];
}

$list=array();

$mon = 0;

if($i%2 == 0){
  $mon = 31;
}
else if($i == 0){
  $mon = 28;
}
else{
  $mon = 30;
}
  for($d=1; $d<=$mon; $d++)
  {
    $time = mktime(0,0,0,date($i,strtotime("first day of $i")), $d,date('Y'));
      // $time=mktime(0, 0, 0, date("m",strtotime("first day of $i")), $d, date('Y'));
      $list[]=date("Y-m-d", $time);
      if (date("Y-m-d", $time)==date("Y-m-d"))
        break;
}

$array = array_values(array_diff($list, $full));

echo json_encode(['dates' => $array]);

?>