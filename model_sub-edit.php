<?php
    session_start();
	include('server.php');
    if (!$_SESSION["use_firstname"]) {
      header('location: login.php?err=1');
    }
    if (isset($_GET["sub_edit"])) {
        $sub_id = $_GET["sub_edit"];
        $sql = mysqli_query($conn, "SELECT  *, (select mod_nameEN FROM model WHERE mod_id = A.mod_id ) modName FROM submodel A WHERE sub_id = '$sub_id' ");
        $show = $sql->fetch_assoc();
    }
    elseif (isset($_GET["submit-editSub-btn"])) {
        $sub_id = $_GET["sub_id"];
        $sub_name = $_GET["sub_name"];
        // echo $sub_name ;
        $sql = "UPDATE `submodel` SET `sub_name` = '$sub_name' WHERE `submodel`.`sub_id` = '$sub_id'";
            if(mysqli_query($conn, $sql))
            {
                $conn->commit();
                echo "<script type='text/javascript'>";
                echo "window.location = 'model_sub.php'; ";
                echo "alert('แก้ใขข้อมูลโมเดลย่อยสำเหร็จ !');";
                echo "</script>";
            }
            else{$conn->rollback();
                echo "<script type='text/javascript'>";
                echo "window.location = 'model_sub.php'; ";
                echo "alert('!ไม่สามารถใช้ชื่อนี้ได้ เนื่องจากมีโมเดลย่อยชื่อนี้อยู่แล้ว !');";
                echo "</script>";
            }
    }
?>

<!DOCTYPE html>
<html>
<body>
        
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">แก้ใขชื่อโมเดลย่อย</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                    <div class="modal-body pt-3">
                    <tbody class="align-middle" id="myTable">
                        <form class="needs-validation" action="model_sub-edit.php" id="edit-sub" novalidate> 
                                <div class="form-group">
                                    
                                    <label for="inputModId">ชื่อโมเดลย่อย(TH)</label>
                                    <input type="hidden"  name="sub_id"  id="sub_id" value="<?php echo $sub_id;?>"  >
                                    <input type="text" class="form-control"  name="sub_name"  id="sub_name" value="<?php echo $show['sub_name'];?>"  onChange="Vaildateform()" required>          
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal" >ปิด</button>
                                    <button type="submit" class="btn btn-primary px-4" name="submit-editSub-btn" id="submit-editSub-btn" disabled >บันทึก</button>
                                </div>
                        </form>

                    </div>
                </div>
            
</body>
</html>
<script>
 function  Vaildateform() {
    document.getElementById("submit-editSub-btn").disabled=false;     
 }
</script>