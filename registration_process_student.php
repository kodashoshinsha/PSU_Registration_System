<?php
session_start();
include ('connection.php');

//The function below is a PHPMailer where it will send a gmail message to the gmail accounts of the users 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail ($email,$code) {
//Load Composer's autoloader
require ("PHPMailer/PHPMailer.php");
require ("PHPMailer/SMTP.php");
require ("PHPMailer/Exception.php");


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = "";                      
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //This is  SMTP server to send through
    $mail->SMTPAuth   = true;                              
    $mail->Username   = 'kodashoshinsha@gmail.com';           //SMTP username
    $mail->Password   = 'bfmymlyoahrkurjn';                   //SMTP password
    $mail->SMTPSecure = 'tls';                                //Enable implicit TLS encryption
    $mail->Port       = 587;                                  //TCP port is set to 587 

    //Recipients
    $mail->setFrom('kodashoshinsha@gmail.com','PSU URDANETA MIS');
    $mail->addAddress($email);                                  //Adds the email of the recipient

    //Mail Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Please activate your Email';               //Gmail subject
    $mail->Body    = "Your account has been registered, but for security reasons
    we need to verify that your email is valid. <br> Please click the link below to verify your email <a href='http://localhost/IM2 - PSU Registration System/emailverify_process_student.php?email=$email&code=$code'><br>Verify</a>";   //Gmail body message
    $mail->send();
    return true;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error:";
    return false;
}
}

 // When form submitted, the process starts.
 if (isset($_POST['register'])) {
    // removes backslashes
    $stid = stripslashes($_POST['id_num']);
    //escapes special characters in a string
    $stid = mysqli_real_escape_string($con, $stid);
    $firstname    = stripslashes($_POST['firstname']);
    $firstname    = mysqli_real_escape_string($con, $firstname);
    $middlename    = stripslashes($_POST['middlename']);
    $middlename    = mysqli_real_escape_string($con, $middlename);
    $lastname    = stripslashes($_POST['lastname']);
    $lastname    = mysqli_real_escape_string($con, $lastname);
    $email    = stripslashes($_POST['email']);
    $email    = mysqli_real_escape_string($con, $email);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($con, $password);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $gender = stripslashes($_POST['gender']);
    $gender = mysqli_real_escape_string($con, $gender);
    $course = stripslashes($_POST['course']);
    $course = mysqli_real_escape_string($con, $course);
    $yearlevel = stripslashes($_POST['yearlevel']);
    $yearlevel = mysqli_real_escape_string($con, $yearlevel);
    $code = bin2hex(random_bytes(16));
    $status = "Not verified";
    $date_time_reg = date('Y-m-d H:i:s', strtotime('+6 hours'));     //Inserts the current datetime stamp
    $date_reg = date('Y-m-d');
    //SQL statement to check if user input already exists in database 
    $check = "SELECT COUNT(*) AS total FROM student  WHERE id_num = '$stid' OR email = '$email'";
    $result = mysqli_query($con,$check);
    $count = mysqli_fetch_array($result);
    $total = $count['total'];

    $id_check = $_POST['id_num'];
    $email_check = $_POST['email'];
    $regex_email = "#^[A-Za-z0-9]+@[A-Za-z0-9]+\.[A-Za-z]+$#";
    $regex_id = "~^\d{2}-[U,R]{2}-\d{4}$~";

    //If user input does not exist yet, insert into the database
    if ($total > 0) {
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
           title:'Registration failed!',
           text:'ID or Email is already taken',
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
           window.location.href = 'registration_student.php';
               }
           })</script>
       </body>
       </html>";
        }
       
        elseif (!preg_match($regex_id,$id_check)) {
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
               title:'Registration failed!',
               text:'Please enter a valid ID number',
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
               window.location.href = 'registration_student.php';
                   }
               })</script>
           </body>
           </html>";
            }

            elseif (!preg_match($regex_email,$email_check)) {
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
                   title:'Registration failed!',
                   text:'Please enter a valid email address',
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
                   window.location.href = 'registration_student.php';
                       }
                   })</script>
               </body>
               </html>";
                }
   else {
        $query = "INSERT INTO `student` (id_num, firstname,middlename, lastname, email, password, gender,
        course, yearlevel,date_time_registered,code,status)
        VALUES ('$stid','$firstname','$middlename','$lastname','$email','$hash','$gender','$course',
        '$yearlevel','$date_time_reg','$code','$status')";

       if (mysqli_query($con, $query) && sendMail($_POST['email'],$code))
        {
            $_SESSION ["Email_address_student"] = $email;
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
           title:'Registration successful!',
           icon:'success',
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
           window.location.href = 'emailverify_student.php';
               }
           })</script>
       </body>
       </html>";
        }
    }
   
    mysqli_close ($con);
} 


?>