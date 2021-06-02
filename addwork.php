<?php
include('server.php'); 
session_start();
if (!$_SESSION["use_firstname"]) {
  header('location: login.php?err=1');
}
if (isset($_GET['logout'])) {
  session_destroy();
  header('location: login.php');
}
if(isset($_GET['err'])){
  if ($_GET['err'] == 1) {
    echo "<SCRIPT> //showing me
        alert('งานใหม่ ซ้ำกับงานที่มีอยู่แล้ว');
        </SCRIPT>";
  }elseif ($_GET['err'] == 2) {
    echo "<SCRIPT> //showing me
        alert('serialรถที่เพิ่มใหม่ ซ้ำกับรถที่มีอยู่แล้ว');
        </SCRIPT>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มงาน</title>
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
                                  <a href="my_edit.php" class="nav-link">
                                  <i class="fas fa-fw fa-cog"></i>
                                  ตั้งค่า</a>                        
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
        <li class="nav-item active">
          <a class="nav-link" href="addwork.php">
            <i class="fas fa-file"></i>
            เพิ่มงาน
          </a>
        </li>
        <li class="nav-item">
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

            <div class="layout">

            <?php
              if (empty($_REQUEST['cus_id'])) {
                  $CusId = '';
              } else {
                  $CusId =  $_REQUEST['cus_id'];
              }
              if (empty($_REQUEST['mod_id'])) {
                  $model = '';
              } else {
                  $model =  $_REQUEST['mod_id'];
              }
              if (empty($_REQUEST['product_id'])) {
                  $ProId = '';
              } else {
                  $ProId =  $_REQUEST['product_id'];
              }
              if (empty($_REQUEST['job_detail'])) {
                  $JobDet = '';
              } else {
                  $JobDet =  $_REQUEST['job_detail'];
              }
              if (empty($_REQUEST['car_id_start'])) {
                  $CarSta = '';
              } else {
                  $CarSta =  $_REQUEST['car_id_start'];
              }
              if (empty($_REQUEST['car_qty'])) {
                  $CarQty = '';
              } else {
                  $CarQty =  $_REQUEST['car_qty'];
              }
              if (empty($_REQUEST['job_axle'])) {
                  $JobAx = '';
              } else {
                  $JobAx =  $_REQUEST['job_axle']; 
              }
              if (empty($_REQUEST['job_date_start'])) {
                  $JobDaSta = '';
              } else {
                  $JobDaSta =  $_REQUEST['job_date_start']; 
              }
              if (empty($_REQUEST['job_date_deadline'])) {
                  $JobDaDead = '';
              } else {
                  $JobDaDead =  $_REQUEST['job_date_deadline']; 
              }
              if (empty($_REQUEST['tec_id_paint'])) {
                  $TecPaint = '';
              } else {
                  $TecPaint =  $_REQUEST['tec_id_paint']; 
              }
              if (empty($_REQUEST['tec_id_elec'])) {
                  $TecElec = '';
              } else {
                  $TecElec =  $_REQUEST['tec_id_elec']; 
              }
              if (empty($_REQUEST['tec_id_weld'])) {
                  $TecWeld = '';
              } else {
                  $TecWeld =  $_REQUEST['tec_id_weld']; 
              }
              if (empty($_REQUEST['tec_id_chassis'])) {
                  $TecChass = '';
              } else {
                  $TecChass =  $_REQUEST['tec_id_chassis']; 
              }
              if (empty($_REQUEST['tec_id_hyd'])) {
                $TecHyd = '';
              } else {
                  $TecHyd =  $_REQUEST['tec_id_hyd']; 
              }
            
              if (empty($_REQUEST['tec_id_logo'])) {
                $TecLogo = '';
              } else {
                  $TecLogo =  $_REQUEST['tec_id_logo']; 
              }

              if (empty($_REQUEST['job_id'])) {
                  $JobId = '';
              } else {
                  $JobId =  $_REQUEST['job_id']; 
              }
            ?>
              
              <div class="pt-4 row justify-content-md-center">
                <div class="modal-content col-lg-8 col-md-10 col-sm-12">

                  <div class="modal-header">
                    <h4 class="modal-title" >เพิ่มงาน</h4>
                  </div>
                  
                  <div class="modal-body pt-3">

                  <form class="needs-validation" name="add_work" id="add_work" action="addwork.php"  method="get" id="add_work" onsubmit="return(btnaddjob());" novalidate>

                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputAddress">ชื่อลูกค้า</label>
                        <select class="custom-select" name="cus_id" onchange="this.form.submit()" required>
                        <option selected disabled value="">กรุณาเลือกชื่อลูกค้า</option>
                        <?php
                          $sql = mysqli_query($conn, "SELECT cus_name, cus_id FROM customer");
                          while ($row = $sql->fetch_assoc()) {
                            if ($row['cus_id'] == $CusId)
                            echo "<option value='" . $row['cus_id'] . "' selected >" . $row['cus_name'] . "</option>";
                            else
                            echo "<option value='" . $row['cus_id'] . "'>" . $row['cus_name'] . "</option>";
                          }
                          $sql->free_result();     
                        ?>  
                        </select>
                        <div class="invalid-feedback">
                          กรุณาใส่ชื่อลูกค้า
                        </div>
                      </div>
                      
                      <div class="form-group col-md-6 ">
                        <label for="inputAddress">รหัสติดตามสินค้า</label>
                        <input type="text" class="form-control" name="product_id" value="<?php echo $ProId ?>" required>
                        <div class="invalid-feedback">
                          กรุณาใส่รหัสติดตามสินค้า
                        </div>
                      </div>
                    </div>

                    
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">โมเดลรถ</label>
                        <select class="custom-select" name="mod_id" onchange="this.form.submit()" required>
                          <option selected disabled value="">กรุณาเลือกโมเดลรถ</option>
                            <?php
                              $sql = mysqli_query($conn, "SELECT mod_id FROM model");
                              while ($row = $sql->fetch_assoc()) {                            
                                if ($row['mod_id'] == $model)
                                  echo "<option value='" . $row['mod_id'] . "' selected >" . $row['mod_id'] . "</option>";
                                else
                                  echo "<option value='" . $row['mod_id'] . "'>" . $row['mod_id'] . "</option>";
                              }
                              $sql->free_result();
                            ?>        
                        </select>
                      <div class="invalid-feedback">
                        กรุณาเลือกโมเดลรถ
                      </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputPassword4">โมเดลย่อย</label>
                        <select class="custom-select" name="sub_id" required>
                          <option selected disabled value="">กรุณาเลือกโมเดลย่อย</option>
                            <?php
                              $model = ($_REQUEST['mod_id']);
                              $sql = mysqli_query($conn, "SELECT s.sub_name FROM submodel s where mod_id = '$model' and 
                              (SELECT COUNT(so.sub_id) FROM submodel_opn so WHERE so.sub_id = s.sub_id  ) > 0 ");
                              while ($row = $sql->fetch_assoc()) {
                                echo "<option value='" . $row['sub_name'] . "'>" . $row['sub_name'] . "</option>";
                              }
                              $sql->free_result();
                            ?>
                        </select>
                      <div class="invalid-feedback">
                        กรุณาเลือกโมเดลย่อย
                      </div>
                      </div>
                    </div>

                    
                    <div class="form-row">

                      <div class="form-group col-md-4">
                        <label for="inputAddress">จำนวนเพลา</label>
                        <select class="custom-select" name="job_axle" value="<?php echo $JobAx ?>"  required>
                          <option selected disabled value="">กรุณาเลือกจำนวนเพลา</option>
                          <option value="1">ไม่มีเพลา</option>
                          <option value="2">2 เพลา</option>
                          <option value="3">3 เพลา</option>
                        </select>
                        <div class="invalid-feedback">
                          กรุณาเลือกจำนวนเพลา
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="inputEmail4">รหัสรถเริ่มต้น</label>
                        <input type="text" class="form-control" placeholder="เลข3ตัว XXX เช่น 001, 015 "  name="car_id_start" required>
                        <div class="invalid-feedback">
                          กรุณาใส่รหัสรหัสรถเริ่มต้น
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="inputPassword4">จำนวนคัน</label>
                        <select class="custom-select" name="car_qty" required>
                          <option selected disabled value="">กรุณาเลือกจำนวนคัน</option>
                          <option value="1">1 คัน</option>
                          <option value="2">2 คัน</option>
                          <option value="3">3 คัน</option>
                          <option value="4">4 คัน</option>
                          <option value="5">5 คัน</option>
                        </select>
                        <div class="invalid-feedback">
                          กรุณาเลือกจำนวนคัน
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputAddress">รายละเอียด</label>
                      <textarea class="form-control" name="job_detail" rows="3" ></textarea>
                    </div>

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputAddress">วันที่เปิดงาน</label>
                      <input class="form-control" type="date" name="job_date_start" value="" required>
                      <div class="invalid-feedback">
                        กรุณาใส่วันที่
                      </div>
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="inputAddress">วันที่ปิดงาน</label>
                      <input class="form-control" type="date" name="job_date_deadline" value="" required>
                      <div class="invalid-feedback">
                        กรุณาใส่วันที่
                      </div>
                    </div>
                  </div>
					  	  
                  <div class="form-row">
					
					<div class="form-group col-md-4">
                      <label for="inputAddress">ช่างเหล็ก</label>
                      <select class="custom-select" name="tec_id_weld" required>
                      <option selected disabled value="">กรุณาเลือกช่างเหล็ก</option>
                      <?php
                        $sql = mysqli_query($conn, "SELECT tec_id, tec_name FROM technical where tec_skill_weld ='1'");
                        while ($row = $sql->fetch_assoc()) {
                          if ($row['tec_id'] == $TecWeld)
                            echo "<option value='" . $row['tec_id'] . "' selected >" . $row['tec_name'] . "</option>";
                          else
                            echo "<option value='" . $row['tec_id'] . "'>" . $row['tec_name'] . "</option>";
                        }
                        $sql->free_result();
                      ?>              
                      </select>
                      <div class="invalid-feedback">
                      กรุณาระบุช่าง
                      </div>
                    </div>
					
					<div class="form-group col-md-4">
                      <label for="inputAddress">ช่างช่วงล่าง</label>
                      <select class="custom-select" name="tec_id_chassis" required>
                      <option selected disabled value="">กรุณาเลือกช่างช่วงล่าง</option>
                      <?php
                        $sql = mysqli_query($conn, "SELECT tec_id, tec_name FROM technical where tec_skill_chassis ='1'");
                        while ($row = $sql->fetch_assoc()) {
                          if ($row['tec_id'] == $TecChass)
                            echo "<option value='" . $row['tec_id'] . "' selected >" . $row['tec_name'] . "</option>";
                          else
                            echo "<option value='" . $row['tec_id'] . "'>" . $row['tec_name'] . "</option>";
                        }
                        $sql->free_result();
                      ?>              
                      </select>                     
                      <div class="invalid-feedback">
                      กรุณาระบุช่าง
                      </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="inputAddress">ช่างไฮดรอลิก</label>
                      <select class="custom-select" name="tec_id_hyd" required>
                      <option selected disabled value="">กรุณาเลือกช่างไฮดรอลิก</option>
                      <?php
                        $sql = mysqli_query($conn, "SELECT tec_id, tec_name FROM technical where tec_skill_hyd ='1'");
                        while ($row = $sql->fetch_assoc()) {
                          if ($row['tec_id'] == $TecHyd)
                            echo "<option value='" . $row['tec_id'] . "' selected >" . $row['tec_name'] . "</option>";
                          else
                            echo "<option value='" . $row['tec_id'] . "'>" . $row['tec_name'] . "</option>";
                        }
                        $sql->free_result();
                      ?>              
                      </select>                     
                      <div class="invalid-feedback">
                      กรุณาระบุช่าง
                      </div>
                    </div>
					  
                    <div class="form-group col-md-4">
                      <label for="inputAddress">ช่างสี</label>
                      <select class="custom-select" name="tec_id_paint" required>
                      <option selected disabled value="">กรุณาเลือกช่างสี</option>
                      <?php
                        $sql = mysqli_query($conn, "SELECT tec_name, tec_id FROM technical where tec_skill_paint ='1'");
                        while ($row = $sql->fetch_assoc()) {
                          if ($row['tec_id'] == $TecPaint)
                            echo "<option value='" . $row['tec_id'] . "' selected >" . $row['tec_name'] . "</option>";
                          else
                            echo "<option value='" . $row['tec_id'] . "'>" . $row['tec_name'] . "</option>";
                        }
                        $sql->free_result();
                      ?>
                      </select>
                      <div class="invalid-feedback">
                        กรุณาระบุช่าง
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputAddress">ช่างทำโลโก้</label>
                      <select class="custom-select" name="tec_id_logo" required>
                      <option selected disabled value="">กรุณาเลือกช่างทำโลโก้</option>
                      <?php
                        $sql = mysqli_query($conn, "SELECT tec_name, tec_id FROM technical where tec_skill_logo ='1'");
                        while ($row = $sql->fetch_assoc()) {
                          if ($row['tec_id'] == $TecLogo)
                            echo "<option value='" . $row['tec_id'] . "' selected >" . $row['tec_name'] . "</option>";
                          else
                            echo "<option value='" . $row['tec_id'] . "'>" . $row['tec_name'] . "</option>";
                        }
                        $sql->free_result();
                      ?>
                      </select>
                      <div class="invalid-feedback">
                        กรุณาระบุช่าง
                      </div>
                    </div>

                    
                    
                    <div class="form-group col-md-4">
                      <label for="inputAddress">ช่างไฟ</label>
                      <select class="custom-select" name="tec_id_elec" required>
                      <option selected disabled value="">กรุณาเลือกช่างไฟ</option>
                      <?php
                        $sql = mysqli_query($conn, "SELECT tec_id, tec_name FROM technical where tec_skill_elec ='1'");
                        while ($row = $sql->fetch_assoc()) {
                          if ($row['tec_id'] == $TecElec)
                            echo "<option value='" . $row['tec_id'] . "' selected >" . $row['tec_name'] . "</option>";
                          else
                            echo "<option value='" . $row['tec_id'] . "'>" . $row['tec_name'] . "</option>";
                        }
                        $sql->free_result();
                      ?>                     
                      </select>
                      <div class="invalid-feedback">
                      กรุณาระบุช่าง
                      </div>
                    </div>

                  </div>

                  <div class="modal-footer mt-4">
                    <fieldset class="w-100">
                      <button type="submit" class="btn btn-primary px-4 float-right" id="submit-addwork-btn" name="submit-addwork-btn">บันทึก</button>
                      <button type="button" class="btn btn-outline-secondary px-4 mr-2 float-right" onclick="goBack()">ย้อนกลับ</button>
                        <script> // goback
                          function goBack() {
                          window.history.back();
                          }
                          </script>
                    </fieldset>
                  </div>
                </form>
                


              

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
    <script> // add job    
        function btnaddjob(){
            document.getElementById("add_work").action ="get_DB.php";
            // document.getElementById("add_work").submit() ;
            return TRUE;
        }
      </script>
</body>
</html>

<?php
mysqli_close($conn);
?>