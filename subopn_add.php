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
    
}
elseif (isset($_GET['To_edit'])) {
    $sub_id = $_GET['sub_id'];
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

                    <div class="header-main row">
                                 
                    </div>

                    <div class="table-responsive">
                    <form name="add_opn" action="subopn_add.php" method="POST" onsubmit="return(validateForm());">
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
                                    <?php
                                    $seq_all = 0 ;
                                    $seq = 1 ;
                                        $sql = mysqli_query($conn, "SELECT* FROM submodel_opn where sub_id = '$sub_id' ORDER BY opn_seq ");
                                        while ($row = $sql->fetch_assoc()) 
                                        {?>
                                            <tr>
                                                <td><?php echo $row["opn_seq"]; ?></td>
                                                <td><?php echo $row["opn_name"]; ?></td>
                                                <td><?php echo $row["opn_duration"]; ?></td>
                                                <td><?php echo $row["show_opn"]; ?></td>
                                                <td><?php echo $row["show_name_new"]; ?></td>
                                                <td style='text-align:center;'>
                                                    <a href="javascript:void(0);" data-href="subopn_edit.php?edit_opn=<?php echo $row["opn_id"]; ?>&sub_id=<?php echo $sub_id; ?>" class="btn btn-outline-info btn-sm edit_sub_opn">แก้ไข</a>
                                                    <a href="model_db.php?del_opn=<?php echo $row["opn_id"]; ?>&sub_id=<?php echo $sub_id; ?>&opn_seq=<?php echo $row["opn_seq"]; ?>" class="btn btn-outline-danger btn-sm" >ลบขั้นตอน</a>
                                                </td>
                                                
                                                <?php
                                                    $seq_all = $seq ;
                                                    $seq = $row["opn_seq"] + 1 ;
                                                ?>
                                            </tr>   
                                    <?php } ?>
                            </tbody>
                            
                            <tfoot>
                                <tr>
                                    <td>
                                        <input type="hidden" name="sub_id" value="<?php echo $sub_id ?>"/>
                                        <!-- number Seq -------------------------------------------------->
                                         <select class="form-control" name="opn_seq" id="opn_seq"  >
                                            <?php
                                                while ($seq > 0 ) {
                                                echo "<option value='".$seq."'>". $seq ."</option>";
                                                $seq--;
                                                }
                                            ?>
                                        </select>    
                                    </td>
                                        <input class="form-control" type="hidden" name="seq_all" value="<?php echo $seq_all ?>" />
                                            <!-- -------------------------------------------------------- -->
                                     <td>     
                                        <input class="form-control" type="text" name="opn_name" id="opn_name"  size="35"autocomplete="on"/>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" name="opn_duration" id="opn_duration" size="2" min="0" max="20"/>
                                    </td> 
                                            <!-- checkbox -------------------------------------------------->
                                    <td>
                                        <input type="hidden" name="show_opn" id="dont_show" value="0" >
                                        <input type="checkbox"  name="show_opn" id="show"  value="1" data-toggle="toggle" data-size="sm" data-on="แสดง" data-off="ไม่แสดง" data-onstyle="info" data-offstyle="danger" >
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="show_name_new" id="show_name_new" />
                                    </td>
                                            <!-- -------------------------------------------------------- -->
                                    <td style='text-align:center;'>
                                        <input class="btn btn-success" type="submit" name="submit_opn"  value="+ เพิ่มขั้นตอน"  />          
                                    </td>                                                           
                                </tr>
                            </tfoot>  
                        </table>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">       
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">

                                    </div>
                                </div>
                            
                            </div>
                        </div> 
        </div>
      </div>

</div>
<!-- ----------------------------------------------------------------------- -->
<!--                                   End                                   -->
<!-- ----------------------------------------------------------------------- -->
<script>
function validateForm() {
    var show = document.getElementById("show").checked
    var NewName = document.forms["add_opn"]["show_name_new"].value;
    var NewSeq = document.forms["add_opn"]["opn_seq"].value;
    var SeqAll = document.forms["add_opn"]["seq_all"].value;
    if (show == 1 && NewName == "")
    {
        alert("กรุณาใส่ชื่อขั้นตอนที่ต้องการแสดง");
        return false;
    }
    else
    {
        if(NewSeq <= SeqAll )
        {
            var c = confirm("คุณต้องการแทรกขั้นตอนที่มีอยู่หรือไม่ ?");
                if (c == true) 
                {
                    return true;   
                }
                else 
                {
                    return false; 
  	            }
        }
        else
        {
            return true; 
        }
    }
}
</script>                                            
        
    

    
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