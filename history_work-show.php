<!---------query jobs------------>
<?php
session_start();
if (!$_SESSION["use_firstname"]) {
  header('location: login.php?err=1');
} 
include('server.php');
    //---------job_id มาจากaddwork DB
    if (isset($_GET['To_show'])) {
        $job_id = $_GET['To_show'];
        $sql = "SELECT A.job_id, A.product_id, A.cus_id, A.job_date_start,A.mod_id,A.sub_id,A.job_axle,A.car_id_start, A.car_qty, A.job_detail,A.job_date_deadline,A.job_date_done,
        (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_weld ) tec_weld,
        (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_paint) tec_paint, 
        (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_chassis) tec_chassis,
        (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_elec) tec_elec,
        (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_hyd) tec_hyd,
        (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_logo) tec_logo, 
        (SELECT COUNT(*) FROM car WHERE car_status IS  NOT NULL AND job_id = A.job_id) nCarStatus,
        (SELECT COUNT(*) FROM car WHERE car_status ='F' AND job_id = A.job_id) nCarFin,
        (SELECT COUNT(*) FROM car WHERE job_id = A.job_id) nCarAll
        FROM job A
        WHERE  job_id = '$job_id'";
        $query = mysqli_query($conn,$sql);
        $result=mysqli_fetch_array($query,MYSQLI_ASSOC);
    }  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>งาน <?php echo $job_id ; ?></title>
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
      <li class="nav-item  ">
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
        <li class="nav-item active">
            <a class="nav-link" href="history_work.php" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> >
              <i class="fas fa-file-invoice"></i>
              ประวัติงาน
            </a>
        </li>
        <li class="nav-item ">
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
              <span>ผลประกอบการบริษัท</span>
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
          <h3><a href="history_work.php" >
          ประวัติงาน</a> > <?php echo $result["job_id"] ?></h3>
              
          <form name="doct" method="POST" enctype="multipart/form-data"  action="get_DB.php"  >             
              <div class="pt-4 pb-5 row justify-content-md-center">

                <div class="modal-content col-md-8 mr-2 col-sm-10">

                  <div class="modal-header">
                    <h4 class="modal-title">รหัสงาน : <?php echo $job_id ?></h4>
                  </div>
                  
                  <div class="modal-body pt-3">

                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="">ชื่อลูกค้า :</label>
                        <?php  
                        $CusId = $result["cus_id"];
                        $sql = mysqli_query($conn, "SELECT cus_name FROM customer where cus_id = '$CusId' ");
                        $row = $sql->fetch_assoc();
                        echo $row['cus_name'] ;
                        ?>
                      </div>
                      
                      <div class="form-group col-md-6 ">
                        <label for="">รหัสติดตามสินค้า :</label>
                        <?php echo $result["product_id"] ;?>
                      </div>
                    </div>

                    
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="">โมเดลรถ :</label>
                        <?php echo $result["mod_id"] ;?>
                      </div>

                      <div class="form-group col-md-9">
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
                            }elseif($JobAx == 3) {
                                echo "3 เพลา" ;
                            }else {
                                echo "ไม่มีเพลา" ;
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

                    <div class="form-group">
                      <label for="">รายละเอียด :</label>
                      <?php echo $result["job_detail"] ;?>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="">วันที่เปิดงาน :</label>
                        <?php echo $result["job_date_start"] ;?>
                        </div>
                        
                        <div class="form-group col-md-6">
                        <label for="">วันที่ปิดงาน :</label>
                        <?php echo $result["job_date_deadline"] ;?>
                        </div>
                    </div>

                    <div class="form-row">
						
						<div class="form-group col-md-3">
                      
                        <label for="">ช่างเหล็ก :</label>
                        <?php 
                                echo $result['tec_weld'];
                        ?>
                        </div>
                        
                        <div class="form-group col-md-3">
                        <label for="">ช่างช่วงล่าง :</label>
                        <?php 
                                echo $result['tec_chassis'];
                        ?>
                        </div>

                        <div class="form-group col-md-3">
                        <label for="">ช่างไฮดรอลิก :</label>
                        <?php 
                                echo $result['tec_hyd'];
                        ?>
                        </div>
                      
                        <div class="form-group col-md-3">
                        <label for="">ช่างสี :</label>
                        <?php 
                            echo  $result["tec_paint"];
                        ?>
                        </div>
                        
                        <div class="form-group col-md-3">
                        <label for="">ช่างโลโก้ :</label>
                        <?php 
                                echo $result['tec_logo'];
                        ?>
                        </div>

                        <div class="form-group col-md-3">
                        <label for="inputAddress">ช่างไฟ :</label>
                        <?php 
                                echo $result['tec_elec'];
							    
                        ?>
                        </div>
                      
                    </div>

                  

                
                    <div class="modal-footer mt-3">
                      <fieldset class="w-100">
						  
						  <?php
                                if ($result['nCarFin'] == $result['nCarAll'] && $result['job_date_done'] == '')
									 
                                      {?>
                                        <a href="get_DB.php?Finish=<?php echo $job_id ;?>" > 
                                            <input type="button" name="del-job"  id="del-" value="ยืนยันการส่งงาน"  />
                                        </a>
                              <?php } ?>
                      		  
                      </fieldset>
                    </div>

                     
                  </div>

                </div>
<!-- ----------------------------------------------------------------------- -->
<!--                                   add doc                               -->                           
                <div class="modal-content col-md-3 col-sm-10">
                    <div class="modal-header">
                      <h4 class="modal-title">เอกสาร : <?php echo $job_id ?></h4>
                    </div>
                          <table class="table table-hover text-nowrap align-middle" id="meTable" >
								<thead class="line-under">
								  <tr>
									<th scope="col">ชื่อเอกสาร</th>
								  </tr>
								</thead>
								<tbody class="align-middle" id="myTable">
									<?php
										$sql = mysqli_query($conn, "SELECT * FROM job_doc where job_id = '$job_id'");
										while ($row = $sql->fetch_assoc()){
									  ?>
									<tr>
									  <td><a href="<?php echo $row['doc_path']?>" target="_blank" ><?php echo $row["doc_name"]; ?></a></td>
									</tr>         
									<input type="hidden" name="doc_id" value="<?php echo $row["doc_id"] ?>">
									<?php } ?>
								</tbody>
							  </table>
                  </div>
                </div>
              </div>
            </form>
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



