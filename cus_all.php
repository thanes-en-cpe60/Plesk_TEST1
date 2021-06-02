<?php 
    header('Content-Type: application/json');
	include('server.php');

    //$conn = new mysqli('27.254.172.62:3306', 'PiroonAssembly','JoB0847807291', 'sql_assembly');

    $sqlQuery = "SELECT B.cus_id ,(SELECT cus_name FROM customer WHERE cus_id = B.cus_id) CusName, 
    COUNT(A.car_id) nCar
    FROM `car`A ,job B
    WHERE car_status = 'F' AND A.job_id = B.job_id AND A.last_opn_date BETWEEN '".$_POST["date_start"]."' AND '".$_POST["date_end"]."'
    GROUP BY B.cus_id 
    ORDER BY nCar DESC";
    $result = mysqli_query($conn,$sqlQuery);

    $data = array();
    foreach ($result as $row) {
        $data[] = $row;
    }
    
    mysqli_close($conn);
    
    echo json_encode($data);
    ?>
