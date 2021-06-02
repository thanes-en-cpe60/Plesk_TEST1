<?php
    session_start();
    if (!$_SESSION["use_firstname"]) {
      header('location: login.php?err=1');
    }
    include('server.php');
    $user = "admin";
    if (isset($_GET["add_remark"])) {
        $car_id = $_GET['add_remark'];
        $car_work_id = $_GET['car_work_id'];
    }
    $sql_que = mysqli_query($conn, " SELECT A.car_id,
    B.opn_seq,
    B.opn_name,
    A.work_date_start,
    A.work_date_deadline,
    C.job_id,
    (SELECT tec_name FROM technical WHERE tec_id = C.tec_id_weld ) tec_weld,
    (SELECT tec_name FROM technical WHERE tec_id = C.tec_id_paint) tec_paint, 
    (SELECT tec_name FROM technical WHERE tec_id = C.tec_id_chassis) tec_chassis,
    (SELECT tec_name FROM technical WHERE tec_id = C.tec_id_elec) tec_elec
    FROM car_work A, job_work  B, job C
    WHERE B.wor_id = A.job_work_id AND B.job_id = C.job_id AND A.wor_id = '$car_work_id'");
    $row = $sql_que->fetch_assoc();    
?>

<div class="modal-content-edit-subopn">
    <div class="align-items-center">
        <form id="work_done" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-12 pb-3 border-bottom">
                    <h4>ขั้นตอนที่ <?php echo $row['opn_seq']; ?> : <?php echo $row['opn_name']; ?></h4>
                </div>
                <div class="form-group col-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">วันที่เริ่มทำ</label>
                        <div class="col-sm-6">
                            <input type="text" readonly class="form-control-plaintext" value="<?php
                    $Date = date_create($row['work_date_start']); 
                    echo date_format($Date,"d-M-Y"); ?>">
                        </div>
                        <label class="col-sm-4 col-form-label">วันกำหนดส่ง</label>
                        <div class="col-sm-6">
                            <input type="text" readonly class="form-control-plaintext" value="<?php 
                    $Date = date_create($row['work_date_deadline']); 
                    echo date_format($Date,"d-M-Y"); ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                    <label class="col-sm-4 col-form-label">ช่างเหล็ก</label>
                    <div class="col-sm-6">
                    <input type="text" readonly class="form-control-plaintext" value="<?php 
                    echo $row['tec_weld'];
                    ?>">
                    </div>
                    <label class="col-sm-4 col-form-label">ช่างช่วงล่าง</label>
                    <div class="col-sm-6">
                    <input type="text" readonly class="form-control-plaintext" value="<?php 
                    echo $row['tec_chassis'];
                    ?>">
                    </div>
                    <label class="col-sm-4 col-form-label">ช่างไฟ</label>
                    <div class="col-sm-6">
                    <input type="text" readonly class="form-control-plaintext" value="<?php
                    echo $row['tec_elec'];
                    ?>">
                    </div>
                    <label class="col-sm-4 col-form-label">ช่างสี</label>
                    <div class="col-sm-6">
                    <input type="text" readonly class="form-control-plaintext" value="<?php 
                    echo $row['tec_paint'];
                    ?>">
                    </div>

                    </div>
                </div>


                <div class="form-group col-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">ผู้บันทึกข้อมูล</label>
                        <div class="col-sm-6">
                            <input type="text" readonly class="form-control-plaintext" value="<?php echo $_SESSION["user_id"] ;?>">
                        </div>
                        <label class="col-sm-4 col-form-label">วันที่บันทึก</label>
                        <div class="col-sm-6">
                            <input type="text" readonly class="form-control-plaintext" value="<?php
                    $name = date_create(date("Y-m-d"));
                    echo date_format($name,"d-M-Y"); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>หมายเหตุ</label>
                        <input type="hidden" name="job_id" value="<?php echo $row['job_id'] ?>" />
                        <input type="hidden" name="car_id" value="<?php echo $car_id?>" />
                        <input type="hidden" name="car_work_id" value="<?php echo $car_work_id ?>" />
                        <textarea class="form-control" name="work_remark" id="work_remark" rows="4"></textarea>
                    </div>
                    <div class="from-group-row">
                        <div class="custom-file">
                        <input type="file"  id="file_pic" name="file_pic" onchange="checkChange()" required>
                        </div>
                    </div>
                    <div class="form-group-row pd-2">
                        <input type="submit" class="btn btn-primary px-4 mt-3 float-right" name="submit_work_done"
                            id="submit_work_done" value="บันทึก" onClick="this.form.action='setwork.php'; submit()"
                            disabled />
                        <button type="button" class="btn btn-outline-secondary px-4 mr-2 mt-3 float-right"
                            data-dismiss="modal">ย้อนกลับ</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>





<script>
    function checkChange() {
        document.getElementById("submit_work_done").disabled = false;
    }
</script>