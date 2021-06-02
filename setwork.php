<?php
session_start();
$user_id = $_SESSION["user_id"];
include('server.php');
// --------------------------------------------------------------------------- Set time (start/deadline:date) operation all --------------------------------------------------------------------------------
 if (isset($_GET["set_date_car"])) {
     $job_id = $_GET["job_id"]; 
     $car_id = $_GET["car_id"];
     
     $sql = mysqli_query($conn, "SELECT car.car_id, job_work.wor_id, job_work.opn_duration FROM car RIGHT JOIN job_work on car.job_id = job_work.job_id WHERE car_id ='$car_id' ORDER BY job_work.opn_seq");
     $dateStart = date_create(date("Y-m-d"));//วันปัจจุบัน
     while ($row = $sql->fetch_assoc()){
            $car_id = $row["car_id"];
            $job_work_id = $row["wor_id"];
            
            $Start = date_format($dateStart, 'Y-m-d'); //------------------------------------วันเริ่มงาน
            //---------------------------------คำนวนวัน--------------------------------------- 
            $day = $row["opn_duration"] - 1;
            $format = $day."day";
            $deadLine = date_add($dateStart, date_interval_create_from_date_string($format));
            $End = date_format($deadLine, 'Y-m-d');//----------------------------------------วันจบงาน
            //---------------------------------update วัน--------------------------------------- 
            $sql_upd = "UPDATE `car_work` SET `work_date_start` = '$Start' ,`work_date_deadline` = '$End' WHERE `car_id` = '$car_id' AND `job_work_id` = '$job_work_id' ";
            if (mysqli_query($conn, $sql_upd)) {
                //-----------------------------------------cal วันเริ่มขั้นตอนถัดไป 
                if ($deadLine) {
                    $dateStart = date_add($deadLine, date_interval_create_from_date_string('1 day'));
                    print_r($dateStart);
                } else {
                    echo "Error: Canot calcolate Date of operation";
                } 
            } else {
               echo "Error: Can't update date deadline in car work";
            }     
        }
    //------------------------------------update status car to I (in process)-------
    $sql_upd = "UPDATE `car` SET `car_status` = 'I' ,car_work_id = (SELECT A.wor_id FROM car_work A WHERE A.job_work_id = (SELECT B.wor_id FROM job_work B WHERE B.job_id = '$job_id' AND B.opn_seq = 1 ) AND A.car_id ='$car_id') WHERE `car_id` = '$car_id'";
    if (mysqli_query($conn, $sql_upd)) {
        // echo "debug err";
        header("Location: showwork_car.php?To_show_car=$job_id"); 
    }else{
         echo "Error: Can't update state this car ".$car_id ;
    }
 }
//  ----------------------------------------------------------------------------------------------------stop operation  --------------------------------------------------------------------------------- 
 elseif (isset($_POST["stop_car_work"])) {
    $car_work_id = $_POST["car_work_id"];
    $car_id = $_POST["car_id"];
    $job_id = $_POST["job_id"];
    $break_remark = $_POST["break_remark"];
    echo $car_work_id.'/'.$car_id;
    
    $Stop = date("Y-m-d");
    $user = $_SESSION["user_id"];
    $sql ="INSERT INTO `car_break`(`car_work_id`, `user_id`, `clk_break`, `break_remark`) VALUES ('$car_work_id','$user','$Stop','$break_remark')";
    if (mysqli_query($conn, $sql)) {
    // ------------------------------------update status car to S (stop)--------------
    
        $sql_upd = "UPDATE `car` SET `car_status` = 'S'  WHERE `car_id` = '$car_id'";
        if (mysqli_query($conn, $sql_upd)) {
            echo "<script type='text/javascript'>";
            echo "window.location = 'showwork_car.php?To_show_car=$job_id'; ";
            echo "alert('หยุดงานรถคันที่ : $car_id สำเหร็จ');";
            echo "</script>";
            
        }else{
            echo "<script type='text/javascript'>";
            echo "window.location = 'showwork_car.php?To_show_car=$job_id'; ";
            echo "alert('!Error : ไม่สามารถอัพเดท state ของรถคันนี้ได้!');";
            echo "</script>";
        } 
    }else{
        echo "<script type='text/javascript'>";
        echo "window.location = 'showwork_car.php?To_show_car=$job_id'; ";
        echo "alert('!Error : มีปัญหาในการบัททึกการหยุดงานในระบบ/err on database car_break !');";
        echo "</script>";
        //  echo "Error: Can't update state this car to stop".$car_work_id ;
    };

}
//  ----------------------------------------------------------------------------------------------------continue operation  --------------------------------------------------------------------------------- 
elseif (isset($_GET["conit_date_car"])) {
    $car_work_id = $_GET["wor_id"];
    $car_id = $_GET["car_id"];
    $job_id = $_GET["job_id"];
    $Continue = date("Y-m-d");

    $sql ="UPDATE `car_break` SET `clk_cont` = '$Continue' WHERE `car_work_id` = '$car_work_id'";
    if (mysqli_query($conn, $sql)) {
        $sql_que = mysqli_query($conn, " SELECT clk_break, clk_cont FROM car_break WHERE car_work_id = '$car_work_id'");
        $row = $sql_que->fetch_assoc();
        $date1=date_create($row["clk_break"]);
        $date2=date_create($row["clk_cont"]);
        $diff=date_diff($date1,$date2);
        $Cal = $diff->format("%a") + 1;
        // ------------------------------------update new date_start & deadline after click continue operation------------
        $sql_upd= "UPDATE `car_work` SET`work_date_start`= DATE_ADD(`work_date_start`, INTERVAL $Cal DAY),`work_date_deadline`= DATE_ADD(`work_date_deadline`, INTERVAL $Cal DAY) WHERE car_id = '$car_id' AND work_date_done = ''";
        if (mysqli_query($conn, $sql_upd)) {
                // ------------------------------------update status car to I (in process)--------------
                $sql_upd = "UPDATE `car` SET `car_status` = 'I'  WHERE `car_id` = '$car_id'";
                if (mysqli_query($conn, $sql_upd)) {
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'showwork_car.php?To_show_car=$job_id'; ";
                    echo "alert('ยืนยันการกลับมาทำงานรถคันที่ : $car_id สำเหร็จ');";
                    echo "</script>";
                }else{
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'showwork_car.php?To_show_car=$job_id'; ";
                    echo "alert('!Error : ไม่สามารถอัพเดท state ของรถคันนี้ได้!');";
                    echo "</script>";
                }
        }else{
            echo "<script type='text/javascript'>";
            echo "window.location = 'showwork_car.php?To_show_car=$job_id'; ";
            echo "alert('!Error : มีปัญหาในการ reset วันส่งงานในระบบ/err on database car_work !');";
            echo "</script>";
        }

    }else{
        echo "<script type='text/javascript'>";
         echo "window.location = 'showwork_car.php?To_show_car=$job_id'; ";
         echo "alert('!Error : มีปัญหาในการบัททึกการหยุดงานในระบบ/err on database car_break !');";
         echo "</script>";
    };
//  ----------------------------------------------------------------------------------------------------submit operation  done --------------------------------------------------------------------------------- 
}
elseif (isset($_POST["submit_work_done"])) {
    $job_id = $_POST['job_id'];
    $car_id = $_POST['car_id'];
    $car_work_id = $_POST['car_work_id'];
    $work_remark = $_POST['work_remark'];
    $date = date('Y-m-d H.i.s');
    $sql_check = mysqli_query($conn, "SELECT work_date_start,work_date_deadline FROM car_work  WHERE car_id = '$car_id' AND wor_id = ' $car_work_id' ");
    $data = $sql_check->fetch_assoc();

    $date_start = date_create($data['work_date_start']);
    $date_done = date_create(date("Y-m-d"));
    $diff=date_diff($date_start, $date_done);
    $var = $diff->format("%R%a");
    echo"01";
        if ($var < 0) {
            echo"02";
            echo "<script type='text/javascript'>";
            echo "window.location = 'showwork_opn.php?To_show_opn=$car_id&job_id=$job_id'; ";
            echo "alert('!สามารถส่งงานได้ หลังวันเริ่มงานของขั้นตอนนี้เท่านั่น!');";
            echo "</script>";
        } else {
            echo"03";
            //-------------------------- uplode file----------------------------//
            $FileName = $_FILES['file_pic']['name'];
            $FileTmpName = $_FILES['file_pic']['tmp_name'];
            $FileSize = $_FILES['file_pic']['size'];
            $FileError = $_FILES['file_pic']['error'];
            $FileType = $_FILES['file_pic']['type'];
            
            $FileExt = explode('.', $FileName); //สกุลไฟล
            $FileActuaExt = strtolower(end($FileExt)); //
            $allowed = array('jpg', 'jpeg', 'png');
                $FileNameNew = $date.".".$FileActuaExt;
                $path = $job_id."/" ;
                $fileDestina = $path.$FileNameNew ;
                $doc_path = $job_id."/".$FileNameNew ;
            if(in_array($FileActuaExt, $allowed)){
                if($FileError === 0){
                    if($FileSize  < 10000000){
                    if(!file_exists($job_id)) {
                        echo $job_id ;
                        //------ถ้าไม่มีFolder ให้ create New folder  
                        mkdir($job_id);
                        if (is_dir($job_id)){
                            //-------------------------- uplode file----------------------------//
                            $moved = move_uploaded_file($FileTmpName, $fileDestina );
                            if ($moved) {
                                $sql_upd = "UPDATE `car_work` SET `work_date_done` = '$date' ,`work_pic_path` = '$doc_path',`work_remark` = '$work_remark',`user_id` = '$user_id'   WHERE car_id = '$car_id' AND wor_id = ' $car_work_id' ";
                                if (mysqli_query($conn, $sql_upd)) {
                                    echo "01";
                                    header("Location: showwork_opn.php?To_show_opn=$car_id&job_id=$job_id");
                                }else{
                                    echo "<script type='text/javascript'>";
                                    echo "window.location = 'showwork_opn.php?To_show_opn=$car_id&job_id=$job_id'; ";
                                    echo "alert('!Error : เกิดข้อผิดพลาดของระบบในการส่งงาน <กรุณาแจ้งเจ้าหน้าที่>!');";
                                    echo "</script>";
                                }
                            }else {
                                echo "<script type='text/javascript'>";
                                echo "window.location = 'showwork_opn.php?To_show_opn=$car_id&job_id=$job_id'; ";
                                echo "alert('!Error : ย้ายไฟลไป New Folder ไม่สำเหร็จ!');";
                                echo "</script>";
                                // echo "ย้ายไฟลไป New Folder ไม่สำเหร็จ" ;
                            }
                        }else {
                        echo "สร้างไฟลไม่สำเหร็จ";
                        }
                    }else{
                        //------ถ้ามี Folder ไห้เช็คว่าไฟลเป็น Directory หรือไม่
                        echo "มีไฟลอยู่แล้ว";
                        if (is_dir($job_id)) {
                            $moved = move_uploaded_file($FileTmpName, $fileDestina );
                            if ($moved) {
                                $sql_upd = "UPDATE `car_work` SET `work_date_done` = '$date' ,`work_pic_path` = '$doc_path',`work_remark` = '$work_remark',`user_id` = '$user_id' WHERE car_id = '$car_id' AND wor_id = ' $car_work_id' ";
                                if (mysqli_query($conn, $sql_upd)) {
                                    echo "02";
                                    header("Location: showwork_opn.php?To_show_opn=$car_id&job_id=$job_id");
                                } else {
                                    echo "<script type='text/javascript'>";
                                    echo "window.location = 'showwork_opn.php?To_show_opn=$car_id&job_id=$job_id'; ";
                                    echo "alert('!Error : เกิดข้อผิดพลาดของระบบในการส่งงาน <กรุณาแจ้งเจ้าหน้าที่>!');";
                                    echo "</script>";
                                }
                            }else {
                                echo "<script type='text/javascript'>";
                                echo "window.location = 'showwork_opn.php?To_show_opn=$car_id&job_id=$job_id'; ";
                                echo "alert('!Error : ย้ายไฟลไป New Folder ไม่สำเหร็จ!');";
                                echo "</script>";
                                // echo "ย้ายไฟลไป New Folder ไม่สำเหร็จ" ;
                            }
                        }else {
                            echo "<script type='text/javascript'>";
                            echo "window.location = 'showwork_opn.php?To_show_opn=$car_id&job_id=$job_id'; ";
                            echo "alert('!Error : โฟลเดอร์ที่จัดเก็บงานไม่เป็น Directory!');";
                            echo "</script>";
                        }  
                    }
                    }else{
                        echo "<script type='text/javascript'>";
                        echo "window.location = 'showwork_opn.php?To_show_opn=$car_id&job_id=$job_id'; ";
                        echo "alert('!Error : ไฟลมีขนาดใหญ่เกินไป!');";
                        echo "</script>";
                        // echo "ไฟลมีขนาดใหญ่เกินไป";
                    }
                }else{
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'showwork_opn.php?To_show_opn=$car_id&job_id=$job_id'; ";
                    echo "alert('!Error : มีปัญหาในการอัพโหลดไฟล!');";
                    echo "</script>";
                    // echo "มีปัญหาในการอัพโหลดไฟล";
                }
            }else{
                echo "<script type='text/javascript'>";
                    echo "window.location = 'showwork_opn.php?To_show_opn=$car_id&job_id=$job_id'; ";
                    echo "alert('!Error : ไม่สามารถอัพโหลดไฟลประเภทนี้!');";
                    echo "</script>";
                // echo "ไม่สามารถอัพโหลดไฟลประเภทนี้";
            }
        }
    }
    else {
        echo "fail";
    }
?>
