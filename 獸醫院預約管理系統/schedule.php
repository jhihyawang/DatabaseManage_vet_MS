<?php 

require_once "config.php";
session_start();  //很重要，可以用的變數存在session裡
if(isset($_SESSION["admin_in"]) && $_SESSION["admin_in"]=== true){

?>


<!DOCTYPE html>
<html lang="en">
<title>修改預約</title>
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>

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
                <h4>查詢預約</h4>

            <form action="schedule.php" method="post">
                日期:<input type="date" name="add_day" id="bookdate" value="<?php echo date("Y-m-d");?>"  max="<?php echo date("Y-m-d",strtotime("+14 day", time()));?>">
                <input type="hidden" name="action" value="search">
                <button type="submit" class="btn btn-info">查詢</button>
            </form>

            <?php
//先檢查請求來源是否是我們上面創建的 form
if (isset($_POST["action"])&&($_POST["action"] == "search")) {

    //取得請求過來的資料
    $date = $_POST["add_day"];
    $sql =  "SELECT * FROM schedule WHERE r_date ='".$date."'";
    $result=mysqli_query($link,$sql);
    if(mysqli_num_rows($result) > 0){
    ?>
    <div class="container">
    <br>
	<caption><?php echo $date;?>的預約資訊</caption>
	<table class="table caption-top" style="text-align:center;" align="center">
		<thead style="text-align:center;">
			<tr style="text-align:center;" bgcolor="#FFCCCC">
				<th scope="col">時間</th>
				<th scope="col">醫生</th>
                <th scope="col">看病原因</th>
				<th scope="col">寵物種類</th>
				<th scope="col">寵物名字</th>
                <th scope="col">編輯</th>
			</tr>
		</thead>
		<tbody>
			
			<?php
					foreach($result as $row)
					{
                        $query6 = "SELECT * FROM VET WHERE VET.v_id = '".$row['v_id']."'"; //搜尋 *(全部欄位)
                        $result6 = mysqli_query($link,$query6);
                        $row6 = $result6->fetch_assoc();
                        $query7 = "SELECT * FROM Pet WHERE Pet.p_id = '".$row['p_id']."'"; //搜尋 *(全部欄位)
                        $result7 = mysqli_query($link,$query7);
                        $row7 = $result7->fetch_assoc();
                        echo "<tr>";
                        echo "<td>".$row['shift']."</td>";
                        echo "<td>".$row6['v_name']."</td>";
                        echo "<td>".$row['disease']."</td>";
                        echo "<td>".$row7['p_type']."</td>";
                        echo "<td>".$row7['p_name']."</td>";
                        echo "<td><a href='resupdte.php?id=".$row['r_id']."'>修改</a> /";
                        echo "<a href='resdelete.php?id=".$row['r_id']."'> 刪除</a></td>";
                        echo "</tr>";
				  }
				
            }else{
                function_alert_box('這天沒有預約');
            }
			?>
		</tbody>
    </table>
</div>
    <?php
}else{
	$query5 = "SELECT * FROM schedule "; //搜尋 *(全部欄位)
	$result5 = mysqli_query($link,$query5);
?>
<div class="container">
    <br>
    <caption>所有預約資訊</caption>
	<table class="table caption-top" style="text-align:center;" align="center">
		<thead style="text-align:center;">
			<tr style="text-align:center;" bgcolor="#FFCCCC">
                <th scope="col">編號</th>
				<th scope="col">日期</th>
				<th scope="col">時間</th>
				<th scope="col">醫生</th>
                <th scope="col">看病原因</th>
				<th scope="col">寵物種類</th>
				<th scope="col">寵物名字</th>
                <th scope="col">編輯</th>
			</tr>
		</thead>

		<tbody>
			
			<?php
				if(mysqli_num_rows($result5) > 0)
				{
					foreach($result5 as $row5)
					{
                        $query6 = "SELECT * FROM VET WHERE VET.v_id = '".$row5['v_id']."'"; //搜尋 *(全部欄位)
                        $result6 = mysqli_query($link,$query6);
                        $row6 = $result6->fetch_assoc();
                        $query7 = "SELECT * FROM Pet WHERE Pet.p_id = '".$row5['p_id']."'"; //搜尋 *(全部欄位)
                        $result7 = mysqli_query($link,$query7);
                        $row7 = $result7->fetch_assoc();
                        echo "<tr>";
                        echo "<td scope='row'> ".$row5['r_id']."</td>";
                        echo "<td>".$row5['r_date']."</td>";
                        echo "<td>".$row5['shift']."</td>";
                        echo "<td>".$row6['v_name']."</td>";
                        echo "<td>".$row5['disease']."</td>";
                        echo "<td>".$row7['p_type']."</td>";
                        echo "<td>".$row7['p_name']."</td>";
                        echo "<td><a href='resupdte.php?id=".$row5['r_id']."'>修改</a> /";
                        echo "<a href='resdelete.php?id=".$row5['r_id']."'> 刪除</a></td>";
                        echo "</tr>";
				  }
				}
            }
			?>
		</tbody>

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
function function_alert_box($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
    window.location.href='schedule.php';
    </script>"; 
    return false;
} 
?>
