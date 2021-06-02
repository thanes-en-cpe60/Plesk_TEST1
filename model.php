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
<html>  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model</title>
    
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
      <li class="nav-item">
         <a class="nav-link" href="index.php">
            <i class="fas fa-file"></i>
            ตารางงาน
          </a>
        </li>
        <li class="nav-item ">
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
              <h3>โมเดลรถ</h3>
              <div class="header-top row">
                <div class="col-12 mt-3">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="mode-tab"  href="model.php">โมเดลหลัก</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="model-sub-tab"  href="model_sub.php">โมเดลย่อย</a>
                    </li>
                  </ul>           
                </div>
              </div>

              <div class="mid-main">

                <!-- model tab -->
                <div class="tab-content" id="nav-tabContent"> 
                  <div class="tab-pane fade show active" id="model" role="tabpanel" aria-labelledby="model-tab">
                    <div class="header-main row">
                      <div class="col-12">                  
                        <button type="button"  name="btn_addmodel" class="btn btn-primary" data-toggle="modal" data-target="#addmodelModal" <?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?> ><i class="fas fa-file-medical"></i> เพิ่มโมเดลหลัก</button>
                       </div>            
                    </div>
                    <div class="table-responsive ">
                      <table class="table table-hover text-nowrap table-light align-middle" id="meTable" >
                        <thead class="line-under">
                          <tr>
                            <th scope="col">โมเดลหลัก</th>
                            <th scope="col">ชื่อโมเดลหลัก EN</th>
                            <th scope="col">ชื่อโมเดลหลัก TH</th>
                          </tr>
                        </thead>
                        <tbody class="align-middle" id="myTable">
                        <?php
                            $stmp = "";
                           
                            $sql = mysqli_query($conn, "SELECT B.*,(SELECT COUNT(sub_id) FROM submodel A WHERE A.mod_id = B.mod_id )nSub FROM model B ORDER BY mod_id  ");
                            while ($row = $sql->fetch_assoc()) { 
                        ?>
                            <tr>
                              <td data-label="โมเดลหลัก"><?php echo $row["mod_id"];?></td>
                              <td data-label="ชื่อโมเดลหลักEN"><?php echo $row["mod_nameEN"];?></td>
                              <td data-label="ชื่อโมเดลหลักTH"><?php echo $row["mod_nameTH"];?></td>
                              <td>
                                  <a  name="editMod-btn"  href="javascript:void(0);" data-href="model_edit.php?mod_edit=<?php echo $row["mod_id"];?>" class="btn btn-outline-primary btn-sm edit_model">แก้ไข</a>
                                  <a name="del-Mod" href="get_DB.php?del-Mod=<?php echo $row["mod_id"];?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่ !'); " >
                                    <input type="button"  value="ลบ"  class="btn btn-outline-danger btn-sm edit_data" <?php  if($row["nSub"] > 0){echo 'hidden' ;}else{echo '';} ?>  />
                                  </a>
                                </td>    
                            </tr>
                        <?php } ?>
                        </tbody>
                      </table>    
                    </div>
                  </div>
                </div>
              </div>
            </div>
<!-- ------------------------------- add_model ------------------------------- -->


            <div class="modal fade" id="addmodelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">เพิ่มโมเดลหลัก</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body pt-3">

                  <form class="needs-validation" action="get_DB.php" id="add-user" novalidate> 
                    
                    <div class="form-group">
                      <label for="inputAddress">รหัสโมเดลหลัก</label>
                      <input type="text" class="form-control" name="model"  required>
                      <div class="invalid-feedback">
                        กรุณาใส่รหัสโมเดลหลัก
                      </div>
                    </div>

                                      
                    <div class="form-group">
                      <label for="inputAddress">ชื่อโมเดล(EN)</label>
                      <input type="text" class="form-control" name="model_en"  required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อผู้ใช้
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="inputAddress">ชื่อโมเดล(TH)</label>
                      <input class="form-control" rows="3" name="model_th"  required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อโมเดล(TH)
                      </div>
                    </div>
                
                  </div>
                    

                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary px-4" name="submit-addmodel-btn">บันทึก</button>
                  </div>
                </form>
                </div>
              </div>
            </div>


<!-- -------------------------------- edit_model ------------------ -->

          <div class="modal fade" id="ModalModEdit" role="dialog">
                <div class="modal modal-dialog modal-dialog-centered">       
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body-edit">
                        </div>
                    </div>                            
                </div>
            </div>
<!-- ---------------------------------------------------------------- -->      
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
          <script> // Search bar
          
            $(document).ready(function(){
              $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
              });
            });
            </script>

          <script> //Table Jquery 1
            $(document).ready(function() {
            $('#meTable').DataTable({
                paging: true,
                pageLength: 10,
                searching: false,
                lengthChange: false,
                info: false,
                "ordering": false,
                "language": {
                "paginate": {
                "next": "ถัดไป",
                "previous":   "ก่อนหน้า"
                }
            }  
            });
            } );
            </script>

      
          <script>  //Update data
            $(document).ready(function(){  
                
                $(document).on('click', '.edit_data', function(){  
                      var edit_cus_id = $(this).attr("id");  
                      $.ajax({  
                          url:"get_DB.php",  
                          method:"POST",  
                          data:{edit_cus_id:edit_cus_id},  
                          dataType:"json",  
                          success:function(data){  
                            $('#cus_firstname').val(data.cus_firstname);  
                            $('#cus_add').val(data.cus_add);  
                            $('#cus_tel').val(data.cus_tel);
                            $('#cus_id').val(data.cus_id);
                            $('#editcsuModal').modal('show');  
                          }  
                      });  
                });  
                
            });  
            </script>

          <script> // Show subopn   
            $(document).ready(function(){
              console.log("Debug 01 ");
                $('.edit_model').on('click',function(){
                    var dataURL = $(this).attr('data-href');
                    $('.modal-body-edit').load(dataURL,function(){
                        $('#ModalModEdit').modal({show:true});
                        console.log("Debug 02 ");
                        });
                    }); 
                });
          </script>

</body>
</html>