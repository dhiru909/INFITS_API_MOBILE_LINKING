<?php 
    // Database connection details
    require "connect.php";
    $result = array();

    // Check for errors
    if ($conn->connect_error) {
        $result['error'] = "true";
        $result['message'] =  $conn->connect_error;
    die("Connection failed: " . $conn->connect_error);
    }



    $clientID = $_POST['clientID'];

    $date = $_POST['date'];
    
    switch ($_POST['for']) {
    case 'day':
        $stmnt = $conn->prepare("SELECT * FROM `calories_burnt` WHERE `client_id` LIKE ? AND `date` = ?");
        $stmnt->bind_param("ss",$clientID,$date);
        break;
    case 'week':
        $stmnt = $conn->prepare("SELECT * FROM `calories_burnt` WHERE `client_id` LIKE ? AND `date` BETWEEN DATE_SUB(curdate(), INTERVAL 1 WEEK) AND curdate() ORDER BY `calories_burnt`.`date` DESC");
        $stmnt->bind_param("s",$clientID);
        break;
    case 'month':
        $stmnt = $conn->prepare("SELECT *
        FROM `calories_burnt`
        WHERE `client_id` LIKE ? 
          AND `date` BETWEEN DATE_SUB(curdate(), INTERVAL 1 MONTH) AND curdate() 
        ORDER BY `date` DESC
        ");
       
        $stmnt->bind_param("s",$clientID);
        break;
    default:
        $result['error'] = "true";
        $result['message'] =  "for Values not provided";
        break;
}


    if($stmnt->execute()){
        $result['error'] = "false";
        $result['message'] =  "Values entered sucessfully";
        $row = $stmnt->get_result();

// Loop through all rows in the result set and print the data
    while ($temp = $row->fetch_assoc()) {
            $result[] = $temp;
        }
        echo json_encode($result);
    }
    else{
        $result['error'] = "true";
        $result['message'] =  "Values not entered";
        echo json_encode($result);
    }


    
  
?>