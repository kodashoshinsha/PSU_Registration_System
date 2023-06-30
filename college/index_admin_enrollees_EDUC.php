<?php
session_start();
include '../connection.php';
if(!isset($_SESSION ['admin_login_id'])) {
    header('location:login_admin.php');
}
$admin_ID = $_SESSION ['admin_login_id'];
$admin_fname = $_SESSION ['admin_fname'];
$admin_mname = $_SESSION ['admin_mname'];
$admin_lname = $_SESSION ['admin_lname'];
$admin_college = $_SESSION ['department'];

$sql = "SELECT yearlevel, COUNT(*) AS count FROM student WHERE course = 'Bachelor of Science in Education Major in Filipino' GROUP BY yearlevel;";
$result = mysqli_query($con, $sql);
$data = array();
while ($row = mysqli_fetch_array($result)) {
  $data[$row['yearlevel']] = $row['count'];
  }
$labels = array_keys($data);
$values = array_values($data);

$sql2 = "SELECT yearlevel, COUNT(*) AS count FROM student WHERE course = 'Bachelor of Science in Education Major in Science' GROUP BY yearlevel";
$result2 = mysqli_query($con, $sql2);
$data2 = array();
while ($row = mysqli_fetch_array($result2)) {
  $data2[$row['yearlevel']] = $row['count'];
  }
$labels2 = array_keys($data2);
$values2 = array_values($data2);

$sql3 = "SELECT gender,COUNT(*) as gender_count FROM student WHERE date_registered >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY gender";
$result3 = mysqli_query($con, $sql3);
$data3 = array();
while ($row = mysqli_fetch_array($result3)) {
  $data3[$row['gender']] = $row['gender_count'];
  }
$labels3 = array_keys($data3);
$values3 = array_values($data3);

mysqli_close($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="icon" href="../images/psu_logo-removebg-preview.ico">
    <title>Pangasinan State University</title>
    <script src="https://kit.fontawesome.com/31b6b547f0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <div class="sidebar">
        <img src="../images/PSU roar-modified.png" alt="PSU Logo">
        <h5>Pangasinan State University</h5>
        <div class="sidebar-item">
        <a href="../index_admin.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-user" style="margin-right:1em;"></i>Profile</a>
        </div>
        <div id="active">
        <a href="../index_admin_dashboard.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-chart-simple" style="color: #ffffff;margin-right:15px;"></i></i>Dashboard</a> <br>
        </div>
        <div class="sidebar-item">
        <a href="../index_admin_student_table.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-table" style="color: #ffffff;margin-right:15px;"></i>Student Table</a> <br>
        </div>
        <div class="sidebar-item">
        <a href="../index_admin_admin_table.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-table" style="color: #ffffff;margin-right:15px;"></i>Admin Table</a> <br>
        </div>
        <div class="sidebar-item">
        <a href="../login_admin.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal" style="color: #ffffff;margin-right:15px;"></i>Log out</a>
        </div>
    </div>
  
    <div class="content" >
        <?php 
            echo "<h5>$admin_ID</h5>";
            echo "<h5>$admin_fname $admin_mname $admin_lname</h5>";
            echo "<em>$admin_college</em><br>";
        ?>
        <hr style="height:2px;">
        <h5>Enrollees</h5>
        <div class="search-bar" style="display:flex; justify-content:center; gap:10px;">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" style="padding-bottom: 6%;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Sort by
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="../index_admin_enrollees.php" id="twentyeight_days">College of Computing</a></li>
                    <li><a class="dropdown-item" href="index_admin_enrollees_ENG.php" id="twentyeight_days">College of Engineering and Architecture</a></li>
                    <li><a class="dropdown-item" href="#" id="month">College of Arts and Education</a></li>
                </ul>
            </div>
	    </div>
        <br>
        <!-- BSEDFIL CHART -->
           <div class="chart2">
                <div class="chart-header5">
                    <span style="padding-left:1%;font-size:large;color:white;">Bachelor of Science in Education Major in Filipino</span>
                    <button type="button" class="btn btn-primary" id="btnbar" onclick="toggleElements('bar')" style="color:white;margin-left:43%">Bar Chart</button>
                    <button type="button" class="btn btn-info" id="btnline" onclick="toggleElements('line')" style="color:white;margin-left:0%">Line Chart</button>
                </div>
                <div id="yearBar">
                    <canvas id="yearlevelBar" style="background-color: white; border-radius:0px;padding:2%"></canvas>
                </div>
                <div id="yearLine" class="hidden">
                    <canvas id="yearlevelLine" style="background-color: white; border-radius:0px;padding:2%"></canvas>
                </div>
            </div>

<script>
    var chart_Today;
    var chart_line;

    window.onload = function() {
        var yearBarElement = document.getElementById('yearBar');
        var yearLineElement = document.getElementById('yearLine');

        yearBarElement.classList.remove('hidden');
        yearLineElement.classList.add('hidden');

        var ctx = document.getElementById('yearlevelBar').getContext('2d');
        chart_Today = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label:'Number of Enrollees',
                    data: <?php echo json_encode($values); ?>,
                    backgroundColor: [
                        '#0080FF'

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
    };

    function toggleElements(chartType) {
        var yearBarElement = document.getElementById('yearBar');
        var yearLineElement = document.getElementById('yearLine');

        if (chartType === 'bar') {
            yearBarElement.classList.remove('hidden');
            yearLineElement.classList.add('hidden');

            if (!chart_Today) {
                var ctx = document.getElementById('yearlevelBar').getContext('2d');
                chart_Today = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels); ?>,
                        datasets: [{
                            label: 'Number of Enrollees',
                            data: <?php echo json_encode($values); ?>,
                            backgroundColor: [
                                '#FF9B00'
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
            }
            if (chart_line) {
                chart_line.destroy();
                chart_line = null;
            }
        } else if (chartType === 'line') {
            yearBarElement.classList.add('hidden');
            yearLineElement.classList.remove('hidden');

            if (!chart_line) {
                var ctx = document.getElementById('yearlevelLine').getContext('2d');
                chart_line = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels:<?php echo json_encode($labels); ?>,
                        datasets: [{
                            label: 'Number of Enrollees',
                            data: <?php echo json_encode($values); ?>,
                            backgroundColor: [
                                '#FF9B00'
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
            }
            
            // Hide the bar chart if it was previously displayed
            if (chart_Today) {
                chart_Today.destroy();
                chart_Today = null;
            }
        }
    }
</script>
<br>
<!-- BSCOE CHART -->
<div class="chart2">
    <div class="chart-header5">
        <span style="padding-left:1%;font-size:large;color:white;">Bachelor of Science in Education Major in Science</span>
        <button type="button" class="btn btn-primary" id="btnbar" onclick="toggleElements2('bar')" style="color:white;margin-left:43%">Bar Chart</button>
        <button type="button" class="btn btn-info" id="btnline" onclick="toggleElements2('line')" style="color:white;margin-left:0%">Line Chart</button>
    </div>
    <div id="courseBar">
        <canvas id="courselevelBar" style="background-color: white; border-radius:0px;padding:2%"></canvas>
    </div>
    <div id="courseLine" class="hidden">
        <canvas id="courselevelLine" style="background-color: white; border-radius:0px;padding:2%"></canvas>
    </div>
</div>

<script>
    var chart_courseBar;
    var chart_courseLine;

    window.onload = function() {
        var courseBarElement = document.getElementById('courseBar');
        var courseLineElement = document.getElementById('courseLine');

        courseBarElement.classList.remove('hidden');
        courseLineElement.classList.add('hidden');

        var ctx = document.getElementById('courselevelBar').getContext('2d');
        chart_courseBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels2); ?>,
                datasets: [{
                    label: 'Number of Enrollees',
                    data: <?php echo json_encode($values2); ?>,
                    backgroundColor: [
                        '#FF25DB'
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
    };

    function toggleElements2(chartType) {
        var courseBarElement = document.getElementById('courseBar');
        var courseLineElement = document.getElementById('courseLine');

        if (chartType === 'bar') {
            courseBarElement.classList.remove('hidden');
            courseLineElement.classList.add('hidden');

            if (!chart_courseBar) {
                var ctx = document.getElementById('courselevelBar').getContext('2d');
                chart_courseBar = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels2); ?>,
                        datasets: [{
                            label: 'Number of Enrollees',
                            data: <?php echo json_encode($values2); ?>,
                            backgroundColor: [
                                '#FF25DB'
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
            }

            // Hide the line chart if it was previously displayed
            if (chart_courseLine) {
                chart_courseLine.destroy();
                chart_courseLine = null;
            }
        } else if (chartType === 'line') {
            courseBarElement.classList.add('hidden');
            courseLineElement.classList.remove('hidden');

            if (!chart_courseLine) {
                var ctx = document.getElementById('courselevelLine').getContext('2d');
                chart_courseLine = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($labels2); ?>,
                        datasets: [{
                            label: 'Number of Enrollees',
                            data: <?php echo json_encode($values2); ?>,
                            backgroundColor: [
                                '#FF25DB'
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
            }

            // Hide the bar chart if it was previously displayed
            if (chart_courseBar) {
                chart_courseBar.destroy();
                chart_courseBar = null;
            }
        }
    }
</script>
<br>
<!-- GENDER CHART 
<div class="chart2">
    <div class="chart-header3">
        <span style="padding-left:1%;font-size:large;color:white;">Gender</span>
        <button type="button" class="btn btn-primary" id="btnbar" onclick="toggleElements3('bar')" style="color:white;margin-left:72%">Bar Chart</button>
        <button type="button" class="btn btn-info" id="btnline" onclick="toggleElements3('line')" style="color:white;margin-left:0%">Line Chart</button>
    </div>
    <div id="genderBar">
        <canvas id="GenderBar" style="background-color: white; border-radius:0px;padding:2%"></canvas>
    </div>
    <div id="genderLine" class="hidden">
        <canvas id="GenderLine" style="background-color: white; border-radius:0px;padding:2%"></canvas>
    </div>
</div>

<script>
    var chart_genderBar;
    var chart_genderLine;

    window.onload = function() {
        var genderBarElement = document.getElementById('genderBar');
        var genderLineElement = document.getElementById('genderLine');

        genderBarElement.classList.remove('hidden');
        genderLineElement.classList.add('hidden');

        var ctx = document.getElementById('GenderBar').getContext('2d');
        chart_genderBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels3); ?>,
                datasets: [{
                    label: 'Number of Registrant (Gender)',
                    data: <?php echo json_encode($values3); ?>,
                    backgroundColor: [
                        '#259CFF'
                
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
    };

    function toggleElements3(chartType) {
        var genderBarElement = document.getElementById('genderBar');
        var genderLineElement = document.getElementById('genderLine');

        if (chartType === 'bar') {
            genderBarElement.classList.remove('hidden');
            genderLineElement.classList.add('hidden');

            if (!chart_genderBar) {
                var ctx = document.getElementById('GenderBar').getContext('2d');
                chart_genderBar = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels3); ?>,
                        datasets: [{
                            label: 'Number of Registrant (Gender)',
                            data: <?php echo json_encode($values3); ?>,
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
            }

            // Hide the line chart if it was previously displayed
            if (chart_genderLine) {
                chart_genderLine.destroy();
                chart_genderLine = null;
            }
        } else if (chartType === 'line') {
            genderBarElement.classList.add('hidden');
            genderLineElement.classList.remove('hidden');

            if (!chart_genderLine) {
                var ctx = document.getElementById('GenderLine').getContext('2d');
                chart_genderLine = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($labels3); ?>,
                        datasets: [{
                            label: 'Number of Registrant (Gender)',
                            data: <?php echo json_encode($values3); ?>,
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
            }

            // Hide the bar chart if it was previously displayed
            if (chart_genderBar) {
                chart_genderBar.destroy();
                chart_genderBar = null;
            }
        }
    }
</script>-->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>