<?php
function date_compare($a, $b)
{
    $t1 = $a['date'];
    $t2 = $b['date'];
    return $t2 - $t1;
}
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


$sql = "select * from watertracker where clientID='$clientID' and date = '$date' and type='$type'";

$result = mysqli_query($conn, $sql);

// $full = array();
// while ($row = mysqli_fetch_assoc($result)) {

//     $emparray['dateandtime'] = $row['dateandtime'];
//     $emparray['drinkConsumed'] = $row['drinkConsumed'];
//     $emparray['goal'] = $row['goal'];

//     $full[] = $emparray;
// }

// echo json_encode(['water' => $full]);

if (mysqli_num_rows($result) == 0) {
    $sql = "insert into watertracker(drinkConsumed,goal,date,clientuserID,time,type,amount,clientID,dietitian_id) values('$consumed','0','$date','$clientuserID','$time','$type','$amount','$clientID','$dietitian_id')";
    if (mysqli_query($conn, $sql)) {
        echo "inserted_add_liq";
    } else {
        echo "error";
    }
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $liquid = $row['drinkConsumed'];
	
    }

    $liquid += $amount;

    $sql = "update watertracker set amount='$amount',drinkConsumed='$liquid' where clientID='$clientID' and date='$date' and type='$type'";
    if (mysqli_query($conn, $sql)) {
        echo "updated_add_liq";
    } else {
        echo "error";
    }
}
