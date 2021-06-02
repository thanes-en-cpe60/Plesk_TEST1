<?php 
    header('Content-Type: application/json');

    include('server.php');

    $sqlQuery = "SELECT B.mod_id , COUNT(A.car_id) nCar 
    FROM `car`A ,job B 
    WHERE car_status = 'F' AND A.job_id = B.job_id AND A.last_opn_date BETWEEN '".$_POST["date_start"]."' AND '".$_POST["date_end"]."' 
    GROUP BY B.mod_id ORDER BY nCar DESC";
    $result = mysqli_query($conn,$sqlQuery);

    $data = array();
    foreach ($result as $row) {
        $data[] = $row;
    }
    
    mysqli_close($conn);
    
    echo json_encode($data);
    ?>
