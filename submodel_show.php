<?php

//-----------------------------------------------------------
session_start();
include('server.php');
if (!$_SESSION["use_firstname"]) {
  header('location: login.php?err=1');
}

if (isset($_GET['To_show'])) {
    $sub_name = $_GET['To_show'];
    // --------ดึง mod_id & sub_name เพื่อมาโชว
    $sql =mysqli_query($conn, "SELECT sub_id, mod_id FROM submodel WHERE sub_name = '$sub_name'");
    $row = $sql->fetch_assoc();
    $mod_id = $row["mod_id"] ;
    $sub_id = $row["sub_id"] ;
    // --------ดึง opn_seq เพื่อดูว่ามี opn ของ sub_id นั้นหรือไม่
    $sql = mysqli_query($conn, "SELECT opn_id FROM submodel_opn WHERE sub_id = '$sub_id'");
    $row = $sql->fetch_assoc();
    $opn = $row["opn_id"] ;
    if (!$opn) {
        header("Location: subopn_add.php?To_add=$sub_id");  
    }
}
elseif (isset($_GET['To_show_copy'])) {
  $sub_name = $_GET['To_show_copy'];
  // --------ดึง mod_id & sub_name เพื่อมาโชว
  $sql =mysqli_query($conn, "SELECT sub_id, mod_id FROM submodel WHERE sub_name = '$sub_name'");
  $row = $sql->fetch_assoc();
  $mod_id = $row["mod_id"] ;
  $sub_id = $row["sub_id"] ;
  // --------ดึง opn_seq เพื่อดูว่ามี opn ของ sub_id นั้นหรือไม่
  $sql = mysqli_query($conn, "SELECT opn_id FROM submodel_opn WHERE sub_id = '$sub_id'");
  $row = $sql->fetch_assoc();
  $opn = $row["opn_id"] ;
  if (!$opn) {
      header("Location: subopn_copy.php?To_add=$sub_id");  
  }
}
?>

<!DOCTYPE html>  
<html>  
<head>  
    <title><?php echo $mod_id." | ".$sub_name ; ?></title>  
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
              <h3>โมเดลรถ > <?php echo $mod_id." | ".$sub_name ; ?></h3>
              
              <div class="header-main row justify-content-between">
                <div class="col-8">                  
                  <form  method="GET">
                    <input type="hidden" name="sub_id" id="sub_id" value="<?php echo $sub_id ?>">
					<button class="btn btn-primary" type="submit" name="To_edit" onClick="this.form.action='subopn_add.php'; submit()" 
						<?php if($_SESSION["use_role"]=='U'){echo 'hidden';}elseif($_SESSION["use_role"]=='A'){}?>>
                        <i class="far fa-edit"></i> แก้ใขโมเดลย่อย
                    </button>
                    
                  </form>
                </div>
			 	<div class="col-4">
					<a class="float-right btn btn-outline-secondary" href="PDF.php?sub_id=<?php echo $sub_id ?>" target="_blank">
						<i class="far fa-file-pdf"></i>
                        <span> พิมพ์ตารางงาน</span> 
                    </a>
				</div>
              </div>

                <div class="pt-4 row justify-content-md-center">

                <div class="table-responsive col-md-8 ">

                  <table class="table table-hover text-nowrap table-light align-middle" id="meTable" >
                    <thead class="line-under">
                      <tr>
                        <th scope="col" class="text-center" style="width: 15%">ลำดับ</th>
                        <th scope="col" style="width: 65%">ขั้นตอน</th>
                        <th scope="col" class="text-center" style="width: 20%">จำนวนวันที่ทำ</th>
                      </tr>
                    </thead>

                    <tbody class="align-middle">
                    <?php                        
                        $sql = mysqli_query($conn, "SELECT opn_seq, opn_name, opn_duration FROM submodel_opn WHERE sub_id = '$sub_id' order by opn_seq");
                        while ($row = $sql->fetch_assoc()) {?>
                            <tr>
                                <td scope="row" class="text-center"><?php echo $row["opn_seq"]; ?></td>
                                <td><?php echo $row["opn_name"]; ?></td>
                                <td class="text-center"><?php echo $row["opn_duration"]; ?></td>
                            </tr>
                                
                        <?php } ?>
                    </tbody>
                  </table>
                   
                </div>
                 
                    <div class="modal-content col-md-4">
                    <form name="doct"  enctype="multipart/form-data" action="get_DB.php" method="post">
                        <div class="modal-header">
                          <h4 class="modal-title">เอกสาร : <?php echo $mod_id." | ".$sub_name ; ?></h4>
                        </div>

                        <div class="modal-body pt-2">
                          <label for="doc_name">ชื่อเอกสาร</label>
                          <div class="input-group ">
                            <input type="hidden" name="sub_id" value="<?php echo $sub_id ?>" />
                            <input type="text" class="form-control col-md-11" id="doc_name" name="doc_name" required/>
                            
                          </div>
                            <input class="btn" type="file"  id="file_doc" name="file_doc" required/>
                            <input type="submit"  name="submit-submodel_doc"  value="บันทึก" class="btn btn-outline-info btn-sm" />  
                          <div class="modal-footer mt-1">
                            <fieldset class="w-100">
                              <?php
                                $sql = mysqli_query($conn, "SELECT * FROM submodel_doc where sub_id = '$sub_id'");
                                while ($row = $sql->fetch_assoc()){
                              ?>
                                <br>
                                  <td><a href="<?php echo $row['doc_path']?>" target="_blank" ><?php echo $row["doc_name"]; ?></a></td>
                                  <input type="hidden" name="doc_id" value="<?php echo $row["doc_id"] ?>">
                                  <td><a href="get_DB.php?del-submodel_doc=<?php echo $row["doc_id"]; ?>">
                                      <input type="button" name="del-cus-btn" value="ลบ"  class="btn btn-outline-danger btn-sm edit_data" />
                                  </a></td>
                                  
                                </br>
                            <?php } ?>
                            </fieldset>
                            </form>
                          </div>
                    
                      </div>

                    </div>
                    
                </div>

            </div>

<!-- ------------------------------- adduser ------------------------------- -->


            <div class="modal fade" id="adduserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">เพิ่มช่าง</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body pt-3">

                  <form class="needs-validation" action="get_DB.php" id="add-user" novalidate> 
                    
                    <div class="form-group">
                      <label for="inputAddress">ชื่อลูกค้า</label>
                      <input type="text" class="form-control" name="cus_firstname"  required>
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
                      <input type="text" class="form-control" name="cus_tel"  required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อผู้ใช้
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

            <div class="modal fade" id="editcsuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">เพิ่มช่าง</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body pt-3">

                  <form class="needs-validation" action="get_DB.php" id="add-user" novalidate> 
                    
                    <div class="form-group">
                      <label for="inputAddress">ชื่อลูกค้า</label>
                      <input type="text" class="form-control" name="cus_firstname" id="cus_firstname" required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อ
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">ที่อยู่</label>
                      <textarea class="form-control" rows="3" name="cus_add" id="cus_add" required></textarea>
                      <div class="invalid-feedback">
                        กรุณาใส่นามสกุล
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">เบอร์ติดต่อ</label>
                      <input type="text" class="form-control" name="cus_tel" id="cus_tel" required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อผู้ใช้
                      </div>
                    </div>
                    <input type="hidden" name="cus_id" id="cus_id" />
                  </div>
                    
                
                
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary px-4" name="submit-update-customer-btn">อัพเดท</button>
                  </div>
                </form>
                </div>
              </div>
            </div>



    </div>
          
          

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

          












































