<?php
require_once "config.php";

session_start();  //很重要，可以用的變數存在session裡
$username=$_SESSION["username"];
$userid = $_SESSION [ 'uid' ];
$user_name = $_SESSION["u_name"];

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ( isset ($userid) && $userid!="") { 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>中興獸醫院預約系統</title>

        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="#">中興獸醫院預約系統   歡迎：<?php echo $user_name.'('.$_COOKIE['name'].')';?></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="welcome.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="reservation.php">預約掛號</a></li>
                            <li><a class="dropdown-item" href=""></a></li>
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
    <body class="d-flex flex-column h-100">
            <!-- Blog preview section-->
            <section class="py-5">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <div class="text-center">
                                <h2 class="fw-bolder">以下為本院醫生</h2><br>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5">
            <?php
            	$query = "SELECT * FROM VET "; //搜尋 *(全部欄位)
                $result = mysqli_query($link,$query);
				if(mysqli_num_rows($result) > 0)
				{
					foreach($result as $row)
					{
                        $jobtime = birthday($row['startday'])
            ?>

                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">GOLD</div>
                                    <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">學經歷  <?php echo $row['v_school'] ?></h5></a>
                                    <p class="card-text mb-0">專業：<?php echo $row['v_major'] ?></p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle me-3" src="img/vet/<?php echo $row['v_name'] ?>.jpg" width="80px" height="80px" alt="..." />
                                            <div class="small">
                                                <div class="fw-bold"><?php echo $row['v_name'] ?>醫師</div>
                                                <div class="text-muted">from <?php echo $row['startday'].'｜年資：'.$jobtime ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
            <?php
    			  }
                } 
            ?>
            </div>
        </div>
        <style>
            .map{
                float: center;
                width: 80%;
            }
        </style>
        <div class="row">
        <div class="col">
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d20483.560028856853!2d120.64704480958876!3d24.13186426559674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34693d1d66e43737%3A0x222fef5f1bd06a4e!2z5Lit6IiI5aSn5a2454246Yar5pWZ5a246Yar6Zmi!5e0!3m2!1szh-TW!2stw!4v1685072085902!5m2!1szh-TW!2stw" width="500" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <div class="col">
            <div><img src="img/nchu.jpeg" height="200"/></div>
        </div>
    
    </div>
    <br>
    <br>
    <br>

        
        <!-- Footer-->
        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0 text-white" >Copyright &copy; Selina Website database project</div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>

<?php

}
}else{
    function_alert("非法登入!");
}

function function_alert_box($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
    </script>"; 
    return false;
} 
function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='index.php';
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