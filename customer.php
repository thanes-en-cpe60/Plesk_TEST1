<?php
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
<html>  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <script src="js/slim.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/fa.js"></script>
    <script src="js/script.js"></script> 
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
        <li class="nav-item ">
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

        <li class="nav-item ">
            <a class="nav-link" href="model.php" >
              <i class="fas fa-car"></i>
              <span>โมเดลรถ</span>
            </a>
        </li>

        <br>

        <li class="nav-item active">
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
              <span>ผลสรุป</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="conclusion_tec.php" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> >
              <i class="fas fa-fw fa-cog"></i>
              <span>ผลการทำงาน</span>
            </a>
        </li>             
  </ul>

</div>


<!-- -------------------------------- Main --------------------------------- -->

            <div class="layout">
              <h3>ข้อมูลลูกค้า</h3>
              <div class="header-main row">
                <div class="col col-md-8 col-sm-12">                  
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adduserModal"><i class="fas fa-file-medical"></i> เพิ่มลูกค้า</button>
                </div>
                <div class="col col-md-4 col-sm-12 pt-sm-4">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" id="myInput" onkeyup="myFunction()">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-fw fa-search"></i> Search </button>
                    </div>
                  </div>
                </div>              
              </div>

                <div class="table-responsive pb-5">

                  <table class="table table-hover text-nowrap table-light align-middle" id="meTable" >
                    <thead class="line-under">
                      <tr>
                        <th scope="col">ชื่อลูกค้า</th>
                        <th scope="col">ที่อยู่</th>
                        <th scope="col">เบอร์โทรศัพท์</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>

                    <tbody class="align-middle" id="myTable">
                      <?php
                            $conn = new mysqli('27.254.172.62:3306', 'PiroonAssembly','JoB0847807291', 'sql_assembly');
                            $sql = mysqli_query($conn, "SELECT * FROM customer");
                            while ($row = $sql->fetch_assoc()){
                        ?>
                            <tr>
                                <td data-label="ชื่อลูกค้า"><?php echo $row["cus_name"];?></td>
                                <td data-label="ที่อยู่"><?php echo $row["cus_add"];?></td>
                                <td data-label="เบอร์โทรศัพท์"><?php echo $row["cus_tel"];?></td>
                                <td data-label="">
								                  <a href="javascript:void(0);" data-href="customer_edit.php?cus_edit=<?php echo $row["cus_id"];?>" class="btn btn-outline-info btn-sm submit_show_work">แก้ไข</a>
                                  <a href="get_DB.php?delete_cus=<?php echo $row["cus_id"];?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่ !');" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> >
                                    <input type="button" name="del-cus-btn" value="ลบ"  class="btn btn-outline-danger btn-sm edit_data" />
                                  </a>
                                </td>                                
                            </tr>
                        <?php } ?> 
                        
                    </tbody>
                  </table>
                  
                </div>

            </div>

<!-- ------------------------------- Add-cus ------------------------------- -->


            <div class="modal fade" id="adduserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลลูกค้า</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body pt-3">

                  <form class="needs-validation" action="get_DB.php" id="add-user" novalidate> 
                    
                    <div class="form-group">
                      <label for="inputAddress">ชื่อลูกค้า</label>
                      <input type="text" class="form-control" name="cus_name"  required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อ
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">ที่อยู่</label>
                      <textarea class="form-control" rows="3" name="cus_add"  required></textarea>
                      <div class="invalid-feedback">
                        กรุณาใส่นามสกุล
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">เบอร์ติดต่อ</label>
                      <input type="text" class="form-control" placeholder="062123xxxx or 02414xxxx" pattern="[0-9]{9,10}" name="cus_tel"  required>
                      <div class="invalid-feedback">
                        กรุณาใส่เบอร์ติดต่อไห้ถูกต้อง
                      </div>
                    </div>
                
                  </div>
                    

                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary px-4" name="submit-customer-btn">บันทึก</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
			
			
			
			<!-- -------------------------------- Edit_cus -------------------------------- -->


            <div class="modal fade modal-ed" id="Modalcusedit" role="dialog">
            
            </div>


<!-- ----------------------------------------------------------------------- -->



           
          </div>
          
          




          
          <script> // validation From
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

			
		<script> // Edit cus 
					$(document).ready(function(){
						$('.submit_show_work').on('click',function(){
							var dataURL = $(this).attr('data-href');
							$('.modal-ed').load(dataURL,function(){
								$('#Modalcusedit').modal({show:true});
								});
							}); 
						});
			</script>