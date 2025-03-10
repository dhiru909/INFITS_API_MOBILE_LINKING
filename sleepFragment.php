<?php 
require "connect.php";
// Create connection
$conn=mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

	$userID = $_POST['userID'];
	
	$stmnt = $conn -> prepare("SELECT AVG(hrsSlept) FROM sleeptracker WHERE WEEKOFYEAR(cast(sleeptracker.waketime as DATE))=WEEKOFYEAR(NOW())AND clientid=?");
	
	$stmnt-> bind_param("s",$userID);
	$stmnt-> execute();
	$stmnt-> bind_result($Sum);
	
	$products = array();
	
	while($stmnt->fetch()){
	  $temp = array();
	  
	  $temp['SumWeek']= $Sum;
	   
	  array_push($products,$temp);
	}

	$stmnt = $conn -> prepare("SELECT AVG(hrsSlept) FROM sleeptracker WHERE YEAR(cast(sleeptracker.waketime as DATE)) = YEAR(NOW()) AND MONTH(cast(sleeptracker.waketime as DATE))=MONTH(NOW()) AND clientid=?");
	
	$stmnt-> bind_param("s",$userID);
	$stmnt-> execute();
	$stmnt-> bind_result($Sum);
	
	while($stmnt->fetch()){
	  $temp = array();
	  
	  $temp['SumMonth']= $Sum;
	   
	  array_push($products,$temp);
	}

	$stmnt = $conn -> prepare("SELECT AVG(hrsSlept) FROM sleeptracker WHERE cast(sleeptracker.waketime as DATE)=CURRENT_DATE AND clientid=?");
	
	$stmnt-> bind_param("s",$userID);
	$stmnt-> execute();
	$stmnt-> bind_result($Sum);
	
	while($stmnt->fetch()){
	  $temp = array();
	  
	  $temp['SumDaily']= $Sum;
	   
	  array_push($products,$temp);
	}

	$stmnt = $conn -> prepare("SELECT AVG(hrsSlept) FROM sleeptracker WHERE clientid=?");
	
	$stmnt-> bind_param("s",$userID);
	$stmnt-> execute();
	$stmnt-> bind_result($Sum);
	
	while($stmnt->fetch()){
	  $temp = array();
	  
	  $temp['SumTotal']= $Sum;
	   
	  array_push($products,$temp);
	}

if(count($products)>-1){
echo json_encode($products);
}

else {
echo "failure";
}
?>
