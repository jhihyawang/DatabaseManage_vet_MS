<?php
$conn=require_once("config.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST["username"];
    $password=$_POST["password"];
    $u_name=$_POST["u_name"];
    $email=$_POST["email"];

    //檢查帳號是否重複
    $check="SELECT * FROM user WHERE username ='".$username."'";
    if(mysqli_num_rows(mysqli_query($conn,$check))==0){
        $sql="INSERT INTO user (id,username, password,u_name,email)
            VALUES(NULL,'".$username."','".$password."','".$u_name."','".$email."')";
        
        if(mysqli_query($conn, $sql)){
            echo "註冊成功!3秒後自動跳轉登入頁面<br>";
            echo "<a href='index.php'>若無自動跳轉 請重新登入</a>";
            header("refresh:3 ;url=index.php");
            exit;
        }else{
            echo "Error creating table: " . mysqli_error($conn);
        }
    }
    else{
        echo "該帳號已有人使用!<br>3秒後將自動跳轉回註冊頁面<br>";
        echo "<a href='register.php'>未成功跳轉頁面請點擊此</a>";
        header("refresh:3;url=register.php",true);
        exit;
    }
}


mysqli_close($conn);

function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='index.php';
    </script>"; 
    
    return false;
} 
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>註冊</title>
    <script>
        
        function validateForm() {
            var p = document.forms["registerForm"]["username"].value;
            var x = document.forms["registerForm"]["password"].value;
            var y = document.forms["registerForm"]["password_check"].value;
            if(p.length!=10){
                alert("PHONE 格式錯誤 請輸入手機號碼10碼");
                return false;
            }
            if(x.length<6){
                alert("密碼長度不足");
                return false;
            }
            if (x != y) {
                alert("請確認密碼是否輸入正確");
                return false;
            }
        }
    </script>
	<!-- Meta-Tags -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- //Meta-Tags -->

	<!-- Style --> <link rel="stylesheet" href="css/signup.css" type="text/css" media="all">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<!-- //Head -->

<!-- Body -->
<body>

	<div class="container w3layouts agileits">
		<div class="register w3layouts agileits">
			<h2>Sign up</h2>
            <form name="registerForm" method="post" action="register.php" onsubmit="return validateForm()">
				<input type="text" name="username" placeholder="PHONE" required="">
				<input type="text" name="email" placeholder="EMAIL" required="">
				<input type="text" name="u_name" placeholder="NAME" required="">
				<input type="password" name="password" id="password" placeholder="PASSWORD" required="">
                <input type="password" name="password_check" id="password_check" placeholder="PASSWORD CHECK" required="">
			<div class="send-button w3layouts agileits">
            <button type="submit" onclick="window.location.href='index.php'">回上一頁</button>
                    <input type="reset" value="清除" name="submit">
					<input type="submit" value="Sign up" name="submit">
                
			</form>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>

	<div class="footer w3layouts agileits">
		<p>Copyright &copy;From Selina Wang 4110029009</p>
	</div>
<style>
.copyrights{text-indent:-9999px;height:0;line-height:0;font-size:0;overflow:hidden;}
</style>
</body>
<!-- //Body -->

</html>