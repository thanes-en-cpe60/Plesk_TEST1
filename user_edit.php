<?php
    session_start();
    if (!$_SESSION["use_firstname"]) {
      header('location: login.php?err=1');
    }
    include('server.php');
    if (isset($_GET["user_edit"])) {
        $user_id = $_GET["user_edit"];
        $sql = "SELECT * FROM user WHERE user_id = '".$user_id."' ";
        $query = mysqli_query($conn,$sql);
        $result=mysqli_fetch_array($query,MYSQLI_ASSOC);  
    }     
?>

<?php
    $sql_que = mysqli_query($conn, " SELECT * FROM user WHERE user_id = '$user_id'");
    $row = $sql_que->fetch_assoc();   
?>


                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">แก้ไขบุคลากร</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="needs-validation" action="get_DB.php" id="edit-user" name="edit-user" method="post" onsubmit="return(validateForm());" novalidate>
                  <div class="modal-body pt-3">
                    <div class="form-group">
                      <h5>USER ID : <?php echo $row['user_id']?></h5>
                      <label for="inputAddress">ชื่อ</label>
                      <input type="text" class="form-control" name="use_firstname" value="<?php echo $row['use_firstname']?>" required>
                      <div class="invalid-feedback">
                        กรุณาใส่ชื่อ
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <label for="inputAddress">นามสกุล</label>
                      <input type="text" class="form-control" name="use_lastname" value="<?php echo $row['use_lastname']?>" required>
                      <div class="invalid-feedback">
                        กรุณาใส่นามสกุล
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputAddress">รหัสผ่านใหม่</label>
                      <input type="password" class="form-control" name="new_pass" pattern="[A-Za-z0-9]{8,}" required>
                      <label for="confirm_pass">ยืนยันรหัสผ่านใหม่</label>
                      <input type="password" class="form-control" name="confirm_pass" pattern="[A-Za-z0-9]{8,}" required>
                      <div class="invalid-feedback">
                       กรุณาใส่รหัสผ่าน (รูปแบบ a-z,A-Z,0-9 มากกว่า 8 ตัว)
                      </div>
                    </div>
                    

                    <div class="form-group">
                      <label for="inputAddress">สิทธิ์</label>
                        <select class="custom-select" name="use_role" required>
                          <option value="A" <?php if($row['use_role']=="A") echo 'selected="selected"'; ?> >Admin</option>
                          <option value="U" <?php if($row['use_role']=="U") echo 'selected="selected"'; ?> >User</option>
                         
                        </select>
                      <div class="invalid-feedback">
                        กรุณาเลือกสิทธิ์
                      </div>
                    </div>
                    
                  </div>
                  

                
                  <div class="modal-footer">
                  <input type="hidden"  name="user_id" value="<?php echo $row['user_id']?>" >
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">ปิด</button>
                    <input type="submit" class="btn btn-primary px-4" name="submit-user-edit" value="บันทึก" >
                  </div>
                </form>
                <script>
                        function validateForm() {
                          var newP = document.forms["edit-user"]["new_pass"].value;
                          var confirm = document.forms["edit-user"]["confirm_pass"].value;
                              
                              if (newP != confirm ) {
                                  alert("ยืนยันรหัสผ่านไม่ถูกต้อง");
                                  return false ;
                              }
                              else{
                                  return true ;
                              }
                      
                        }
                </script>