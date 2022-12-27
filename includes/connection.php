
<?php
// site url
//define('SITE_URL', 'http://www.icreach2022.com');

//Localhost URL
define('SITE_URL', 'http://localhost/icreach/');


define('ADMIN_EMAIL', 'webteam.cf8@gmail.com');
// connection mysqli_connect_error
//$connection = mysqli_connect('localhost', 'kavisoft_emsi17', 'f]X_3cr)nQfT','kavisoft_emsi2k17');
//$connection = mysqli_connect('localhost', 'kavisoft_emsi17', 'f]X_3cr)nQfT','kavisoft_emsi2k17');
//$connection = mysqli_connect("localhost", "root", "","cf8");
$connection = mysqli_connect("localhost", "root", "","icreach2022");

$dblink = new mysqli("localhost", "root", "","icreach2022");
   if ($dblink->connect_error) {
      die("Connection failed: " . $dblink->connect_error);
   }	
//if (!$connection){

if (mysqli_connect_errno())
{
    die("Database Connection Failed" . mysqli_connect_error());
}
?>
