<?php 
require_once "config.php";
session_start();  //很重要，可以用的變數存在session裡
if(isset($_SESSION["admin_in"]) && $_SESSION["admin_in"] === true){
        echo(null);
?>


<!DOCTYPE html>
<html lang="en">
<title>醫生資訊</title>
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
</head>

<body>

    <div class="container">
                <br>
            <form action="vetinfo.php" method="post" name="formAdd" id="formAdd">
            <fieldset>
                <legend>新增醫生</legend>
                <label>醫生姓名:</label><input type="text" name="cName" id="cName"><br/>
                <label>畢業學校:</label><input type="text" name="cschool" id="cschool"><br/>
                <label>醫學專業:</label><input type="text" name="cmajor" id="cmajor"><br/>
                <label>入職日期:</label><input type="date" name="cinday" id="cinday" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>"><br>
                <label>電話號碼:</label><input type="text" name="cphone" id="cphone"><br/>
                <input type="hidden" name="action" value="add">
                <input type="submit" name="button" value="新增資料">
                <input type="reset" name="button2" value="重新填寫">
                </fieldset>
            </form>
            <?php
//先檢查請求來源是否是我們上面創建的 form
if (isset($_POST["action"])&&($_POST["action"] == "add")) {
    if(!empty($_POST["cName"])&&!empty($_POST["cphone"])&&!empty($_POST["cschool"])&&!empty($_POST["cmajor"])&&!empty($_POST["cinday"])){
    //引入檔，負責連結資料庫

    //取得請求過來的資料
    $cname = $_POST["cName"];
    $cphone = $_POST["cphone"];
    $cschool = $_POST["cschool"];
    $cmajor = $_POST["cmajor"];
    $cinday = $_POST['cinday'];

    //資料表查訪指令，請注意 "" , '' 的位置
    //INSERT INTO 就是新建一筆資料進哪個表的哪個欄位
    $sql_query = "INSERT INTO VET (v_name,v_phone,v_school,v_major,startday) VALUES ('$cname', '$cphone','$cschool','$cmajor','$cinday')";

    //對資料庫執行查訪的動作
    mysqli_query($link,$sql_query);

    header("Location: vetinfo.php");
}else{
    function_alert_box("請輸入有效的資料");
}
}
?>

<br>
<caption>所有醫生資訊</caption>
	<table class="table caption-top" style="text-align:center;" align="center">
		<thead style="text-align:center;">
			<tr style="text-align:center;" bgcolor="#CCCCFF">
                <th scope="col">#</th>
				<th scope="col">醫生</th>
				<th scope="col">學歷</th>
				<th scope="col">電話</th>
				<th scope="col">專業</th>
				<th scope="col">入職日期</th>
                <th scope="col">編輯</th>
			</tr>
		</thead>
		<tbody>
			<?php
            	$query = "SELECT * FROM VET "; //搜尋 *(全部欄位)
                $result = mysqli_query($link,$query);
				if(mysqli_num_rows($result) > 0)
				{
					foreach($result as $row)
					{
                        echo "<tr>";
                        echo "<th scope='row'>".$row['v_id']."</th>";
                        echo "<td>".$row['v_name']."</td>";
                        echo "<td>".$row['v_school']."</td>";
                        echo "<td>".$row['v_phone']."</td>";
                        echo "<td>".$row['v_major']."</td>";
                        echo "<td>".$row['startday']."</td>";
                        echo "<td><a href='vetupdte.php?id=".$row['v_id']."'>修改</a> /";
                        echo "<a href='vetdelete.php?id=".$row['v_id']."'> 刪除</a></td>";
                        echo "</tr>";
				  }
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
    </script>"; 
    return false;
} 
?>
