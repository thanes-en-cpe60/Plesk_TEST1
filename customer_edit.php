<?php
    session_start();
	include('server.php');
    if (!$_SESSION["use_firstname"]) {
      header('location: login.php?err=1');
    }
 
    if (isset($_GET["cus_edit"])) {
        $cus_id = $_GET["cus_edit"];
    }
     
?>

<?php
    $sql_que = mysqli_query($conn, " SELECT * FROM customer WHERE cus_id = '$cus_id'");
    $row = $sql_que->fetch_assoc();    
?>

<!DOCTYPE html>
<html>
<body>
<div class="modal-dialog modal-dialog-centered">
	 
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">แก้ใขข้อมมูล</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
					<form class="needs-validation" action="get_DB.php" id="add-user" novalidate> 
                  <div class="modal-body pt-3">

                  
                    
                    <div class="form-group">
                      <label for="inputAddress">ชื่อลูกค้า</label>
                      <input type="text" class="form-control" name="cus_name" id="cus_name"  value="<?php echo $row['cus_name']?>" required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อ
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">ที่อยู่</label>
                      <textarea class="form-control" rows="3" name="cus_add" id="cus_add" required><?php echo $row['cus_add']?></textarea>
                      <div class="invalid-feedback">
                        กรุณาใส่ที่อยู่
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">เบอร์ติดต่อ</label>
                      <input type="text" class="form-control" placeholder="062123xxxx or 02414xxxx" pattern="[0-9]{9,10}" name="cus_tel" id="cus_tel"  value="<?php echo $row['cus_tel']?>" required>
                      <div class="invalid-feedback">
                        กรุณาใส่เบอร์ติดต่อไห้ถูกต้อง
                      </div>
                    </div>
                    <input type="hidden" name="cus_id" id="cus_id" value="<?php echo $row['cus_id']?>" />
                  </div>
                    
                
                
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary px-4" name="submit-update-customer-btn">อัพเดท</button>
                  </div>
                		</form>
                </div>

              </div>
	
</body>
</html>
