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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติรถ</title>
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
                          <li class="nav-item">
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
                          <li class="nav-item active">
                              <a class="nav-link" href="history_car.php" >
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
                              <a class="nav-link" href="conclusion_tec.php" >
                                <i class="fas fa-fw fa-cog"></i>
                                <span>ผลการทำงานช่าง</span>
                              </a>
                          </li>             
                    </ul>
  
            </div>

<!-- -------------------------------- Main --------------------------------- -->

            <div class="layout">
              <h3>ประวัติรถ</h3>
              <div class="header-main row">
                <div class="col-8">                  
                  <button type="button" id="filterCollapse" class="btn btn-outline-primary"><i class="fas fa-filter"></i> Filter </button>
                </div>
                <div class="col-4">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" id="myInput" onkeyup="myFunction()">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-fw fa-search"></i> Search </button>
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
                      <input  id="meTable2" type="date" class="form-control">
                    </div>                    

                    <div class="form-group col-md-1.5">
                      <label for="">กำหนดส่ง</label>
                      <input  id="meTable3" type="date" class="form-control">
                    </div>

                    <div class="form-group col-md-1">
                      <label for="">วันส่งงาน</label>
                      <input  id="meTable4" type="date" class="form-control">
                    </div>

                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-2">
                      <label for="">สถานะ</label>
                      <input id="meTable5" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="">ช่างเหล็ก</label>
                      <input id="meTable6" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="">ช่างช่วงล่าง</label>
                      <input id="meTable7" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="">ช่างสี</label>
                      <input id="meTable8" type="text" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="">ช่างไฟ</label>
                      <input id="meTable9" type="text" class="form-control">
                    </div>
                  </div>

                </div>

              </div>
              

                <div class="table-responsive ">

                  <table class="table table-hover text-nowrap table-light align-middle" id="meTable" >
                    <thead class="line-under">
                      <tr>
                        <th style="width: 10%" scope="col">รหัสงาน</th>
                        <th style="width: 15%" scope="col">ลูกค้า</th>
                        <th style="width: 8%" scope="col" class="text-center">วันที่เปิดJOB</th>
                        <th style="width: 8%" scope="col" class="text-center">กำหนดส่ง</th>
                        <th style="width: 10%" scope="col" class="text-center">วันที่รถเสร็จ</th>
                        <th style="width: 10%" scope="col" class="text-center">สถานะ</th>
                        <th style="width: 4%" scope="col" class="text-center">ช่างเหล็ก</th>
                        <th style="width: 4%" scope="col" class="text-center">ช่างช่วงล่าง</th>
                        <th style="width: 4%" scope="col" class="text-center">ช่างไฮดรอลิก</th>
                        <th style="width: 4%" scope="col" class="text-center">ช่างสี</th>
                        <th style="width: 4%" scope="col" class="text-center">ช่างทำโลโก้</th>
                        <th style="width: 4%" scope="col" class="text-center">ช่างไฟ</th>
                      </tr>
                    </thead>

                    <tbody class="align-middle" id="myTable">
                    <?php
                        $sql = mysqli_query($conn, "SELECT A.car_id,
                        (SELECT (SELECT C.cus_name FROM customer C WHERE C.cus_id = B.cus_id) FROM job B WHERE B.job_id = A.job_id) cusName,
                        (SELECT MIN(D.work_date_start) FROM car_work D WHERE D.car_id = A.car_id ) wStart,
                        (SELECT MAX(D.work_date_deadline) FROM car_work D WHERE D.car_id = A.car_id ) dDeadline,
                        (SELECT MAX(D.work_date_done) FROM car_work D WHERE D.car_id = A.car_id ) wEnd,
                        (SELECT DATEDIFF((SELECT MAX(D.work_date_deadline) FROM car_work D WHERE D.car_id = A.car_id ),(SELECT MAX(D.work_date_done) FROM car_work D WHERE D.car_id = A.car_id ))) dDiff, 
                        (SELECT (SELECT T.tec_name FROM technical T WHERE T.tec_id = B.tec_id_weld) FROM job B WHERE B.job_id = A.job_id) tec_weld,
                        (SELECT (SELECT T.tec_name FROM technical T WHERE T.tec_id = B.tec_id_paint) FROM job B WHERE B.job_id = A.job_id) tec_paint,
                        (SELECT (SELECT T.tec_name FROM technical T WHERE T.tec_id = B.tec_id_elec) FROM job B WHERE B.job_id = A.job_id) tec_elec,
                        (SELECT (SELECT T.tec_name FROM technical T WHERE T.tec_id = B.tec_id_chassis) FROM job B WHERE B.job_id = A.job_id) tec_chassis,
                        (SELECT (SELECT T.tec_name FROM technical T WHERE T.tec_id = B.tec_id_hyd) FROM job B WHERE B.job_id = A.job_id) tec_hyd,
                        (SELECT (SELECT T.tec_name FROM technical T WHERE T.tec_id = B.tec_id_logo) FROM job B WHERE B.job_id = A.job_id) tec_logo,
                        (SELECT datediff( dDeadline,wEnd) )dLate
                        FROM car A
                        WHERE A.car_status = 'F'");
                        while ($row = $sql->fetch_assoc()){
                        $car_id = $row["car_id"];
                    ?>
                      <tr>                                   
                        <td scope="row">
							<a class="btn btn-outline-primary btn-sm m-0 waves-effect" href="history_car-opn.php?To_his_opn=<?php echo $row["car_id"]; ?>" >
                     
                            <?php echo $row["car_id"];?>
                          </a>
							
                      
                        </td>
                        <td><?php echo $row["cusName"];?></td>
                        <td class="text-center"><?php echo $row["wStart"];?></td>
                        <td class="text-center"><?php echo $row["dDeadline"];?></td>
                        <td class="text-center"><?php echo $row["wEnd"];?></td>
                        <td class="text-center">
                          <button  <?php if ($row["dLate"] < 0) {
                              echo 'hidden' ;
                            } else {}
                            ?> type="button" class="btn btn-outline-success btn-sm">อยู่ในกำหนด</button>
                            <button  <?php if ($row["dLate"] >= 0) {
                              echo 'hidden' ;
                            } else {}
                            ?> type="button" class="btn btn-outline-danger btn-sm">เลยกำหนด</button>
                        </td>
                        <td class="text-center"><?php echo $row["tec_weld"];?></td>
                        <td class="text-center"><?php echo $row["tec_chassis"];?></td>
                        <td class="text-center"><?php echo $row["tec_hyd"];?></td>
                        <td class="text-center"><?php echo $row["tec_paint"];?></td>
                        <td class="text-center"><?php echo $row["tec_logo"];?></td>
                        <td class="text-center"><?php echo $row["tec_elec"];?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  
                </div>

            </div>

<!-- ------------------------------- addwork ------------------------------- -->

            

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
	<script src="TableFilter.min.js" defer=""></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">




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

    

<script> //Table Jquery
              $(document).ready( function () {
                var table = $('#meTable').DataTable({
                  paging: true,
                        pageLength:15,
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




</body>
</html>