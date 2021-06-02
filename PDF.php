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
if(isset($_GET['sub_id']))
{
 $id = $_GET['sub_id'];
  
include('server.php');
    $sql_top = mysqli_query($conn, "SELECT sub_name FROM `submodel`  WHERE sub_id = $id");
    $data = $sql_top->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	}
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlanPDF</title>
    <a href="ReportModel.pdf" target="_blank" >Print this from</a>
</head>
<?php ob_start() ?>
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

        
</style>
<body>
    <img src="Piroon3.png" alt="header" style="width:100%;"   >
        <h4>ตารางการประกอบรถ....<?php  echo $data['sub_name'] ?>....</h4>
<table style="width:100%"  >
    <tr>
        <th>ลำดับ</th>
        <th>ขั้นตอน</th>

        <?php
        $sql_head = mysqli_query($conn, "SELECT SUM(opn_duration) nAll FROM `submodel_opn`  WHERE sub_id = '$id'");
        $row = $sql_head->fetch_assoc();
        $c_All = $row['nAll'];
        
        $colum = 1 ; 
        while ($colum <= $c_All) {
            // $format = ($colum-1)."days"; 
            // $date = date_create(date('Y-m-d'));
            // date_add($date, date_interval_create_from_date_string("$format"));
            // $day = date_format($date,"d-M");
            echo "<th>$colum</th>";
            $colum++;
        }
        ?>
    </tr>
    </tr>
    
        <?php
            $sql = mysqli_query($conn, "SELECT A.opn_seq ,A.opn_name,(SELECT SUM(B.opn_duration)FROM `submodel_opn` B WHERE B.sub_id = '$id' )nAll, A.opn_duration FROM `submodel_opn` A WHERE A.sub_id = '$id'order by A.opn_seq ");
            $slash = 0;
            while ($row = $sql->fetch_assoc()) {
                $block = null ; 
                $num = $row['opn_seq'];
                $text = $row['opn_name'];
                $max_day = $row['nAll'];
                $day = $row['opn_duration'];
                $q = 1 ;
                $day = $day + $slash;
                while ($q <= $max_day) {
                    if($q <= $slash ) {
                        $mark = "<th>  </th>";
                    }
                    elseif ($q <= $day) {
                        $mark = "<th>P</th>";
                        
                        $slash++;
                        //--debug $q----- 
                        // echo $q . " ";
                    }
                    else {
                        
                        $mark = "<th>  </th>";
                    }
                    //-------
                    $block = $block.$mark;
                    
                    $q++;
                    
                }
                echo "<tr><th>$num</th><th>$text</th>$block</tr>" ;
                //--debug $q 
                // echo "|" ;
        }
        ?>
        
</table>
P = Plan/แผน
                <?php 
                $html = ob_get_contents();
                $mpdf->WriteHTML($html);
                $mpdf->Output("ReportModel.pdf");
                header("Location:ReportModel.pdf");  
                ob_end_flush(); 
                ?>
</body>
</html>
