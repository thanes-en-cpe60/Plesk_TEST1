<?php
include('server.php');
// ------ จาก submodel_add-------
if (isset($_GET['edit_opn'])) {  
    $opn_id = $_GET['edit_opn'];
    $sub_id = $_GET['sub_id'];
    $sql = mysqli_query($conn, "SELECT* FROM submodel_opn where opn_id = $opn_id ");
    $row = $sql->fetch_assoc();  
}
?>


    <form name="edit_opn"  method="GET" onsubmit="return(validateForm());">
        <input type="hidden" name="sub_id" value="<?php echo $sub_id ?>"/>
        <input type="hidden" name="opn_id" value="<?php echo $opn_id ?>"/>
        <div class="modal-content-edit-subopn">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <div class="form-group">
                    <label for="inputEmail4">ขั้นตอน</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><?php echo  $row['opn_seq']." :" ?></div>
                            </div>
                            <input type="text" name="opn_name" class="form-control" id="opn_name" size="45"autocomplete="on" value="<?php echo  $row['opn_name'] ?> " onchange="myFunction()"/>
                        </div>
                    </div>    
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ระยะเวลา(วัน)</label>
                    <input type="number" name="opn_duration" class="form-control" id="opn_duration" size="2" min="0" max="20" value="<?php echo  $row['opn_duration'] ?>"  onchange="myFunction()"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">เตือนล่วงหน้า(วัน)</label>
                    <input type="number" name="opn_day_notify" class="form-control" id="opn_day_notify" size="2" min="0" max="20" value="<?php echo  $row['opn_day_notify'] ?>" onchange="myFunction()"/>
                </div>
            </div>

            <label>แสดงขั้นตอน</label>
            <div class="form-row align-items-center">
                <div class="col-3 my-1">
                    <div class="mr-sm-2 form-check">
                        <input class="form-check-input" type="radio" name="show_opn" id="show" value="1"  <?php  if($row['show_opn'] == "1"){echo "checked";} ?> onchange="myFunction()"/>
                        <label class="form-check-label">แสดง</label>
                    </div>
                    <div class="mr-sm-2 form-check">
                        <input class="form-check-input" type="radio" name="show_opn" id="cant_show" value="0" <?php  if($row['show_opn'] == "0"){echo "checked";} ?> onchange="myFunction()"/>
                        <label class="form-check-label">ไม่สแดง</label>
                    </div>
                </div>
                <div class="col-9 my-1">
                <div class="">
                    <input class="form-control" type="text" name="show_name_new" id="show_name_new" value="<?php echo  $row['show_name_new'] ?>" onchange="myFunction()"/>
                </div>
                </div>
            </div>
        </div>       

        <div class="modal-footer-edit-subopn">
            <button type="button" class="btn btn-outline-secondary px-4 mx-2" data-dismiss="modal">ย้อนกลับ</button>
            <input  type="submit" class="btn btn-primary px-4" name="submit_opn_1" id="submit_opn_1" value="แก้ใข" disabled/>
        </div>
    </form> 

       

<script>
function myFunction() {
  document.getElementById("submit_opn_1").disabled = false; 
}
function validateForm() {
  var Show = document.forms["edit_opn"]["show_opn"].value;
  var NewName = document.forms["edit_opn"]["show_name_new"].value;
    if (Show == "1" && NewName == "") {
    	alert("กรุณาใส่ชื่อขั้นตอนที่ต้องการแสดง");    
        return false ;  
    }else{
        return true ;
    }
}
</script>