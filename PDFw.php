<?php
//----------------------------------- write html
require_once __DIR__ . '/vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'sarabun',
    'mode' => 'utf-8',
    'format' => 'A4',
    'orientation' => 'L'

]);
//-----------------------------------------------------------
if(isset($_GET['car_id']))
{
 $id = $_GET['car_id'];
//   echo $id;
   include('server.php');
     $sql_top = mysqli_query($conn, "SELECT j.mod_id,
	j.job_id,
	(SELECT sub_name FROM submodel WHERE sub_id = j.sub_id)sub 
	,MIN(cw.work_date_start) StDate
	,MAX(cw.work_date_deadline) DlDate
	FROM job j,car c,car_work cw
	WHERE j.job_id = c.job_id and c.car_id =cw.car_id and c.car_id ='$id'");
    $data = $sql_top->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">
<?php ob_start() ?>
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan<?php echo $id?></title>
    <a href="ReportSubmodel.pdf" target="_blank" >Print this from</a>
</head>
<style>
        table, th, td 
        {
        border: 1px solid black;
        border-collapse: collapse;
        }
        h4
        {
        text-align: center;
        }
		div.buttom
		{
		text-align: left;
		}
</style>
<body>
		<img src="Piroon3.png" alt="header" style="width:100%;"   >
        <h4>ตารางการประกอบรถ....<?php  echo $data['mod_id'].''.$data['sub']; ?>...  รหัสงาน...<?php  echo $data['job_id']; ?>...  รหัสรถ...<?php  echo $id ; ?>... เริ่มผลิต...<?php $date = date_create($data['StDate']);$day_start = date_format($date,"d-M-Y"); echo $day_start ;?>...  สิ้นสุด...<?php $date = date_create($data['DlDate']);$day_start = date_format($date,"d-M-Y"); echo $day_start ;?>... </h4>
<table style="width:100%"  >
    <tr>
        <th>ลำดับ</th>
        <th>ขั้นตอน</th>

        <?php
        $sql_head = mysqli_query($conn, "SELECT min(cw.work_date_start) dateStart,
        (SELECT sum(opn_duration) FROM job_work WHERE job_id = (SELECT c.job_id FROM car c WHERE c.car_id = cw.car_id))nAll 
        FROM car_work cw 
        WHERE cw.car_id ='$id'");
        $row = $sql_head->fetch_assoc();
        $c_All = $row['nAll'];
        
        $colum = 1 ; 
        while ($colum <= $c_All) {
            $format = ($colum-1)."days"; 
            $date = date_create($row['dateStart']);
            date_add($date, date_interval_create_from_date_string("$format"));
            $day = date_format($date,"d");
            $month = date_format($date,"M");
            echo "<th>$day <br> $month</th>";
            $colum++;
        }
        ?>
    </tr>
    </tr>
    
        <?php
            $sql = mysqli_query($conn, "SELECT (SELECT j.opn_seq FROM job_work j WHERE j.wor_id =cw.job_work_id)opn_seq,
            (SELECT j.opn_name FROM job_work j WHERE j.wor_id =cw.job_work_id)opn_name,
            (SELECT sum(opn_duration) FROM job_work WHERE job_id = (SELECT c.job_id FROM car c WHERE c.car_id = cw.car_id))nAll,
            (SELECT j.opn_duration FROM job_work j WHERE j.wor_id =cw.job_work_id)opn_duration,
            datediff(cw.work_date_done,cw.work_date_deadline)late
            FROM car_work cw
            WHERE cw.car_id ='$id'");
            $plan = 0;
            while ($row = $sql->fetch_assoc()) {
                $block = null ; 
                $num = $row['opn_seq'];
                $text = $row['opn_name'];
                $max_day = $row['nAll'];
                $day = $row['opn_duration'];
                $daylate = $row['late'];
                $q = 1 ;
                $day = $day + $plan;
                
                while ($q <= $max_day) {
                    if($q <= $plan ) {
                        $mark = "<th>  </th>";
                    }
                    elseif ($q <= $day) {
                        if ($row['late']=="") {
                            $mark = "<th>P</th>";
                        } else {
                            $mark = "<th>C</th>";
                        }
                        $plan++;

                    }
                    else {
                        if ($q <= $day+$daylate) {
                            $mark = "<th>L</th>";
                        } else {
                            $mark = "<th>  </th>";
                        }
                        //--debug $q----- 
                         //echo $q . " "."|"  ;
                    }
                    //-------
                    $block = $block.$mark;
                    
                    $q++;
                    
                }
                echo "<tr><th>$num</th><th>$text</th>$block</tr>" ;
                //--debug $q 
                // echo ">>" ;
        }
        ?>
</table>
P = Plan/แผน   C = Complete/เสร็จสมบูรณ์   L = Late/ล่าช้า
<table>
รายการหยุดงาน
    <tr>
        <th>ขั้นตอน</th>
        <th>ชื่อขั้นตอน</th>
        <th>ผู้สั่งหยุดงาน</th>
        <th>วันที่เริ่มหยุด</th>
        <th>วันที่ทำงานต่อ</th>
        <th>หมายเหตุ</th>
    </tr>

<?php 
    $sql = mysqli_query($conn, "SELECT (SELECT C.opn_seq FROM job_work C WHERE C.wor_id = (SELECT job_work_id FROM car_work WHERE wor_id = A.car_work_id)) opnSeq,
    (SELECT C.opn_name FROM job_work C WHERE C.wor_id = (SELECT job_work_id FROM car_work WHERE wor_id = A.car_work_id)) opnName,
    (SELECT D.use_firstname FROM user D WHERE D.user_id = A.user_id) userClick,
    A.clk_break, A.clk_cont, A.break_remark
    FROM `car_break` A
    WHERE (SELECT car_id FROM car_work B WHERE B.wor_id = A.car_work_id ) = '$id'");
     while ($brakeRek = $sql->fetch_assoc())
        {?>
        <tr>
            <td><?php echo $brakeRek['opnSeq']; ?></td>
            <td><?php echo $brakeRek['opnName']; ?></td>
            <td><?php echo $brakeRek['userClick']; ?></td>
            <td><?php 
                $date = date_create($brakeRek['clk_break']);
                $day = date_format($date,"d-M-Y");
                echo $day; ?>
            </td>
            <td><?php
                if (!$brakeRek['clk_cont']) {
                    echo '-' ;
                } else {
                    $date = date_create($brakeRek['clk_cont']);
                $day = date_format($date,"d-M-Y");
                echo $day; 
                }?>
            </td>
            <td><?php echo $brakeRek['break_remark']; ?></td>
        </tr>
         <?php }?>

</table>

<br>วันที่สั่งปริ้น <?php  echo date('Y/m/d H:i:s') ;?>

                <?php 
                $html = ob_get_contents();
                $mpdf->WriteHTML($html);
                $mpdf->Output("ReportSubmodel.pdf");
				header("Location: ReportSubmodel.pdf"); 
                ob_end_flush(); 
                 
                ?>
</body>
</html>