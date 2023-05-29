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
$date=$_POST['dateandtime'];

$sql = "select sum(drinkConsumed) x , sum(goal) y, dateandtime from watertracker where clientuserID='$clientuserID' and dateandtime ='$date' group by dateandtime";

$result = mysqli_query($conn, $sql);

$full = array();
while ($row = mysqli_fetch_assoc($result)) {

    $emparray['date'] = $row['dateandtime'];
    $emparray['drinkConsumed'] = $row['x'];
    $emparray['goal'] = $row['y'];

    $full[] = $emparray;
}

// usort($full, 'date_compare');

echo json_encode(['water' => $full]);




// if (mysqli_num_rows($result) == 0) {
//     $sql = "insert into watertrackerdt values('$consumed','$goal','$dateandtime','$userID','$type','$amount')";
//     if (mysqli_query($conn, $sql)) {
//         echo "updated";
//     } else {
//         echo "error";
//     }
// } else {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $liquid = $row['drinkConsumed'];
//     }
//     $liquid += $amount;
//     $sql = "insert into watertrackerdt values('$liquid','$goal','$dateandtime','$userID','$type','$amount')";
//     if (mysqli_query($conn, $sql)) {
//         echo "updated";
//     } else {
//         echo "error";
//     }
// }

?>


