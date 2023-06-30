<?php  
    ob_start();
    session_start();
    include ('connection.php');
    if (isset($_POST['login']) && isset($_POST['id_num']) && isset($_POST['password'])) {
        // removes backslashes
        function validate($data){

          $data = trim($data);
   
          $data = stripslashes($data);
   
          $data = htmlspecialchars($data);
   
          return $data;
   
       }
   
       $sID = validate($_POST['id_num']);
       $pass = validate($_POST['password']);
           $sql = "SELECT * FROM student WHERE id_num='$sID'";   
           $result = mysqli_query($con, $sql);
   
           if (mysqli_num_rows($result) === 1) {
            
               $row = mysqli_fetch_assoc($result);
               $hashed_password = $row['password'];
               $fname = $row['firstname'];
               $mname = $row['middlename'];
               $lname = $row['lastname'];
               $course = $row['course'];
               $year = $row['yearlevel'];
               $verified = $row['status']; 
               if ($row['id_num'] === $sID && password_verify($pass, $hashed_password) && $verified == "Not verified") {
                   header("Location: unverified_email.php");
                   exit();
               }
                else if ($row['id_num'] === $sID && password_verify($pass, $hashed_password))
            {
               if(mysqli_num_rows($result) == 1) { 
                // $user_id = mysqli_fetch_assoc($result)['student_id'];
                $user_id = $row['id_num'];
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $timestamp = date('Y-m-d h:i H', strtotime('+6 hours'));
                $sql = "INSERT INTO logins(id_num,login_id,firstname, middlename, lastname, ip_address, timestamp) VALUES ('$user_id','','$fname', '$mname', '$lname', '$ip_address', '$timestamp')";
                mysqli_query($con, $sql);
                header("Location: index_student.php");
                $_SESSION ['log_in'] = true;
                $_SESSION ['login_id'] = $sID;
                $_SESSION ['fname'] = $fname;
                $_SESSION ['mname'] = $mname;
                $_SESSION ['lname'] = $lname;
                $_SESSION ['course'] = $course;
                $_SESSION ['year'] = $year;
                exit();
            }
            }
            else {
                echo "<html>
                <head>
                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'>
                <link rel='icon' type='image/x-icon' href='images/psu_logo-removebg-preview.ico' />
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@9'></script>
                <title>Pangasinan State University</title>
                </head>
               <body>
           
               <script> 
               Swal.fire({
                   title:'Login failed!',
                   text:'Incorrect ID or password',
                   icon:'error',
                   buttons:{
                       confirm: {
                           text: 'OK',
                           value: true,
                           visible: true
                           // className: 'btn-primary',
                               }
                           }
                  })
                  .then((value) => {
                  if (value) {
                   window.location.href = 'login_student.php';
                       }
                   })</script>
               </body>
               </html>";
               }
   
           }
           if (mysqli_num_rows($result) === 0) {
            echo "<html>
            <head>
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'>
            <link rel='icon' type='image/x-icon' href='images/psu_logo-removebg-preview.ico' />
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@9'></script>
            <title>Pangasinan State University</title>
            </head>
           <body>
       
           <script> 
           Swal.fire({
               title:'Login failed!',
               text:'This account does not exist',
               icon:'error',
               buttons:{
                   confirm: {
                       text: 'OK',
                       value: true,
                       visible: true
                       // className: 'btn-primary',
                           }
                       }
              })
              .then((value) => {
              if (value) {
               window.location.href = 'login_student.php';
                   }
               })</script>
           </body>
           </html>";
           }
           mysqli_close($con);
   
       }
   
   

?>