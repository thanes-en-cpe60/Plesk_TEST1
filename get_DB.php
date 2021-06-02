<?php
// echo 'TEST.....................TEST';
session_start();
include('server.php');
/* -------------------------------- Closebtn -------------------------------- */

if (isset($_GET['close-btn'])){
    header("location:javascript://history.go(-1)");
    exit; 
} 

elseif (isset($_POST['login_submit'])) {
    $user_id = $_POST['user_id'];
    $p = md5($_POST['use_password']).'.'.md5($_POST['user_id']);
    $sql = mysqli_query($conn, "SELECT  * FROM user WHERE user_id = '$user_id' ");
    $row = $sql->fetch_assoc();
    $Key = ($row['use_password']);
    print_r($p);
    if ($p == $Key) {
        $_SESSION["user_id"] = $row['user_id'];
        $_SESSION["use_firstname"] = $row['use_firstname'];
        $_SESSION["use_lastname"] = $row['use_lastname'];
        $_SESSION["use_role"] = $row['use_role'];
        $_SESSION["key"] = $p ;
        header("Location: index.php");
    } else {
        header('Location: login.php?err=2');
    }
}
/* -------------------------------- Add job -------------------------------- */
 
elseif (isset($_REQUEST['submit-addwork-btn'])){

    //Start transaction 
    $conn->autocommit(FALSE);
    //Gen job_id จากหน้า Addwork
    $car_cal = $_GET['car_id_start'] + $_GET['car_qty'] - 1;
    $car_cal = str_pad($car_cal,3,"0",STR_PAD_LEFT);
        
    $YeAr = date("Y"); 
    if ($YeAr < 2500) {
         $YeAr = $YeAr + 543 ;
    }
    $YeAr = "".$YeAr ; 
    $YeAr = substr($YeAr,2,2);
    if($_GET['car_qty'] == 1){
        $job_id = $YeAr.$_GET['mod_id'] . "-" . $_GET['car_id_start'] ;
    } else{
        $job_id = $YeAr.$_GET['mod_id'] . "-" . $_GET['car_id_start'] . "-" . $car_cal ;
    }

    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);
    $cus_id = mysqli_real_escape_string($conn, $_GET['cus_id']);
    $mod_id = mysqli_real_escape_string($conn, $_GET['mod_id']);
    $sub = mysqli_real_escape_string($conn, $_GET['sub_id']);
        $Compare = mysqli_query($conn,"SELECT sub_id FROM submodel Where sub_name like '$sub'");
        $row = $Compare->fetch_assoc();
        $sub_id = $row["sub_id"];
    $job_axle = mysqli_real_escape_string($conn, $_GET['job_axle']);
    $car_id_start = mysqli_real_escape_string($conn, $_GET['car_id_start']);
    $car_qty = mysqli_real_escape_string($conn, $_GET['car_qty']);
    $job_detail = mysqli_real_escape_string($conn, $_GET['job_detail']);
    $job_date_start = mysqli_real_escape_string($conn, $_GET['job_date_start']);
    $job_date_deadline = mysqli_real_escape_string($conn, $_GET['job_date_deadline']);
    $tec_id_paint = mysqli_real_escape_string($conn, $_GET['tec_id_paint']);
    $tec_id_elec = mysqli_real_escape_string($conn, $_GET['tec_id_elec']);
    $tec_id_weld = mysqli_real_escape_string($conn, $_GET['tec_id_weld']);
    $tec_id_chassis = mysqli_real_escape_string($conn, $_GET['tec_id_chassis']);
    //check data same data in sql
    $sql = mysqli_query($conn,"SELECT job_id FROM job Where job_id = '$job_id'") or die(mysqli_error());
    $data = mysqli_num_rows($sql);
    if ($data > 0) {
        $conn->rollback();
        header("Location: addwork.php?err=1");
    } else {
            $sql = "INSERT INTO job (job_id, product_id, cus_id, sub_id, job_axle, mod_id, car_id_start, car_qty, job_detail, job_date_start, job_date_deadline, tec_id_paint, tec_id_elec, tec_id_weld, tec_id_chassis)
            VALUES ('$job_id', '$product_id', '$cus_id', '$sub_id', '$job_axle', '$mod_id', '$car_id_start', '$car_qty', '$job_detail', '$job_date_start', '$job_date_deadline', '$tec_id_paint', '$tec_id_elec', '$tec_id_weld', '$tec_id_chassis')";
            //----------------------rowback
            if(mysqli_query($conn, $sql)){
                // echo "Records inserted successfully.";
                $sql = "INSERT INTO job_work( `job_id`, `opn_seq`, `opn_name`, `opn_duration`, `opn_day_notify`, `show_opn`, `show_name_new`) SELECT '$job_id', opn_seq, opn_name,  opn_duration,opn_day_notify, show_opn, show_name_new  FROM submodel_opn where sub_id  = '$sub_id' ORDER BY opn_seq";
                if(mysqli_query($conn, $sql)){
                        //----------------------insert เข้าตารางcar
                $i = 0 ;
                    while($i<$car_qty){
                        $CarNum =$_GET['car_id_start'] + $i;
                        $CarNum = str_pad($CarNum,3,"0",STR_PAD_LEFT);
                        $car_id = $YeAr.$_GET['mod_id'] . "-" . $CarNum;
                        //check data same data in sql
                        $sql = mysqli_query($conn,"SELECT car_id FROM car WHERE car_id = '$car_id'") or die(mysqli_error());
                        $data = mysqli_num_rows($sql);
                        if ($data > 0) 
                        {
                            $conn->rollback();
                            echo "err 02";
                            //get out loop
                            header("Location: addwork.php?err=2");
                             
                        }
                        else 
                        {
                            $sql_car = "INSERT INTO car (car_id, job_id) VALUES ('$car_id','$job_id')";
                                if(mysqli_query($conn, $sql_car))
                                {
                                    $user = $_SESSION["user_id"];
                                    $sql_carWork = "INSERT INTO `car_work`(`car_id`, `job_work_id`, `user_id`) SELECT '$car_id', wor_id, '$user' FROM job_work WHERE job_id = '$job_id' ORDER BY opn_seq";
                                    echo "this process = ".(mysqli_query($conn, $sql_carWork) ? "pass" : "ERROR: Could not able to execute Car Table $sql_car. " . mysqli_error($conn));
                                    $conn->commit();
                                    header("Location: addwork_show.php?To_show=$job_id");  
                                }
                                else
                                {
                                    $conn->rollback();
                                    echo "ERROR: Could not able to execute Car Table $sql_car. " . mysqli_error($conn);
                                }
                            //End transaction
                        }
                        $i++;
                        echo ".....TEST COUNT...."    ;
                    }               
                }else{
                    echo "ERROR: ไม่สามารถ query sub_opn " ;
                }
            } else{
                echo "ERROR: Could not able to execute Job Table $sql. " . mysqli_error($conn);
            }
        }
        $conn->close();           
    }
/* -------------------------------------------------------------------------- */

/* ------------------------------ edit job ------------------------------ */

elseif (isset($_POST['edit-addwork-btn']))
    {
    $job_id = $_POST['job_id'];
    $job_detail = $_POST['job_detail'];
    $cus_id = $_POST['cus_id'];
    $job_date_start = $_POST['job_date_start'];
    $job_date_deadline = $_POST['job_date_deadline'];
    $job_date_notify = $_POST['job_date_notify'];
    $tec_id_paint = $_POST['tec_id_paint'];
    $tec_id_elec = $_POST['tec_id_elec'];
    $tec_id_weld = $_POST['tec_id_weld'];
    $tec_id_chassis = $_POST['tec_id_chassis'];
    echo $job_id ;
    $sql_upd = "UPDATE `job` 
        SET `cus_id` = '$cus_id',
        `job_date_start` = '$job_date_start',
        `job_date_deadline` = '$job_date_deadline',
        `job_date_notify` = '$job_date_notify',
        `job_detail` = '$job_detail',
        `tec_id_paint` = '$tec_id_paint',
        `tec_id_elec` = '$tec_id_elec',
        `tec_id_weld` = '$tec_id_weld',
        `tec_id_chassis` = '$tec_id_chassis'
        WHERE `job_id` = '$job_id'";
        if(mysqli_query($conn, $sql_upd)){
        echo "<script type='text/javascript'>";
        echo "window.location = 'addwork_show.php?To_show=$job_id'; ";
        echo "alert('Update Job Succesfuly');";
        echo "</script>";
        }
        else{
        echo "<script type='text/javascript'>";
        echo "window.location = 'addwork_show.php?To_show=$job_id'; ";
        echo "alert('Error back to Update again');";
        echo "</script>";
        }
    $conn->close(); 
    }
/* -------------------------------------------------------------------------- */


/* ------------------------------ Del job ------------------------------ */

elseif (isset($_GET['delete_job']))
    {
    $conn->autocommit(FALSE);
    $id = $_GET['delete_job'];
    $sql = "DELETE FROM `job_doc` WHERE job_id ='$id'";
    if(mysqli_query($conn, $sql))
    {
        $sql = "DELETE FROM `job_work` WHERE job_id ='$id'";
        if(mysqli_query($conn, $sql))
        {
                $sql = "DELETE FROM car WHERE job_id = '$id'";
                if(mysqli_query($conn, $sql))
                {
                    $sql = "DELETE FROM job WHERE job_id = '$id'";
                    if(mysqli_query($conn, $sql))
                    {
                        $conn->commit();
                        header("Location: index.php");
                    }
                    else{$conn->rollback(); echo "ERROR: Could not Delete Job $sql. " . mysqli_error($conn);}
                }
                else{ $conn->rollback(); echo "ERROR: Could not Delete all car $sql. " . mysqli_error($conn);}
        }
        else{$conn->rollback(); echo "ERROR: Could not Delete Job_work $sql. " . mysqli_error($conn);}
    }
    else{echo "ERROR: Could not Delete this Doc $sql. " . mysqli_error($conn);} 
    }
/* -------------------------------------------------------------------------- */
/* ------------------------------ Done job ------------------------------ */

elseif (isset($_GET['Finish']))
    {
    $conn->autocommit(FALSE);
    $id = $_GET['Finish'];
    $date_done = date("Y-m-d");
    $sql = mysqli_query($conn,"SELECT * FROM car WHERE car_status = 'I' AND  job_id ='$id'") or die(mysqli_error());
    $data = mysqli_num_rows($sql);
        if ($data > 0) 
        {
            echo "ERROR: Could not update Job_done $sql. " . mysqli_error($conn);
        }
        else 
        {
            $sql = "UPDATE `job` SET `job_date_done` = '$date_done' WHERE `job`.`job_id` = '$id'";
            if(mysqli_query($conn, $sql))
            {
                $conn->commit();
                header("Location: index.php");
            }
            else{$conn->rollback(); echo "ERROR: Could not Delete Job $sql. " . mysqli_error($conn);}
        }
    }
/* -------------------------------------------------------------------------- */

/* -------------------------------- Addmodel -------------------------------- */
 
elseif (isset($_GET['submit-addmodel-btn'])){
    
    $model = mysqli_real_escape_string($conn, $_GET['model']);
    $model_th = mysqli_real_escape_string($conn, $_GET['model_th']);
    $model_en = mysqli_real_escape_string($conn, $_GET['model_en']);

    $sql = "INSERT INTO model (mod_id, mod_nameTH, mod_nameEN) VALUES ('$model', '$model_th', '$model_en')";
    if(mysqli_query($conn, $sql)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    
header("Location: model.php");
exit; 
}

/* -------------------------------------------------------------------------- */

/* -------------------------------- AddSubmodel -------------------------------- */
 
elseif (isset($_GET['submit-addsubmodel-btn'])){
    
    $id_model = mysqli_real_escape_string($conn, $_GET['id_model']);
    $name_submodel_th = mysqli_real_escape_string($conn, $_GET['name_submodel_th']);
    $sub_axle = mysqli_real_escape_string($conn, $_GET['sub_axle']);

    $sql = "INSERT INTO submodel (mod_id, sub_name, sub_axle) VALUES ('$id_model', '$name_submodel_th', '$sub_axle')";
    if(mysqli_query($conn, $sql)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    
header("Location: model.php");
exit; 
}
/* -------------------------------------------------------------------------- */

/* -------------------------------- AddSubmodel_opn -------------------------------- */
elseif(isset($_GET['submit-addsubmodel_opn'])){
    $output = null;
    $sub_id = $_GET['sub_id'];
	$opn_name = $_GET['opn_name'];
	$opn_duration = $_GET['opn_duration'];
    $opn_seq = 0 ;
    echo $sub_id;
	// $show_opn = mysqli_real_escape_string($conn, $_GET['show_opn']);
	foreach($opn_name as $key => $value) {
            $opn_seq = $opn_seq + 1 ;
            echo $opn_name;
            echo $opn_duration;
			$query = "INSERT INTO submodel_opn (sub_id,opn_seq,opn_name,opn_duration) 
			VALUES ('"
			. $conn->real_escape_string($sub_id) .
			"', '"
			. $conn->real_escape_string($opn_seq) .
			"', '"
			. $conn->real_escape_string($value) . 
			"', '"
			. $conn->real_escape_string($opn_duration[$key]) .
			"')
			";
            exit;
      $insert = $conn->query($query);
      if(!$insert){
            echo $conn->error;
      }else{
            $output .="<p>pass". $sub_id  . $opn_seq . $value . "</p>"  ;
	  }
    }
    echo $output ;
    // header("Location: model.php");
    
}
/* -------------------------------------------------------------------------- */

/* ------------------------------ Add customer ------------------------------ */

elseif (isset($_GET['submit-customer-btn'])){
    
    $cus_name = mysqli_real_escape_string($conn, $_GET['cus_name']);
    $cus_tel = mysqli_real_escape_string($conn, $_GET['cus_tel']);
    $cus_add = mysqli_real_escape_string($conn, $_GET['cus_add']);

    $sql = "INSERT INTO customer (cus_name, cus_tel, cus_add) VALUES ('$cus_name', '$cus_tel', '$cus_add')";
    if(mysqli_query($conn, $sql)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    
header("Location: customer.php");

}

/* -------------------------------------------------------------------------- */

/* ------------------------------ Update customer ------------------------------ */

elseif (isset($_GET['submit-update-customer-btn'])){

        $sql = "UPDATE customer SET  
                cus_name = '".$_GET["cus_name"]."' , 
                cus_add = '".$_GET["cus_add"]."' ,
                cus_tel = '".$_GET["cus_tel"]."' 
                WHERE cus_id ='".$_GET["cus_id"]."' ";

        if(mysqli_query($conn, $sql)){
            echo "<script type='text/javascript'>";
            echo "window.location = 'customer.php'; ";
            echo "alert('Update Succesfuly');";
            echo "</script>";
            }
            else{
            echo "<script type='text/javascript'>";
            echo "alert('Error back to Update again');";
            echo "</script>";
            }
}
/* -------------------------------------------------------------------------- */

/* ------------------------------ Del customer ------------------------------ */

elseif (isset($_GET['delete_cus'])){
    // ----------- Check customer in job 
    
    $id = $_GET['delete_cus'];
    $sql = "DELETE FROM customer WHERE cus_id='".$_GET['delete_cus']."'";
    echo $sql;
    if(mysqli_query($conn, $sql)){
            echo "<script type='text/javascript'>";
            echo "window.location = 'customer.php'; ";
            echo "</script>";
            }
            else{
            echo "<script type='text/javascript'>";
            echo "alert('* รายชื่อนี้มีอยู่ในงาน * ไม่สามารถลบได้ !');";
            echo "window.location = 'customer.php'; ";
            echo "</script>";
            }
}
/* -------------------------------------------------------------------------- */

/* ------------------------------ Add technical ------------------------------ */

elseif (isset($_GET['submit-technical-btn'])){
    
    if(isset($_GET['tec_tel'])&& $_GET['tec_tel']!=''){
        $tec_tel = mysqli_real_escape_string($conn, $_GET['tec_tel']);
     } else{
         echo"ERROR: กรุณาใส่ชื่อช่าง";
         exit;
         }
 
     
     if(isset($_GET['tec_name'])&& $_GET['tec_name']!=''){
         $tec_name  = mysqli_real_escape_string($conn, $_GET['tec_name']);
     }else {
         echo"ERROR: กรุณาใส่ชื่อช่าง";
         exit;
     }
 
     if(isset($_GET['tec_skill_paint'])){
         $tec_skill_paint  = mysqli_real_escape_string($conn, 1 );
     }else {
         $tec_skill_paint  = mysqli_real_escape_string($conn, 0 );
     }
 
     if(isset($_GET['tec_skill_elec'])){
         $tec_skill_elec  = mysqli_real_escape_string($conn, 1 );
     }else {
         $tec_skill_elec  = mysqli_real_escape_string($conn, 0 );
     }
 
     if(isset($_GET['tec_skill_chassis'])){
         $tec_skill_chassis  = mysqli_real_escape_string($conn, 1 );
     }else {
         $tec_skill_chassis = mysqli_real_escape_string($conn, 0 );
     }
 
     if(isset($_GET['tec_skill_weld'])){
         $tec_skill_weld  = mysqli_real_escape_string($conn, 1 );
     }else {
         $tec_skill_weld = mysqli_real_escape_string($conn, 0 );
     }
     if(isset($_GET['tec_skill_hyd'])){
        $tec_skill_hyd  = mysqli_real_escape_string($conn, 1 );
    }else {
        $tec_skill_hyd = mysqli_real_escape_string($conn, 0 );
    }

    if(isset($_GET['tec_skill_logo'])){
        $tec_skill_logo  = mysqli_real_escape_string($conn, 1 );
    }else {
        $tec_skill_logo = mysqli_real_escape_string($conn, 0 );
    }
 
     $sql = "INSERT INTO technical (tec_tel, tec_skill_weld, tec_skill_paint, tec_skill_chassis, tec_skill_elec, tec_skill_logo, tec_skill_hyd,  tec_name) 
             VALUES ('$tec_tel', '$tec_skill_weld', '$tec_skill_paint', '$tec_skill_chassis', '$tec_skill_elec','$tec_skill_logo', '$tec_skill_hyd','$tec_name')";
 
     if(mysqli_query($conn, $sql)){
         echo "Records inserted successfully.";
     } else{
         echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
     }
     
 header("Location: technical.php");
 
 }
 
 /* -------------------------------------------------------------------------- */
 
 /* ------------------------------ Update technical ------------------------------ */
 
 elseif (isset($_GET['submit-update-technical-btn'])){
    
    $sql = "UPDATE technical SET  
    tec_name = '".$_GET["tec_name"]."' , 
    tec_tel = '".$_GET["tec_tel"]."' ,
    `tec_skill_weld` = '".$_GET["tec_skill_weld"]."',
    `tec_skill_paint` = '".$_GET["tec_skill_paint"]."',
    `tec_skill_chassis` = '".$_GET["tec_skill_chassis"]."',
    `tec_skill_elec` = '".$_GET["tec_skill_elec"]."',
    `tec_skill_hyd` = '".$_GET["tec_skill_hyd"]."',
    `tec_skill_logo` = '".$_GET["tec_skill_logo"]."'  
    WHERE tec_id ='".$_GET["tec_id"]."' ";
 
         if(mysqli_query($conn, $sql)){
             echo "<script type='text/javascript'>";
             echo "window.location = 'technical.php'; ";
             echo "alert('Update Succesfuly');";
             echo "</script>";
             }
             else{
             echo "<script type='text/javascript'>";
             echo "alert('Error back to Update again');";
             echo "</script>";
             
             }
 
 }
 
 /* -------------------------------------------------------------------------- */
 
 /* ---------------------------------- fetch technical --------------------------------- */
 
 elseif(isset($_POST["edit_tec_id"]))  
  {  
       $query = "SELECT * FROM technical WHERE tec_name = '".$_POST["edit_tec_id"]."'";  
       $result = mysqli_query($conn, $query);  
       $row = mysqli_fetch_array($result);  
       echo json_encode($row);
       exit;  
  }  
  
  
 /* -------------------------------------------------------------------------- */
 
 /* ------------------------------ Del technical ------------------------------ */
 
 elseif (isset($_GET['delete_tec']))
    {
        $id = $_GET['delete_tec'];
        $sql = "DELETE FROM technical WHERE tec_id = '".$_GET['delete_tec']."'";
        echo $sql;
        if(mysqli_query($conn, $sql)){
                echo "<script type='text/javascript'>";
                echo "window.location = 'technical.php'; ";
                echo "</script>";
                }
                else{
                echo "<script type='text/javascript'>";
                echo "alert('! ไม่สามารถลบได้ ! เนื่องจากมีช่างคนนี้อยู่ในตารางงาน);";
                echo "window.location = 'technical.php'; ";
                echo "</script>";
               
                }
    }
 /* -------------------------------------------------------------------------- */

/* ------------------------------ Add user ------------------------------ */

elseif (isset($_POST['submit-user-btn'])){
    
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $use_password  = mysqli_real_escape_string($conn, $_POST['use_password']);
    $use_firstname = mysqli_real_escape_string($conn, $_POST['use_firstname']);
    $use_lastname = mysqli_real_escape_string($conn, $_POST['use_lastname']);
    $use_role = mysqli_real_escape_string($conn, $_POST['use_role']);
    $p = md5($_POST['use_password']).'.'.md5($_POST['user_id']);
    //-------- Check user_id same
    $sql = mysqli_query($conn,"SELECT user_id FROM user Where user_id = '$user_id'") or die(mysqli_error());
    $data = mysqli_num_rows($sql);
    if ($data > 0) 
    {
        header("Location: user.php?err=1");
    } 
    else 
    {
        $sql = "INSERT INTO user (user_id, use_password, use_firstname, use_lastname, use_role) VALUES ('$user_id', '$p', '$use_firstname', '$use_lastname', '$use_role')";
        if(mysqli_query($conn, $sql))
        {
            echo "Records inserted successfully.";
            header("Location: user.php");
        }
        else
        {
            echo "Not Records inserted successfully.";
        }
    } 
}

/* -------------------------------------------------------------------------- */

/* ------------------------------ Update user ------------------------------ */

elseif (isset($_POST['submit-user-edit'])){
    $user_id = $_POST['user_id'];
    $user_role = $_POST["use_role"];
    $new_pass = $_POST["new_pass"];
    $firstname = $_POST["use_firstname"];
    $lastname = $_POST["use_lastname"];
    echo $user_id ;
    if ($new_pass == "") {
        $sql = "UPDATE user SET  
                    use_firstname = '$firstname' ,
                    use_lastname = '$lastname' ,
                    use_role = '$user_role'  
                    WHERE user_id ='$user_id' ";
        if(mysqli_query($conn,$sql)){
            echo "<script type='text/javascript'>";
            echo "window.location = 'user.php'; ";
            echo "alert('อัพเดตเสร็จสมบูรณ์');";
            echo "</script>";
            }
            else{
            echo "<script type='text/javascript'>";
            echo "window.location = 'user.php'; ";
            echo "alert('Error back to Update again 011');";
            echo "</script>";
            }
    } else {
        $p = md5($new_pass).'.'.md5($_POST['user_id']);
        $sql = "UPDATE user SET  
                use_password = '$p' , 
                use_firstname = '$firstname' ,
                use_lastname = '$lastname' ,
                use_role = '$user_role'  
                WHERE user_id ='$user_id' ";
        if(mysqli_query($conn,$sql)){
            echo "<script type='text/javascript'>";
            echo "window.location = 'user.php'; ";
            echo "alert('อัพเดตเสร็จสมบูรณ์');";
            echo "</script>";
            }
            else{
            echo "<script type='text/javascript'>";
            echo "alert('Error back to Update again');";
            echo "</script>";
            }
    }
}
/* -------------------------------------------------------------------------- */

/* ------------------------------ Del User ------------------------------ */

elseif (isset($_GET['delete_user'])){

    $id = $_GET['delete_user'];
    $sql = "DELETE FROM user WHERE user_id='".$_GET['delete_user']."'";
    echo $sql;
    if(mysqli_query($conn, $sql)){
            echo "<script type='text/javascript'>";
            echo "window.location = 'user.php'; ";
            echo "</script>";
            }
            else{
                echo "<script type='text/javascript'>";
                echo "window.location = 'user.php'; ";
                echo "alert('*มีuserนี้อยู่ในงาน* ไม่สามารถลบบุคลากรคนนี้ได้');";
                echo "</script>";
            }
        exit;
}
/* -------------------------------------------------------------------------- */

/* ------------------------------ Add job Doc ------------------------------ */
elseif(isset($_POST["submit_doc"])){
        $job_id = $_POST['job_id'];
        $doc_name = $_POST['doc_name'];
        $date = date('Y-m-d H.i.s');
       //-------------------------- uplode file----------------------------//
       $FileName = $_FILES['file_doc']['name'];
       $FileTmpName = $_FILES['file_doc']['tmp_name'];
       $FileSize = $_FILES['file_doc']['size'];
       $FileError = $_FILES['file_doc']['error'];
       $FileType = $_FILES['file_doc']['type'];
    
       $FileExt = explode('.', $FileName); //สกุลไฟล
       $FileActuaExt = strtolower(end($FileExt)); //
       $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'txt');
       $FileNameNew = $date.".".$FileActuaExt;
        $path = $job_id."/" ;
        $fileDestina = $path.$FileNameNew ;
        $doc_path = $job_id."/".$FileNameNew ;
        if(in_array($FileActuaExt, $allowed)){
            if($FileError === 0){
              if($FileSize  < 2097152){
                if(!file_exists($job_id)) {
                  echo $job_id ;
                  //------ถ้าไม่มีFolder ให้ create New folder  
                  mkdir($job_id);
                  if (is_dir($job_id)){
                       //-------------------------- uplode file----------------------------//
                       $moved = move_uploaded_file($FileTmpName, $fileDestina );
                      if ($moved) {
                          $sql = "INSERT INTO job_doc (job_id, doc_name, doc_path) 
                          VALUES ('"
                          . $conn->real_escape_string($job_id) .
                              "', '"
                          . $conn->real_escape_string($doc_name) .
                              "', '"
                          . $conn->real_escape_string($doc_path) .
                          "')
                          ";
                          if($conn->query($sql)){
                              echo "pass";
                              header("Location: addwork_edit.php?work-edit-btn=$job_id");
                          }else{
                            echo "<script type='text/javascript'>";
                            echo "window.location = 'addwork_edit.php?work-edit-btn=$job_id'; ";
                            echo "alert('อัพโหลไฟลไม่สำเหร็จ');";
                            echo "</script>";
                            // echo "อัพโหลไฟลไม่สำเหร็จ";
                          }
                      }else {
                        echo "<script type='text/javascript'>";
                        echo "window.location = 'addwork_edit.php?work-edit-btn=$job_id'; ";
                        echo "alert('ย้ายไฟลไป New Folder ไม่สำเหร็จ');";
                        echo "</script>";
                        // echo "ย้ายไฟลไป New Folder ไม่สำเหร็จ" ;
                      }
                  }else {
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'addwork_edit.php?work-edit-btn=$job_id'; ";
                    echo "alert('สร้างไฟลไม่สำเหร็จ');";
                    echo "</script>";
                    //   echo "สร้างไฟลไม่สำเหร็จ";
                  }
                }else{
                  //------ถ้ามีFolder ไห้เช็คว่าไฟลเป็น Directory หรือไม่
                  echo "มีไฟลอยู่แล้ว";
                  if (is_dir($job_id)) {
                      $moved = move_uploaded_file($FileTmpName, $fileDestina );
                      if ($moved) {
                          $sql = "INSERT INTO job_doc (job_id, doc_name, doc_path) 
                          VALUES ('"
                          . $conn->real_escape_string($job_id) .
                              "', '"
                          . $conn->real_escape_string($doc_name) .
                              "', '"
                          . $conn->real_escape_string($doc_path) .
                          "')
                          ";
                          if($conn->query($sql)){
                              echo "pass";
                              header("Location: addwork_edit.php?work-edit-btn=$job_id");  
                          }else{
                            echo "<script type='text/javascript'>";
                            echo "window.location = 'addwork_edit.php?work-edit-btn=$job_id'; ";
                            echo "alert('อัพโหลไฟลไม่สำเหร็จ');";
                            echo "</script>";
                            // echo "อัพโหลไฟลไม่สำเหร็จ";
                          }
                      }else {
                        echo "<script type='text/javascript'>";
                        echo "window.location = 'addwork_edit.php?work-edit-btn=$job_id'; ";
                        echo "alert('ย้ายไฟลไป New Folder ไม่สำเหร็จ');";
                        echo "</script>";
                        // echo "ย้ายไฟลไป New Folder ไม่สำเหร็จ" ;
                      }
                  }else {
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'addwork_edit.php?work-edit-btn=$job_id'; ";
                    echo "alert('this file is not Directory');";
                    echo "</script>";
                //   echo "this file is not Directory";
                  }  
                }
              }else{
                echo "<script type='text/javascript'>";
                echo "window.location = 'addwork_edit.php?work-edit-btn=$job_id'; ";
                echo "alert('ไฟลมีขนาดใหญ่เกินไป');";
                echo "</script>";
                // echo "ไฟลมีขนาดใหญ่เกินไป";
              }
            }else{
                echo "<script type='text/javascript'>";
                echo "window.location = 'addwork_edit.php?work-edit-btn=$job_id'; ";
                echo "alert('มีปัญหาในการอัพโหลดไฟล');";
                echo "</script>";
            //   echo "มีปัญหาในการอัพโหลดไฟล";
            }
         }else{
            echo "<script type='text/javascript'>";
            echo "window.location = 'addwork_edit.php?work-edit-btn=$job_id'; ";
            echo "alert('ไม่สามารถอัพโหลดไฟลประเภทนี้');";
            echo "</script>";
        //    echo "ไม่สามารถอัพโหลดไฟลประเภทนี้";
         }
      
}
/* -------------------------------------------------------------------------- */

/* ------------------------------ del job Doc ------------------------------ */
elseif(isset($_GET["del_doc"])) 
    {
        $id =  $_GET["del_doc"] ;
        echo $id ;
        $sql = mysqli_query($conn, "SELECT job_id FROM job_doc where doc_id = $id ");
            $row = $sql->fetch_assoc();
            $job_id =  $row['job_id'] ;
        if ($job_id) {
            $sql = "DELETE FROM job_doc WHERE doc_id ='$id' ";
            echo $sql;
            if(mysqli_query($conn, $sql)){
                echo "del pass";
                header("Location: addwork_show.php?To_show=$job_id"); 
            }else{
            echo "alert('Error back to Update again');";
            }
        }else {
            echo "error query job_id : ";
        }
    }
/* -------------------------------------------------------------------------- */

/* ------------------------------ Add submodel Doc ------------------------------ */
elseif(isset($_POST['submit-submodel_doc'])){
        $sub_id = $_POST['sub_id'];
        $sql =mysqli_query($conn, "SELECT sub_name FROM submodel WHERE sub_id = '$sub_id'");
        $row = $sql->fetch_assoc();
        $sub_name = $row['sub_name'];
        
    
        $doc_name = $_POST['doc_name'];
        $date = date('Y-m-d H.i.s');
       //-------------------------- uplode file----------------------------//
       $FileName = $_FILES['file_doc']['name'];
       $FileTmpName = $_FILES['file_doc']['tmp_name'];
       $FileSize = $_FILES['file_doc']['size'];
       $FileError = $_FILES['file_doc']['error'];
       $FileType = $_FILES['file_doc']['type'];
    
       $FileExt = explode('.', $FileName); //สกุลไฟล
       $FileActuaExt = strtolower(end($FileExt)); //
       $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'txt');
       $FileNameNew = $date.".".$FileActuaExt;
        $path = $sub_id."/" ;
        $fileDestina = $path.$FileNameNew ;
        $doc_path = $sub_id."/".$FileNameNew ;
        
        if(in_array($FileActuaExt, $allowed)){
            if($FileError === 0){
              if($FileSize  < 2097152){
                if(!file_exists($sub_id)) {
                  echo $sub_id ;
                  //------ถ้าไม่มีFolder ให้ create New folder  
                  mkdir($sub_id);
                  if (is_dir($sub_id)){
                       //-------------------------- uplode file----------------------------//
                       $moved = move_uploaded_file($FileTmpName, $fileDestina );
                      if ($moved) {
                          $sql = "INSERT INTO submodel_doc (sub_id, doc_name, doc_path) 
                          VALUES ('"
                          . $conn->real_escape_string($sub_id) .
                              "', '"
                          . $conn->real_escape_string($doc_name) .
                              "', '"
                          . $conn->real_escape_string($doc_path) .
                          "')
                          ";
                          if($conn->query($sql)){
                              echo "pass";
                              header("Location: submodel_show.php?To_show=$sub_name");
                          }else{
                            echo "<script type='text/javascript'>";
                            echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                            echo "alert('อัพโหลไฟลไม่สำเหร็จ');";
                            echo "</script>";
                            // echo "อัพโหลไฟลไม่สำเหร็จ";
                            
                          }
                      }else {
                        echo "<script type='text/javascript'>";
                        echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                        echo "alert('ย้ายไฟลไป New Folder ไม่สำเหร็จ');";
                        echo "</script>";
                        // echo "ย้ายไฟลไป New Folder ไม่สำเหร็จ" ;
                      }
                  }else {
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                    echo "alert('สร้างไฟลไม่สำเหร็จ');";
                    echo "</script>";
                    //   echo "สร้างไฟลไม่สำเหร็จ";
                  }
                }else{
                  //------ถ้ามีFolder ไห้เช็คว่าไฟลเป็น Directory หรือไม่
                  echo "มีไฟลอยู่แล้ว";
                  if (is_dir($sub_id)) {
                      $moved = move_uploaded_file($FileTmpName, $fileDestina );
                      if ($moved) {
                          $sql = "INSERT INTO submodel_doc (sub_id, doc_name, doc_path) 
                          VALUES ('"
                          . $conn->real_escape_string($sub_id) .
                              "', '"
                          . $conn->real_escape_string($doc_name) .
                              "', '"
                          . $conn->real_escape_string($doc_path) .
                          "')
                          ";
                          if($conn->query($sql)){
                              echo "pass";
                              header("Location: submodel_show.php?To_show=$sub_name");  
                          }else{
                            echo "<script type='text/javascript'>";
                            echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                            echo "alert('อัพโหลไฟลไม่สำเหร็จ');";
                            echo "</script>";
                            // echo "อัพโหลไฟลไม่สำเหร็จ";
                          }
                      }else {
                        echo "<script type='text/javascript'>";
                        echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                        echo "alert('ย้ายไฟลไป New Folder ไม่สำเหร็จ');";
                        echo "</script>";
                        // echo "ย้ายไฟลไป New Folder ไม่สำเหร็จ" ;
                      }
                  }else {
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                    echo "alert('this file is not Directory');";
                    echo "</script>";
                //   echo "this file is not Directory";
                  }  
                }
              }else{
                echo "<script type='text/javascript'>";
                echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                echo "alert('ไฟลมีขนาดใหญ่เกินไป');";
                echo "</script>";
                // echo "ไฟลมีขนาดใหญ่เกินไป";
              }
            }else{
                echo "<script type='text/javascript'>";
                echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                echo "alert('มีปัญหาในการอัพโหลดไฟล');";
                echo "</script>";
            //   echo "มีปัญหาในการอัพโหลดไฟล";
            }
         }else{
            echo "<script type='text/javascript'>";
            echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
            echo "alert('ไม่สามารถอัพโหลดไฟลประเภทนี้');";
            echo "</script>";
        //    echo "ไม่สามารถอัพโหลดไฟลประเภทนี้";
         }
}
/* -------------------------------------------------------------------------- */

/* ------------------------------ del job Doc ------------------------------ */
elseif (isset($_GET['del-submodel_doc'])) {
    $id =  $_GET["del-submodel_doc"] ;
        echo $id ;
        $sql = mysqli_query($conn, "SELECT (SELECT sub_name FROM submodel WHERE sub_id = s.sub_id)sub_name 
                                        FROM submodel_doc s 
                                        where s.doc_id = $id ");
            $row = $sql->fetch_assoc();
            $sub_name =  $row['sub_name'] ;
            echo $sub_name ;
        if ($sub_name) {
            $sql = "DELETE FROM submodel_doc WHERE doc_id ='$id' ";
            echo $sql;
            if(mysqli_query($conn, $sql)){
                echo "del pass";
                header("Location: addwork_show.php?To_show=$job_id"); 
            }else{
                echo "<script type='text/javascript'>";
                echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                echo "alert('มีปัญหากับการลบไฟลนี้');";
                echo "</script>";
            }
        }else {
            echo "<script type='text/javascript'>";
                echo "window.location = 'submodel_show.php?To_show=$sub_name'; ";
                echo "alert('ไม่พบ');";
                echo "</script>";
        }
}
/* -------------------------------------------------------------------------- */
/* -------------------------------- del Submodel -------------------------------- */
elseif(isset($_GET['del_sub'])){
	$sub_id = $_GET['del_sub'];
	$sql = "DELETE FROM submodel WHERE sub_id = '$sub_id'";
                    if(mysqli_query($conn, $sql))
                    {
                        $conn->commit();
                        header("Location: model_sub.php");
                    }
                    else{$conn->rollback();
						 echo "<script type='text/javascript'>";
        				echo "window.location = 'model_sub.php'; ";
       					 echo "alert('!ไม่สามารถลบได้ มีงานที่ใช้โมเดลย่อยนี้อยู่ !');";
        				echo "</script>";
					}
}

/* -------------------------------------------------------------------------- */
else{
    echo 'False';
}
?>