<?php
include('server.php');
// ------ จาก submodel_add-------
if (isset($_GET['insert_opn'])) {  
    $sub_id = $_GET['sub_id'];
    $opn_seq = $_GET['opn_seq']; 
}
elseif (isset($_GET["submit_opn"])) {
    $sub_id = $_GET['sub_id'];
    $opn_seq = $_GET['opn_seq'];
    $opn_id = $_GET['opn_id'];
	$opn_name = $_GET['opn_name'];
    $opn_duration = $_GET['opn_duration'];
    $opn_day_notify = $opn_duration ;
    $show_opn = $_GET['show_opn'];
    $show_name_new = $_GET['show_name_new'];
    if ($show_opn == '1' AND $show_name_new == null) {
        echo 'ERROR: Show name operation is null ';
    }else{
        $sql = mysqli_query($conn, "SELECT* FROM submodel_opn where sub_id = '$sub_id' AND opn_seq ='$opn_seq' ");
        $row = $sql->fetch_assoc();
        //(2) --------Check new seq == sql in db(yes/no)? 
        if ($row["opn_seq"]) {
            $sql = "UPDATE `submodel_opn` SET `opn_seq`= `opn_seq` +1 WHERE sub_id = $sub_id AND opn_seq >= $opn_seq ";
            if(mysqli_query($conn, $sql)){
                // allpass  insert to db
                $sql = "INSERT INTO submodel_opn (sub_id, opn_seq, opn_name, opn_duration, opn_day_notify, show_opn, show_name_new) VALUES ('$sub_id','$opn_seq','$opn_name','$opn_duration','$opn_day_notify','$show_opn','$show_name_new')";
                if(mysqli_query($conn, $sql)){
                    header("Location: subopn_add.php?To_add=$sub_id");
                }else{
                    echo "ERROR: Could not able to execute Car Table $sql. " . mysqli_error($conn);
                }
            }else{
                echo "ERROR: Could not able to execute Car Table $sql. " . mysqli_error($conn);
            }
        }else {
            // allpass  insert to db
            $sql = "INSERT INTO submodel_opn (sub_id, opn_seq, opn_name, opn_duration, opn_day_notify, show_opn, show_name_new) VALUES ('$sub_id','$opn_seq','$opn_name','$opn_duration','$opn_day_notify','$show_opn','$show_name_new')";
                if(mysqli_query($conn, $sql)){
                    header("Location: subopn_add.php?To_add=$sub_id");
                }else{
                    echo "ERROR: Could not able to execute Car Table $sql. " . mysqli_error($conn);
                }
        }
    } 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แทรกขั้นตอนที่ :<?php echo  $row['opn_seq'] ?></title>
    <a href="subopn_add.php?To_add=<?php echo $sub_id; ?>">ถอยกลับ</a>
</head>

<body>
        <form name="edit_opn"  method="GET" onsubmit="return(validateForm());">
            <input type="hidden" name="sub_id" value="<?php echo $sub_id ?>"/>
            <input type="hidden" name="opn_seq" value="<?php echo $opn_seq ?>"/>
            <!-- number Seq ------------------------------------------------>
            <?php echo  $opn_seq." :" ?>
            <!-- -------------------------------------------------------- -->
            <input type="text" name="opn_name" id="opn_name" size="45"autocomplete="on"  onchange="myFunction()"/>
            <br>
            <label for="opn_duration">ระยะเวลา(วัน)</label>
            <input type="number" name="opn_duration" id="opn_duration" size="2" min="0" max="20"  onchange="myFunction()"/>
            <br>
            <!-- checkbox -------------------------------------------------->
            <label for="show">แสดง</label>
            <input  type="radio" name="show_opn" id="show" value="1"   onchange="myFunction()"/>
            <label for="cant_show">ไม่แสดง</label>
            <input  type="radio" name="show_opn" id="cant_show" value="0"  checked="checked" onchange="myFunction()"/>
            <!-- -------------------------------------------------------- -->
            <input type="text" name="show_name_new" id="show_name_new"  onchange="myFunction()"/>
            <input type="submit" name="submit_opn"  id="submit_opn" value="แก้ใข" disabled/>
        </form>        
</body>
</html>
<script>
function myFunction() {
  document.getElementById("submit_opn").disabled = false;
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