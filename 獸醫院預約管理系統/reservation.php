<?php 

require_once "config.php";
session_start();  //很重要，可以用的變數存在session裡
$userid = $_SESSION [ 'uid' ];
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ( isset ($userid) && $userid!="") { 
        $query = "SELECT v_name FROM VET";
        $result = mysqli_query($link, $query);

        $query3 = "SELECT * FROM Pet WHERE id = $userid";
        $result3 = mysqli_query($link, $query3);

?>


<!DOCTYPE html>
<html lang="en">
<title>預約掛號</title>
<head>
<style>
fieldset {
  background-color: #eeeeee;
}

legend {
  background-color: #EEFFBB;
  color: white;
  padding: 5px 10px;
}

</style>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="#">中興獸醫院 預約掛號</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="welcome.php">Home</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="welcome.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">會員中心</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">   
                                <li><a class="dropdown-item" href="showpet.php">個人資料</a></li>
                                <li><a class="dropdown-item" href='logout.php'>登出</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
</head>

<body>

            <div class="container">
            <form action="reservation.php" method="post" name="formAdd" id="formAdd">
            <fieldset>
                <legend>新增預約</legend>
                <label>日期</label><input type="date" name="add_day" id="bookdate" value="<?php echo date("Y-m-d");?>" min="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d",strtotime("+14 day", time()));?>"><br>
                <label>時間</label><select name="add_time">
                    <option>9:00~12:00</option>
                    <option>14:00~17:00</option>
                    <option>18:00~21:00</option>
                </select><br/>
                <label>預約醫生</label><select name="add_vet">
                    <?php
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo "<option>".$row['v_name']."</option>";
                      }
                    ?>
                </select><br/>
                <label>寵物名字</label><select name="add_pet">
                    <?php
                    while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
                        echo "<option>".$row3['p_name']."</option>";
                      }
                    ?>
                </select><br/>
                <label>看病原因</label><input type="text" name="disease"><br/>
                <input type="hidden" name="action" value="add">
                <input type="submit" name="button" value="新增資料">
                <input type="reset" name="button2" value="重新填寫">
                </fieldset>
            </form>
            <?php

//先檢查請求來源是否是我們上面創建的 form
if (isset($_POST["action"])&&($_POST["action"] == "add")) {
    if(!empty($_POST["add_day"])&&!empty($_POST["add_day"])&&!empty($_POST["add_time"])&&!empty($_POST["disease"])&&!empty($_POST["add_vet"])&&!empty($_POST['add_pet'])){
    //取得請求過來的資料
    $day = $_POST["add_day"];
    $shift = $_POST["add_time"];
    $disease = $_POST["disease"];

    $v_name = $_POST["add_vet"];
    $query1 = "SELECT v_id FROM VET WHERE v_name ='".$v_name."'";
    $result1 = mysqli_query($link, $query1);
    $row_result1 = mysqli_fetch_assoc($result1);
    $v_id = $row_result1["v_id"];

    $p_name = $_POST['add_pet'];

    $query8 = "SELECT p_id FROM Pet WHERE p_name ='".$p_name."'";
    $result8 = mysqli_query($link, $query8);
    $row_result8 = mysqli_fetch_assoc($result8);
    $p_id = $row_result8["p_id"];

    $sql_query4 = "INSERT INTO schedule (v_id,p_id,shift,r_date,disease) VALUES ('$v_id', '$p_id','$shift','$day','$disease')";
    //對資料庫執行查訪的動作
    mysqli_query($link,$sql_query4);
    $link->close();

    header("Location: reservation.php");
}else{
    function_alert_box("輸入資料不完整");
}
}
?>

            </div><br>
<div class="container">
    <caption>您的預約資訊</caption>
	<table class="table caption-top" style="text-align:center;" align="center">
		<thead style="text-align:center;">
			<tr style="text-align:center;" bgcolor="#EEFFBB">
                <th scope="col">#</th>
				<th scope="col">日期</th>
				<th scope="col">時間</th>
				<th scope="col">醫生</th>
				<th scope="col">寵物種類</th>
				<th scope="col">寵物名字</th>
                <th scope="col">看病原因</th>
			</tr>
		</thead>
		<tbody>

			<?php
            
            $query5 = "SELECT * FROM schedule "; //搜尋 *(全部欄位)
            $result5 = mysqli_query($link,$query5);
				if(mysqli_num_rows($result5) > 0)
				{
					foreach($result5 as $row5)
					{
                        $query7 = "SELECT * FROM Pet WHERE p_id = '".$row5['p_id']."' AND id=$userid";
                        $result7 = mysqli_query($link,$query7);
                        if(mysqli_num_rows($result7) > 0){
                            $query6 = "SELECT * FROM VET WHERE VET.v_id = '".$row5['v_id']."'"; //搜尋 *(全部欄位)
                            $result6 = mysqli_query($link,$query6);
                            $row6 = $result6->fetch_assoc();
                            $row7 = $result7->fetch_assoc();
                            echo "<tr>";
                            echo "<td scope='row'>".$row5['r_id']."</td>";
                            echo "<td>".$row5['r_date']."</td>";
                            echo "<td>".$row5['shift']."</td>";
                            echo "<td>".$row6['v_name']."</td>";
                            echo "<td>".$row7['p_type']."</td>";
                            echo "<td>".$row7['p_name']."</td>";
                            echo "<td>".$row5['disease']."</td>";
                            echo "</tr>";
                        }
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
function function_alert_box($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='reservation.php';
    </script>"; 
    return false;
} 
function compareByTimeStamp($time1, $time2)

{

    if (strtotime($time1) < strtotime($time2))

        return 1;

    else if (strtotime($time1) > strtotime($time2)) 

        return -1;

    else

        return 0;

}
?>
