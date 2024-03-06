<?php
require_once "config.php";
session_start();  //很重要，可以用的變數存在session裡

if(isset($_SESSION["admin_in"]) && $_SESSION["admin_in"] === true){
    $username=$_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>中興獸醫院後台管理</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column h-100">

        <main class="flex-shrink-0">
            <!-- Navigation-->
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
    <br>
    <br>
    <br>
<body>
<div class="container">		
			<?php
            $today = date("Y-m-d");
            $query5 = "SELECT * FROM schedule WHERE r_date ='".$today ."'"; //搜尋 *(全部欄位)
            $result5 = mysqli_query($link,$query5);
				if(mysqli_num_rows($result5) > 0)
				{
            ?>
    <caption>今日預約</caption>
	<table class="table caption-top" style="text-align:center;" align="center">
		<thead style="text-align:center;">
			<tr style="text-align:center;" bgcolor="#EEFFBB">
                <th scope="col">#</th>
				<th scope="col">日期</th>
				<th scope="col">時間</th>
				<th scope="col">醫生</th>
                <th scope="col">看病原因</th>
				<th scope="col">寵物種類</th>
				<th scope="col">寵物名字</th>
                <th scope="col">飼主電話</th>
			</tr>
		</thead>
		<tbody>
            <?php
					foreach($result5 as $row5)
					{
                        $query6 = "SELECT * FROM VET WHERE VET.v_id = '".$row5['v_id']."'"; //搜尋 *(全部欄位)
                        $result6 = mysqli_query($link,$query6);
                        $row6 = $result6->fetch_assoc();
                        $query7 = "SELECT * FROM Pet WHERE Pet.p_id = '".$row5['p_id']."'"; //搜尋 *(全部欄位)
                        $result7 = mysqli_query($link,$query7);
                        $row7 = $result7->fetch_assoc();
                        $query8 = "SELECT * FROM user WHERE id = '".$row7['id']."'"; //搜尋 *(全部欄位)
                        $result8 = mysqli_query($link,$query8);
                        $row8 = $result8->fetch_assoc();
                        echo "<tr>";
                        echo "<td scope='row'>".$row5['r_id']."</td>";
                        echo "<td>".$row5['r_date']."</td>";
                        echo "<td>".$row5['shift']."</td>";
                        echo "<td>".$row6['v_name']."</td>";
                        echo "<td>".$row5['disease']."</td>";
                        echo "<td>".$row7['p_type']."</td>";
                        echo "<td>".$row7['p_name']."</td>";
                        echo "<td>".$row8['username']."</td>";
                        echo "</tr>";
				    }
                }else{echo "<h2>今日無預約 可以下班了</h2>";}
			?>
		</tbody>
</div>
</body>
        
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
  
?>
