<?php
session_start();
include 'connection.php';
if(!isset($_SESSION ['admin_login_id'])) {
    header('location:login_admin.php');
}
$admin_ID = $_SESSION ['admin_login_id'];
$admin_fname = $_SESSION ['admin_fname'];
$admin_mname = $_SESSION ['admin_mname'];
$admin_lname = $_SESSION ['admin_lname'];
$admin_college = $_SESSION ['department'];

$sql_registered = "SELECT COUNT(*) AS row_count FROM student;";
$result_count = mysqli_query($con,$sql_registered);
if ($result_count) {
    $row =  mysqli_fetch_assoc($result_count);
    $count = $row['row_count'];
}

$sql_registered2 = "SELECT COUNT(*) AS row_count2 FROM admin;";
$result_count2 = mysqli_query($con,$sql_registered2);
if ($result_count2) {
    $row2 =  mysqli_fetch_assoc($result_count2);
    $count2 = $row2['row_count2'];
}

$sql_logins = "SELECT COUNT(*) AS login_count FROM logins";
$login_count = mysqli_query($con,$sql_logins);
if($login_count) {
    $row3 = mysqli_fetch_assoc($login_count);
    $count_logins = $row3['login_count'];
}

$sql_logins_chart = "SELECT id_num,COUNT(*) as login_count FROM logins WHERE DATE(timestamp) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY id_num;";
$result_logins = mysqli_query($con, $sql_logins_chart);
$data_logins = array();
while ($row = mysqli_fetch_array($result_logins)) {
  $data_logins[$row['id_num']] = $row['login_count'];
 }
$labels_logins = array_keys($data_logins);
$values_logins = array_values($data_logins);

$sql_enrollees = "SELECT course,yearlevel,COUNT(*) AS enrollee_count FROM student GROUP BY course,yearlevel ";
$result_enrollees = mysqli_query($con, $sql_enrollees);
$data_enrollees = array();
while ($row = mysqli_fetch_array($result_enrollees)) {
  $data_enrollees[$row['course']] = $row['enrollee_count'];
 }
$labels_enrollees = array_keys($data_enrollees);
$values_enrollees = array_values($data_enrollees);

//SQL STATEMENT FOR TODAY CHART
 $sql = "SELECT yearlevel,COUNT(*) as count FROM student GROUP BY yearlevel";
 $result = mysqli_query($con, $sql);
 $data = array();
 while ($row = mysqli_fetch_array($result)) {
   $data[$row['yearlevel']] = $row['count'];
  }
 $labels = array_keys($data);
 $values = array_values($data);

 $sql2 = "SELECT course,COUNT(*) as course_count FROM student WHERE DATE(date_registered) = CURDATE() GROUP BY course";
 $result2 = mysqli_query($con, $sql2);
 $data2 = array();
 while ($row = mysqli_fetch_array($result2)) {
   $data2[$row['course']] = $row['course_count'];
  }
 $labels2 = array_keys($data2);
 $values2 = array_values($data2);


/*SQL STATEMENT FOR LAST 7 DAYS CHART
  $sql2 = "SELECT yearlevel,COUNT(*) as count FROM student WHERE date_registered >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY yearlevel";
  $result2 = mysqli_query($con, $sql2);
  $data2 = array();
  while ($row = mysqli_fetch_array($result2)) {
    $data2[$row['yearlevel']] = $row['count'];
    }
  $labels2 = array_keys($data2);
  $values2 = array_values($data2);
*/

//SQL STATEMENT FOR LAST 14 DAYS CHART
  $sql3 = "SELECT gender,COUNT(*) as gender_count FROM student WHERE (date_registered) = CURDATE() GROUP BY gender";
  $result3 = mysqli_query($con, $sql3);
  $data3 = array();
  while ($row = mysqli_fetch_array($result3)) {
    $data3[$row['gender']] = $row['gender_count'];
    }
  $labels3 = array_keys($data3);
  $values3 = array_values($data3);

  $sql3 = "SELECT gender,COUNT(*) as gender_count FROM student WHERE (date_registered) = CURDATE() GROUP BY gender";
  $result3 = mysqli_query($con, $sql3);
  $data3 = array();
  while ($row = mysqli_fetch_array($result3)) {
    $data3[$row['gender']] = $row['gender_count'];
    }
  $labels3 = array_keys($data3);
  $values3 = array_values($data3);

  $sql4 = "SELECT status,COUNT(*) as status_count FROM student WHERE (date_registered) = CURDATE() GROUP BY status";
  $result4 = mysqli_query($con, $sql4);
  $data4 = array();
  while ($row = mysqli_fetch_array($result4)) {
    $data3[$row['status']] = $row['status_count'];
    }
  $labels4 = array_keys($data4);
  $values4 = array_values($data4);

/*SQL STATEMENT FOR LAST 21 DAYS CHART
  $sql4 = "SELECT yearlevel,COUNT(*) as count FROM student
  WHERE date_registered >= DATE_SUB(CURDATE(), INTERVAL 21 DAY) GROUP BY yearlevel
  ";
  $result4 = mysqli_query($con, $sql4);
  $data4 = array();
  while ($row = mysqli_fetch_array($result4)) {
    $data4[$row['yearlevel']] = $row['count'];
    }
  $labels4 = array_keys($data4);
  $values4 = array_values($data4);
*/

//SQL STATEMENT FOR LAST 28 DAYS CHART
 $sql5 = "SELECT yearlevel,COUNT(*) as count FROM student
 WHERE date_registered >= DATE_SUB(CURDATE(), INTERVAL 28 DAY) GROUP BY yearlevel";
 $result5 = mysqli_query($con, $sql5);
 $data5 = array();
 while ($row = mysqli_fetch_array($result5)) {
  $data5[$row['yearlevel']] = $row['count'];
  }
 $labels5 = array_keys($data5);
 $values5 = array_values($data5);  

// SQL STATEMENT FOR MONTHLY 
 $sql6 = "SELECT yearlevel, COUNT(*) AS count, MONTH(date_registered) AS month
 FROM student GROUP BY yearlevel, month ORDER BY month";
 $result6 = mysqli_query($con, $sql6);
 $year = array();
 $yearCounts = array();
 while ($row = mysqli_fetch_assoc($result6)) {
 $year[] = $row['yearlevel'];
 $yearCounts[] = $row['count'];
 $yearMonths[] = $row['month'];
 $month = date("F");
  }

 mysqli_close($con); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="icon" href="images/psu_logo-removebg-preview.ico">
    <title>Pangasinan State University</title>
    <script src="https://kit.fontawesome.com/31b6b547f0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="sidebar">
        <img src="images/PSU roar-modified.png" alt="PSU Logo">
        <h5>Pangasinan State University</h5>
        <div class="sidebar-item">
        <a href="index_admin.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-user" style="margin-right:1em;"></i>Profile</a>
        </div>
        <div id="active">
        <a href="index_admin_dashboard.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-chart-simple" style="color: #ffffff;margin-right:15px;"></i></i>Dashboard</a> <br>
        </div>
        <div class="sidebar-item">
        <a href="index_admin_student_table.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-table" style="color: #ffffff;margin-right:15px;"></i>Student Table</a> <br>
        </div>
        <div class="sidebar-item">
        <a href="index_admin_admin_table.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-table" style="color: #ffffff;margin-right:15px;"></i>Admin Table</a> <br>
        </div>
        <div class="sidebar-item">
        <a href="login_admin.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal" style="color: #ffffff;margin-right:15px;"></i>Log out</a>
        </div>
    </div>
  
    <div class="content" >
        <?php 
            echo "<h5>$admin_ID</h5>";
            echo "<h5>$admin_fname $admin_mname $admin_lname</h5>";
            echo "<em>$admin_college</em><br>";
        ?>
        <hr style="height:2px;">
        <h5>Dashboard</h5>
        <!-- SEARCH RESULTS
        <div class="search-bar" style="display:flex; justify-content:center; gap:10px;">
		    <input type="text" class="form-control" name="search" id="search" placeholder="Search" autocomplete="off" onkeyup="searchKey();" style="padding: 15px; height:43px; width:30%;">
	    </div>

        <br>
        <div id="result"></div>-->
        <br>
        <div class="dashboard-items">
            <div id="recent-registered">
                <!-- <div id="icon">
                <i class="fa-solid fa-user fa-sm" style="color: #5b0085;margin-right:5%;"></i>
                </div>
                <br> -->
                <h5>Registered users</h5>
                <div style="display: flex;">
                <h3 style="margin-left:5%;color:white;"><?php echo $count; ?></h3>
                <span style="margin-left:2%;color:white;">Student</span>

                <h3 style="margin-left:10%;color:white;"><?php echo $count2; ?></h3>
                <span style="margin-left:2.5%;color:white;">Admin</span>
                </div>
                <div class="more-info">
                    <a href="index_admin_registrants.php" style="font-size:14px; color:white; text-decoration: none;">More info</a>
                    <!-- <i class="fa-sharp fa-solid fa-arrow-right fa-sm" style="color: #5b0085"></i> -->
                </div>
            </div>

            <div id="login-history">
                <!-- <div id="icon">
                <i class="fa-solid fa-user fa-sm" style="color: #5b0085;margin-right:5%;"></i>
                </div>
                <br> -->
                <h5>Number of logins</h5>
                <div>
                <h3 style="margin-left:5%;color:white;"><?php echo $count_logins; ?></h3>
                </div>
                <div class="more-info">
                    <a href="index_admin_logins.php" style="font-size:14px; color:white; text-decoration: none;">More info</a>
                    <!-- <i class="fa-sharp fa-solid fa-arrow-right fa-sm" style="color: #5b0085"></i> -->
                </div>
            </div>

            <div id="enrollees">
                <!-- <div id="icon">
                <i class="fa-solid fa-user fa-sm" style="color: #5b0085;margin-right:5%;"></i>
                </div>
                <br> -->
                <h5>Enrollees</h5>
                <div>
                <h3 style="margin-left:5%;color:white;"><?php echo $count; ?></h3>
                </div>
                <div class="more-info">
                    <a href="index_admin_enrollees.php" style="font-size:14px; color:white; text-decoration: none;">More info</a>
                    <!-- <i class="fa-sharp fa-solid fa-arrow-right fa-sm" style="color: #5b0085"></i> -->
                </div>
            </div>
        </div>

        
        <!-- CHART -->
        <!-- TODAY CHART -->  
        <div class="charts">
                <div id="today" style="width: 40%;" >
                    <!-- <div class="chart-header"><h5 style="text-align: center;" >Yearlevel</h5></div> -->
                    <div style="display:flex;">
                    <h5 style="color: white;" >Registered users</h5>
                    <a href="index_admin_registrants.php" style="margin-left:auto;text-decoration:none;color:white;font-size:small">See more</a>
                    </div>
                    <canvas id="chart_Today" style="background-color: white; border-radius:5px;padding:5%;"></canvas>
                    </div>
            <script>
                var ctx = document.getElementById('chart_Today').getContext('2d');
                var chart_Today = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                    label: 'Number of Registrant (Yearlevel)',
                    data: <?php echo json_encode($values); ?>,
                    backgroundColor: [
                        '#0061FF',
                        '#0064FF',
                        '#FF4900',
                        '#6100FF',
                        '#FB00FF',
                        '#FF9B00',
                        '#00FFD4',
                        '#5959C6'
                    ]
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            </script>
            <!-- END OF REGISTERED USERS CHART -->

            <!-- NUMBER OF LOGINS CHART -->
            <div id="seven-days" style="width: 40%;">
            <div style="display:flex;">
                    <h5 style="color: white;">Number of Logins</h5>
                    <a href="index_admin_logins.php" style="margin-left:auto;text-decoration:none;color:white;font-size:14px">See more</a>
                    </div>
                <canvas id="chart_last7days" style="background-color: white; border-radius:5px;padding:5%;"></canvas>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('chart_last7days').getContext('2d');
                var chart_last7days = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($labels_logins); ?>,
                    datasets: [{
                    label: 'Number of Logins',
                    data: <?php echo json_encode($values_logins); ?>,
                    backgroundColor: [
                        '#FB00FF',
                        '#0064FF',
                        '#FF4900',
                        '#6100FF',
                        '#FB00FF',
                        '#FF9B00',
                        '#00FFD4',
                        '#5959C6'
                    ]
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            </script>
        <!-- END OF LOGINS CHART -->

        <!-- ENROLLEES CHART 
                <div id="enrolled" style="width: 40%;" >
                    <div style="display:flex;">
                    <h5 style="color: white;" >Enrolled students</h5>
                    <a href="index_admin_enrollees.php" style="margin-left:auto;text-decoration:none;color:white;font-size:small">See more</a>
                    </div>
                    <canvas id="chart_enrollees" style="background-color: white; border-radius:5px;padding:5%;"></canvas>

                </div>
            <script>
                var ctx = document.getElementById('chart_enrollees').getContext('2d');
                var chart_enrollees = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels_enrollees); ?>,
                    datasets: [{
                    label: 'Number of Registrant (Yearlevel)',
                    data: <?php echo json_encode($values_enrollees); ?>,
                    backgroundColor: [
                        '#0061FF',
                        '#0064FF',
                        '#FF4900',
                        '#6100FF',
                        '#FB00FF',
                        '#FF9B00',
                        '#00FFD4',
                        '#5959C6'
                    ]
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            </script>

         <!-- LAST 14 DAYS CHART 
            <div id="14days" style="width: 40%;">
                <h5 style="text-align: center;">Gender</h5>
                <canvas id="chart_last14days"></canvas>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('chart_last14days').getContext('2d');
                var chart_last14days = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels3); ?>,
                    datasets: [{
                    label: 'Number of Registrant (Gender)',
                    data: <?php echo json_encode($values3); ?>,
                    backgroundColor: [
                        '#5959C6',
                        '#0064FF',
                        '#FF4900',
                        '#6100FF',
                        '#FB00FF',
                        '#FF9B00',
                        '#00FFD4',
                        '#5959C6'
                    ]
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            </script>
            <!-- END OF LAST 14 DAYS CHART -->

            <!-- LAST 21 DAYS CHART 
            <div id="21days" style="width: 40%;">
                <h5 style="text-align: center;">Status</h5>
                <canvas id="chart_last21days"></canvas>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('chart_last21days').getContext('2d');
                var chart_last21days = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels4); ?>,
                    datasets: [{
                    label: 'Number of Registrant (Yearlevel)',
                    data: <?php echo json_encode($values4); ?>,
                    backgroundColor: [
                        '#0061FF',
                        '#0064FF',
                        '#FF4900',
                        '#6100FF',
                        '#FB00FF',
                        '#FF9B00',
                        '#00FFD4',
                        '#5959C6'
                    ]
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            </script> 
            <!-- END OF LAST 21 DAYS CHART -->

            <!-- LAST 28 DAYS CHART -->
            <!-- <div id="28days" style="width: 40%;">
                <h5 style="text-align: center;">Last 28 Days</h5>
                <canvas id="chart_last28days"></canvas>
                <div class="save-chart">
                    <button type="button" class="btn btn-primary btn-sm">Save as PNG</button>
                    <button type="button" class="btn btn-success btn-sm">Save as Excel</button>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('chart_last28days').getContext('2d');
                var chart_last28days = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels4); ?>,
                    datasets: [{
                    label: 'Number of Registrant (Yearlevel)',
                    data: <?php echo json_encode($values4); ?>,
                    backgroundColor: [
                        '#0061FF',
                        '#0064FF',
                        '#FF4900',
                        '#6100FF',
                        '#FB00FF',
                        '#FF9B00',
                        '#00FFD4',
                        '#5959C6'
                    ]
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            </script> -->
            <!-- END OF LAST 28 DAYS CHART -->

            <!-- MONTH CHART -->
            <!-- <div id="month" style="width: 40%;">
                <h5 style="text-align: center;">Current Month</h5>
                <canvas id="chart_month"></canvas>
                <div class="save-chart">
                    <button type="button" class="btn btn-primary btn-sm">Save as PNG</button>
                    <button type="button" class="btn btn-success btn-sm">Save as Excel</button>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('chart_month').getContext('2d');
                var chart_month = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($year); ?>,
                    datasets: [{
                    label: 'Number of Registrant (Yearlevel)',
                    data: <?php echo json_encode($yearCounts); ?>,
                    backgroundColor: [
                        '#0061FF',
                        '#0064FF',
                        '#FF4900',
                        '#6100FF',
                        '#FB00FF',
                        '#FF9B00',
                        '#00FFD4',
                        '#5959C6'
                    ]
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            </script> -->
            <!-- END OF MONTH CHART -->

    </div>
            <!-- END OF CHART -->

    <script src="js/script.js"></script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>