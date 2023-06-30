<?php
session_start();
include 'connection.php';
if(!isset($_SESSION['admin_login_id'])) {
    header('location:login_admin.php');
}

$admin_ID = $_SESSION['admin_login_id'];
$admin_fname = $_SESSION['admin_fname'];
$admin_mname = $_SESSION['admin_mname'];
$admin_lname = $_SESSION['admin_lname'];
$admin_college = $_SESSION['department'];

// Pagination configuration
$resultsPerPage = 10;
$currentPage = 1;
if(isset($_GET['page'])) {
    $currentPage = $_GET['page'];
}
$start = ($currentPage - 1) * $resultsPerPage;

// Search functionality
$search = '';
if(isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Retrieve admin records with pagination and search
$sql = "SELECT * FROM admin WHERE id_num LIKE '%$search%' OR firstname LIKE '%$search%' OR middlename LIKE '%$search%' OR lastname LIKE '%$search%' 
OR college LIKE '%$search%' OR gender LIKE '%$search%' OR date_registered LIKE '%$search%' LIMIT $start, $resultsPerPage";
$result = $con->query($sql);

// Retrieve total number of admin records for pagination calculation
$totalRecords = $con->query("SELECT COUNT(*) as count FROM admin WHERE id_num LIKE '%$search%' OR firstname LIKE '%$search%' OR middlename LIKE '%$search%' OR lastname LIKE '%$search%'
OR college LIKE '%$search%' OR gender LIKE '%$search%' OR date_registered LIKE '%$search%'")->fetch_assoc()['count'];
$totalPages = ceil($totalRecords / $resultsPerPage);

?>

<!DOCTYPE html>
<html lang="en">
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
        <div class="sidebar-item">
        <a href="index_admin.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-user" style="margin-right:1em;"></i>Profile</a>
        </div>
        <div class="sidebar-item">
        <a href="index_admin_dashboard.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-chart-simple" style="color: #ffffff;margin-right:15px;"></i></i>Dashboard</a> <br>
        </div>
        <div class="sidebar-item">
        <a href="index_admin_student_table.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-table" style="color: #ffffff;margin-right:15px;"></i>Student Table</a> <br>
        </div>
        <div id="active">
        <a href="index_admin_admin_table.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-table" style="color: #ffffff;margin-right:15px;"></i>Admin Table</a> <br>
        </div>
        <div class="sidebar-item">
        <a href="login_admin.php" style="color:white;margin-left:10%;text-decoration:none;"><i class="fa-solid fa-right-from-bracket fa-flip-horizontal" style="color: #ffffff;margin-right:15px;"></i>Log out</a>
        </div>
    </div>
<div class="content" style="height:100%;">
        <?php 
            echo "<h5>$admin_ID</h5>";
            echo "<h5>$admin_fname $admin_mname $admin_lname</h5>";
            echo "<em>$admin_college</em><br>";
        ?>
        <hr style="height:2px;">
        <h5>Admin Table Record</h5>
        <div class="container-tb">
            <table class="table table-hover table-borderless">
                <thead>
                    <tr>
                    <th scope="col">ID no.</th>
                    <th scope="col">First name</th>
                    <th scope="col">Middle name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Date registered</th>
                    </tr>
                </thead>

                <tbody>
                
    <div class="container-tb">
        <!-- Search form -->
        <form action="" method="GET">
            <div class="mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo $search; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
<?php
                    if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                ?>
                    <tr>
                    <td><?php echo $row['id_num']; ?></td>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['middlename']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['college']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['date_registered']; ?></td>
                    </tr>    

                <?php       
                    }

                    }
                    else {
                        echo "No admin record found";
                    }

                ?>                
                </tbody>
            </table>
            <ul class="pagination">
            <?php if($currentPage > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo $search; ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if($currentPage < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo $search; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
        </div>

    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>