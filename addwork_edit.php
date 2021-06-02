<?php
session_start();
include('server.php'); 
if (!$_SESSION["use_firstname"]) {
  header('location: login.php');
}
if (isset($_GET['logout'])) {
  session_destroy();
  header('location: login.php');
}
    //---------job_id 
    if (isset($_GET['work-edit-btn'])) {
      $job_id = $_GET['work-edit-btn'];
     $sql = "SELECT A.job_id, A.product_id, A.cus_id, A.job_date_start,A.mod_id,A.sub_id,A.job_axle,A.car_id_start, A.car_qty, A.job_detail,A.job_date_deadline,
        A.tec_id_weld,
        A.tec_id_paint, 
        A.tec_id_chassis,
        A.tec_id_elec,
        A.tec_id_hyd,
        A.tec_id_logo,  
        (SELECT COUNT(*) FROM car WHERE car_status IS  NOT NULL AND job_id = A.job_id) nCarStatus,
        (SELECT COUNT(*) FROM car WHERE car_status ='F' AND job_id = A.job_id) nCarFin,
        (SELECT COUNT(*) FROM car WHERE job_id = A.job_id) nCarAll
        FROM job A
        WHERE  job_id = '$job_id'";
      $query = mysqli_query($conn,$sql);
      $result=mysqli_fetch_array($query,MYSQLI_ASSOC);  
  }



?>

<!-- <?php
            if (empty($_REQUEST['cus_id'])) {
                $CusId = '';
            } else {
                $CusId =  $_REQUEST['cus_id'];
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
			      if (empty($_REQUEST['job_date_notify'])) {
              $JobDaNotify = '';
          	} else {
              $JobDaNotify =  $_REQUEST['job_date_notify']; 
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
            ?> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขงาน<?php echo $job_id ; ?></title>
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
                            <!-- <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="icon fas fa-user-circle"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                  <h6 class="dropdown-header">ชื่อผู้ใช้:พงษ์เดช จารุวนากุล</h6>
                                  <h6 class="dropdown-header">สิทธิ์:Admin</h6>                        
                                  <div class="dropdown-divider"></div>
                                  <div class="btn-logout">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-block ">ลงชื่อออก</button>
                                  </div>                          
                                </div>
                            </div> -->
                        </div>
                    </div>
                </header>
            </div>

<!-- ------------------------------- Sidebar ------------------------------- -->

            <div class="layout" id="sidebar">
  
                    <ul class="list-unstyled components">
                        <li class="nav-item ">
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
                              <a class="nav-link" href="history_work.php" >
                                <i class="fas fa-file-invoice"></i>
                                ประวัติงาน
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#" >
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
                              <a class="nav-link" href="user.php" >
                                <i class="fas fa-id-card"></i>
                                <span>ข้อมูลบุคลากร</span>
                              </a>
                          </li>
            
                          <br>
            
                          <li class="nav-item">
                              <a class="nav-link" href="conclusion.php" >
                                <i class="fas fa-fw fa-cog"></i>
                                <span>ผลประกอบการ</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#" >
                                <i class="fas fa-fw fa-cog"></i>
                                <span>ผลการทำงานช่าง</span>
                              </a>
                          </li>             
                    </ul>
  
            </div>

<!-- -------------------------------- Main --------------------------------- -->

          <div class="layout">
          <h3><a href="index.php">ตารางงาน</a> > <a href="showwork_car.php?To_show_car=<?php echo $job_id; ?>" >
          <?php echo $job_id ?></a> > ดูข้อมูล</h3>
                  
              <div class="pt-4 row justify-content-md-center">

                <div class="modal-content col-md-7 mr-md-4">
                  <form class="needs-validation" action="get_DB.php" id="edit-job"  name="edit-job" method='POST'   onsubmit="return(validateForm());" novalidate>  
                    <input type="hidden" name="job_id" id="job_id" value="<?php echo $job_id ?>">
                    <div class="modal-header">
                      <h4 class="modal-title">แก้ไขรหัสงาน : <?php echo $job_id ?></h4>
                    </div>
                    
                      <div class="form-row pt-4">
                        <div class="form-group col-md-6">
                          <label for="">โมเดลรถ :</label>
                          <?php echo $result["mod_id"] ;?>
                        </div> 

                        <div class="form-group col-md-6">
                          <label for="">โมเดลย่อย :</label>
                          <?php  
                              $SubId = $result["sub_id"];
                              $sql = mysqli_query($conn, "SELECT sub_name FROM submodel where sub_id = '$SubId'");
                              $row = $sql->fetch_assoc();
                              echo $row['sub_name'] ; 
                          ?> 
                        </div>
                      </div>
                        <div class="form-row">

                        <div class="form-group col-md-4">
                          <label for="">จำนวนเพลา :</label>
                          
                          <?php  
                              $JobAx = $result["job_axle"];
                              if($JobAx == 2){
                                  echo "2 เพลา" ;
                              }else {
                                  echo "3 เพลา" ;
                              }
                          ?> 
                        </div>

                        <div class="form-group col-md-4">
                          <label for="">รหัสรถเริ่มต้น :</label>
                          <?php echo $result["car_id_start"];?>
                        </div>

                        <div class="form-group col-md-4">
                          <label for="">จำนวนคัน :</label>
                          <?php  
                              $CarQty = $result["car_qty"];
                              if($CarQty == 1){
                                  echo "1 คัน" ;
                              }elseif ($CarQty == 2) {
                                  echo "2 คัน" ;
                              }elseif ($CarQty == 3) {
                                  echo "3 คัน" ;
                              }elseif ($CarQty == 4) {
                                  echo "4 คัน" ;
                              }elseif ($CarQty == 5) {
                                  echo "5 คัน" ;
                              }
                          ?>
                        </div>
                      </div>
                    <div class="modal-body pt-3">

                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="inputAddress">ชื่อลูกค้า</label>
                              <?php  $CusId = $result["cus_id"];?>
                              <select class="custom-select" name="cus_id" required>    
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
                          </div>
                        
                        <div class="form-group col-md-6 ">
                          <div class="form-group">
                            <label>รหัสติดตามสินค้า</label>                          
                              <input type="text" class="form-control" id="staticEmail" name="product_id" value="<?php echo $result["product_id"] ?>">                          
                          </div>
                        </div>
                      </div>

                      
                      <div class="form-row">
                        <div class="form-group col-md-12">                        
                            <label >รายละเอียด</label> 
                            <textarea class="form-control" rows="2" name="job_detail" >
                            <?php echo $result["job_detail"] ?>
                            </textarea>                                                                             
                        </div>                                      
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-4">                        
                            <label>วันที่เปิดงาน</label> 
                            <input type="date" class="form-control" name="job_date_start" value="<?php echo $result["job_date_start"] ;?>">                                                                              
                            <input type="hidden" name="old_date_start" id="old_date_start" value="<?php echo $JobDaSta ?>">
                        </div>
                        <div class="form-group col-md-4">                        
                            <label>วันที่ปิดงาน</label> 
                            <input type="date" class="form-control" name="job_date_deadline" value="<?php echo $result["job_date_deadline"] ;?>">                                             
                        </div>
						  <div class="form-group col-md-4">                        
                            <label>แจ้งเตือนใกล้ถึงกำหนด</label> 
                            <input type="date" class="form-control" name="job_date_notify" value="<?php echo $result["job_date_notify"] ;?>">                                                                              
                        </div>
                      </div>                 
                    
                      <div class="form-row">
                      <div class="form-group col-md-4">
                      <label for="inputAddress">ช่างเหล็ก<?php echo $result["tec_id_weld"] ?></label>
                      <select class="custom-select" name="tec_id_weld" required>
                      
                      <?php
                       $TecWeld = $result["tec_id_weld"];
                       
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
                      
                      <?php
                      $TecChass = $result["tec_id_chassis"];
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
                      
                      <?php
                        $TecHyd = $result["tec_id_hyd"];
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
                      
                      <?php
                      $TecPaint = $result["tec_id_paint"];
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
                      
                      <?php
                      $TecLogo = $result["tec_id_logo"];
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
                      
                      <?php
                      $TecElec = $result["tec_id_elect"];
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
                              
                      <div class="modal-footer row">
                      
						  <div class="col-8">
                              <?php
                                if ($result['nCarStatus'] == 0) 
                                  {?>
                                    <a class="btn btn-outline-danger edit_data" href="get_DB.php?delete_job=<?php echo $job_id ;?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่ !');"> 
                                    <i class="fas fa-trash-alt"></i>
                                            <span>ยกเลิกการทำงาน</span> 
                                    </a>
                              <?php }
                                    elseif ($result['nCarStatus'] != 0)
                                      {?>
                                        <a href="get_DB.php?Finish=<?php echo $job_id ;?>" class="btn btn-outline-danger edit_data disabled"  > 
                                          <i class="fas fa-trash-alt"></i>
                                            <span>ยกเลิกการทำงาน</span>
                                        </a>
                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                           <?php if($_SESSION["use_role"]=='U'){}elseif($_SESSION["use_role"]=='A'){echo '!* หากเริ่มงานไปแล้ว จะไม่สามารถยกเลิกงานนี้ได้ *!';}?>
                                        </small>
							 
							                     
                              <?php }?>
                            <!-- </div>
						  <div class="col-4"> -->
						  
                        <input type="submit"  class="btn btn-primary btn-sm px-4 float-right" id="edit-addwork-btn" name="edit-addwork-btn" value="บันทึก">

                         </div>
                    
                      </div>
                    </div>
                    </form>
                  </div>
                <!--                                   show doc                               -->          
                  <div class="modal-content col-md-4">
					<form name="doct" method="POST" enctype="multipart/form-data"  action="get_DB.php"  > 
                    <div class="modal-header">
                      <h4 class="modal-title">เอกสาร : <?php echo $job_id ?></h4>
                    </div>

                    <div class="modal-body pt-2">
                      <label for="doc_name">ชื่อเอกสาร</label>

                      <div class="input-group mb-3 ">
                        <input type="hidden" name="job_id" value="<?php echo $job_id ?>" />
                        <input type="text" class="form-control col-md-11" id="doc_name" name="doc_name" required/>   
                      </div>

                      <div class="input-group mb-3">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="file_doc" name="file_doc" >
                          <label class="custom-file-label" for="file_doc">Choose file</label>
                        </div>
                        <div class="input-group-append">
                        <input type="submit"  name="submit_doc"  value="บันทึก" class="btn btn-outline-info btn-sm" />
                        </div>
                      </div> 
                      <div class="modal-footer mt-1">
                        <fieldset class="w-100">
							<table class="table table-hover text-nowrap align-middle" id="meTable" >
								<thead class="line-under">
								  <tr>
									<th scope="col">ชื่อเอกสาร</th>
									<th scope="col"></th>
								  </tr>
								</thead>
								<tbody class="align-middle" id="myTable">
																
								  <?php
									$sql = mysqli_query($conn, "SELECT * FROM job_doc where job_id = '$job_id'");
									while ($row = $sql->fetch_assoc()){
								  ?>
									<tr>
									  <input type="hidden" name="doc_id" value="<?php echo $row["doc_id"] ?>">
									  <td><a href="<?php echo $row['doc_path']?>" target="_blank" ><?php echo $row["doc_name"]; ?></a></td>
									  <td><a class="fas fa-trash-alt" href="get_DB.php?del_doc=<?php echo $row["doc_id"]; ?>"> ลบเอกสาร  </a></td>
									</tr>         
                        		<?php } ?>
								</tbody>
							  </table>
							
							
                   

                        </fieldset>
                      </div>
                
                  </div>
					</form>
                  </div>
                <!-- ----------------------------------------------------------------------- -->  
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
    <script> // check job    
        function validateForm() {
            return true ;
        }
    </script>
	
		<script> // Type File name 
      // Add the following code if you want the name of the file appear on select
      $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
      </script>
</body>
</html>

<?php
mysqli_close($conn);
?>