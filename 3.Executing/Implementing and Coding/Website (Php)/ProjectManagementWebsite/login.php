<?php
if(!isset($_SESSION))
{
session_start();  
}
if(isset($_SESSION['username'])){
  header("Location: index.php");
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="styles/login.css" type="text/css">
</head>
<?php
//Navigation Area
include('base/navbar.php');
?>
<body>
  <div class="container" id="loginpage">
    <div class="row justify-content-center">
      <div class="col-md-6 col-sm-8">
        <div id="loginarea" class="main">
          <p class="sign" align="center">Login Form</p>
          <?php
          if(!empty($_GET['Error']))
          {
            echo"<p style='text-align:center; font-weight:bold; margin-left:5px; font-size:18px;'>".$_GET['Error']."</p>";
          }
          ?>
          <form action="base/login.php" method="POST" class="log">
            <select name="usertype" class="un">            
              <option value="2">Customer</option>
              <option value="1">Trader</option>
              <option value="0">Admin</option>
            </select>
            <input class="un" name="email" type="email" align="center" placeholder="Email Address" value="<?php if(isset($_POST['email'])){ echo $_POST['email'];} ?>" required>
            <input class="un" name="password" type="password" align="center" placeholder="Password" required>
            <input type="submit" class="submit" align="center" name="login" value="Sign In">
          </form>
          <p class="forgot"><a href="reset.php">Forgot Password?</a>
            <a href="Register.php#register" class="btn btn-outline-info" role="button">Create New Account</a>
          </p>
        </div>
      </div>
    </div>
  </div>
  <?php
  if (!empty($_GET['verify'])) {
    $email = $_GET['email'];
    echo '<div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" id="modalbox" class="btn modals" data-toggle="modal" data-target="#myModal">Open Modal</button>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title">Email Verification.</h4>
        </div>
        <div class="modal-body">
          <p>Please check your mail: <b><i>'.$email.'</i></b> for verification link.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div>  
</div>';
  }
  //Footer Area
  include('base/footer.php');
  ?>
  <script type="text/javascript">
    document.getElementById("modalbox").click();
  </script>
</body>

</html>