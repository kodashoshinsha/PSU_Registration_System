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

$sql_logins = "SELECT id_num,timestamp,COUNT(*) AS login_count FROM logins WHERE DATE(timestamp) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) GROUP BY id_num
;";
$login_count = mysqli_query($con,$sql_logins);
$data = array();
while ($row = mysqli_fetch_assoc($login_count)) {
    $data[] = array(
        'id_num' => $row['id_num'],
        'timestamp' => $row['timestamp'],
        'login_count' => $row['login_count']
    );
}

$sql_logins2 = "SELECT ip_address,timestamp,COUNT(*) AS login_count2 FROM logins WHERE DATE(timestamp) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) GROUP BY ip_address
;";
$login_count2 = mysqli_query($con,$sql_logins2);
$data2 = array();
while ($row2 = mysqli_fetch_assoc($login_count2)) {
    $data2[] = array(
        'ip_address' => $row2['ip_address'],
        'timestamp' => $row2['timestamp'],
        'login_count2' => $row2['login_count2']
    );
}

$sql_logins3 = "SELECT CONCAT_WS(' ', firstname, middlename, lastname) AS full_name, DATE(timestamp) AS login_date, COUNT(*) AS login_count3 FROM 
logins WHERE DATE(timestamp) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) GROUP BY full_name, login_date;";
$login_count3 = mysqli_query($con,$sql_logins3);
$data3 = array();
while ($row3 = mysqli_fetch_assoc($login_count3)) {
    $data3[] = array(
        'full_name' => $row3['full_name'],
        'login_date' => $row3['login_date'],
        'login_count3' => $row3['login_count3']
    );
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
        <div class="search-bar" style="display:flex; justify-content:center; gap:10px;">
            <!-- END OF  SEARCH BAR -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" style="padding-bottom: 6%;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Last 24 hours
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="daterange/index_admin_logins_48hours.php" id="twentyeight_days" onclick="selectdate('seven')">Last 48 hours</a></li>
                    <li><a class="dropdown-item" href="#" id="twentyeight_days" onclick="selectdate('twenty_eight')">Last 3 days</a></li>
                    <li><a class="dropdown-item" href="#" id="month" onclick="selectdate('month')">Last 5 days</a></li>
                    <li><a class="dropdown-item" href="#" id="custome" onclick="selectdate('custom')">Custom</a></li>
                    
                </ul>
            </div>
	    </div>
        <h5>Number of logins</h5>
        <div class="chart2">
                <div class="chart-header4">
                    <span style="padding-left:1%;font-size:large;color:white;">ID number</span>
    
                </div>
                <div id="loginchart">
                    <canvas id="login_chart" style="background-color: white; border-radius:0px;padding:2%"></canvas>
                </div>
            </div>

<script>
var ctx = document.getElementById('login_chart').getContext('2d');
var chartData = <?php echo json_encode($data); ?>;

var labels = chartData.map(function(item) {
    return item.id_num + ' - ' + item.timestamp;
});

var counts = chartData.map(function(item) {
    return item.login_count;
});

var chart_login = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Number of Logins (ID Number)',
            data: counts,
            backgroundColor: '#6100FF'
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

<br>

<div class="chart2">
                <div class="chart-header4">
                    <span style="padding-left:1%;font-size:large;color:white;">IP Address</span>
                </div>
                <div id="loginchart2">
                    <canvas id="login_chart2" style="background-color: white; border-radius:0px;padding:2%"></canvas>
                </div>
</div>

<script>
var ctx = document.getElementById('login_chart2').getContext('2d');
var chartData2 = <?php echo json_encode($data2); ?>;

var labels2 = chartData2.map(function(item) {
    return item.ip_address + ' - ' + item.timestamp;
});

var counts2 = chartData2.map(function(item) {
    return item.login_count2;
});

var chart_login2 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels2,
        datasets: [{
            label: 'Number of Logins (IP Address)',
            data: counts2,
            backgroundColor: '#F3FF00'
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

<br>

<div class="chart2">
                <div class="chart-header4">
                    <span style="padding-left:1%;font-size:large;color:white;">Name</span>
                </div>
                <div id="loginchart3">
                    <canvas id="login_chart3" style="background-color: white; border-radius:0px;padding:2%"></canvas>
                </div>
</div>

<script>
var ctx = document.getElementById('login_chart3').getContext('2d');
var chartData3 = <?php echo json_encode($data3); ?>;

var labels3 = chartData3.map(function(item) {
    return item.full_name + ' - ' + item.login_date;
});

var counts3 = chartData3.map(function(item) {
    return item.login_count3;
});

var chart_login3 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels3,
        datasets: [{
            label: 'Number of Logins (Name)',
            data: counts3,
            backgroundColor: '#FF0004'
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

</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>
    