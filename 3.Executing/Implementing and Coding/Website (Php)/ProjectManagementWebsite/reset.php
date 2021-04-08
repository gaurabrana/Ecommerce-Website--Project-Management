<?php
include('base/connect.php');
require 'base/email/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
$data = 0;

if(isset($_POST['reset']))
{
    $email = $_POST['email'];
    $sql = "Select * from USERS where EMAIL = '$email'";
    $result = oci_parse($conn,$sql);
    oci_execute($result);
    while($row=oci_fetch_assoc($result))
    {
      $cookie_value = md5(rand());
      if(isset($_COOKIE['User'])) {        
        setcookie('User', "", time() - (600), "/");
        setcookie('User', $cookie_value, time() + (600), "/");
      }
      else{
        setcookie('User', $cookie_value, time() + (600), "/");
      }        
        $_SESSION['verification_key'] = $row['VERIFICATION_KEY'];
        $data++;
    }
    oci_free_statement($result);
    if($data>0){
        $message = "
        <h2>RESET YOUR PASSWORD!</h2>        
        <p>Your account : ".$email." recently requested for password reset.</p>        
        <p>Please click the link below to reset your password.</p>
        <a href='http://localhost/ProjectManagementWebsite/reset.php?vkey=$cookie_value'>Reset Password</a>
    ";
    $mail = new PHPMailer(true);                             				    
        //Server settings
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                               
        $mail->Username = 'networkedappetite@gmail.com';     
        $mail->Password = 'Ericwinty90@gmail.com';
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   

        $mail->setFrom('networkedappetite@gmail.com');
        
        //Recipients
        $mail->addAddress($email);              				        
       
        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Reset Password';
        $mail->Body    = $message;

        $mail->send();
        header("Location: reset.php?Error=Please follow up the link through your email address.&redirect=true");			
    }
    else
    {
        header("Location: reset.php?Error=Email Address Not Found. Check Again.");
    }
}
if(!empty($_GET['vkey']))
{
  if(isset($_COOKIE['User']) && $_COOKIE['User']==$_GET['vkey'])
  {
    ?>   
        <div class="container">
        <!-- Trigger the modal with a button -->
        <button type="button" style="visibility:hidden;" id="modalbox" class="btn btn-info btn-lg modals" data-toggle="modal" data-target="#myModal">Open Modal</button>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">    
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Reset Password</h4>
              </div>
              <div class="modal-body">
              <form action="base/reset.php" method="POST" onsubmit="return test();">
                <input id="pass" class="un" name="password" oninput="myFunction1()" type="text" align="center" placeholder="New Password" required autocomplete="off">
                <p id="password_message"></p>            
                <input id="confirmpass" class="un" name="confirmpassword" oninput="myFunction2()" type="text" align="center" placeholder="Confirm Password" required autocomplete="off">            
                <p id="confirm_message"></p>  
                <input style="margin-bottom:10px;" type="submit" id="resetsubmit" align="center" name="change" value="Confirm">                
                </form>
              </div>        
            </div>      
          </div>
        </div>
      </div>
      <?php
  }  
  else
{
  header("Location: index.php");
}
}
?>
<?php
include('base/navbar.php');
?>
<html>
<head>
<title>Reset Email</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="styles/login.css" type="text/css">
</head>
<div class="container" id="loginpage">
    <div class="row justify-content-center">
      <div class="col-md-6 col-sm-8">
        <div id="loginarea" class="main">
          <p class="sign" align="center">Reset Password</p>
          <?php
          if(!empty($_GET['Error']))
          {
            echo"<p style='text-align:center; font-weight:bold; margin-left:5px; font-size:18px;'>".$_GET['Error']."</p>";
            if(!empty($_GET['redirect']))
            {
              echo"<script>setTimeout(function() {window.location.href= 'login.php';}, 3000);</script>";
            }
          }
          else{
            echo"<p style='text-align:center; font-weight:bold; margin-left:5px; font-size:18px;'>Enter your email address to proceed to password reset.</p>";
          }
          ?>
          <form action="" method="POST" class="log">            
            <input class="un" name="email" type="email" align="center" placeholder="Email Address" required>            
            <input style="margin-bottom:10px;" type="submit" class="submit" align="center" name="reset" value="Reset">
          </form>          
        </div>
      </div>
    </div>
  </div>
  </html>
<?php
include('base/footer.php');
?>
<script>  
  document.getElementById("modalbox").click();
  function myFunction1() {
  var elements = document.getElementById("pass").value;  
  var values = [];  
  values.push(elements);
  var val = values.toString();    
  if(val.length>0){
    if(val.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d!$%@#£€*?&*_]{8,}$/)){
      document.getElementById("password_message").innerHTML = "Valid Password";
      document.getElementById("resetsubmit").disabled = false;
    }  
    else{
      document.getElementById("password_message").innerHTML = "Invalid Password (at least 1 numeric, 1 lowercase and 1 uppercase needed.";
      document.getElementById("resetsubmit").disabled = true;
    }   
  }
    return val;      
}
function myFunction2(){ 
  var element = document.getElementById("confirmpass").value;  
  var values = [];  
  values.push(element);
  var val = values.toString(); 
  return val;
}
function test(){
  if(myFunction1().length>0 && myFunction2().length>0)
  {
    if(myFunction2() == myFunction1()){
    return true;
    }  
    else
    {
    document.getElementById("confirm_message").innerHTML = "Password does not match.";    
    return false;
    }
  } 
}
</script>