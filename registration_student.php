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
        <form action="registration_process_student.php" method="POST">
        <div class="fields">
            <div class="mb-3">
                <input type="text" class="form-control" id="student_id" placeholder="ID number" name="id_num" maxlength="10" required>
                <span id="id-status" style="font-size: 12px;"></span>
            </div>

            <div class="mb-3">
                <input type="email" class="form-control" id="email" placeholder="Email address" name="email" required>
                <span id="email-status" style="font-size: 12px;"></span>
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
                <input type="password" class="form-control" placeholder="Password" id="pass" name="password" minlength="8" required>
                <span id="pass-status" style="font-size: 12px;"></span>
            </div>

        <div class="mb-3">
            <select name="course" class="form-select " required>
            <option value="" disabled selected hidden>Course</option>
            <optgroup label="College of Arts and Education">
            <option value="Bachelor of Arts in English Language">Bachelor of Arts in English Language</option>
                <option value="Bachelor of Early Childhood Education">Bachelor of Early Childhood Education</option>
                <option value="Bachelor of Science in Education Major in Filipino">Bachelor of Science in Education Major in Filipino</option>
                <option value="Bachelor of Science in Education Major in Science">Bachelor of Science in Education Major in Science</option>
            <optgroup label="College of Computing">
                <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                <option value="Bachelor of Science in Mathematics">Bachelor of Science in Mathematics</option>
            <optgroup label="College of Engineering and Architecture">
                <option value="Bachelor of Science in Architecture">Bachelor of Science in Architecture</option>
                <option value="Bachelor of Science in Civil Engineering">Bachelor of Science in Civil Engineering</option>
                <option value="Bachelor of Science in Computer Engineering">Bachelor of Science in Computer Engineering</option>
                <option value="Bachelor of Science in Electrical Engineering">Bachelor of Science in Electrical Engineering</option>
                <option value="Bachelor of Science in Mechanical Engineering">Bachelor of Science in Mechanical Engineering</option>
            </select>
        </div>

        <div class="mb-3">
            <select name="yearlevel" class="form-select" required>
            <option value="" disabled selected hidden>Year</option>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
                <option value="5th Year">5th Year</option>
                <option value="6th Year">6th Year</option>
                <option value="7th Year">7th Year</option>
                <option value="8th Year">8th Year</option>
            </select>
        </div>
        </div>

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
                <p>Already have an account? <a href="login_student.php" style="text-decoration:none;">Login</a></p>
                <p>Register as  <a href="registration_admin.php" style="text-decoration:none;">Admin</a> </p>
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