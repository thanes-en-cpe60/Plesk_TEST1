<?php
    session_start();
	include('server.php');
    if (!$_SESSION["use_firstname"]) {
      header('location: login.php?err=1');
    }
 
    if (isset($_GET["tec_edit"])) {
        $tec_id = $_GET["tec_edit"];
    }
     
?>

<?php
    $sql_que = mysqli_query($conn, " SELECT * FROM technical WHERE tec_id = '$tec_id'");
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
                      <label for="inputAddress">ชื่อช่าง</label>
                      <input type="text" class="form-control" name="tec_name" id="tec_name" value="<?php echo $row['tec_name']?>" required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อช่าง
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">เบอร์โทรศัพท์</label>
                      <input type="tel" class="form-control"  name="tec_tel" id="tec_tel" placeholder="062123xxxx or 02414xxxx" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?php echo $row['tec_tel']?>" required>
                      <div class="invalid-feedback">
                        กรุณาใส่เบอร์โทรศัพท์
                      </div>
                    </div>
					  <label class="" for="">! เลือกความสามารถของช่างได้หนึ่งอย่างเท่านั้น !</label>
                    <div class="form-group">
						<div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="tec_skill_weld" value="1" <?php if($row['tec_skill_weld'] == 1) echo 'checked'; ?> /> 
                        <label class="form-check-label" for="inlineCheckbox1">ช่างเหล็ก</label>
                      </div>
						
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="tec_skill_chassis" value="1" <?php if($row['tec_skill_chassis'] == 1) echo 'checked'; ?> /> 
                        <label class="form-check-label" for="inlineCheckbox1">ช่างช่วงล่าง</label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox"  name="tec_skill_hyd"  value="1" <?php if($row['tec_skill_hyd'] == 1) echo 'checked'; ?>>
                        <label class="form-check-label" for="inlineCheckbox1">ช่างไฮดรอลิก</label>
                      </div>
						
                      <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="tec_skill_paint" value="1" <?php if($row['tec_skill_paint'] == 1) echo 'checked'; ?> /> 
                        <label class="form-check-label" for="inlineCheckbox1">ช่างสี</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox"  name="tec_skill_logo" value="1" <?php if($row['tec_skill_logo'] == 1) echo 'checked'; ?> />
                        <label class="form-check-label" for="inlineCheckbox1">ช่างทำโลโก้</label>
                      </div>
						
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="tec_skill_elec" value="1" <?php if($row['tec_skill_elec'] == 1) echo 'checked'; ?> /> 
                        <label class="form-check-label" for="inlineCheckbox1">ช่างไฟ</label>
                      </div>
						
                      
                    </div>
                    
                    <input type="hidden" name="tec_id" id="tec_id" value="<?php echo $row['tec_id']?>" />

                    
                   
                  </div>
                    
                
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary px-4" name="submit-update-technical-btn">อัพเดท</button>
                    </div>
                    </form>
                </div>
            </div>
	
</body>
</html>
