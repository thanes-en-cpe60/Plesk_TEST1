<?php
session_start();
include('server.php');
if (!$_SESSION["use_firstname"]) {
  header('location: login.php?err=1');
}
if (isset($_GET['logout'])) {
  session_destroy();
  header('location: login.php');
}
if(isset($_GET['err'])){
  if ($_GET['err'] == 1)
  {
    echo "<SCRIPT> //showing me
        alert('! มี User_id นี้อยู่แล้ว กรุณากรอก user id ใหม่ !');
        </SCRIPT>";
  }
  else
  {
    echo "<SCRIPT> //showing me
        alert('ระบบเกิดข้อผิดพลาด');
        </SCRIPT>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลสรุป</title>

    <style>

        #chart-container {
            width: 100%;
            height: auto;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" href="fontawesome/fa.css">
</head>
<body>
    
        <div class="wrapper">

<!-- ------------------------------- Header -------------------------------- -->

            <div class="layout"> 
                <header class="navbar bg-white py-2">
                    <div class="container-fluid justify-content-between align-items-center">
                        <div class="nav col-4">
                            <nav>
                                <span class="nav-toggle" id="js-nav">
                                  <button type="button" id="sidebarCollapse" class="btn">
                                    <i class="icon fas fa-bars"></i>
                                  </button>          
                                </span>
                            </nav>
                        </div>
                        <div class="text-center col-4">
                            <div class="logo">
                                <img src="img/logo.png" alt width="140" height="50">
                            </div>
                        </div>
                        <div class="account d-flex justify-content-end col-4">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="icon fas fa-user-circle"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                  <h6 class="dropdown-header">ชื่อผู้ใช้:<?php echo $_SESSION["use_firstname"].".".$_SESSION["use_lastname"] ?></h6>
                                  <h6 class="dropdown-header">สิทธิ์:<?php if ( $_SESSION["use_role"] == 'A') {
                                    echo"Admin";
                                  }elseif ($_SESSION["use_role"] == 'U') {
                                    echo "User";
                                  }elseif ($_SESSION["use_role"] == 'R') {
                                    echo "Read only";
                                  } ?></h6>
									<a href="my_edit.php" class="nav-link">
                                  <i class="fas fa-fw fa-cog"></i>
                                  ตั้งค่า</a>
                                  <div class="dropdown-divider"></div>
                                  <div class="btn-logout">
                                  <button type="button" class="btn btn-outline-danger btn-sm btn-block " onclick="window.location.href='index.php?logout'" >ลงชื่อออก</button>
                                  </div>                          
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>

<!-- ------------------------------- Sidebar ------------------------------- -->

            <div class="layout" id="sidebar">
  
                    <ul class="list-unstyled components">
                        <li class="nav-item">
                           <a class="nav-link" href="index.php">
                              <i class="fas fa-file"></i>
                              ตารางงาน
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="addwork.php">
                              <i class="fas fa-file"></i>
                              เพิ่มงาน
                            </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="history_work.php" >
                                <i class="fas fa-file-invoice"></i>
                                ประวัติงาน
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#" >
                                <i class="fas fa-file-invoice"></i>
                                ประวัติรถ
                              </a>
                          </li>
            
                          <br>
            
                          <li class="nav-item">
                              <a class="nav-link" href="model.php" >
                                <i class="fas fa-car"></i>
                                <span>โมเดลรถ</span>
                              </a>
                          </li>
            
                          <br>
            
                          <li class="nav-item">
                              <a class="nav-link" href="customer.php" >
                                <i class="fas fa-id-card"></i>
                                <span>ข้อมูลลูกค้า</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="technical.php" >
                                <i class="fas fa-id-card"></i>
                                <span>ข้อมูลช่าง</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="user.php" >
                                <i class="fas fa-id-card"></i>
                                <span>ข้อมูลบุคลากร</span>
                              </a>
                          </li>
            
                          <br>
            
                          <li class="nav-item active">
                              <a class="nav-link" href="conclusion.php" >
                                <i class="fas fa-fw fa-cog"></i>
                                <span>ผลประกอบการ</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="conclusion_tec.php" >
                                <i class="fas fa-fw fa-cog"></i>
                                <span>ผลการทำงานช่าง</span>
                              </a>
                          </li>             
                    </ul>
  
            </div>

<!-- -------------------------------- Main --------------------------------- -->

            <div class="layout">
              <h3>ผลสรุปยอดสั่งผลิตรถต่อโมเดล</h3>

              <div class="header-top row">
                <div class="col-12 mt-3">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" id="mode-tab" href="conclusion.php">โมเดล</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="model-sub-tab" href="conclusion_cus.php">ลูกค้า</a>
                    </li>
                  </ul>           
                </div>
              </div>

              <div class="row">
                <div class="col-12 pt-3">
                  <div class="main float-right">                  
                    <div class="form-row align-items-center">                      
                      <div class="form-inline">
                        <form class="form-inline" action="car_all.php" method="POST" id="testform">
                          <div class="col-auto my-1">
                            <label class="mr-sm-2 justify-content-start" for="date_start">ตั้งแต่วันที่</label>
                            <input class="form-control mr-sm-2" type="date" name="date_start" id="date_start" onchange="">
                          </div>
                          <div class="col-auto my-1">
                            <label class="mr-sm-2 justify-content-start" for="date_end">ถึงวันที่</label>
                            <input class="form-control mr-sm-2" type="date" name="date_end" id="date_end" onchange="">
                          </div>
                        </form>
                        <div class="col-auto my-1">
                          <br>
                          <input type="submit" class="btn btn-primary px-4 float-right" name="submit_search" id="submit_search11" value="ค้นหา">
                        </div>
                      </div>              
                    </div>                    
                  </div>
                </div>
              </div>

              <div class="row pt-3">
                <div class="col-12">                      
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">กราฟผลสรุป</h5>
                      </div>
                      <div class="modal-body">
                        <div id="chart-container">
                            <canvas id="graphCanvas" height="15vh" width="50vw"></canvas>
                        </div>    
                      </div>
                    </div>
                  </div>                              
              </div>
            </div>   

</div>


<!-- ----------------------------------------------------------------------- -->
<!--                                   End                                   -->
<!-- ----------------------------------------------------------------------- -->

        
    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/fa.js"></script>
    <script src="js/script.js"></script>  
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script> //chart bar
        $(submit_search11).click(function() {
            showGraph();
        });
        function showGraph(){
            {
                $.post("car_all.php",$("#testform" ).serialize(),  function(data) {
                    console.log(data);
                    let name = [];
                    let score = [];
                    for (let i in data) {
                        name.push(data[i].mod_id);
                        score.push(data[i].nCar);
                    }
                    let chartdata = {
                        labels: name,
                        datasets: [{
                                label: 'จำนวนคันที่ผลิต',
                                backgroundColor: '#F0B27A',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: score
                        }]
                    };

                    var options = {
                        animation: false,
                        ///Boolean - Whether grid lines are shown across the chart
                        scaleShowGridLines : true,
                        //Boolean - Whether to show vertical lines (except Y axis)
                        scaleShowVerticalLines: true,
                        showTooltips: false
                    };


                    let graphTarget = $('#graphCanvas');
                    let barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                        layout: {
                          padding: 10,
                        },        
                        scales: {
                          yAxes: [{
                              display: true,
                              ticks: {
                                  suggestedMin: ,    // minimum will be 0, unless there is a lower value.
                                  // OR //
                                  beginAtZero: true   // minimum value will be 0.
                              }
                          }]
                        
                        }
                      }
                    })
                })
            }
        }
    </script>

    <script type="text/javascript"> //Hamberger menu
      $(document).ready(function () {
         

          $('#sidebarCollapse').on('click', function () {
              $('#sidebar, #content').toggleClass('active');
              $('.collapse.in').toggleClass('in');
              $('a[aria-expanded=true]').attr('aria-expanded', 'false');
          });

          $('#filterCollapse').on('click', function () {
              $('#filter, #content').toggleClass('active');
              $('.collapse.in').toggleClass('in');
              $('a[aria-expanded=true]').attr('aria-expanded', 'false');
          });
      });
      </script>

    
</body>
</html>