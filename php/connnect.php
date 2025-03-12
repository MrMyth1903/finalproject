<?php
include 'signup.php';
if(isset($_POST['submit'])){
 $uname=$_POST['username'];
 $pwd=$_POST['password'];
 if($uname && $pwd)
 {
$msg="You loggin";
header('refresh:3; url=http://localhost/final year/home.html');
 }
 else
 {
$msg="Not lo";
 }
 
}

?>