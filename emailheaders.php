<?php 

// ini_set("mail.log", "tmp/mail.log");
// ini_set("mail.add_x_header", TRUE);


//  ini_set('mail.add_x_header','On'); 

//  ini_set('sendmail_from','icreach2022@gmail.com'); 
 
//  ini_set('SMTP','smtp.gmail.com'); 
 
//  ini_set('smtp_port','465'); 


// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php'; 
require 'PHPMailer/PHPMailer.php'; 
require 'PHPMailer/SMTP.php'; 
$phpemail = new PHPMailer(TRUE);

//$mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output 
$phpemail->isSMTP();                            // Set mailer to use SMTP 
$phpemail->Host = 'smtp.gmail.com';           // Specify main and backup SMTP servers 
$phpemail->SMTPAuth = true;                     // Enable SMTP authentication 
$phpemail->Username = 'sampathraj.mp@gmail.com';       // SMTP username 
$phpemail->Password = 'ftkqhlddckmalage';         // SMTP password 
$phpemail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted 
$phpemail->Port = 465;                          // TCP port to connect to 

//  MAIL_DRIVER="smtp"
// MAIL_HOST="smtp.gmail.com"
// MAIL_PORT="465"
// MAIL_USERNAME="sampathraj.mp@gmail.com"
// MAIL_PASSWORD="ftkqhlddckmalage"
// MAIL_ENCRYPTION="SSL"
// MAIL_FROM_ADDRESS="sampathraj.mp@gmail.com"
// MAIL_FROM_NAME="no-reply"
 
 ?>