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
</head>
<body>
    <div class="sidebar">
        <img src="images/PSU roar-modified.png" alt="PSU Logo">
        <h5>Pangasinan State University</h5>
        <div id="active">
        <a href="index_admin.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-user" style="margin-right:1em;"></i>Profile</a>
        </div>
        <div class="sidebar-item">
        <a href="index_admin_dashboard.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-chart-simple" style="color: #ffffff;margin-right:15px;"></i>Dashboard</a> <br>
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
    <div class="content" style="margin-left:16%;width:84%;height:100%;">
        <?php 
            echo "<h5>$admin_ID</h5>";
            echo "<h5>$admin_fname $admin_mname $admin_lname</h5>";
            echo "<em>$admin_college</em><br>";
        ?>
        <hr style="height:2px;">
        <h5>Subjects</h5>

        <div class="accordion accordion-flush" id="accordionExample" style="width:60%;">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Information Management 2 
                </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body" style="padding-top:0px;height:20%;">
                    <div class="container text-center">
                        <div class="row align-items-center">
                            <div class="col">
                            <strong>Tuesday</strong>
                            10:00 - 12:00 PM
                            </div>

                            <div class="col">
                            <strong>Wednesday</strong>
                            11:00 - 12:00 PM
                            </div>

                            <div class="col">
                            <strong>Thursday</strong>
                            2:00 - 5:00 PM
                            </div>

                            <div class="col" style="padding-top:12px;">
                            <strong>Section</strong> <br>
                            3A, 3B, 3C
                            </div>
                    </div>

                </div>
                </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Websystem and Technologies 2
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body" style="padding-top:0px;">
            <div class="container text-center">
                        <div class="row align-items-center">
                            <div class="col">
                            <strong>Tuesday</strong>
                            10:00 - 12:00 PM
                            </div>

                            <div class="col">
                            <strong>Wednesday</strong>
                            11:00 - 12:00 PM
                            </div>

                            <div class="col">
                            <strong>Thursday</strong>
                            2:00 - 5:00 PM
                            </div>
                    </div>

                </div>
            </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Mobile Application and Development 2
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body" style="padding-top:0px;">
                <div class="container text-center">
                        <div class="row align-items-center">
                            <div class="col">
                            <strong>Tuesday</strong>
                            10:00 - 12:00 PM
                            </div>

                            <div class="col">
                            <strong>Wednesday</strong>
                            11:00 - 12:00 PM
                            </div>

                            <div class="col">
                            <strong>Thursday</strong>
                            2:00 - 5:00 PM
                            </div>
                </div>
            </div>
        </div>

        </div>
        

    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>