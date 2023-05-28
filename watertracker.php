<?php
$conn=new mysqli("www.db4free.net","infits_free_test","EH6.mqRb9QBdY.U","infits_db");


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$clientuserID = $_POST['clientuserID'];
$date=$_POST['date'];
$time=$_POST['time'];
$goal = $_POST['goal'];
$type = $_POST['type'];
$amount = $_POST['amount'];
$consumed = $_POST['consumed'];
$clientID=$_POST['clientID'];
$dietitian_id=$_POST['dietitian_id'];



// $sql = "select drinkConsumed from watertracker where clientID='$userID' and date = '$date'";

// $result = mysqli_query($conn, $sql);

// if(mysqli_num_rows($result) == 0){
// $sql = "insert into watertracker values('$consumed','$goal','$date','$userID')";
// if (mysqli_query($conn,$sql)) {
//     echo "updated";
// }
// else{
//     echo "error";
// }
// }
// else{
//     $sql = "update watertracker set drinkConsumed = '$consumed',goal = '$goal' where clientID = '$clientID' and date = '$date'";
//     if (mysqli_query($conn,$sql)) {
//         echo "updated";
//     }
//     else{
//         echo "error";
//     }   
// }

$sql = "select drinkConsumed, goal from watertracker where clientID='$clientID' and date = '$date' and type='$type'";

// $liquid = 0;

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
$sql = "insert into watertracker(drinkConsumed,goal,date,clientuserID,time,type,amount,clientID,dietitian_id) values('$consumed','$goal','$date','$clientuserID','$time','$type','$amount','$clientID','$dietitian_id')";
if (mysqli_query($conn,$sql)) {
    echo "inserted_water_goal ";
}
else{
    echo "error_in_insertion";
}
}
else{
    while ($row = mysqli_fetch_assoc($result)) {
        $liquid = $row['drinkConsumed'];
	$old=$row['goal'];
    }
   $new_goal=$goal+ $old;
    $liquid += $amount;
    
	$sql="update watertracker set time ='$time', goal='$new_goal'  where clientID='$clientID' and date='$date'";

    //$sql = "insert into watertracker(drinkConsumed,goal,date,clientuserID,time,type,amount,clientID,dietitian_id) values('$liquid','$goal','$date','$clientuserID','$time','$type','$amount','$clientID','$dietitian_id')";

if (mysqli_query($conn,$sql)) {
    echo "updated_water_goal";
}
else{
    echo "error_in_updation";
}
}
?>