<?php
    if(isset($_GET['err'])){
        if ($_GET['err'] == 1) {
          echo "<SCRIPT> //showing me
              alert('กรุณา Login เข้าสู่ระบบก่อน !');
              </SCRIPT>";
        }elseif ($_GET['err'] == 2) {
          echo "<SCRIPT> //showing me
              alert('บัญชีผู้ใช้หรือรหัสผ่านไม่ถูกต้อง !');
              </SCRIPT>";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <title>Login</title>
</head>
<body>
    <div class="container-fluid">
        <div class="layout-login">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-8 col-lg-5 pb-5">
                    <div class="login-content pr-3">
                        <form class="login" action="get_DB.php" method="POST">
                            <div class="img-logo pr-4">
                                <img src="img/logo.png">
                            </div>
                            <input type="text" name="user_id" id="user_id" placeholder="ชื่อผู้ใช้งาน" require>
                            <input type="password" name="use_password" id="use_password" placeholder="รหัสผ่าน">
                            <input type="submit" class="btn-login" name="login_submit" value="ลงชื่อเข้าใช้">
                        </form>
                    </div>
                </div>
                <div class="col-lg-7 d-none d-lg-block">
                    <div class="bg">
						<img src="css/truck.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>