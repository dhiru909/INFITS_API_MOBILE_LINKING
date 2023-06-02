<?php

$server="127.0.0.1:3306";
$username="root";
$password="";
$database = "infits";

$conn=mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// $clientID="test";
$clientID=$_POST['clientID'];

$duration=$_POST['for'];
// $duration="today";
date_default_timezone_set("Asia/Calcutta");

switch($duration){
  case "today":
    $today = date('Y-m-d H:i:s');
    $from=date('Y-m-d 00:00:00',strtotime("-0 days",strtotime($today)));
    break;
    // echo $from;
  case "week":
    $today = date('Y-m-d H:i:s');
    $from=date('Y-m-d 00:00:00',strtotime("-7 days",strtotime($today)));
    break;
  case "month":
    $today = date('Y-m-d H:i:s');
    $from=date('Y-m-d 00:00:00',strtotime("-30 days",strtotime($today)));
    break;
  }
getData($conn,$clientID,$today,$from);



function getData($conn,$clientID,$today,$from){
      $Meal_Type1=array("BreakFast","Lunch","Dinner","Snacks");
      $duration="today";
      $final=array();
      foreach($Meal_Type1 as $Meal_Type){
      $sql="select * from calorietracker where clientID='$clientID' and MealType='$Meal_Type'
      and time between '$from' and '$today' order by time DESC";
      $sql1="select sum(caloriesconsumed) from calorietracker where clientID='$clientID' and MealType='$Meal_Type' and time between '$from' and '$today'";
      $sql2="select sum(caloriesconsumed) from calorietracker where clientID='$clientID'
      and time between '$from' and '$today'";
      
      $result=mysqli_query($conn,$sql);
      $result1=mysqli_query($conn,$sql1);
      $result2=mysqli_query($conn,$sql2);
      
      $emparray=array();
      
      $row1=mysqli_fetch_assoc($result1);
      $row2=mysqli_fetch_assoc($result2);
      
      $full=array();
      $full1=array();
      if($row1['sum(caloriesconsumed)']==null){
        $row1['sum(caloriesconsumed)']="0";
      }
      if($row2['sum(caloriesconsumed)']==null){
        $row2['sum(caloriesconsumed)']="0";
      }
      $full['MealType_caloriesconsumed']=$row1['sum(caloriesconsumed)'];
      
      // switch($duration){
      //   case 'day'
      // }
      while($row=mysqli_fetch_assoc($result)){
                // $emparray['Meal_Name']=$row['Meal_Name'];
                // $emparray['caloriesconsumed']=$row['caloriesconsumed'];
                // $emparray['time']=$row['time'];
                // $emparray['carbs']=$row['carbs'];
                // $emparray['fiber']=$row['fiber'];
                // $emparray['protein']=$row['protein'];
                // $emparray['fat']=$row['fat'];
                // $emparray['MealType']=$row['MealType'];
                // $emparray['Quantity']=$row['Quantity'];
                $emparray[]=$row;
                // echo implode("   ",$emparray);
      
      }
      $full['data']=$emparray;
      // $full1[$Meal_Type]=$full;
      $final[$Meal_Type]=$full;
      }
      $final['total_caloriesconsumed']=$row2['sum(caloriesconsumed)'];

      echo json_encode(['value'=>$final]);
}
// getData($conn,$clientID);
?>