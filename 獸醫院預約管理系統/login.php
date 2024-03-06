<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username=$_POST["username"];
$password=$_POST["password"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "SELECT * FROM user WHERE username ='".$username."'";
    $result=mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)==1 && $password==$row["password"]){
        setcookie("name", $username);
        session_start();
        // Store data in session variables
        //這些是之後可以用到的變數
        if($row["level"]==1){ 
            $_SESSION["admin_in"] = true;
            $_SESSION["username"] = $username;
            header("Location:member_admin.php");
            exit();
        }else{
            $_SESSION['level']=$row["level"];
            $_SESSION["uid"] = $row["id"];
            $_SESSION["username"] = $username;
            $_SESSION["u_name"] = $row["u_name"];
            $_SESSION["loggedin"] = true;
            if ( isset ( $_SESSION [ 'uid' ]) && $_SESSION [ 'uid' ]!="") { 
                echo "User: " . $_SESSION [ 'uid' ]; 
                header('Location:welcome.php');
            exit();
            } else { 
                echo "沒有用戶" ; }
        }
    }else{
            function_alert("帳號或密碼錯誤"); 
        }
}else{
        function_alert("Something wrong"); 
    }

    // Close connection
    mysqli_close($link);



function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='index.php';
    </script>"; 
    return false;
} 
function function_alert_box($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='welcome.php';
    </script>"; 
    return false;
} 

?>