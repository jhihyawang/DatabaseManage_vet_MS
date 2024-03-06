<?php 
require_once "config.php";
session_start();  //很重要，可以用的變數存在session裡
if(isset($_SESSION["admin_in"]) && $_SESSION["admin_in"] === true){
        echo(null);
?>


<!DOCTYPE html>
<html lang="en">
<title>飼主資訊</title>
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>

<body class="d-flex flex-column h-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="member_admin.php">中興獸醫院後台管理 歡迎管理者：<?php echo $_COOKIE['name'];?></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="vetinfo.php">醫生資料</a></li>
                            <li class="nav-item"><a class="nav-link" href="schedule.php">預約修改/刪除</a></li>
                            <li class="nav-item"><a class="nav-link" href="searchowner.php">查詢飼主資料</a></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">登出</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container" align="center">
                <br>
                <h4>查詢飼主</h4>

            <form action="searchowner.php" method="post">
                帳號(電話):<input type="text" name="username">
                <input type="hidden" name="action" value="search">
                <button type="submit" class="btn btn-info">查詢</button>
            </form>

            <?php
//先檢查請求來源是否是我們上面創建的 form
if (isset($_POST["action"])&&($_POST["action"] == "search")) {

    //取得請求過來的資料
    $username = $_POST["username"];
    $sql =  "SELECT * FROM user WHERE username ='".$username."'";
    $result=mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($result);
    if(isset($row['username'])){

    $u_id = $row['id'];
    $u_name = $row['u_name'];
    $u_email = $row['email'];


?>

            </div><br>
<div class="container">
<caption>飼主資料</caption>
	<table class="table caption-top" style="text-align:center;" align="center">
		<thead style="text-align:center;">
			<tr style="text-align:center;" bgcolor="#FFDDAA">
                <th scope="col">電話</th>
				<th scope="col">姓名</th>
				<th scope="col">電郵</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(!empty($row))
				{
					echo "<tr>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['u_name']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "</tr>";
				}
			?>
		</tbody>
    </table>
    <?php
                $sql2 =  "SELECT * FROM Pet WHERE id = $u_id";
                $result2=mysqli_query($link,$sql2);
            if(mysqli_num_rows($result2) > 0)
            {
    ?>
    <caption>寵物資料</caption>
    <table class="table caption-top" style="text-align:center;" align="center">
		<thead style="text-align:center;">
			<tr style="text-align:center;" bgcolor="#CCFF99">
                <th scope="col">種類</th>
				<th scope="col">名字</th>
				<th scope="col">生日</th>
                <th scope="col">年齡</th>
			</tr>
		</thead>
		<tbody>
			<?php
                foreach($result2 as $row2)
                {
                    $age=birthday($row2['p_birth']);
                    echo "<tr>";
                    echo "<td>".$row2['p_type']."</td>";
                    echo "<td>".$row2['p_name']."</td>";
                    echo "<td>".$row2['p_birth']."</td>";
                    echo "<td>".$age." 歲</td>";
                    echo "</tr>";
                    
              }
			?>
		</tbody>
    </table>
    <br>
    <?php
    $sql5 =  "SELECT * FROM schedule,Pet,user WHERE schedule.p_id = Pet.p_id AND Pet.id = $u_id";
    $result5=mysqli_query($link,$sql5);
    if(mysqli_num_rows($result5) > 0){
    ?>
    <caption>預約記錄</caption>
    <table class="table caption-top" style="text-align:center;" align="center">
		<thead style="text-align:center;">
			<tr style="text-align:center;" bgcolor="#CCDDFF">
                <th scope="col">日期</th>
				<th scope="col">時間</th>
				<th scope="col">醫生</th>
                <th scope="col">寵物</th>
                <th scope="col">看病原因</th>
			</tr>
		</thead>
		<tbody>
        <?php
            if(mysqli_num_rows($result2) > 0)
            {
                foreach($result2 as $row2)
                {
                    $p_id = $row2['p_id'];
                    $sql3 =  "SELECT * FROM schedule WHERE p_id = $p_id";
                    $result3=mysqli_query($link,$sql3);
                    foreach($result3 as $row3)
                    {
                        $v_id = $row3['v_id'];
                        $sql4 =  "SELECT * FROM VET WHERE v_id = $v_id";
                        $result4=mysqli_query($link,$sql4);
                        $row4 = mysqli_fetch_assoc($result4);
                        $v_name = $row4['v_name'];

                        echo "<tr>";
                        echo "<td>".$row3['r_date']."</td>";
                        echo "<td>".$row3['shift']."</td>";
                        echo "<td>".$v_name."</td>";
                        echo "<td>".$row2['p_name']."</td>";
                        echo "<td>".$row3['disease']."</td>";
                        echo "</tr>";
                    }
                }
            }
            }else{
                echo "無預約紀錄";}
        }else{
            echo "尚未登記寵物";}
    }else{
        function_box_alert('此帳號不存在');
    }
			?>
		</tbody>
    </table>
</div>
    </body>


<!--BOOTSTRAP的東西------------------------------------------------------------------------->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
</html>
<?php
}
}else{
    function_alert("非法登入!");
}

function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='index.php';
    </script>"; 
    return false;
} 
function function_box_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
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
