<?php
$conn=new mysqli("www.db4free.net","infits_free_test","EH6.mqRb9QBdY.U","infits_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$userID = $_POST['userID'];
$date = $_POST['date'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$bmi = $_POST['bmi'];
$goal = $_POST['goal'];

$sql = "select weight from weighttracker where clientID='$userID' and date = '$date'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
$sql = "insert into weighttracker values('$date',$height,$weight,$bmi,$goal,'$userID')";
if (mysqli_query($conn,$sql)) {
    $sql = "update client set height='$height',weight = '$weight' where clientuserID = '$userID'";
    mysqli_query($conn,$sql);
    echo "updated";
}
else{
    echo "error1";
}
}
else{
    $sql = "update weighttracker set height='$height',weight = '$weight',goal = '$goal',bmi = '$bmi' where date = '$date' and clientID = '$userID'";
    if (mysqli_query($conn,$sql)) {
        $sql = "update client set height='$height',weight = '$weight' where clientuserID = '$userID'";
        mysqli_query($conn,$sql);
        echo "updated";
    }
    else{
        echo "error2";
    }   
}
?>