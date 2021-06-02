<?php
include('server.php');
// ----------เพิ่มขั้นตอน

// ----------ลบขั้นตอน
if (isset($_GET["del_opn"])) {
    $opn_id =  $_GET["del_opn"] ;
    $sub_id =  $_GET['sub_id'] ;
    $opn_seq = $_GET['opn_seq'];
    $sql_del = "DELETE FROM submodel_opn WHERE opn_id ='$opn_id' ";
    if(mysqli_query($conn, $sql_del)){
        $sql_upd ="UPDATE `submodel_opn` SET `opn_seq`= `opn_seq` - 1 WHERE sub_id = $sub_id AND opn_seq > $opn_seq ";
        if (mysqli_query($conn, $sql_upd)) {
             header("Location: subopn_add.php?To_add=$sub_id");
        } else {
            echo "alert('Error:Can't reset sequence/ back to delete again');";
        }   
    }else{
        echo "alert('Error:Can't delete sequence/ back to delete again');";
    }
}
// ----------copy ขั้นตอน
elseif (isset($_GET["exam_id"])) {
    $exam_id = $_GET['exam_id'];
    $sub_id = $_GET['sub_id'];
	echo  $exam_id.'/';
	echo  $sub_id;
    $copy = "INSERT INTO submodel_opn (sub_id, opn_seq, opn_name, opn_duration, opn_day_notify, show_opn, show_name_new) SELECT '$sub_id',opn_seq, opn_name, opn_duration, opn_day_notify, show_opn, show_name_new FROM submodel_opn Where sub_id = '$exam_id' ";
    if(mysqli_query($conn, $copy)){
       header("Location: subopn_add.php?To_add=$sub_id");
    }else{
        echo "alert('Error back to subopn_add again');";
    }

}
// ----------re run เลขขั้นตอน
elseif (isset($_GET['re_opn'])) {
    $sub_id = $_GET['re_opn'];
    $re_seq = 1 ;
    $sql = mysqli_query($conn, "SELECT opn_id, opn_seq FROM submodel_opn where sub_id = '$sub_id' ORDER BY opn_seq");
        while ($row = $sql->fetch_assoc()){
            $seq = $row["opn_seq"];
            $id = $row["opn_id"];
            $seq = $re_seq;
            $up_sql = " UPDATE submodel_opn SET opn_seq ='$seq' WHERE opn_id = '$id' ";
            mysqli_query($conn, $up_sql);
            $re_seq++ ;                
        }    
     header("Location: subopn_add.php?To_add=$sub_id");
}
?>