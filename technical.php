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
    <title>ข้อมูลช่าง</title>
    
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
                                <img src="img/logo.png" class="responimg">
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
                          <li class="nav-item active">
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
              <h3>ข้อมูลช่าง</h3>
              <div class="header-main row">
                <div class="col-md-8 col-sm-4">                  
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtechnicalModal"><i class="fas fa-file-medical"></i> เพิ่มช่าง</button>
                </div>
                <div class="col-md-4 col-sm-4">
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
                        <th scope="col">ชื่อช่าง</th>
                        <th scope="col">เบอร์โทรศัพท์</th>
                        <th scope="col" class="text-center">ช่างเหล็ก</th>
                        <th scope="col" class="text-center">ช่างช่วงล่าง</th>
                        <th scope="col" class="text-center">ช่างไฮดรอลิก</th>
                        <th scope="col" class="text-center">ช่างสี</th>
                        <th scope="col" class="text-center">ช่างทำโลโก้</th>
                        <th scope="col" class="text-center">ช่างไฟ</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>

                    <tbody class="align-middle" id="myTable">
                      <?php
                            $sql = mysqli_query($conn, "SELECT * FROM technical");
                            while ($row = $sql->fetch_assoc()){
                        ?>
                            <tr>
                                <td data-label="ชื่อช่าง"><?php echo $row["tec_name"];?></td>
                                <td data-label="เบอร์โทรศัพท์"><?php echo $row["tec_tel"];?></td>
                        <?php
                                if($row["tec_skill_weld"] == 0){
                                    echo '<td data-label="ช่างเหล็ก" align="center">',"<span style='color: #6c757d;''><i class='far fa-times-circle fa-lg'></i></span>",'</td>';
                                }else{
                                    echo '<td data-label="ช่างเหล็ก" align="center">',"<span style='color: #007bff;''><i class='far fa-check-circle fa-lg'></i></span>",'</td>';
                                }
								
								                if($row["tec_skill_chassis"] == 0){
                                    echo '<td data-label="ช่างช่วงล่าง" align="center">',"<span style='color: #6c757d;''><i class='far fa-times-circle fa-lg'></i></span>",'</td>';
                                }else{
                                    echo '<td data-label="ช่างช่วงล่าง" align="center">',"<span style='color: #007bff;''><i class='far fa-check-circle fa-lg'></i></span>",'</td>';
                                }

                                if($row["tec_skill_hyd"] == 0){
                                  echo '<td data-label="ช่างไฮดรอลิก" align="center">',"<span style='color: #6c757d;''><i class='far fa-times-circle fa-lg'></i></span>",'</td>';
                                }else{
                                  echo '<td data-label="ช่างไฮดรอลิก" align="center">',"<span style='color: #007bff;''><i class='far fa-check-circle fa-lg'></i></span>",'</td>';
                                }
								
                                if($row["tec_skill_paint"] == 0){
                                    echo '<td data-label="ช่างสี" align="center">',"<span style='color: #6c757d;''><i class='far fa-times-circle fa-lg'></i></span>",'</td>';
                                }else{
                                    echo '<td data-label="ช่างสี" align="center">',"<span style='color: #007bff;''><i class='far fa-check-circle fa-lg'></i></span>",'</td>';
                                }

                                if($row["tec_skill_logo"] == 0){
                                  echo '<td data-label="ช่างทำโลโก้" align="center">',"<span style='color: #6c757d;''><i class='far fa-times-circle fa-lg'></i></span>",'</td>';
                              }else{
                                  echo '<td data-label="ช่างทำโลโก้" align="center">',"<span style='color: #007bff;''><i class='far fa-check-circle fa-lg'></i></span>",'</td>';
                              }
                               
                                if($row["tec_skill_elec"] == 0){
                                    echo '<td data-label="ช่างไฟ" align="center">',"<span style='color: #6c757d;''><i class='far fa-times-circle fa-lg'></i></span>",'</td>';
                                }else{
                                    echo '<td data-label="ช่างไฟ" align="center">',"<span style='color: #007bff;''><i class='far fa-check-circle fa-lg'></i></span>",'</td>';
                                }
                        ?>
                                <td>
                                  <a href="javascript:void(0);" data-href="technical_edit.php?tec_edit=<?php echo $row["tec_id"];?>" class="btn btn-outline-info btn-sm submit_show_work">แก้ไข</a>
                                  <a href="get_DB.php?delete_tec=<?php echo $row["tec_id"];?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่ !'); " >
                                    <input type="button" name="edit" value="ลบ"  class="btn btn-outline-danger btn-sm edit_data" />
                                  </a>
                                </td>
                                
                            </tr>
                        <?php } ?> 
                      

                    </tbody>
                  </table>
                  
                </div>

            </div>

<!-- ------------------------------- add technical ------------------------------- -->


            <div class="modal fade " id="addtechnicalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">เพิ่มช่าง</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body pt-3">

                  <form class="needs-validation" action="get_DB.php" id="add-customer" novalidate> 
                    
                    <div class="form-group">
                      <label for="inputAddress">ชื่อช่าง</label>
                      <input type="text" class="form-control" name="tec_name" required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อช่าง
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">เบอร์โทรศัพท์</label>
                      <input type="tel" class="form-control" placeholder="062123xxxx or 02414xxxx" pattern="[0-9]{9,10}" name="tec_tel" required>
                      <div class="invalid-feedback">
                        กรุณาใส่เบอร์โทรศัพท์ตัวเลข 10 หลัก
                      </div>
                    </div>

					<label class="" for="">! เลือกความสามารถของช่างได้หนึ่งอย่างเท่านั้น !</label>
                    <div class="form-group">
                
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="tec_skill_hyd">
                        <label class="form-check-label" for="inlineCheckbox1">ช่างเหล็ก</label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="tec_skill_chassis">
                        <label class="form-check-label" for="inlineCheckbox1">ช่างช่วงล่าง</label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="tec_skill_logo">
                        <label class="form-check-label" for="inlineCheckbox1">ช่างไฮดรอลิก</label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="tec_skill_paint">
                        <label class="form-check-label" for="inlineCheckbox1">ช่างสี</label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="tec_skill_logo">
                        <label class="form-check-label" for="inlineCheckbox1">ช่างทำโลโก้</label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="tec_skill_elec">
                        <label class="form-check-label" for="inlineCheckbox1">ช่างไฟ</label>
                      </div>

                    </div>
                    
                    
                    
                  </div>
                  

                
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary px-4" name="submit-technical-btn">บันทึก</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
            

          </div>


<!-- -------------------------------- Edit_tec -------------------------------- -->


            <div class="modal fade modal-ed" id="Modaltecedit" role="dialog"></div>

            <div class="modal fade" id="Modaledit" role="dialog">
                <div class="modal modal-dialog modal-dialog-centered">       
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                                hello
                        </div>
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



    <script> // Edit tec  
            $(document).ready(function(){
                $('.submit_show_work').on('click',function(){
                    var dataURL = $(this).attr('data-href');
                    $('.modal-ed').load(dataURL,function(){
                        $('#Modaltecedit').modal({show:true});
                        });
                    }); 
                });
          </script>


</body>
</html>