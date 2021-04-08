<?php
include('connect.php');
if(isset($_POST['change']))
{
  $pass = md5($_POST['password']);
  $verifykey = $_SESSION['verification_key'];  
  $sql = "Update users SET PASSWORD ='$pass' where VERIFICATION_KEY='$verifykey'";
  $result = oci_parse($conn, $sql);
  oci_execute($result);
  setcookie('User', "", time() - (600), "/");
  header("Location: ../login.php?Error=Successfully Password Reset. Please Login With New Password");
}
?>