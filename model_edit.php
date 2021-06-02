<?php
    session_start();
	include('server.php');
    if (!$_SESSION["use_firstname"]) {
      header('location: login.php?err=1');
    }
    if (isset($_GET["mod_edit"])) {
        $mod_id = $_GET["mod_edit"];
        $sql = mysqli_query($conn, "SELECT B.*,(SELECT COUNT(sub_id) FROM submodel A WHERE A.mod_id = B.mod_id )nSub FROM model B ORDER BY mod_id  ");
        $row = $sql->fetch_assoc();
    }
    elseif (isset($_GET["submit-editModel-btn"])) {
        $mod_id = $_GET["mod_id"];
        $mod_th = $_GET["model_th"];
        $mod_en = $_GET["model_en"];
        $sql = "UPDATE `model` SET `mod_nameEN` = '$mod_en', `mod_nameTH` ='$mod_th' WHERE `model`.`mod_id` = '$mod_id'";
            if(mysqli_query($conn, $sql))
            {
                $conn->commit();
                echo "<script type='text/javascript'>";
                echo "window.location = 'model.php'; ";
                echo "alert('แก้ใขข้อมูลโมเดลหลักสำเหร็จ !');";
                echo "</script>";
            }
            else{$conn->rollback();
                echo "<script type='text/javascript'>";
                echo "window.location = 'model.php'; ";
                echo "alert('!ไม่สามารถใช้ชื่อนี้ได้ เนื่องจากมีโมเดลหลักชื่อนี้อยู่แล้ว !');";
                echo "</script>";
            }
    }
?>

<!DOCTYPE html>
<html>
<body>
            
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">แก้ใขโมเดลหลัก</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                    <div class="modal-body pt-3">
                    <tbody class="align-middle" id="myTable">
                        <form class="needs-validation" action="model_edit.php" id="add-user" novalidate> 
                                <div class="form-group">
                                    <label for="inputModId">รหัสโมเดลหลัก</label>
                                    <input type="hidden"  name="mod_id" value="<?php echo $row["mod_id"];?>"  >
                                    <input type="text" class="form-control"  id="inputModId" value="<?php echo $row["mod_id"];?>"  disabled required>
                                    <div class="invalid-feedback">
                                        กรุณาใส่รหัสโมเดลหลัก
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputNameEN">ชื่อโมเดล(EN)</label>
                                    <input type="text" class="form-control" name="model_en" id="inputNameEN" value="<?php echo $row["mod_nameEN"];?>" onChange="Vaildateform()" required>
                                        <small id="inputNameEN" class="form-text text-muted">
                                            ชื่อโมเดลหลัก ภาษาอังกฤษ
                                        </small>
                                    <div class="invalid-feedback">
                                        กรุณาใส่ชื่อโมเดล
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputNameTH">ชื่อโมเดล(TH)</label>
                                    <input class="form-control" rows="3" name="model_th" id="inputNameTH" value="<?php echo $row["mod_nameTH"];?>" onChange="Vaildateform()" required>
                                        <small id="inputNameTH" class="form-text text-muted">
                                            ชื่อโมเดลหลัก ภาษาไทย
                                        </small>
                                    <div class="invalid-feedback">
                                        กรุณาใส่ชื่อโมเดล(TH)
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal" >ปิด</button>
                                    <button type="submit" class="btn btn-primary px-4" name="submit-editModel-btn" id="submit-editModel-btn" disabled >บันทึก</button>
                                </div>
                        </form>

                    </div>
                </div>
            
</body>
</html>
<script>
 function  Vaildateform() {
    document.getElementById("submit-editModel-btn").disabled=false;     
 }
</script>