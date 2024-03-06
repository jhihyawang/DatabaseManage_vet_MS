<?php
// Initialize the session
session_start();
?>


<DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>登入</title>
<link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css ">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="overlay">

<form action="login.php" method="post">
   <div class="con">
   <header class="head-form">
      <h2>Log In</h2>
      <p>login here using your phone and password</p>
   </header>
   <br>
   <div class="field-set">
     
         <span class="input-item">
         <i class="fa fa-user-circle-o" aria-hidden="true"></i>
         </span>

         <input name="username" class="form-input"  id="txt-input" type="text" placeholder="Phone" required>
      <br>
     
      <span class="input-item">
        <i class="fa fa-key"></i>
       </span>

      <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password" required>

     <span>
        <i class="fa fa-eye" aria-hidden="true"  type="button" id="eye"></i>
     </span>
    
      <br>
      <button class="log-in" type="submit" name="submit"> Log In </button>
   </div>
  
   <div class="other">
      <button class="btn submits frgt-pass" onclick="window.location.href='updatepw.php'">Forgot Password</button>

     <button class="btn submits sign-up" type="submit" onclick="window.location.href='register.php'">Sign Up
      <i class="fa fa-user-plus" aria-hidden="true"></i></a>
      </button>
   </div>
  </div>
</form>
</div>

<div class="footer w3layouts agileits">
		<p>Copyright &copy;From Selina Wang 4110029009</p>
	</div>
   <style>
.copyrights{text-indent:-9999px;height:0;line-height:0;font-size:0;overflow:hidden;}
</style>
<script 
    src="js/login.js">
</script>
</body>

</html>