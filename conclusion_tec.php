<?php
session_start();
$date_start = null; 
$date_end = null;
if (!$_SESSION["use_firstname"]) {
  header('location: login.php');
}
if (isset($_GET['logout'])) {
  session_destroy();
  header('location: login.php');
}
elseif (isset($_POST['submit_search'])) {
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลสรุปช่าง</title>
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
                          <li class="nav-item active">
                              <a class="nav-link" href="conclusion_tec.php" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> >
                                <i class="fas fa-fw fa-cog"></i>
                                <span>ผลการทำงานช่าง</span>
                              </a>
                          </li>             
                    </ul>
  
            </div>

<!-- -------------------------------- Main --------------------------------- -->

            <div class="layout">
				<h3>ผลการทำงานของช่าง</h3>
            <div class="row">
                <div class="col-12 pt-3">
                  <div class="main float-right">                  
                    <div class="form-row align-items-center">                      
                      <div class="form-inline">
                        <form class="form-inline" action="conclusion_tec.php" method="POST" id="testform">
                          <div class="col-auto my-1">
                            <label class="mr-sm-2 justify-content-start" for="date_start">ตั้งแต่วันที่</label>
                            <input class="form-control mr-sm-2" type="date" name="date_start" id="date_start" value="<?php echo $date_start ;?>" onchange="">
                          </div>
                          <div class="col-auto my-1">
                            <label class="mr-sm-2 justify-content-start" for="date_end">ถึงวันที่</label>
                            <input class="form-control mr-sm-2" type="date" name="date_end" id="date_end" value="<?php echo $date_end ;?>"  onchange="">
                          </div>
                        
                        <div class="col-auto my-1">
                          <br>
                          <input type="submit" class="btn btn-primary px-4 float-right" name="submit_search" id="submit_search11" value="ค้นหา">
                        </div>
                        </form>
                      </div>              
                    </div>                    
                  </div>
                </div>
              </div>
              <div class="table-responsive ">

                  <table class="table table-hover text-nowrap table-light align-middle" id="meTable" >
                    <thead class="line-under">
                      <tr>
                        <th scope="col">ชื่อช่าง</th>
                        <th class="text-center" scope="col">ขั้นตอนที่เสร็จตามกำหนด</th>
                        <th class="text-center" scope="col">ขั้นตอนทั้งหมด</th>
                        <th class="text-center" scope="col">ประสิทภาพ</th>
                        <th></th>
                      </tr>
                    </thead>

                    <tbody class="align-middle" id="myTable">
                      <?php
                           $conn = new mysqli('27.254.172.62:3306', 'PiroonAssembly','JoB0847807291', 'sql_assembly');
                            $sql = mysqli_query($conn, "call getTecPerformance('$date_start','$date_end')");
                            while ($row = $sql->fetch_assoc()){
                        ?>
                            <tr>
                                <td><?php echo $row["tec_name"];?></td>
                                <td class="text-centera"><?php echo $row["nNotLate"];?></td>
                                <td class="text-centera"><?php echo $row["nOpn"];?></td>
                                <td class="text-centera"><?php $cal = ($row["nNotLate"]/$row["nOpn"]);
                                echo number_format( $cal * 100, 2 ) . ' %' ;
                                ?></td> 
                            </tr>
                        <?php } ?> 
                      

                    </tbody>
                  </table>
                  
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
                        pageLength:5,
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