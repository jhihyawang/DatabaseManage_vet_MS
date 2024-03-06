<?php
require_once "config.php";

 $userID = $_GET['id'];
 
 //請注意，這邊因為 $userID 本身是 integer，所以可以不用加 ''
 $query = "SELECT * FROM VET WHERE v_id = $userID";
 $result = mysqli_query($link, $query);
 $row_result = mysqli_fetch_assoc($result);
 $id = $row_result['v_id'];
 $name = $row_result['v_name'];
 $startday = $row_result['startday'];
 $major = $row_result['v_major'];
 $school = $row_result['v_school'];
 $phone = $row_result['v_phone'];


?>

<html>

<head>
    <meta charset="UTF-8" />
    <title>修改醫生資料</title>
</head>
<body>

<form action="" method="post" name="formAdd" id="formAdd">
     
醫生姓名:<input type="text" name="cName" id="cName" value="<?php echo $name ?>"><br/>
畢業學校:<input input type="text" name="cschool" id="cschool" value="<?php echo $school ?>"><br/>
醫學專業:<input type="text" name="cmajor" id="cmajor" value="<?php echo $major ?>"><br/>
入職日期:<input type="date" name="cinday" id="cinday" value="<?php echo $startday ?>"><br/>
電話號碼:<input type="text" name="cphone" id="cphone" value="<?php echo $phone ?>"><br/>
<input type="hidden" name="action" value="update">
<input type="submit" name="button" value="修改資料">

</form>
</body>
</html>


<?php
 if (isset($_POST["action"]) && $_POST["action"] == 'update') {

     $newName = $_POST['cName'];
     $newSchool = $_POST['cschool'];
     $newMajor = $_POST['cmajor'];
     $newStartday = $_POST['cinday'];
     $newPhone = $_POST['cphone'];

     $query = "UPDATE VET SET v_name= '$newName', v_school = '$newSchool', v_major = '$newMajor',v_phone='$newPhone',startday='$newStartday' WHERE v_id = $userID";

     mysqli_query($link,$query);
     $link->close();

     header('Location: vetinfo.php');
 }
 ?>