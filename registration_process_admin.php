<?php
session_start();
    // Enter your host name, database username, password, and database name.
    // If you have not set database password on localhost then set empty.
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
    $mail->SMTPDebug = "";                               //Enable verbose debug output
    $mail->isSMTP();                                    //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';               //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                            
    $mail->Username   = 'kodashoshinsha@gmail.com';     //SMTP username
    $mail->Password   = 'bfmymlyoahrkurjn';            //SMTP password
    $mail->SMTPSecure = 'tls';                         //Enable implicit TLS encryption
    $mail->Port       = 587;                           //TCP port is set to 587 

    //Recipients
    $mail->setFrom('kodashoshinsha@gmail.com','PSU URDANETA MIS');
    $mail->addAddress($email);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Please activate your Email';
    $mail->Body    = "Your account has been registered, but for security reasons
    we need to verify that your email is valid. <br> Please click the link below to verify your email <a href='http://localhost/IM2 - PSU Registration System/emailverify_process_admin.php?email=$email&code=$code'><br>Verify</a>";
    $mail->send();
    return true;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error:";
    return false;
}
}
     // When form submitted, the process starts
     if (isset($_POST['register'])) {
        // removes backslashes
        $fcid = stripslashes($_REQUEST['id_num']);
        //escapes special characters in a string
        $fcid = mysqli_real_escape_string($con, $fcid);
        $firstname    = stripslashes($_REQUEST['firstname']);
        $firstname    = mysqli_real_escape_string($con, $firstname);
        $middlename    = stripslashes($_REQUEST['middlename']);
        $middlename    = mysqli_real_escape_string($con, $middlename);
        $lastname    = stripslashes($_REQUEST['lastname']);
        $lastname    = mysqli_real_escape_string($con, $lastname);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $gender = stripslashes($_REQUEST['gender']);
        $gender = mysqli_real_escape_string($con, $gender);
        $college = stripslashes($_REQUEST['college']);
        $college = mysqli_real_escape_string($con, $college);
        $code = bin2hex(random_bytes(16));                      //generates a random bits of strings for the email verification code
        $status = "Not verified";                               //authenticates if user has already activated the email verification code
        $datereg = date('Y-m-d H:i:s', strtotime('+6 hours'));                         //inserts the current datetime stamp
        //SQL statement checks if user input already exists in the database 
        $check = "SELECT COUNT(*) AS total FROM admin WHERE id_num = '$fcid' OR email = '$email'";
        $result = mysqli_query($con,$check);
        $count = mysqli_fetch_array($result);
        $total = $count ['total'];

        $id_check = $_POST['id_num'];
        $email_check = $_POST['email'];
        $regex_email = "#^[A-Za-z0-9]+@[A-Za-z0-9]+\.[A-Za-z]+$#";
        $regex_id = "~^\w[F,C]-[U,R]{2}-\d{4}$~";

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
               window.location.href = 'registration_admin.php';
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
               window.location.href = 'registration_admin.php';
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
                   window.location.href = 'registration_admin.php';
                       }
                   })</script>
               </body>
               </html>";
                }
        else {
            $query = "INSERT INTO `admin` (id_num, email, firstname, middlename, lastname, password, college, gender, 
            date_time_registered,code,status) VALUES ('$fcid','$email','$firstname','$middlename','$lastname','$hash','$college','$gender',
            '$datereg','$code','$status')";
           if (mysqli_query($con, $query) && sendMail($_POST['email'],$code))
            {   
                $_SESSION["Email_address_admin"] = $email;
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
               window.location.href = 'emailverify_admin.php';
                   }
               })</script>
           </body>
           </html>";
            }
        }
       
        mysqli_close ($con);
    } 
?>
