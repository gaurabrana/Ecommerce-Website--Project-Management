<!DOCTYPE html>
<html lang="en">
<head>
  <title>Email Verification</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
      .modals{visibility:hidden;}
  </style>
</head>
<body>
<?php
include('connect.php');
if(!empty($_GET['vkey']))
{
$verifykey = $_GET['vkey'];
$sql = "Update users SET VERIFIED = 'YES' where VERIFICATION_KEY='$verifykey'";
$result = oci_parse($conn, $sql);
oci_execute($result);
echo'<div class="container">
 
  <!-- Trigger the modal with a button -->
  <button type="button" id="modalbox" class="btn btn-info btn-lg modals" data-toggle="modal" data-target="#myModal">Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Registration</h4>
        </div>
        <div class="modal-body">
          <p>Your account is successfully verified. Thank you for choosing us.<br/> You will be now redirected to login page in 5 sec.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div>
</div>';
echo"<script>setTimeout(function() {window.location.href= '../login.php';}, 5000);</script>";
}
?>
</body>
</html>
<script type="text/javascript">
document.getElementById("modalbox").click();
</script>
