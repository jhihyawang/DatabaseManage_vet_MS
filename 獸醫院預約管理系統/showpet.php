<?php
require_once "config.php";
session_start();

$userid = $_SESSION [ 'uid' ];
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ( isset ($userid) && $userid!="") { 
 //請注意，這邊因為 $userID 本身是 integer，所以可以不用加 ''
 $query = "SELECT * FROM user WHERE id = $userid";
 $result = mysqli_query($link, $query);
 $row_result = mysqli_fetch_assoc($result);
 $id = $row_result['id'];
 $name = $row_result['u_name'];
 $password = $row_result['password'];
 $phone = $row_result['username'];
 $email = $row_result['email'];
?>


<!DOCTYPE html>
<html lang="en">
<title>個人資訊</title>
<head>
<style>
fieldset {
  background-color: #eeeeee;
}

legend {
  background-color: #CCCCFF;
  color: white;
  padding: 5px 10px;
}

</style>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="#">個人資訊</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="welcome.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="reservation.php">預約掛號</a></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">登出</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
<form action="" method="post" name="formAdd" id="formAdd">
<fieldset>
        <legend>修改個人資料</legend>
        <label>姓名:</label><input type="text" name="cName" id="cName" value="<?php echo $name ?>"><br/>
        <label>電話:</label><input input type="text" name="username" id="username" value="<?php echo $phone ?>"><br/>
        <label>密碼:</label><input type="text" name="password" id="password" value="<?php echo $password ?>"><br/>
        <label>電郵:</label><input type="text" name="email" id="email" value="<?php echo $email ?>"><br/>
        <input type="hidden" name="action" value="update">
        <input type="submit" name="button" value="修改資料">
</fieldset>
</form>
</div><br>
<div class="container">
<caption>可愛的寶貝</caption>
	<table class="table caption-top" style="text-align:center;">
		<thead style="text-align:center;">
			<tr style="text-align:center;" bgcolor="#E8CCFF">
				<th scope="col">寵物名</th>
				<th scope="col">寵物種類</th>
				<th scope="col">寵物生日</th>
                <th scope="col">寵物年齡</th>
                <th scope="col">掰掰</th>
			</tr>
		<tbody>
			<!-- 大括號的上、下半部分 分別用 PHP 拆開 ，這樣中間就可以純用HTML語法-->
			<?php
             $query1 = "SELECT * FROM Pet WHERE id = $userid";
             $result1 = mysqli_query($link, $query1);
             $row_result1 = mysqli_fetch_assoc($result1);
				if(mysqli_num_rows($result1) > 0)
				{
					foreach($result1 as $row1)
					{
                        $age=birthday($row1['p_birth']);
                        echo "<tr>";
                        echo "<td>".$row1['p_name']."</td>";
                        echo "<td>".$row1['p_type']."</td>";
                        echo "<td>".$row1['p_birth']."</td>";
                        echo "<td>".$age." 歲</td>";
                        echo "<td><button><a href='petdelete.php?id=".$row1['p_id']."'>刪除</a></button></td>";
                        echo "</tr>";
				  }
				}
			?>
		</tbody>
        <form action="showpet.php" method="GET">
        <tr style="text-align:center;">
				<th>新增寵物：<input type="text" name="add_pname"></th>
				<th>
                <select name="add_ptype">
                    <option>狗</option>
                    <option>貓</option>
                    <option>兔</option>
                    <option>爬蟲</option>
                    <option>刺蝟</option>
                    <option>蜜袋鼯</option>
                    <option>鼠</option>
                    <option>其他</option>
                </select>
                </th>
				<th><input type="date" name="add_pbirth" id="bookdate" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>"></th>
				<th><button type="submit">新增</button></th>

			</tr>
        </thead>
        </form>
	</table>
</div>
</body>
</html>


<?php
 if (isset($_GET["add_pname"]) && isset($_GET["add_ptype"])&&isset($_GET["add_pbirth"])) {
    if(!empty($_GET["add_pname"])&&!empty($_GET["add_ptype"])&&!empty($_GET["add_pbirth"])){
    $add_pname = $_GET["add_pname"];
    $add_ptype = $_GET["add_ptype"];
    $add_pbirth= $_GET["add_pbirth"];

    $query3 = "INSERT INTO Pet (p_name,p_birth,p_type,id) VALUES ('$add_pname', '$add_pbirth','$add_ptype','$userid')";
    mysqli_query($link,$query3);
    $link->close();
    function_alert_box("新增成功");

}else{
        function_alert_box("輸入不完整");
    }
}

 if (isset($_POST["action"]) && $_POST["action"] == 'update') {
    if(!empty($_POST['cName'])&&!empty($_POST['email'])&&!empty($_POST['password'])&&!empty($_POST['username'])){
     $newName = $_POST['cName'];
     $newemail = $_POST['email'];
     $newpassword= $_POST['password'];
     $newphone = $_POST['username'];


     $query2 = "UPDATE user SET u_name= '$newName', email = '$newemail', password= '$newpassword',username='$newphone' WHERE id = $id";

     mysqli_query($link,$query2);
     $link->close();
     function_alert_box("修改成功");
    }else{
        function_alert_box("輸入不完整");
    }
 }
}
}
function function_alert_box($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
    window.location.href='showpet.php';
    </script>"; 
    return false;
} 
function birthday($birthday){ 
    $age = strtotime($birthday); 
    if($age === false){ 
      return false; 
    } 
    list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age)); 
    $now = strtotime("now"); 
    list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now)); 
    $age = $y2 - $y1; 
    if((int)($m2.$d2) < (int)($m1.$d1)) 
      $age -= 1; 
    return $age; 
  } 
 ?>