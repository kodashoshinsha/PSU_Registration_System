<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pangasinan State University</title>
    <link href=https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="icon" href="images/psu_logo-removebg-preview.ico">
</head>
<body>
    <div class="container">
        <div class="image">
            <img src="images/psu_logo-removebg-preview.png" alt="PSU Logo">
        </div>
        <div class="PSU">
        <h4>Pangasinan State University</h4>
        </div>
        <br>
    <!-- FORM -->
        <form action="registration_process_admin.php" method="POST">
        <div class="fields">
            <div class="mb-3">
                <input type="text" class="form-control" id="faculty_id" placeholder="ID number" name="id_num" maxlength="10" required>
                <span id="id-status2" style="font-size: 12px;"></span>
            </div>

            <div class="mb-3">
                <input type="email" class="form-control" id="email_admin" placeholder="Email address" name="email" required>
                <span id="email-status2" style="font-size: 12px;"></span>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Firstname" name="firstname" required>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Middlename" name="middlename" required>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Lastname" name="lastname" required>
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password" minlength="8" maxlength="16" required>
            </div>

        <div class="mb-3">
            <select name="college" class="form-select " required>
            <option value="" disabled selected hidden>Department</option>
            <optgroup label="College of Arts and Education">
            <option value="English Department">English Department</option>
                <option value="Teacher Education Department">Teacher Education Department</option>
            <optgroup label="College of Computing">
                <option value="Information Technology Department">Information Technology Department</option>
                <option value="Mathematics Department">Mathematics Department</option>
            <optgroup label="College of Engineering and Architecture">
                <option value="Engineering Department">Engineering Department</option>
                <option value="Architecture Department">Architecture Department</option>
            </select>
        </div>
        </div>
        <br>
        <div class="form-check form-check-inline">
            <input name="gender" class="form-check-input" type="radio" required id="inlineRadio1" value="Male">
            <label class="form-check-label" for="inlineRadio1">Male</label>
            </div>

            <div class="form-check form-check-inline">
            <input name="gender" class="form-check-input" type="radio" required id="inlineRadio2" value="Female">
            <label class="form-check-label" for="inlineRadio2">Female</label>
            </div>

            <div class="form-check form-check-inline">
            <input name="gender" class="form-check-input" type="radio" required id="inlineRadio3" value="Other">
            <label class="form-check-label" for="inlineRadio3">Other</label>
            </div>

            <br>
            <br>
            <div class="d-grid gap-2 mx-auto">
            <button name="register" class="btn btn-primary btn-lg" id="reg-btn" type="submit">Register</button>
            </div>

            <br>
            <div style="columns:2 auto;">
                <p>Already have an account? <a href="login_admin.php" style="text-decoration:none;">Login</a></p>
                <p>Register as  <a href="registration_student.php" style="text-decoration:none;">Student</a> </p>
            </div>
            </div>
        </form>
    <!-- END OF FORM -->        
    </div>

    <script src="js/script.js"></script>
</body>
</html>

<?php
include "footer.php";
?>