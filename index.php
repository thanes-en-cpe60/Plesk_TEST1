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

//session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางงาน</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" href="fontawesome/fa.css">
</head>
<body>
    
        <div class="wrapper">

<!-- ------------------------------- Header -------------------------------- -->

            <div class="layout"> 
                <header class="navbar bg-white py-2">
                    <div class="container-fluid justify-content-between align-items-center">
                        <div class="nav col-2">
                            <nav>
                                <span class="nav-toggle" id="js-nav">
                                  <button type="button" id="sidebarCollapse" class="btn">
                                    <i class="icon fas fa-bars"></i>
                                  </button>          
                                </span>
                            </nav>
                        </div>
                        <div class="text-center col-8">
                            <div class="logo">
                                <img src="img/logo.png" class="responimg">
                            </div>
                        </div>
                        <div class="account d-flex justify-content-end col-2">
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
                        <li class="nav-item active ">
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
                          <li class="nav-item">
                              <a class="nav-link" href="history_work.php" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?>>
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
              <h3>ตารางงาน</h3>
              <div class="header-main row">
                <div class="col col-md-8 col-sm-12">                  
                  <button type="button" name="btn_addwork" class="btn btn-primary" onclick="window.location.href='addwork.php'"><i class="fas fa-file-medical"></i> เพิ่มงาน</button>
                  <button type="button" id="filterCollapse" class="btn btn-outline-primary"><i class="fas fa-filter"></i> ฟิลเตอร์ </button>
                </div>
                <div class="col col-md-4 col-sm-12 pt-sm-4">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" id="myInput" onkeyup="myFunction()">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-fw fa-search"></i> ค้นหา </button>
                    </div>
                  </div>
                </div>              
              </div>

              <div class="filter-main row" id="filter">
                <div class="col-12 pt-2" >  <!--  filter  --> 

                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="">โมเดลรถ</label>
                      <input id="meTable0" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="">ลูกค้า</label>
                      <input id="meTable1" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-1.5">
                      <label for="">วันที่เปิดJOB</label>
                      <input id="meTable2" type="date" class="form-control">
                    </div>                    

                    <div class="form-group col-md-1.5">
                      <label for="">กำหนดส่ง</label>
                      <input id="meTable3" type="date" class="form-control">
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-2">
                      <label for="">สถานะ</label>
                      <input id="meTable4" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="">ช่างเหล็ก</label>
                      <input id="meTable5" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="">ช่างช่วงล่าง</label>
                      <input id="meTabl6" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="">ช่างสี</label>
                     <input id="meTable7" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="">ช่างไฟ</label>
                      <input id="meTable8" type="text" class="form-control">
                    </div>
                  </div>

                </div>

              </div>
              

                <div class="table-responsive ">

                  <table class="table table-hover text-nowrap table-light align-middle" id="meTable" >
                    <thead class="line-under">
                      <tr>
                        <th style="width: 10%" scope="col" onclick="sortTable(0)">รหัสงาน</th>
                        <th style="width: 15%" scope="col" onclick="sortTable(1)">ลูกค้า</th>
                        <th style="width: 10%" scope="col" class="text-center" onclick="sortTable(2)">วันที่เปิดงาน</th>
                        <th style="width: 10%" scope="col" class="text-center" onclick="sortTable(3)">กำหนดส่ง</th>
                        <th style="width: 10%" scope="col" class="text-center" onclick="sortTable(5)">สถานะ</th>
                        <th style="width: 4%" scope="col" class="text-center" onclick="sortTable(6)">ช่างเหล็ก</th>
                        <th style="width: 4%" scope="col" class="text-center" onclick="sortTable(7)">ช่างช่วงล่าง</th>
                        <th style="width: 4%" scope="col" class="text-center" onclick="sortTable(8)">ช่างไฮดรอลิก</th>
                        <th style="width: 4%" scope="col" class="text-center" onclick="sortTable(9)">ช่างสี</th>
                        <th style="width: 4%" scope="col" class="text-center" onclick="sortTable(9)">ช่างทำโลโก้</th>
                        <th style="width: 4%" scope="col" class="text-center" onclick="sortTable(10)">ช่างไฟ</th>
                      </tr>
                    </thead>

                    <tbody class="align-middle" id="myTable">
                    <?php
                      $sql = mysqli_query($conn, "SELECT `job_id`, `job_date_start`, `job_date_deadline`,
                      (SELECT cus_name FROM customer WHERE cus_id = A.cus_id ) cus_name,
                      (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_weld ) tec_weld,
                      (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_paint) tec_paint, 
                      (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_chassis) tec_chassis,
                      (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_elec) tec_elec,
                      (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_hyd) tec_hyd,
                      (SELECT tec_name FROM technical WHERE tec_id = A.tec_id_logo) tec_logo,
					            (SELECT datediff(job_date_deadline,CURRENT_DATE) )dLate,
                      (SELECT COUNT(*) FROM car B WHERE B.job_id = A.job_id )nCar,
                      (SELECT COUNT(*) FROM car B WHERE B.job_id = A.job_id AND B.car_status = 'F')nCarDone
                      FROM job A WHERE job_date_done IS NULL");
                      while ($row = $sql->fetch_assoc()){
                    ?>
                      <tr class="ac">
                        <td data-label="รหัสงาน" scope="row">
                        
                        <input type="hidden" value="<?php echo $row["job_id"];?>">
							
                          <a class="btn btn-outline-primary btn-sm m-0 waves-effect" href="showwork_car.php?To_show_car=<?php echo $row["job_id"]; ?>" >
                          
                            <?php echo $row["job_id"];?>
                          </a>
							
                          
                        </td>
                        <td data-label="ลูกค้า"><?php echo $row["cus_name"];?></td>
                        <td data-label="วันที่เปิดJOB" class="text-centera">
                          <?php
                            $Date = date_create($row['job_date_start']); 
                            echo date_format($Date,"d-M-Y"); 
                          ?>
                        </td>
                        <td data-label="กำหนดส่ง" class="text-centera">
                          <?php
                              $Date = date_create($row['job_date_deadline']); 
                              echo date_format($Date,"d-M-Y"); 
                          ?>
                        </td>
                    
                        <td data-label="สถานะ" class="text-centera">
                          <?php
                          if ($row['dLate'] >= 0 ) {
                            echo '<p class="status--green status">อยู่ในกำหนด</p>'; 
                          }else {
                            echo '<p class="status--yellow status">เลยกำหนด</p>';
                          }
                          ?>
                        </td>
                        <td data-label="ช่างเหล็ก" class="text-centera"><?php echo $row["tec_weld"];?></td>
                        <td data-label="ช่างช่วงล่าง" class="text-centera"><?php echo $row["tec_paint"];?></td>
                        <td data-label="ช่างไฮดรอลิก" class="text-centera"><?php echo $row["tec_hyd"];?></td>
                        <td data-label="ช่างสี" class="text-centera"><?php echo $row["tec_chassis"];?></td>
                        <td data-label="ช่างทำโลโก้" class="text-centera"><?php echo $row["tec_logo"];?></td>
                        <td data-label="ช่างไฟ" class="text-centera"><?php echo $row["tec_elec"];?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  
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
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">


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

    

    <script> // Modal
      $('.openBtn').on('click',function(){
          $('.modal').load('addwork.php',function(){
              $('#addworkModal').modal({show:true});
          });
      });

      </script>

<script> //Table Jquery
              $(document).ready( function () {
                var table = $('#meTable').DataTable({
                  paging: true,
                        pageLength:10,
                        searching: true,
                        lengthChange: false,
                        info: false,
                        "dom": '<"table-responsive"tlip>',
                        "ordering": false,
                        "language": {
                          "paginate": {
                          "next": "ถัดไป",
                          "previous":   "ก่อนหน้า"
                        }
                      }  
                  
                });
          
                $('#myInput').on( 'keyup', function () {
                  table.search($('#myInput').val()).draw();
                });
              });
            </script>
	
	<script src="TableFilter.min.js" defer=""></script>


</body>
</html>