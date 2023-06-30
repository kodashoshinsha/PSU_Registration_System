<?php  
    ob_start();
    session_start();
    include "connection.php";
    
    if (isset($_POST['fc_id']) && isset($_POST['password'])) {
        // removes backslashes
        function validate($data){

          $data = trim($data);
   
          $data = stripslashes($data);
   
          $data = htmlspecialchars($data);
   
          return $data;
   
       }
   
       $fID = validate($_POST['fc_id']);
   
       $pass = validate($_POST['password']);
   
           $sql = "SELECT * FROM `admin` WHERE id_num='$fID'";
   
           $result = mysqli_query($con, $sql);
   
           if (mysqli_num_rows($result) === 1) {
   
               $row = mysqli_fetch_assoc($result);
               $hashed_password = $row['password'];
               $firstname = $row['firstname'];
               $middlename = $row['middlename'];
               $lastname = $row['lastname'];
               $department = $row['college']; 
               $verified = $row['status']; 
               if ($row['id_num'] === $fID && password_verify($pass, $hashed_password) && $verified == "Not verified") {
                header("Location:not_verified.php");
                exit();
   
               }
               else if ($row['id_num'] === $fID && password_verify($pass, $hashed_password)){
                if(mysqli_num_rows($result) == 1) {
                   $user_id = $row['id_num'];
                   $ip_address = $_SERVER['REMOTE_ADDR'];
                   $timestamp = date('Y-m-d h:i H', strtotime('+6 hours'));
                   $sql = "INSERT INTO logins(id_num,login_id,firstname, middlename, lastname, ip_address, timestamp) VALUES ('$user_id','','$firstname', '$middlename', '$lastname', '$ip_address', '$timestamp')";
                   mysqli_query($con, $sql);
                   $_SESSION ['admin_log_in'] = true;
                   $_SESSION ['admin_login_id'] = $fID;
                   $_SESSION ['admin_fname'] =  $firstname;
                   $_SESSION ['admin_mname'] = $middlename;
                   $_SESSION ['admin_lname'] = $lastname;
                   $_SESSION ['department'] =  $department;
                   header("Location:index_admin.php");
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
                   window.location.href = 'login_admin.php';
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
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@9'></script>
            <link rel='icon' type='image/x-icon' href='images/psu_logo-removebg-preview.ico' />
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
               window.location.href = 'login_admin.php';
                   }
               })</script>
           </body>
           </html>";
           }
   
       }
   
?>