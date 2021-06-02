<?php
session_start();
include('server.php');

if (!$_SESSION["use_firstname"]) {
  header('location: login.php?err=1');
}
if (isset($_GET['logout'])) {
  session_destroy();
  header('location: login.php');
}
elseif (isset($_POST['submit-change_pass'])) {
    // echo "submit-change_pass";
    // $sql = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id' ");
    // $data = $sql->fetch_assoc();
    $old_key = md5($_POST['old_pass']).'.'.md5($_SESSION["user_id"]);
    $new = $_POST['new_pass'];
    if ($_SESSION['key'] != $old_key ) {
        echo "<SCRIPT> //showing me
              alert('(err01)รหัสผ่านเดิมไม่ถูกต้อง ! ');
              </SCRIPT>";
    } 
    else {
        $new_key = md5($new).'.'.md5($_SESSION["user_id"]);
        $user = $_SESSION["user_id"];
        $sql = mysqli_query($conn,"SELECT * FROM user WHERE use_password = '$old_key'") or die(mysqli_error());
        $data = mysqli_num_rows($sql);
        if ($data > 0) {
            $sql_upd = "UPDATE `user` SET `use_password` = '$new_key' WHERE `user`.`user_id` = '$user'";
            if(mysqli_query($conn, $sql_upd)){
                echo "<script type='text/javascript'>";
                echo "window.location = 'my_edit.php'; ";
                echo "alert('Update Succesfuly');";
                echo "</script>";
                }
                else{
                echo "<script type='text/javascript'>";
                echo "window.location = 'my_edit.php'; ";
                echo "alert('Error back to Update again');";
                echo "</script>";
                }  
        } else {
            echo "<SCRIPT> //showing me
              alert('(err02)รหัสผ่านเดิมไม่ถูกต้อง !');
             </SCRIPT>";
        }
    } 
}
elseif (isset($_POST['submit-change_name'])) {
    $Fname = $_POST['use_firstname'];
    $Lname = $_POST['use_lastname'];
    $user = $_SESSION["user_id"];
    $sql_upd = "UPDATE `user` SET `use_firstname` = '$Fname', `use_lastname` = '$Lname' WHERE `user`.`user_id` = '$user'";
            if(mysqli_query($conn, $sql_upd)){
                $_SESSION["use_firstname"] = $Fname;
                $_SESSION["use_lastname"] = $Lname;
                echo "<script type='text/javascript'>";
                echo "window.location = 'my_edit.php'; ";
                echo "alert('Update Succesfuly');";
                echo "</script>";
                }
                else{
                echo "<script type='text/javascript'>";
                echo "window.location = 'my_edit.php'; ";
                echo "alert('Error back to Update name again');";
                echo "</script>";
                }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตั้งค่า</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" href="fontawesome/fa.css">
    <script src="dropzone/dist/dropzone.js"></script>
</head>
<body>

  
        <div class="wrapper">

<!-- ------------------------------- Header -------------------------------- -->

            <div class="layout"> 
                <header class="navbar bg-white py-2">
                    <div class="container-fluid justify-content-between align-items-center">
                        <div class="nav col-4">
                            <nav>
                                <span class="nav-toggle" id="js-nav">
                                  <button type="button" id="sidebarCollapse" class="btn">
                                    <i class="icon fas fa-bars"></i>
                                  </button>          
                                </span>
                            </nav>
                        </div>
                        <div class="text-center col-4">
                            <div class="logo">
                                <img src="img/logo.png" alt width="140" height="50">
                            </div>
                        </div>
                        <div class="account d-flex justify-content-end col-4">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="icon fas fa-user-circle"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                  <h6 class="dropdown-header">ชื่อผู้ใช้:<?php echo $_SESSION["use_firstname"].".".$_SESSION["use_lastname"] ?></h6>
                                  <h6 class="dropdown-header">สิทธิ์:<?php if ( $_SESSION["use_role"] == 'A') {
                                    echo"Admin";
                                  }elseif ($_SESSION["use_role"] == 'U') {
                                    echo "User";
                                  }elseif ($_SESSION["use_role"] == 'R') {
                                    echo "Read only";
                                  } ?></h6>                        
                                  <div class="dropdown-divider"></div>
                                  <div class="btn-logout">
                                  <button type="button" class="btn btn-outline-danger btn-sm btn-block " onclick="window.location.href='index.php?logout'" >ลงชื่อออก</button>
                                  </div>                          
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>

<!-- ------------------------------- Sidebar ------------------------------- -->

<div class="layout" id="sidebar">
  
  <ul class="list-unstyled components">
      <li class="nav-item">
         <a class="nav-link" href="index.php">
            <i class="fas fa-file"></i>
            ตารางงาน
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="addwork.php">
            <i class="fas fa-file"></i>
            เพิ่มงาน
          </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="history_work.php" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> >
              <i class="fas fa-file-invoice"></i>
              ประวัติงาน
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="history_car.php" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> >
              <i class="fas fa-file-invoice"></i>
              ประวัติรถ
            </a>
        </li>

        <br>

        <li class="nav-item">
            <a class="nav-link" href="model.php" >
              <i class="fas fa-car"></i>
              <span>โมเดลรถ</span>
            </a>
        </li>

        <br>

        <li class="nav-item">
            <a class="nav-link" href="customer.php" >
              <i class="fas fa-id-card"></i>
              <span>ข้อมูลลูกค้า</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="technical.php" >
              <i class="fas fa-id-card"></i>
              <span>ข้อมูลช่าง</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="user.php" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> >
              <i class="fas fa-id-card"></i>
              <span>ข้อมูลบุคลากร</span>
            </a>
        </li>

        <br>

        <li class="nav-item">
            <a class="nav-link" href="conclusion.php" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> >
              <i class="fas fa-fw fa-cog"></i>
              <span>ผลประกอบการ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="conclusion_tec.php" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> >
              <i class="fas fa-fw fa-cog"></i>
              <span>ผลการทำงานช่าง</span>
            </a>
        </li>             
  </ul>

</div>

<!-- -------------------------------- Main --------------------------------- -->
            <?php
            
            
            ?> 
            <div class="layout">
              <div class="pt-4 row justify-content-md-center">
                <div class="modal-content col-md-8">

                  <div class="modal-header">
                    <h4 class="modal-title" >ตั้งค่า</h4>
                  </div>
                  
                <div class="modal-body pt-3">
                    <h5 class="modal-title" >ชื่อผู้ใช้ : <?php echo $_SESSION['user_id'];?></h5>
                    <form class="needs-validation" name="edit_name" id="edit_name" action="my_edit.php"  method="post" id="add_work"  novalidate>
                        ชื่อ
                        <input type="text" name="use_firstname" id="use_firstname" value="<?php echo $_SESSION['use_firstname']?>" disabled="true">
                        สกุล
                        <input type="text" name="use_lastname" id="use_lastname" value="<?php echo $_SESSION['use_lastname']?>" disabled="true">
						<br>
                        <br>
                        <button type="button" id="to_edit"  class="btn btn-outline-info btn-sm edit_data btn_edit_data" onclick="Edit()">แก้ใข</button>
            
                        <input  type="submit" id="submit-change_name" name="submit-change_name"  class="btn btn-outline-info btn-sm" value="ยืนยัน" hidden="true">
                        <input type="button" id="Reform_name" name="Reform_name" value="ยกเลิก"  class="btn btn-outline-secondary btn-sm submit_show_work" onclick="window.location.href='my_edit.php'" hidden="true">
                    </form>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title" >ตั้งค่ารหัสผ่าน</h4>
                </div>
                <div class="modal-body pt-3">
                
                    <form  name="edit_pass" action="my_edit.php" method="post" onsubmit="return(validateForm());">
                        รหัสผ่านเดิม<br>
                        <input type="password" name="old_pass" id="old_pass"  onchange="UndisableButton()"><br>
                        รหัสผ่านใหม่<br>
                        <input type="password" name="new_pass" placeholder="รหัสใหม่ต้องมากว่า 8 ตัว !" pattern="[A-Za-z0-9]{8,}" title="กรุณาใส่รหัสผ่าน (รูปแบบ a-z,A-Z,0-9 มากกว่า 8 ตัว)" id="new_pass"><br>
                        ยืนยันรหัสผ่านใหม่<br>
                        <input type="password" name="confirm_pass"  id="confirm_pass" pattern="[A-Za-z0-9]{8,}" title="กรุณาใส่รหัสผ่าน (รูปแบบ a-z,A-Z,0-9 มากกว่า 8 ตัว)" ><br><br>
                        <input type="submit" id="submit-change_pass" name="submit-change_pass" value="ยืนยัน" disabled="true" class="btn btn-outline-primary btn-sm submit_work_done">
                        <input type="button" id="Reform" name="Reform" value="ยกเลิก" disabled="true" onclick="window.location.href='my_edit.php'" class="btn btn-outline-secondary btn-sm submit_show_work">
                    </form>          
                </div>              
            </div>

          </div>

</div>


<!-- ----------------------------------------------------------------------- -->
<!--                                   End                                   -->
<!-- ----------------------------------------------------------------------- -->

        
    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/fa.js"></script>
    <script src="js/script.js"></script>  
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>


    <script> // validation From
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() == false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
      </script>

    <script type="text/javascript"> //Hamberger menu
      $(document).ready(function () {
         

          $('#sidebarCollapse').on('click', function () {
              $('#sidebar, #content').toggleClass('active');
              $('.collapse.in').toggleClass('in');
              $('a[aria-expanded=true]').attr('aria-expanded', 'false');
          });

          $('#filterCollapse').on('click', function () {
              $('#filter, #content').toggleClass('active');
              $('.collapse.in').toggleClass('in');
              $('a[aria-expanded=true]').attr('aria-expanded', 'false');
          });
      });
      </script>
</body>
</html>
<script>
function Edit()
{
    document.getElementById("use_firstname").disabled=false;
    document.getElementById("use_lastname").disabled=false;
    document.getElementById("to_edit").hidden=true;
    document.getElementById("submit-change_name").hidden=false;
    document.getElementById("Reform_name").hidden=false;
}
function UndisableButton()
{
    document.getElementById("submit-change_pass").disabled=false;
    document.getElementById("Reform").disabled=false;
}
function validateForm() {
    var oldP = document.forms["edit_pass"]["old_pass"].value;
    var newP = document.forms["edit_pass"]["new_pass"].value;
    var confirm = document.forms["edit_pass"]["confirm_pass"].value;
    var n = newP.length;
    if (oldP == "" && newP == "" && confirm =="")
    {
        alert("กรุณาใส่ข้อมูลให้ครบ");
        return false ;
    }
    else
    {
        if (n < 8 ) {
            alert("รหัสผ่านควรมีความยาว 8 ตัวอักษรขึ้นไป");
            return false ;
        }
        else if (newP != confirm ) {
            alert("ยืนยันรหัสผ่านไม่ถูกต้อง");
            return false ;
        }
        else if  ( newP == oldP){
            alert("กรุณาใส่passwordใหม่ ไห้แตกต่างกับpasswordเดิม");
            return false ;
        }
        else{
            return true ;
        }
    }
}
</script>
<?php
mysqli_close($conn);
?>