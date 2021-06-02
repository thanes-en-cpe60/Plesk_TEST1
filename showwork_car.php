<?php
include('server.php');
    //---------job_id มาจากshowwork_car
    if (isset($_GET['To_show_car'])) {
        $job_id = $_GET['To_show_car'];
    }
    session_start();
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
    <title><?php echo $job_id ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" href="fontawesome/fa.css">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fa.js"></script>
    <script src="js/script.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
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
              <h3><a href="index.php">ตารางงาน</a> > <?php echo $job_id ?></h3>
              <div class="header-main row">
                <div class="col-8">
                    <div class="input-group">
                        <a href="addwork_show.php?To_show=<?php echo $job_id; ?>" >
                            <input type="button" name="show" value="ดูข้อมูล"  class="btn btn-primary " />
                        </a>                  
                    </div>
                </div>                 
              </div> 

                <div class="table-responsive ">

                  <table class="table table-hover text-nowrap table-light align-middle" id="meTable" >
                    <thead class="line-under">
                      <tr>
                        <th style="width: 5%" scope="col" class="text-center">ลำดับ</th>
                        <th style="width: 10%" scope="col">รหัสรถ</th>
                        <th style="width: 10%" scope="col">วันที่เริ่มงาน</th>
                        <th style="width: 10%" scope="col">กำหนดส่ง</th>
                        <th style="width: 5%" scope="col">%</th>
                        <th style="width: 15%" scope="col">ขั้นตอนกำลังดำเนินการ</th>
                        <th style="width: 10%" scope="col" class="text-center">สถานะ</th>
                        <th style="width: 10%" scope="col" class="text-center"></th>
                      </tr>
                    </thead>

                    <tbody class="align-middle" id="myTable">
                    <?php
                        
                        $i = 0;
                        $sql = mysqli_query($conn, "SELECT A.car_work_id ,A.car_id, A.car_status,
                        (SELECT work_date_start FROM car_work WHERE wor_id = A.car_work_id ) work_date_start, 
                        (SELECT work_date_deadline FROM car_work WHERE wor_id = A.car_work_id ) work_date_deadline,  
                        (SELECT opn_seq FROM job_work WHERE wor_id = (SELECT job_work_id FROM car_work WHERE wor_id = A.car_work_id )) opn_seq ,  
                        (SELECT opn_name FROM job_work WHERE wor_id = (SELECT job_work_id FROM car_work WHERE wor_id = A.car_work_id )) opn_name,
                        (SELECT DATEDIFF((SELECT work_date_deadline FROM car_work WHERE wor_id = A.car_work_id ), CURRENT_DATE)) day_balance,
                        (SELECT COUNT(*) FROM car_work WHERE car_id = A.car_id AND work_date_done IS NOT null) nFinish,
                        (SELECT COUNT(*) FROM car_work WHERE car_id = A.car_id ) nAll
                        FROM `car`A WHERE job_id = '$job_id'
                        ORDER BY A.car_id");
                        while ($row = $sql->fetch_assoc()){
                        $car_id = $row['car_id'];
                        $c_w_id = $row['car_work_id'];
                    ?>
                      <tr>
                        <td data-label="ลำดับ" class="text-centera">
                            <?php $i++;   
                            echo $i; ?>
                        </td>
                        <td data-label="รหัสรถ" scope="row">
                          <?php
                            if ($row['car_status'] == NULL ) {
                              echo $car_id;
                            }else {?>
                              <a href="showwork_opn.php?To_show_opn=<?php echo $car_id; ?>&job_id=<?php echo $job_id; ?>">
                                <input type="button" name="show" value="<?php echo $row["car_id"];?>"  class="btn btn-outline-primary btn-sm m-0 waves-effect" />
                              </a>
                          <?php } ?>
                        </td>
                        <td data-label="วันที่เปิดJOB">
                          <?php if ($row['work_date_start'] == null ) {
                              echo '<p class="status--grey">รอดำเนินการ</p>';
                          }else {
                              $Dstat = date_create($row['work_date_start']); 
                              echo date_format($Dstat,"d-M-Y"); 
                          }
                          ?>
                        </td>
                        <td data-label="กำหนดส่ง">
                          <?php if ($row['work_date_deadline'] == null ) {
                              echo '<p class="status--grey">รอดำเนินการ</p>';
                          }else {
                              $Dstat = date_create($row['work_date_deadline']); 
                              echo date_format($Dstat,"d-M-Y"); 
                          }
                          ?>
                        </td>
                        <td data-label="%">
                          <?php
                          if($row['opn_name'] == null){
                            echo '<p class="status--grey">0%</p>';
                          }else {
                            $cal = ($row['nFinish']/$row['nAll']);
                            echo number_format( $cal * 100, 0 ) . '%' ;
                            }
                          
                          ?>
                        </td>
                        
                        <td data-label="ขั้นตอนกำลังดำเนินการ"><?php
                        if($row['opn_name'] == null){
                          echo '<p class="status--grey">รอดำเนินการ</p>';
                        }else {
                            echo $row['opn_seq'].". ".$row['opn_name'];
                          }
                        ?></td>
                        <td data-label="สถานะ" class="text-centera">
                        <?php 
                        if ($row['car_status'] == "F") {
                            echo '<p class="status--green status">Finish</p>';}
                        elseif (($row['car_status'] == null)){
                            echo '<p class="status--grey">รอดำเนินการ</p>';
                          } 
                        elseif ($row['car_status'] == "I") {
                            if ($row['day_balance'] >= 0 ) {
                                echo '<p class="status--green status">อยู่ในกำหนด</p>'; 
                            }else {
                                echo '<p class="status--yellow status">เลยกำหนด</p>';
                            }
                        }
                        elseif ($row['car_status'] == "S") {
                          echo '<p class="status--red status">หยุดการทำงาน</p>';
                        }?>
                        </td>
                        <td class="text-centera">
                          <form method="GET" action="setwork.php">
                              <input type="hidden" name="job_id" value="<?php echo $job_id ?>">
                              <input type="hidden" name="car_id" value="<?php echo $car_id ?>">
                              <input type="hidden" name="wor_id" value="<?php echo $c_w_id  ?>">

                              <input type="submit" name="set_date_car" class="btn btn-outline-success btn-sm " value="เริ่มงาน" 
                              <?php if ($row['car_status'] == 'I' or $row['car_status'] == 'S') {
                                // show when car status == null
                                echo "hidden";
                              }?>
                              />
                              <input type="button" name="stop_date_car" class="btn btn-outline-danger btn-sm btn-stop-work"  href="javascript:void(0);" data-href="stop_car_work.php?stop_date_car=<?php echo $c_w_id;?>"  value="หยุดงาน"  
                              <?php if ($row['car_status'] == NULL or $row['car_status'] == 'S') {
                                // show when car status == In progess
                                echo "hidden";
                              }?>
                              />
                              <input type="submit" name="conit_date_car" class="btn btn-outline-primary btn-sm " value="ทำงานต่อ"  
                              <?php if ($row['car_status'] == NULL or $row['car_status'] == 'I') {
                                // show when car status == Stop
                                echo "hidden";
                              }?>
                              />
                          </form>
                        </td>
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
<!-- -------------------------------- Stop_work ------------------ -->

<div class="modal fade" id="ModalStop_work" role="dialog">
                <div class="modal modal-dialog modal-dialog-centered">       
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body">
                        </div>
                    </div>                            
                </div>
            </div>
<!-- ---------------------------------------------------------------- -->   

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
      $(document).ready(function() {
        $('#meTable').DataTable({
          paging: false,
          pageLength: 10,
          searching: false,
          lengthChange: false,
          info: false,
          "ordering": false,
          "language": {
            "info": "แสดงข้อมูล _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล",
            "paginate": {
              "next": "ถัดไป",
              "previous":   "ก่อนหน้า"
          
            }
          }
          
        });
      });
    </script>
    <script> // Show subopn   
            $(document).ready(function(){
              //console.log("Debug 01 ");
                $('.btn-stop-work').on('click',function(){
                    var dataURL = $(this).attr('data-href');
                    $('.modal-body').load(dataURL,function(){
                      //console.log("Debug 02 ");
                        $('#ModalStop_work').modal({show:true});
                        //console.log("Debug 03 ");
                        });
                    }); 
                });
    </script>

</body>
</html>

