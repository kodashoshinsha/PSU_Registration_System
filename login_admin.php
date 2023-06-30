<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="icon" href="images/psu_logo-removebg-preview.ico">
    <title>Pangasinan State University</title>
</head>
<body>
    <div class="container-login">
        <div class="image">
            <img src="images/psu_logo-removebg-preview.png" alt="PSU Logo">
        </div>
        <div class="PSU">
        <h4>Pangasinan State University</h4>
        </div>
        <br>
    <!-- FORM -->
        <form action="login_process_admin.php" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="ID number" name="fc_id" required maxlength="10">
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>

            <div class="d-grid gap-2 mx-auto">
            <button name="login" class="btn btn-primary btn-lg" id="log-btn-a" type="submit">Login</button>
            </div>

            <br>
            <p>Login as  <a href="login_student.php" style="text-decoration:none;">Student</a> </p>
            <p>Don't have an account? <a href="registration_admin.php" style="text-decoration:none;">Register</a></p>
            <br>
            <p><a href="forgot_password.php" style="text-decoration:none;" target="_blank">Forgot password</a></p>
    </div>
</body>
</html>

<?php
include "footer.php";
?>