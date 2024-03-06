 <?php
session_start(); 
$_SESSION = array(); 
session_destroy(); 
setcookie ( "name", "", time () - 100 );
header('location:index.php'); 
?>
