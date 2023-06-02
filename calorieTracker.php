<?php
require "connect.php";

date_default_timezone_set("Asia/Calcutta");
$today = date('Y-m-d');
$from1 = date('Y-m-d', strtotime('-0 days', strtotime($today)));

$date = date('Y-m-d H:i:s');
$from = date('Y-m-d 00:00:00', strtotime('-0 days', strtotime($date)));

$clientuserID = $_POST['clientID'];
// $clientuserID = 'test';


$sql = "select sum(caloriesconsumed),sum(carbs),sum(fiber),sum(protein),sum(fat) from calorietracker where clientuserID = '$clientuserID' and time between '$from' and '$date'";

$sql1 = "select * from goals_client where clientuserID = '$clientuserID'";

$sql2 = "select sum(calorie_burnt) from calories_burnt where client_id = '$clientuserID' and date between '$from1' and '$today'";

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

$result1 = mysqli_query($conn, $sql1) or die("Error in Selecting " . mysqli_error($connection));

$result2 = mysqli_query($conn, $sql2) or die("Error in Selecting " . mysqli_error($connection));
$empArray1 = array();
$responseArray = array();
while($row =mysqli_fetch_assoc($result1))
{
          $empArray1['CarbsGoal'] = $row['Carbs'];
          $empArray1['fatsGoal'] = $row['fats'];
          $empArray1['calorieConsumed']=$row['calorieConsumed'];
          $empArray1['calorieBurnt']=$row['calorieBurnt'];
          $empArray1['ProteinGoal'] = $row['Protein'];
          $empArray1['FiberGoal'] = $row['Fiber'];   
}
$responseArray["Goals"]=$empArray1;

$calorieBurnt=mysqli_fetch_assoc($result2);
if($calorieBurnt['sum(calorie_burnt)']==null){
  $calorieBurnt['sum(calorie_burnt)']="0";
}
$responseArray["CalorieBurnt"]=$calorieBurnt['sum(calorie_burnt)'];

// echo implode("",$calorieBurnt);

$emparray = array();

$full=array();
while($row =mysqli_fetch_assoc($result))
{
  // echo implode('',$row);
          if($row['sum(caloriesconsumed)']==null){
            $row['sum(caloriesconsumed)'] = "0";
          }
          $emparray['caloriesconsumed'] = $row['sum(caloriesconsumed)'];
       


          if($row['sum(carbs)']==null){
            $row['sum(carbs)'] = "0";
          }
          $emparray['carbs'] = $row['sum(carbs)'];
          


          if($row['sum(fiber)']==null){
            $row['sum(fiber)'] = "0";
          }
          $emparray['fiber'] = $row['sum(fiber)'];

          
          if($row['sum(protein)']==null){
            $row['sum(protein)'] = "0";
          }
          $emparray['protein'] = $row['sum(protein)'];


          if($row['sum(fat)']==null){
            $row['sum(fat)'] = "0";
          }
          $emparray['fat'] = $row['sum(fat)'];
}
$responseArray["Values"]=$emparray;
echo json_encode(['Data' => $responseArray]);
?>