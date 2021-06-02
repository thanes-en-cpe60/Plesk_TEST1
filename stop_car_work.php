<?php
    session_start();
	include('server.php');
    if (!$_SESSION["use_firstname"]) {
      header('location: login.php?err=1');
    }
    elseif (isset($_GET["stop_date_car"])) {
        $dateNow = date_create(date("Y-m-d"));
        $c_w_id = $_GET["stop_date_car"];
        $sql = mysqli_query($conn, "SELECT
        (SELECT opn_seq FROM job_work WHERE wor_id = C.job_work_id) opn_seq,  
        (SELECT opn_name FROM job_work WHERE wor_id = C.job_work_id) opn_name,
        C.car_id,
        (SELECT job_id FROM car WHERE car_id = C.car_id ) job_id
        FROM car_work C 
        WHERE  C.wor_id='$c_w_id'");
        $row = $sql->fetch_assoc();
        
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
                       
<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">หยุดการทำงาน</h4>
</div>
    <div class="modal-body pt-3">
        <tbody class="align-middle" id="myTable">
        <form method="POST" action="setwork.php" id="stop_car_work" >
             ขั้นตอนที่ :<?php echo " ".$row['opn_seq'].". ".$row['opn_name'];?><br>
             หยุดงานวันที่ :<?php echo date_format($dateNow,"d-M-Y"); ?>
            <input type="hidden" name="car_id" id="car_id" value="<?php echo $row['car_id']; ?>">
            <input type="hidden" name="job_id" id="job_id" value="<?php echo $row['job_id']; ?>">  
            <input type="hidden" name="car_work_id" id="car_work_id" value="<?php echo $c_w_id; ?>">
                    
            <div class="form-group">
                <label for="inputAddress">รายละเอียด</label>
                <textarea name="break_remark" class="form-control" name="#" rows="3" ></textarea>
            </div>
                    
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal" >ปิด</button>
                <input type="submit" name="stop_car_work" class="btn btn-primary" value="ยืนยัน"/>
            </div>
        </form>
    </div>
</body>
</html>