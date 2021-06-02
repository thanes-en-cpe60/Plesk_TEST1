<?php
session_start();
if (!$_SESSION["use_firstname"]) {
  header('location: login.php?err=1');
}
//----------------------------------- write html
require_once __DIR__ . '/vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'sarabun'
]);
//-----------------------------------------------------------

include('server.php');
    //---------job_id มาจากshowwork_car
    if (isset($_GET["To_show_opn"])) {
        $car_id = $_GET['To_show_opn'];
        $job_id = $_GET['job_id'];
    }  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $car_id ?></title>
    
    <!-- jQuery library -->
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
              <h3> <a href="index.php">ตารางงาน</a> > 
              <a href="showwork_car.php?To_show_car=<?php echo $job_id; ?>" > <?php echo $job_id ?></a>
              > <?php echo $car_id ?> </h3>
				
				<div class="header-main row justify-content-between">
                <div class="col-8">                  
                </div>
			 	<div class="col-4">
					<a class="float-right btn btn-outline-secondary" href="PDFw.php?car_id=<?php echo $car_id ?>" target="_blank">
						<i class="far fa-file-pdf"></i>
                        <span> พิมพ์ตารางงาน</span> 
                    </a>
				</div>
              </div>

              <?php ob_start() ?>
                <div class="table-responsive ">

                  <table class="table table-hover text-nowrap table-light align-middle" id="meTable" >
                    <thead class="line-under">
                      <tr>
                        <th style="width: 5%" scope="col" class="text-center">ลำดับ</th>
                        <th style="width: 15%" scope="col">ชื่อขันตอน</th>
                        <th style="width: 5%" scope="col" class="text-center">จำนวนวันที่ทำ</th>
                        <th style="width: 5%" scope="col" class="text-center">วันที่เรื่มทำ</th>
                        <th style="width: 5%" scope="col" class="text-center">กำหนดส่ง</th>
                        <th style="width: 5%" scope="col" class="text-center">เตือน</th>
                        <th style="width: 5%" scope="col" class="text-center">วันที่ดำเนินการสำร็จ</th>
                        <th style="width: 5%" scope="col"></th>
                      </tr>
                    </thead>

                    <tbody class="align-middle" id="myTable">
                    <?php
                   
                        $sql = mysqli_query($conn, "SELECT A.wor_id, B.opn_seq, B.opn_name, B.opn_duration, B.opn_day_notify, A.work_date_start, A.work_date_deadline, A.work_date_done,
                        (SELECT DATEDIFF(A.work_date_deadline,A.work_date_done)) day_diff,
                        (SELECT DATEDIFF(A.work_date_deadline, CURRENT_DATE)) day_balance,
                        (SELECT C.car_status FROM car C Where C.car_id = A.car_id) cSta
                        FROM car_work A 
                        JOIN job_work B
                        ON A.job_work_id = B.wor_id 
                        WHERE A.car_id ='$car_id' ORDER BY B.opn_seq");
                        $work_balance = 0;
                        while ($row = $sql->fetch_assoc()){
                        $car_work_id = $row['wor_id'];
                    ?>
                      <tr>
                        <td data-label="ลำดับ" class="text-centera"><?php echo  $row['opn_seq']; ?></td>
                        <td data-label="ชื่อขันตอน"><?php echo  $row['opn_name']?></td>
                        <td data-label="จำนวนวันที่ทำ" class="text-centera"><?php echo  $row['opn_duration'];?> วัน</td>
                        <!-- วัน start ขั้นตอน -->
                        <td data-label="วันที่เรื่มทำ" class="text-centera"><?php
                            if ($row['work_date_start'] == null ) {
                                echo "..........null..........";
                            }else {
                                $Dstat = date_create($row['work_date_start']); 
                                echo date_format($Dstat,"d-M-Y"); 
                            }
                        ?></td>
                        <!-- วัน deadline ขั้นตอน -->
                        <td data-label="กำหนดส่ง" class="text-centera"><?php 
                            if ($row['work_date_deadline'] == null ) {
                                echo "..........null..........";
                            }else {
                                $Dend = date_create($row['work_date_deadline']);
                                $date_done = date("Y-m-d");
                                $row['work_date_deadline'];
                                echo date_format($Dend,"d-M-Y");
                                 
                            }

                        ?></td>
                        <td data-label="เตือน" class="text-centera"><?php 
                            if ($row['day_diff'] == NULL ) {
                                if ($row['day_balance'] < 0) {
                                  echo '<p class="status--red status">เลยกำหนด</p>';
                              }
                                elseif ($row['day_balance'] <= $row['opn_day_notify']) {
                                    echo '<p class="status--yellow status">ใกล้ถึงกำหนด</p>';
                                }elseif ($row['day_balance'] >= $row['opn_day_notify']) {
                                    echo '<p class="status--green status">อยู่ในกำหนด</p>';
                                }
                                
                            }elseif ($row['day_diff'] >= '0') {
                                echo '<p class="status--green status">อยู่ในกำหนด</p>';
                            }elseif ($row['day_diff'] < '0') {
                                echo '<p class="status--red status">เลยกำหนด</p>';
                            } 
                        ?></td>
                        <!-- วัน done ขั้นตอน -->
                        <td data-label="วันที่ดำเนินการสำร็จ" class="text-centera"><?php
                            if ($row['work_date_done'] == null && ++$work_balance == 1) {?>
                                <a  <?php if($row['cSta']=='S'){echo 'hidden';}else{}?>  href="javascript:void(0);" data-href="popup_work-done.php?add_remark=<?php echo $car_id ?>&car_work_id=<?php echo $car_work_id ?>" class="btn btn-outline-primary btn-sm submit_work_done" onclick="check()">ยืนยันการทำงาน</a>
                                <p <?php if($row['cSta']=='I'){echo 'hidden';}else{}?>   class="status--gray status" >หยุดการทำงานอยู่</p>
                        <?php }elseif($row['work_date_done'] == null ) {
                            }else {
                                $Dend = date_create($row['work_date_done']); 
                                echo date_format($Dend,"d-M-Y"); 
                            }
                        ?></td>
                        <td data-label="ลูกค้า"><?php
                            if ($row['work_date_done'] != null) {?>
                                <a href="javascript:void(1);" data-href="pop-up_show-work.php?show_remark=<?php echo $car_id ?>&car_work_id=<?php echo $car_work_id ?>" class="btn btn-outline-secondary btn-sm submit_show_work">ดูข้อมูล</a>        
                        <?php } ?></td>
                      </tr>
                      <?php } 
                      ?>
                    </tbody>
                  </table>
                  
                </div>

            </div>
            <?php 
                $html = ob_get_contents();
                $mpdf->WriteHTML($html);
                $mpdf->Output("Report.pdf"); 
                ob_end_flush(); 
             ?> 

        <!-- Modal-submit -->
            <div class="modal fade" id="Modalsubmit" role="dialog">
                <div class="modal-lg modal-dialog modal-dialog-centered">       
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body">
                        </div>
                    </div>                            
                </div>
            </div>  


        <!-- Modal-show -->
        <div class="modal fade" id="Modalshow" role="dialog">
                <div class="modal-lg modal-dialog modal-dialog-centered">       
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body">
                        </div>
                    </div>                            
                </div>
        </div>  

</div>


<!-- ----------------------------------------------------------------------- -->
<!--                                   End                                   -->
<!-- ----------------------------------------------------------------------- -->



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

    <script> // submit subopn   
        $(document).ready(function(){
            $('.submit_work_done').on('click',function(){
                var dataURL = $(this).attr('data-href');
                $('.modal-body').load(dataURL,function(){
                    $('#Modalsubmit').modal({show:true});
                    });
                }); 
            });
      </script>

    <script> // Show subopn   
            $(document).ready(function(){
              
                $('.submit_show_work').on('click',function(){
                    var dataURL = $(this).attr('data-href');
                    $('.modal-body').load(dataURL,function(){
                        $('#Modalshow').modal({show:true});
                        });
                    }); 
                });

          function check() {
          
          }
          </script>
                


</body>
</html>

<?php
$date_done = date("Y-m-d");
$sql = mysqli_query($conn, "SELECT (COUNT(A.work_date_done)) opn_balance, 
(COUNT(*)) opn_all,
B.car_status
FROM car_work A, car B 
WHERE  A.car_id = B.car_id AND B.car_id = '$car_id'");
$row = $sql->fetch_assoc();
if ($row['opn_balance'] == $row['opn_all'] && $row['car_status'] == 'I') 
{
    $sql_upd = "UPDATE `car` SET `car_status` = 'F', `last_opn_date` = '$date_done'  WHERE `car_id` = '$car_id'";
    if (mysqli_query($conn, $sql_upd))
    {
        echo "Car_id :".$car_id ."->รถคันนี้เสร็จสมบูรณแล้ว" ;
    }
    else
    {
        echo "Error: Can't update state this car ".$car_id ;
    }
}
elseif ($row['opn_balance'] != $row['opn_all'] && $row['car_status'] == 'I') 
{ 
    $sql_upd = "UPDATE `car` SET `car_work_id` = (SELECT A.wor_id FROM `car_work` A WHERE car_id = '$car_id' AND work_date_done IS null ORDER BY wor_id  LIMIT 1), `last_opn_date` = '$date_done'  WHERE `car_id` = '$car_id'";
       if (mysqli_query($conn, $sql_upd))
       {
            echo "inprogress";
       }
       else
       {
            echo "Error: Can't update state this car ".$car_id ;
       }
}
?>
