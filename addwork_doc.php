<?php
include('server.php');
    //---------job_id มาจากaddwork show
    if(isset($_GET['To_addwork_doc'])){
        $job_id = $_GET['job_id'];  
    }
    //---------เพิ่มเอกสาร-------//
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
        $doc_path = $path ; 
       if(in_array($FileActuaExt, $allowed)){
          if($FileError === 0){
            if($FileSize  < 1000000){
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
                        }else{
                            echo "อัพโหลไฟลไม่สำเหร็จ";
                        }
                    }else {
                        echo "ย้ายไฟลไป New Folder ไม่สำเหร็จ" ;
                    }
                }else {
                echo "สร้างไฟลไม่สำเหร็จ";
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
                        }else{
                            echo "อัพโหลไฟลไม่สำเหร็จ";
                        }
                    }else {
                        echo "ย้ายไฟลไป New Folder ไม่สำเหร็จ" ;
                    }
                }else {
                echo "this file is not Directory";
                }  
              }
            }else{
              echo "ไฟลมีขนาดใหญ่เกินไป";
            }
          }else{
            echo "มีปัญหาในการอัพโหลดไฟล";
          }
       }else{
         echo "ไม่สามารถอัพโหลดไฟลประเภทนี้";
       }
    }
    //---------job_id มาจากaddwork db
    elseif(isset($_GET['To_doc'])){
      $job_id = $_GET['To_doc'];  
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มเอกสาร<?php echo $job_id ; ?></title>
</head>
<body>

<div>
<h1>เพิ่มเอกสาร: <?php echo $job_id ?></h1>
    <?php
        $sql = mysqli_query($conn, "SELECT doc_id, doc_name FROM job_doc where job_id = '$job_id'");
        while ($row = $sql->fetch_assoc()){
      ?>
        <br>
          <td><?php echo $row["doc_name"]; ?></td>
          <input type="hidden" name="doc_id" value="<?php echo $row["doc_id"] ?>">
          <td><a href="addwork_db.php?del_doc=<?php echo $row["doc_id"]; ?>">Delete</a></td>
        </br>
    <?php } ?>
    
  <form name="doct" method="POST" enctype="multipart/form-data" >
    <input type="hidden" name="job_id" value="<?php echo $job_id ?>">
    <input type="text" class="text" id="doc_name" name="doc_name" required/>
    <input type="file"  id="file_doc" name="file_doc" />
    <input type="submit"  name="submit_doc"  value="บันทึก" onClick="this.form.action='addwork_doc.php'; submit()" /> 
  </form>
  <td><a href="addwork.php">Main</a></td>
</div>
</body>
</html>
<?php mysqli_close($conn); ?>