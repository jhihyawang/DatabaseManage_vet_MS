<?php
    $userID = $_GET['id'];
    require_once "config.php";

    $query = "DELETE FROM schedule WHERE r_id =  $userID";
    $result = mysqli_query($link, $query);
    $link->close();
    if($result===TRUE){
        function_alert("預約已刪除");
        exit();
    }
    function function_alert($message) { 
      
        // Display the alert box  
        echo "<script>alert('$message');
         window.location.href='schedule.php';
        </script>"; 
        return false;
    } 
    
?>
