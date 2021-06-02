<?php
session_start();
if (!$_SESSION["use_firstname"]) {
  header('location: login.php?err=1');
}
include('server.php');
// ------ จาก submodel_show-------

if (isset($_GET['To_add'])) {  
    $sub_id = $_GET['To_add'];
    $sql = mysqli_query($conn, "SELECT mod_id, sub_name, sub_id FROM submodel where sub_id='$sub_id' ");
    $row = $sql->fetch_assoc();
    $sub_name = $row['sub_name'] ;
    $mod_id = $row['mod_id'] ;
    $exam_id = null ;
}
elseif (isset($_GET['To_edit'])) {
    $sub_id = $_GET['sub_id'];
    $sql = mysqli_query($conn, "SELECT mod_id, sub_name, sub_id FROM submodel where sub_id='$sub_id' ");
    $row = $sql->fetch_assoc();
    $sub_name = $row['sub_name'] ;
    $mod_id = $row['mod_id'] ;
    $exam_id = null ;
}
elseif (isset($_GET['exam_id'])) {
    $exam_id = $_GET['exam_id'] ;
    $sub_id = $_GET['sub_id'] ;
    $sql = mysqli_query($conn, "SELECT mod_id, sub_name, sub_id FROM submodel where sub_id='$sub_id' ");
    $row = $sql->fetch_assoc();
    $sub_name = $row['sub_name'] ;
    $mod_id = $row['mod_id'] ;
}
elseif (isset($_GET["submit_opn_1"])) {
    $sub_id = $_GET['sub_id'];
    $opn_id = $_GET['opn_id'];
	$opn_name = $_GET['opn_name'];
    $opn_duration = $_GET['opn_duration'];
    $opn_day_notify = $_GET['opn_day_notify'];
    $show_opn = $_GET['show_opn'];
    $show_name_new = $_GET['show_name_new'];
    $sql_upd ="UPDATE `submodel_opn` SET opn_name = '$opn_name',opn_duration ='$opn_duration',opn_day_notify = '$opn_day_notify',show_opn = '$show_opn', show_name_new ='$show_name_new'   WHERE opn_id = $opn_id ";
    if (mysqli_query($conn, $sql_upd)) {
        header("Location: subopn_add.php?To_add=$sub_id");
   } else {
       echo "alert('Error:Can't reset sequence/ back to delete again');";
   } 
}
elseif (isset($_POST["submit_opn"])){
    $sub_id = $_POST['sub_id'];
    $opn_seq = $_POST['opn_seq'];
	$opn_name = $_POST['opn_name'];
    $opn_duration = $_POST['opn_duration'];
    $opn_day_notify = $opn_duration ;
    $show_opn = $_POST['show_opn'];
    $show_name_new = $_POST['show_name_new'];
    //(1) --------Check show_opn submit AND name_new submit  ?
    if ($show_opn == '1' AND $show_name_new == null) {
            echo 'ERROR: Show name operation is null ';
    }else{
        $sql = mysqli_query($conn, "SELECT* FROM submodel_opn where sub_id = '$sub_id' AND opn_seq ='$opn_seq' ");
        $row = $sql->fetch_assoc();
        //(2) --------Check new seq == sql in db(yes/no)? 
        if ($row["opn_seq"]) {
            $sql = "UPDATE `submodel_opn` SET `opn_seq`= `opn_seq` +1 WHERE sub_id = $sub_id AND opn_seq >= $opn_seq ";
            if(mysqli_query($conn, $sql)){
                // allpass  insert to db
                $sql = "INSERT INTO submodel_opn (sub_id, opn_seq, opn_name, opn_duration, opn_day_notify, show_opn, show_name_new) VALUES ('$sub_id','$opn_seq','$opn_name','$opn_duration','$opn_day_notify','$show_opn','$show_name_new')";
                if(mysqli_query($conn, $sql)){
                    // header("Location: subopn_add.php?To_add=$sub_id");
                }else{
                    echo "ERROR: Could not able to execute Car Table $sql. " . mysqli_error($conn);
                }
            }else{
                echo "ERROR: Could not able to execute Car Table $sql. " . mysqli_error($conn);
            }
            
        }else {
            // allpass  insert to db
            $sql = "INSERT INTO submodel_opn (sub_id, opn_seq, opn_name, opn_duration, opn_day_notify, show_opn, show_name_new) VALUES ('$sub_id','$opn_seq','$opn_name','$opn_duration','$opn_day_notify','$show_opn','$show_name_new')";
                if(mysqli_query($conn, $sql)){
                    // header("Location: subopn_add.php?To_add=$sub_id");
                }else{
                    echo "ERROR: Could not able to execute Car Table $sql. " . mysqli_error($conn);
                }
        }
    }
    $sql = mysqli_query($conn, "SELECT mod_id, sub_name, sub_id FROM submodel where sub_id='$sub_id' ");
    $row = $sql->fetch_assoc();
    $sub_name = $row['sub_name'] ;
    $mod_id = $row['mod_id'] ;
    $exam_id = null ;  
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มโมเดลย่อย<?php echo $mod_id ."|".$sub_name ?></title>

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
                          <li class="nav-item">
                              <a class="nav-link" href="#" >
                                <i class="fas fa-file-invoice"></i>
                                ประวัติรถ
                              </a>
                          </li>
            
                          <br>
            
                          <li class="nav-item active">
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
        <h3>โมเดลรถ > <?php echo $mod_id ." | ".$sub_name." > " ." ขั้นตอนการประกอบ "?></h3>
        <div class="">

                    <div class="header py-4">
                        <form class="form-inline" name="copy_opn" action="subopn_copy.php" method="GET">
                            <label class="my-1 mr-2">คัดลอกขั้นตอน</label>
                            <select class="custom-select my-1 mr-sm-2" name="exam_id"  id="exam_id" class="select" onchange="this.form.submit()" require >
                                <?php
                                    if ($exam_id == '') echo '<option value="" selected>โปรดเลือก</option>';
                                    else echo '<option value="">โปรดเลือก</option>';
                                    $Ex_sql = mysqli_query($conn, "SELECT s.mod_id, s.sub_name, s.sub_id FROM submodel s WHERE 
                                    (SELECT COUNT(so.sub_id) FROM submodel_opn so WHERE so.sub_id = s.sub_id  ) > 0");
                                    while ($Demo = $Ex_sql->fetch_assoc()) {
                                        $sub_name = $Demo['sub_name'] ;
                                        $mod_id = $Demo['mod_id'] ;
                                        if ($Demo['sub_id'] == $exam_id) {
                                            echo "<option value='" . $Demo['sub_id'] . "' selected >" . $mod_id ."|".$sub_name . "</option>";
                                        }
                                        else {
                                            echo "<option value='" . $Demo['sub_id'] . "'>" . $mod_id ."|".$sub_name . "</option>";
                                        }       
                                    }
                                ?>
                            </select>
                            <input type="hidden" name="sub_id" value="<?php echo $sub_id ?>">
                            <input class="btn btn-primary my-1" type="button" name="submit_copy"value="คัดลอกขั้นตอน" onClick="this.form.action='model_db.php'; submit()">
                        </form>          
                    </div>

                    <div class="table-responsive">
                    <form name="add_opn" action="subopn_add.php" method="POST" >
                        <table class="table table-hover text-nowrap table-light align-middle"  >
                            <thead class="line-under">
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ขั้นตอน</th>
                                <th scope="col">จำนวนวันที่ทำ</th>
                                <th scope="col">แสดงขั้นตอน</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody class="align-middle" id="myTable">
                            <form action="" method="get">
                            <?php
                                if ($exam_id != null) {
                                    $sql = mysqli_query($conn, "SELECT* FROM submodel_opn where sub_id = '$exam_id' ORDER BY opn_seq");
                                    while ($row = $sql->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$row["opn_seq"]."</td>";
                                        echo "<td>".$row["opn_name"]."</td>"; 
                                        echo "<td>".$row["opn_duration"]."</td>";
                                        echo "<td>".$row["show_opn"]."</td>";
                                        echo "<td>".$row["show_name_new"]."</td>";
                                        echo "</tr>";
                                    } 
                                }
                            ?> 
                            </form>
                            </tbody>  
                        </table>
        </div>
      </div>
      
      
            



</div>
<!-- ----------------------------------------------------------------------- -->
<!--                                   End                                   -->
<!-- ----------------------------------------------------------------------- -->

        
    

    
    <script language="javascript"> // Get outside from
        function fncSubmit(strPage){
            if(strPage == "page1")
            {
                document.copy_opn.action='model_db.php';
            }	 
            document.copy_opn.submit();
        } 
        </script>

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

    <script> //Table Jquery
      $(document).ready(function() {
        $('#meTable').DataTable({
          paging: false,
          searching: false,
          lengthChange: false,
          info: false,
          "ordering": false,
          "language": {
            "info": " ",
            "paginate": {
              "next": "ถัดไป",
              "previous":   "ก่อนหน้า"
          
            }
          }
          
        });
      });
      </script>
    <script> // edit subopn   
        $(document).ready(function(){
            $('.edit_sub_opn').on('click',function(){
                var dataURL = $(this).attr('data-href');
                $('.modal-body').load(dataURL,function(){
                    $('#myModal').modal({show:true});
                    });
                }); 
            });
            </script>
            
        </script>





</body>
</html>