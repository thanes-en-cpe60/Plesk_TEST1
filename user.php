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
if(isset($_GET['err'])){
  if ($_GET['err'] == 1)
  {
    echo "<SCRIPT> //showing me
        alert('! มี User_id นี้อยู่แล้ว กรุณากรอก user id ใหม่ !');
        </SCRIPT>";
  }
  else
  {
    echo "<SCRIPT> //showing me
        alert('ระบบเกิดข้อผิดพลาด');
        </SCRIPT>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลบุคลากร</title>

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
                        <li class="nav-item ">
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
                              <a class="nav-link " href="customer.php" >
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
                          <li class="nav-item active">
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
              <h3>ข้อมูลบุคลากร</h3>
              <div class="header-main row">
                <div class="col-8">                  
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adduserModal"><i class="fas fa-file-medical"></i> เพิ่มบุคลากร</button>
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

                <div class="table-responsive ">

                  <table class="table table-hover text-nowrap table-light align-middle" id="meTable" >
                    <thead class="line-under">
                      <tr>
                        <th scope="col">ชื่อผู้ใช้</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">นามสกุล</th>
                        <th scope="col">สิทธิ์</th>
                        <th></th>
                      </tr>
                    </thead>

                    <tbody class="align-middle" id="myTable">
                      <?php
                            
                            $sql = mysqli_query($conn, "SELECT * FROM user");
                            while ($row = $sql->fetch_assoc()){
                        ?>
                            <tr>
                                <td data-label="ชื่อผู้ใช้"><?php echo $row["user_id"];?></td>
                                <td data-label="ชื่อ"><?php echo $row["use_firstname"];?></td>
                                <td data-label="นามสกุล"><?php echo $row["use_lastname"];?></td>
                        <?php
                                if($row["use_role"] == "A"){
                                    echo '<td data-label="สิทธิ์">',"Admin",'</td>';
                                }
                                elseif($row["use_role"] == "U"){
                                    echo '<td data-label="สิทธิ์">',"User",'</td>';
                                }
                                else{
                                    echo '<td data-label="สิทธิ์">',"Read only",'</td>';
                                }
                        ?>

                                <td>
                                  <a  name="edituser-btn" href="javascript:void(0);" data-href="user_edit.php?user_edit=<?php echo $row["user_id"];?>" class="btn btn-outline-primary btn-sm edit_user">แก้ไข</a>
                                  <a name="del-user-btn" href="get_DB.php?delete_user=<?php echo $row["user_id"];?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่ !'); " >
                                    <input type="button" name="del-cus-btn" value="ลบ"  class="btn btn-outline-danger btn-sm edit_data" />
                                  </a>
                                </td>      
                            </tr>
                        <?php } ?> 
                      

                    </tbody>
                  </table>
                  
                </div>

            </div>

<!-- ------------------------------- adduser ------------------------------- -->


            <div class="modal fade" id="adduserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">เพิ่มบุคลากร</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body pt-3">

                  <form class="needs-validation" action="get_DB.php" id="add-user" method="post" novalidate> 
                    
                    <div class="form-group">
                      <label for="inputAddress">ชื่อ</label>
                      <input type="text" class="form-control" name="use_firstname" required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อ
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">นามสกุล</label>
                      <input type="text" class="form-control" name="use_lastname" required>
                      <div class="invalid-feedback">
                        กรุณาใส่นามสกุล
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">User ID</label>
                      <input type="text" class="form-control"  pattern="[A-Za-z0-9]{4,10}" title="user id"  name="user_id" required>
						<small id="passwordHelpBlock" class="form-text text-muted">
						  สามารถใส่ตัวอักษรได้ไม่เกิน 10 ตัวอักษร
						</small>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อผู้ใช้ (รูปแบบ a-z,A_Z,0-9 ห้ามใช้อักขระพิเศษ)
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputAddress">Password</label>
                      <input type="text" class="form-control"  name="use_password"  pattern="[A-Za-z0-9]{8,}" title="password" required>
                      <div class="invalid-feedback">
                        กรุณาใส่รหัสผ่าน (รูปแบบ a-z,A-Z,0-9 มากกว่า 8 ตัว)
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputAddress">สิทธิ์</label>
                        <select class="custom-select" name="use_role" required>
                          <option selecte disabled value="">โปรดเลือก</option>
                          <option value="A">Admin</option>
                          <option value="U">User</option>
                   
                        </select>
                      <div class="invalid-feedback">
                        กรุณาเลือกสิทธิ์
                      </div>
                    </div>
                    
                  </div>
                  

                
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary px-4" name="submit-user-btn">บันทึก</button>
                  </div>
                </form>
                </div>
              </div>
            </div>                    
            

          </div>

          <!-- Modal-show -->
          <div class="modal fade" id="Modaledit" role="dialog">
                <div class="modal modal-dialog modal-dialog-centered">       
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body-edit">
                        </div>
                    </div>                            
                </div>
        </div>






<!-- ----------------------------------------------------------------------- -->
<!--                                   End                                   -->
<!-- ----------------------------------------------------------------------- -->



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


    <script> // Show subopn   
            $(document).ready(function(){
                $('.edit_user').on('click',function(){
                    var dataURL = $(this).attr('data-href');
                    $('.modal-body-edit').load(dataURL,function(){
                        $('#Modaledit').modal({show:true});
                        });
                    }); 
                });
          </script>




</body>
</html>